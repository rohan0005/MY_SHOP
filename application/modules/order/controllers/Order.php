<?php

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
    }

    public function place_order()
    {

        $this->form_validation->set_rules('f_name', 'First Name', 'required');
        $this->form_validation->set_rules('l_name', 'Last Name', 'required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
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

}
?>