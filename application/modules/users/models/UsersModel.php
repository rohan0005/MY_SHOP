<?php

class UsersModel extends CI_Model
{
    public function get_all_users()
    {

        $query = $this->db->get("users");

        return $query->result();
    }


    public function get_user_details_ss_model($start, $length, $search)
    {
        $this->db->from("users");

        if ($search) {
            $this->db->group_start();
            $this->db->like("users.f_name", $search);
            $this->db->or_like("users.l_name", $search);
            $this->db->group_end();
        }

        $this->db->limit($length, $start);
        return $this->db->get()->result();
    }

    public function count_all_users()
    {
        return $this->db->count_all('users');
    }


    public function count_filtered_users($search)
    {
        $this->db->from('users');

        if ($search) {
            $this->db->group_start();
            $this->db->like('users.f_name', $search);
            $this->db->or_like('users.l_name', $search);
            $this->db->group_end();
        }

        return $this->db->count_all_results();
    }
}
