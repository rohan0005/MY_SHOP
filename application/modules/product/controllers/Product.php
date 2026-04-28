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
        $this->load->helper(array('form', 'url'));
        //upload 
        $this->load->library('upload');

        //load second database
        $db2 = $this->load->database('inventory_db', TRUE);  // TRUE = DO NOT REPLACE DEFAULT DB.
    }

    public function get_product_page()
    {
        $page['page_content'] = 'product/product_details';

        $this->load->view("template/global_template", $page);
        $this->load->view("template/footer");
    }


    public function get_all_product()
    {
        $all_products = $this->ProductModel->get_products();

        if ($all_products) {
            echo json_encode([
                "success" => true,
                "data" => $all_products,
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "NO DATA FOUND",
            ]);
        }
    }

    // ADD PRODUCT
    public function add_new_product()
    {


        $this->form_validation->set_rules('productName', 'Product Name', 'required');
        $this->form_validation->set_rules('productPrice', 'Price', 'required');
        $this->form_validation->set_rules('productWarehouse', 'Warehouse', 'required');
        $this->form_validation->set_rules('productStock', 'Stock', 'required');
        $this->form_validation->set_rules('productSupplier', 'Supplier', 'required');

        try {

            if ($this->form_validation->run() == FALSE) {

                $errors = explode("\n", trim(strip_tags(validation_errors())));

                echo json_encode([
                    'success' => false,
                    'message' => $errors[0],

                ]);
            } else {
                // upload product image

                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 10240;  //KB
                $config['max_width']            = 0;
                $config['max_height']           = 0;

                // $this->load->library('upload', $config);

                $this->upload->initialize($config); // using initialize 

                if (! $this->upload->do_upload('productImage'))   //default method do_upload()
                {
                    echo json_encode([
                        'success' => false,
                        'message' => strip_tags($this->upload->display_errors()),

                    ]);
                } else //call model
                {
                    $uploaded_data = $this->upload->data();
                    $this->ProductModel->add_product($uploaded_data['file_name']);

                    echo json_encode([
                        'success' => true,
                        'message' => "New Product Added!!",
                    ]);
                }
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function new_product_page()
    {
        $page['page_content'] = 'product/view_product_SS';

        $this->load->view("template/global_template", $page);
        $this->load->view("template/footer");
    }

    //SS view product.

    public function all_product_ss()
    {
        $draw = $_POST['draw'];
        $start = $_POST['start'];
        $length = $_POST['length'];
        $searchPost = $_POST['search'];

        $search = isset($searchPost['value']) ? $searchPost['value'] : '';


        $data = $this->ProductModel->get_products_serverside($start, $length, $search);
        $totalData = $this->ProductModel->count_all_product();
        $totalFilteredData = $this->ProductModel->count_filtered_order($search);


        $rows = array();
        foreach ($data as $item) {
            $rows[] = array(
                'id' => $item->id,
                'p_name' => $item->p_name,
                'price' => $item->price,
                // 'image' => $item->image
                'action' => '<button data-bs-toggle="modal" data-bs-target="#productImageViewModal" class="productImageViewModal btn btn-primary btn-sm" data-productname="' . $item->p_name . '" data-image="' . $item->image . '">View Image</button>'

            );
        }

        echo json_encode([
            "draw" => intval($draw),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFilteredData),
            "data" => $rows,
        ]);
    }




    // SS PRODUCT AND STOCK

    public function products_page_with_stock()
    {
        $page['page_content'] = 'product/product_and_stock';

        $this->load->view("template/global_template", $page);
        $this->load->view("template/footer");
    }

    public function get_products_and_stock()
    {

        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $searchPost = $this->input->post('search');
        $search = isset($searchPost['value']) ? $searchPost['value'] : '';


        $data = $this->ProductModel->get_products_with_stocK($start, $length, $search);
        $totalData = $this->ProductModel->count_all_products_with_stock();
        $totalFilteredData = $this->ProductModel->count_filtered_products_with_stock($search);

        $rows = array();

        foreach ($data as $item) {
            $rows[] = array(
                'id' => $item->id,
                'p_name' => $item->p_name,
                'price' => $item->price,
                'stock' => $item->stock,
                'warehouse_location' => $item->warehouse_location,
                'supplier_name' => $item->supplier_name
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
