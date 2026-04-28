<?php

class OrdersModel extends CI_Model
{
    protected $inventory_db;

    public function __construct()
    {
        parent::__construct();

        $this->inventory_db = $this->load->database('inventory_db', TRUE);
        // $this->db = $this->load->database('shop_db');
    }

    public function place_order()
    {
        $products = $this->input->post('products');

        try {

            $this->db->trans_begin();   // It allows to group multiple database queries together so that they either all succeed or all fail as a single unit.

            $grand_total = 0;
            $product_list = [];

            if (!empty($products) && is_array($products)) {

                foreach ($products as $product) {
                    $product_id = (int) $product['id'];
                    $quantity = (int) $product['quantity'];
                    $price = (float) $product['price'];


                    //check if there is stock of this product...
                    if ($quantity > 0) {
                        // $stock =  " ";
                        // $query = $this->db->inventory_db->query("SELECT stock from inventory_db.inventory where product_id= '$product_id'");

                        $this->inventory_db->select('stock');
                        $this->inventory_db->from('inventory');
                        $this->inventory_db->where('product_id', $product_id);

                        $query = $this->inventory_db->get();
                        $row = $query->row();

                        // SHOW THE PRODUCT NAME.
                        $this->db->select('p_name');
                        $this->db->from('product');
                        $this->db->where('id', $product_id);

                        $query2 = $this->db->get();
                        $ProductRow = $query2->row();


                        if ($row) {
                            $current_stock = (int) $row->stock;

                            $productName = $ProductRow->p_name;


                            if ($quantity > $current_stock) {
                                throw new Exception("Not enough Stock Available for: " . $productName);
                            } else {
                                $newQuantity = $current_stock - $quantity;

                                $this->inventory_db->where('product_id', $product_id);
                                $this->inventory_db->update('inventory', ['stock' => $newQuantity]);
                            }
                        } else {
                            throw new Exception("Product ID: " . $product_id . " not found in inventory.");
                        }
                    }


                    $total = $quantity * $price;

                    if ($quantity > 0 && $price >= 0) {
                        $grand_total += $quantity * $price;
                    }

                    $product_list[] = [
                        'name'     => $product['name'],
                        'quantity' => $quantity,
                        'price'    => $price,
                        'total'    => $total
                    ];
                }
            }



            // Check if user already exists

            $phone = $this->input->post("phone");

            $this->db->where("phone", $phone);
            $existing_user = $this->db->get("users")->row();

            if ($existing_user) {
                //user exist
                $user_id = $existing_user->id;
            } else {

                $userData = array(

                    'f_name' => $this->input->post("f_name"),
                    'l_name' => $this->input->post("l_name"),
                    'phone' => $this->input->post("phone"),
                    'created_at' => date("Y-m-d H:i:s"),
                    'email' => $this->input->post("email"),


                );

                $this->db->insert('users', $userData);
                $user_id = $this->db->insert_id();      // getting the USER id after insert.
            }



            // NOW INSERT INTO ORDER TABLE:
            $orderData = array(
                // 'p_id' => $p_id,
                'user_id' => $user_id,
                // 'quantity' => x$this->input->post("quantity"),
                'total_price' => $grand_total,
                'status' => "pending",
            );
            $this->db->insert("orders", $orderData);

            //get the id of orders
            $order_ID = $this->db->insert_id();



            if (!empty($products) && is_array($products)) {

                foreach ($products as $product) {
                    $product_id = (int) $product['id'];
                    $quantity = (int) $product['quantity'];
                    $price = (float) $product['price'];
                    $total = $quantity * $price;


                    $itemData =
                        [
                            'order_id' => $order_ID,
                            'p_id' => $product_id,
                            'price' => $total,
                            'quantity' => $quantity,
                        ];

                    $this->db->insert('order_items', $itemData);
                }
            }


            $this->db->trans_commit();

            return [
                'order_id'    => $order_ID,
                'items'       => $product_list,
                'grand_total' => $grand_total
            ];;
        } catch (Exception $e) {
            $this->db->trans_rollback();  //rollback on any error

            return ['error' => $e->getMessage()];
        }
    }

    public function view_all_orders()
    {

        $this->db->select('orders.id, orders.order_date, order_items.quantity, orders.total_price, orders.status, users.f_name, users.l_name, users.phone, product.p_name, product.price');

        $this->db->from('orders');

        $this->db->join('users', 'users.id = orders.user_id');

        $this->db->join('order_items', 'order_items.order_id = orders.id');

        $this->db->join('product', 'product.id = order_items.p_id');


        $query = $this->db->get();

        return $query->result();


        // $query = $this->db->get("order"); //get the table order

        // return $query->result();


        // $this->db->from("order");

    }

    public function get_single_order_by_id($id)
    {
        $this->db->select("`orders`.id, `orders`.total_price ,`orders`.status, users.f_name, users.l_name, users.created_at,  users.phone, order_items.quantity, order_items.price, product.p_name ");
        $this->db->from("`orders`");
        $this->db->join("users", "users.id = `orders`.user_id ");
        $this->db->join("order_items", "order_items.order_id = orders.id");
        $this->db->join("product", "product.id = `order_items`.p_id ");
        $this->db->where("`orders`.id", $id);

        $query = $this->db->get();

        return $query->result();    //return restul not row!!!!!!!!

    }


    public function update_status_model($id)
    {
        // $this->db->update()
        $data = array(
            'status' => $this->input->post('status')
        );

        if ($id) {
            $this->db->where("id", $id);
            return $this->db->update('orders', $data);
        }
    }


    public function delete_order($id)
    {

        //  Getting the order first to find user_id and p_id

        $this->db->where('id', $id);
        $order = $this->db->get('`orders`')->row();

        if ($order) {
            $this->db->delete('`orders`', array('id' => $id));
            $this->db->delete('`product`', array('id' => $order->p_id));
            return true;
        } else {
            return false;
        }



        // return $this->db->delete('order',array('id'=>$id));
        // return
    }



    public function latest_order($id)
    {

        $this->db->select("`orders`.id, `order_items`.price,  `orders`.order_date, users.f_name, users.l_name, product.p_name, `order_items`.quantity,");
        $this->db->from("`orders`");
        $this->db->join("users", "users.id = `orders`.user_id");
        $this->db->join("order_items", "order_items.order_id = `orders`.id");
        $this->db->join("product", "product.id = `order_items`.p_id");
        $this->db->where("`orders`.user_id", $id);

        $this->db->order_by("order_date", "DESC");
        $this->db->limit(2);

        $query = $this->db->get();

        return $query->result();
    }


    //server side order data loading MODEL:
    public function get_all_orders_with_details($start, $length, $search)
    {
        $this->db->select(" orders.id, orders.total_price, orders.status,users.phone, users.f_name, users.created_at, users.l_name, product.p_name, product.price, order_items.quantity, order_items.price");
        $this->db->from("orders");
        $this->db->join("users", "users.id = orders.user_id");
        $this->db->join("order_items", "order_items.order_id = orders.id");
        $this->db->join("product", "product.id = order_items.p_id");
        $this->db->group_by("orders.id");


        if ($search) {
            $this->db->group_start();
            $this->db->like("users.f_name", $search);
            $this->db->or_like("product.p_name", $search);
            $this->db->group_end();
        }

        $this->db->limit($length, $start);
        return $this->db->get()->result();
    }


    public function count_all_orders()
    {
        return $this->db->count_all('orders');
    }

    public function count_filtered_orders($search)
    {
        $this->db->from('orders');
        $this->db->join('users', 'users.id = orders.user_id');
        $this->db->join('order_items', 'order_items.order_id = orders.id');
        $this->db->join('product', 'product.id = order_items.p_id');

        if ($search) {
            $this->db->like('users.f_name', $search);
            $this->db->or_like('product.p_name', $search);
        }

        return $this->db->count_all_results();
    }
}
