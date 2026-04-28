<?php

class ProductModel extends CI_Model
{

    protected $inventory_db;

    public function __construct()
    {
        parent::__construct();

        //loading second db
        $this->inventory_db = $this->load->database('inventory_db', TRUE);
    }

    public function get_products()
    {
        $query = $this->db->get("product");

        return $query->result();
    }

    public function add_product($image_name = '')
    {
        $product_name = $this->input->post("productName");
        $price = $this->input->post("productPrice");
        $stock = $this->input->post("productStock");
        $warehouse = $this->input->post("productWarehouse");
        $supplier = $this->input->post("productSupplier");

        if ($price <= 0 || $stock <= 0) {
            throw new Exception("Price or Stock is invalid!!");
        }

        // FIRST SAVE ON PRODUCT TABLE
        $NewProduct = array(
            'p_name' => $product_name,
            'price' => $price,
            'image' => $image_name, //saving the image file name

        );

        $this->db->insert("product", $NewProduct);
        $p_id = $this->db->insert_id();

        // NOW SAVE ON INVENTORY TABLE.

        $newInventoryItem = array(
            'product_id' => $p_id,
            'stock' => $stock,
            'warehouse_location' => $warehouse,
            'supplier_name' => $supplier,
        );

        $this->inventory_db->insert('inventory', $newInventoryItem);

        return true;
    }


    public function get_products_serverside($start, $length, $search)
    {
        $this->db->from("product");

        if ($search) {
            $this->db->group_start();
            $this->db->like('product.p_name', $search);
            $this->db->or_like('product.price', $search);
            $this->db->group_end();
        }

        $this->db->limit($length, $start);
        return $this->db->get()->result();
    }

    public function count_all_product()
    {
        return $this->db->count_all('product');
    }


    public function count_filtered_order($search)
    {
        $this->db->from("product");

        if ($search) {
            $this->db->group_start();
            $this->db->like('product.p_name', $search);
            $this->db->or_like('product.price', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }


    public function get_products_with_stocK($start, $length, $search)
    {
        $this->db->reset_query();

        $this->db->select("product.id, product.p_name, product.price, i.stock, i.warehouse_location, i.supplier_name");

        $this->db->from("shop_db.product");
        $this->db->join("shop_inventory_db.inventory i", "product.id = i.product_id", "left"); // LEFT JOIN

        if ($search) {
            $this->db->group_start();
            $this->db->like('product.p_name', $search);
            $this->db->or_like('product.price', $search);
            $this->db->or_like('i.warehouse_location', $search);
            $this->db->or_like('i.supplier_name', $search);
            $this->db->group_end();
        }


        $this->db->limit($length, $start);
        return $this->db->get()->result();
    }


    public function count_all_products_with_stock()
    {
        $this->db->reset_query();

        $this->db->from("shop_db.product");
        // $this->db->join("shop_inventory_db.inventory i", "shop_db.product.id= i.product_id", "left");

        return $this->db->count_all_results();
    }


    public function count_filtered_products_with_stock($search)
    {
        $this->db->reset_query();

        $this->db->from("shop_db.product");
        $this->db->join("shop_inventory_db.inventory i", "shop_db.product.id = i.product_id", "left");

        if ($search) {
            $this->db->group_start();
            $this->db->like('product.p_name', $search);
            $this->db->or_like('product.price', $search);
            $this->db->or_like('i.warehouse_location', $search);
            $this->db->or_like('i.supplier_name', $search);
            $this->db->group_end();


            return $this->db->count_all_results();
        }
    }
}
