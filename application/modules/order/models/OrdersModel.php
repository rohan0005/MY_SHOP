<?php

    class OrdersModel extends CI_Model
    {
       
        public function place_order()
        {
            $products = $this->input->post('products');


            $this->db->trans_start();   // It allows to group multiple database queries together so that they either all succeed or all fail as a single unit.

            $grand_total = 0;
            
            if (!empty($products) && is_array($products)) {

            foreach($products as $product)
                {
                    $product_id = (int) $product['id'];
                    $quantity = (int) $product['quantity'];
                    $price = (float) $product['price'];

                    if ($quantity > 0 && $price >= 0) {
                        $grand_total += $quantity * $price;
                    }



                }
            }
            
                // Check if user already exists

            $phone = $this->input->post("phone");

            $this->db->where("phone", $phone);
            $existing_user = $this->db->get("users")->row();

            if($existing_user)
            {
                //user exist
                $user_id = $existing_user->id;
            }

            else
                {

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

                        foreach($products as $product)
                            {
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


                    $this->db->trans_complete();


                    if ($this->db->trans_status() === FALSE) {
                        $error = $this->db->error();
                            print_r($error);   // TEMPORARY DEBUG
                            exit;

                            return false;
                    }

                    return true;


                }

        public function view_all_orders()
        {

            $this->db->select('orders.id, order_items.quantity, orders.total_price, orders.status, users.f_name, users.l_name, users.phone, product.p_name, product.price');

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

            if($id)
                {
                    $this->db->where("id", $id);
                    return $this->db->update('orders', $data);
                }
        }


        public function delete_order($id)
        {
            
            //  Getting the order first to find user_id and p_id

            $this->db->where('id',$id);
            $order = $this->db->get('`orders`')->row();

            if($order)
                {
                    $this->db->delete('`orders`', array('id'=>$id));
                    $this->db->delete('`product`', array('id'=>$order->p_id));
                    return true;

                }

            else
            {
                return false;
            }



            // return $this->db->delete('order',array('id'=>$id));
            // return
        }



        public function latest_order($id)
        {

            $this->db->select("`orders`.id, `orders`.quantity, `orders`.order_date, users.f_name, users.l_name, product.p_name, product.price");
            $this->db->from("`orders`");    
            $this->db->join("users", "users.id = `orders`.user_id");
            $this->db->join("product", "product.id = `orders`.p_id");
            $this->db->where("`orders`.user_id", $id);

            $this->db->order_by("order_date", "DESC");
            $this->db->limit(2);

            $query =$this->db->get();

            return $query->result();

        }
        
    }

?>