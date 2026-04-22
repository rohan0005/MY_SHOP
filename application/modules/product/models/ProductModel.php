<?php

    class ProductModel extends CI_Model
    {
        public function get_products()
        {
            $query = $this->db->get("product");

            return $query->result();

        }
    
    public function add_product($image_name = '')
    {
        $product_name = $this->input->post("productName");
        $price = $this->input->post("productPrice");

        $NewProduct = array(
            'p_name' => $product_name,
            'price' => $price,
            'image' => $image_name, //saving the image file name

        );

        $this->db->insert("product", $NewProduct);
        return true;
        
    }

    }


?>