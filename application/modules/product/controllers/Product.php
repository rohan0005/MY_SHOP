<?php

    class Product extends MY_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->database();
            $this->load->module('template');
            $this->load->model('ProductModel');
            $this->load->library('form_validation');
            $this->load->library('session');
        } 

        public function get_product_page()
        {
            $page['page_content'] = 'product/product_details';
            $this->load->view("template/global_template", $page);
            $this->load->view("template/footer");
            
        }


        public function get_all_product()
        {
            $all_products= $this->ProductModel->get_products();

            if($all_products)
            {
                echo json_encode([
                    "success"=> true,
                    "data"=> $all_products,
                ]);
            }

            else
                {
                    echo json_encode([
                    "success"=> false,
                    "message"=> "NO DATA FOUND",
                ]);

                }
        }

        // ADD PRODUCT
        public function add_new_product()
        {
           

            $this->form_validation->set_rules('productName', 'Product Name', 'required');
            $this->form_validation->set_rules('productPrice', 'Price', 'required');

            if ($this->form_validation->run() == FALSE)
                {
                    echo json_encode([
                            'success'=> false,
                            'message'=> strip_tags(validation_errors()),
                    ]);
                }

            else
                {
                    $this->ProductModel->add_product();

                    echo json_encode([
                            'success'=> true,
                            'message'=> "New Product Added!!",
                    ]);
                }

            
        }



    }

?>