<?php

class Index extends MY_Controller{

    public function __construct()
    {
         parent:: __construct();
        //  $this->load->module("")
        $this->load->module("template");
        $this->load->helper('url');

    }


    public function load_index_page(){
        
    
        $this->load->view("order/add_order"); //MODAL
        $this->load->view("index/view-details"); //MODAL

        $this->template->loadTemplate("index/index_page");
        $this->load->view("template/footer");




        //this - > MODULE_NAME -> MODULE_METHOD_NAME
    
    }


}

?>