<?php

class UsersModel extends CI_Model
{
    public function get_all_users()
    {

        $query = $this->db->get("users");

        return $query->result();
    }

}


?>