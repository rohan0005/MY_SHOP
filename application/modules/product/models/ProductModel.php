<?php

    class ProductModel extends CI_Model
    {
        public function get_products()
        {
            $query = $this->db->get("product");

            return $query->result();

        }
    
    public function add_product()
    {
        $product_name = $this->input->post("productName");
        $price = $this->input->post("productPrice");

        $NewProduct = array(
            'p_name' => $product_name,
            'price' => $price,
        );

        $this->db->insert("product", $NewProduct);
        return true;
        
    }

    }


?>