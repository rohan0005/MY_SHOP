<?php

class Users extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
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
        $this->load->view("users/view_latest_two_orders_modal");
        $this->load->view("template/footer");
    }


    // THIS METHOD returns JSON FOR AJAX.

    public function get_users_data()
    {

        $all_user_data = $this->UsersModel->get_all_users();

        if ($all_user_data) {
            echo json_encode([
                'success' => true,
                'message' => $all_user_data,

            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "NO DATA FOUND!!!",
            ]);
        }
    }



    //user page


    public function users_details_page_ss()
    {
        $page['page_content'] = 'users/users_ss';
        $this->load->view("template/global_template", $page);
        $this->load->view("template/footer");
    }

    public function get_user_details_ss()
    {

        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $searchPost = $this->input->post('search');

        $search = isset($searchPost['value']) ? $searchPost['value'] : '';

        $data = $this->UsersModel->get_user_details_ss_model($start, $length, $search);
        $totalData = $this->UsersModel->count_all_users();
        $totalFilteredData = $this->UsersModel->count_filtered_users($search);


        $rows = array();

        foreach ($data as $item) {
            $rows[] = array(
                'id' => $item->id,
                'fname' => $item->f_name,
                'lname' => $item->l_name,
                'phone' => $item->phone,
                'email' => $item->email,
                'createdat' => $item->created_at,
            );
        }

        echo json_encode([
            "draw" => intval($draw),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFilteredData),
            "data" => $rows,
        ]);
    }
}
