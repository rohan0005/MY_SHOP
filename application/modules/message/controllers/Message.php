<?php

class Message extends MY_Controller{

    public function __construct()
    {
         parent:: __construct();
         $this->load->module("school");
    }


    public function show_message(){

        echo "<h3>THIS IS A MESSAGE FROM THE MessageController</h3>";

        //this - > MODULE_NAME -> MODULE_METHOD_NAME
        $this->school->get_school_name();
        $this->school->get_school_address();
    
    }



    public function simpleMessage(){
        $content['message'] = "This is a simple message from the message controller";

        //---  MODULE_NAME/VIEWS_FILE_NAME, content
        $this->load->view("message/simple-message", $content);  // LOAD THE simple-message.php file from views.

        
    
    }

}

?>