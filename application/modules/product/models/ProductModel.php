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
}
