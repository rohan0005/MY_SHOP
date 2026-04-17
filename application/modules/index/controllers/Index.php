<?php

class Index extends MY_Controller{

    public function __construct()
    {
         parent:: __construct();
        //  $this->load->module("")
        $this->load->module("template");
    }


    public function load_index_page(){

        $this->template->loadTemplate("index/index_page");



        //this - > MODULE_NAME -> MODULE_METHOD_NAME
    
    }



    // public function simpleMessage(){
    //     $content['message'] = "This is a simple message from the message controller";

    //     //---  MODULE_NAME/VIEWS_FILE_NAME, content
    //     // $this->load->view("message/simple-message", $content);  // LOAD THE simple-message.php file from views.

        
    
    // }

}

?>