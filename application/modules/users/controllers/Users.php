<?php

    class Users extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            $this->load->module("index");
            $this->load->module("template");
            $this->load->model("UsersModel");
            $this->load->database();
        }


        //THIS METHOD LOADS THE PAGE:
        public function get_users()
        {

        $page['page_content'] = 'users/user_details';
            
        // $this->template->loadTemplate("index/index_page");
        $this->load->view("template/global_template", $page);

        $this->load->view("template/footer");

        }


        // THIS METHOD returns JSON FOR AJAX.

        public function get_users_data()
        {
            
        $all_user_data = $this->UsersModel->get_all_users();

        if($all_user_data){
            echo json_encode([
            'success'=> true,
            'message' => $all_user_data,

        ]);
            
        }

        else
            {
                echo json_encode([
                    'success'=> false,
                    'message' => "NO DATA FOUND!!!",
                ]);

            }

        }


    }



?>