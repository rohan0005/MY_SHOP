<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Order extends MY_Controller
{
public function __construct()

    {
         parent:: __construct();
        //  $this->load->module("")
        $this->load->module("template");
        $this->load->model("OrdersModel");
        $this->load->database();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('email');
        // $this->load->helper('url');
    }

    public function place_order()
    {

        $this->form_validation->set_rules('f_name', 'First Name', 'required');
        $this->form_validation->set_rules('l_name', 'Last Name', 'required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required|exact_length[10]|numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');


        
        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata("errors", validation_errors());

            echo json_encode([
                'success'=> false,
                'message'=> strip_tags(validation_errors()),

            ]);
        }

        else
        {
            
            // $user_email = $this->form_validation->set_rules('email', 'Email', 'required');
            $user_email = $this->input->post('email');

            
            $subject = "Order Placed!!";
            $message = "<h1>Your order has been placed!</h1>";
            
            //call model function to save the data.
            $result = $this->OrdersModel->place_order();
            // send_email();
            // send_email($user_email, $subject, $message);

           if ($result) {
                
                $this->send_email($user_email, $subject, $message);

                echo json_encode([
                    'success' => true,
                    'message' => "Order Placed Successfully!!!!"
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => "Database error occurred"
                ]);
            }
            
        }

    }


    public function view_order()
    {

        $data = $this->OrdersModel->view_all_orders();


        //sending in json format
        echo json_encode([
            "success" => true,
            "data" => $data,
        ]);

        
    }

    public function view_oder_details($id)
    {
        $data = $this->OrdersModel->get_single_order_by_id($id);

        echo json_encode([

        "success" => true,
        "data" => $data,

        ]);

    }


    public function update_status($id)
    {
        $this->form_validation->set_rules("status", "status", 'required');

        if($this->form_validation->run() == FALSE)
        {
            $this->session->flashdata('errors', validation_errors());

            echo json_encode([

                'success' => false,
                'message' => validation_errors(),

            ]);
            
        }

        else
        {
            $this->OrdersModel->update_status_model($id);
            echo json_encode([
                "success" => true,
                "message" => "Order status Changed!!!"
            ]);
        }

    }



    //DELETE ORDER
    public function delete_order($id)
    {

        if(empty($id))
            {

                echo json_encode([

                'success' => false,
                'message' => "No ID provided",

            ]);
            
            return;

            }


            {
                $this->OrdersModel->delete_order($id);

                echo json_encode([

                    'success' => true,
                    'message' => "ORDER DELETED!!!!!!",
                ]);
                
            }
    }


    //Controller- list latest 2 orders.
    public function latest_two_orders($id)
    {
        $latest_orders = $this->OrdersModel->latest_order($id);

        echo json_encode([
            "success" => true,
            'data' => $latest_orders,

        ]);


    }



    public function send_email($user_email, $subject, $message)
    {
        try {
        $my_gmail = 'jr8484511@gmail.com';

        $config = array(
            'protocol'   => 'smtp',
            'smtp_host'  => 'smtp.gmail.com',
            'smtp_port'  => 587,
            'smtp_user'  => $my_gmail,
            'smtp_pass'  => 'opnx xooj tnqj quwo', // app password
            'smtp_crypto'=> 'tls',
            'mailtype'   => 'html',
            'charset'    => 'utf-8',
            'newline'    => "\r\n",
            'crlf'       => "\r\n",
        );

        $this->email->initialize($config);
        $this->email->clear(); 

        $this->email->from($my_gmail, 'MY SHOP');
        $this->email->to((string)$user_email); 
        $this->email->subject($subject);
        $this->email->message($message);


        if(!$this->email->send()){
            echo $this->email->print_debugger();
            exit;
        }

        if(!$this->email->send()){
            log_message('error', $this->email->print_debugger());
        }

        }

        catch(Exception $e) {
        log_message('error', 'Email error: ' . $e->getMessage());
        }


    }

}

?>