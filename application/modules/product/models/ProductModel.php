<?php

    class ProductModel extends CI_Model
    {
        public function get_products()
        {
            $query = $this->db->get("product");

            return $query->result();

        }

        
    }


?>