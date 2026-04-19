<?php

    class Product extends MY_Controller
    {
        public function __construct()
        {
            parent::__construct();
        } 

        public function Product()
        {
            $this->load->database();
            $this->load->library('form_validation');
            $this->load->library('session');
            $this->load->module('template');
            $this->load->model('ProductModel');
        }



    }

?>