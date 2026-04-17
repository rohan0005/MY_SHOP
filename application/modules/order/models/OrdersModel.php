<?php

    class OrdersModel extends CI_Model
    {
       
        public function place_order()
        {
            //--- INSERT THE ORDER DATA INTO THE DATABASE.
            // $this->db->insert("orders", $order_data);
            // return $this->db->insert_id();  // RETURN THE ID OF THE INSERTED ORDER.

            $data = array(

                'f_name' => $this->input->post("f_name"),
                'l_name' => $this->input->post("l_name"),
                'phone' => $this->input->post("phone"),
                'created_at' => date("Y-m-d H:i:s"),
            );

            return $this->db->insert('users', $data);
            
        }
    }

?>