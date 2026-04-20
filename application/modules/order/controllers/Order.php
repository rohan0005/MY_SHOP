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
        // $this->load->helper('url');
    }

    public function place_order()
    {

        $this->form_validation->set_rules('f_name', 'First Name', 'required');
        $this->form_validation->set_rules('l_name', 'Last Name', 'required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required|exact_length[10]|numeric');
        $this->form_validation->set_rules('product_name', 'Product Name', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        $this->form_validation->set_rules('quantity', 'Quantity', 'required|integer');

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

            
            //call model function to save the data.
            $this->OrdersModel->place_order();

            echo json_encode([
                'success' => true,
                'message' => "Order Placed Successfully!!!!"
            ]);

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




}

?>