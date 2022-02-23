<?php

class User_model extends CI_model
{
    //mengambil id user
    public function getUserId($id)
    {
        return $this->db->get_where('login', ['id' => $id])->row_array();
    }

    //melakukan query edit user
    public function editUser()
    {
        $data = [
            "name" => $this->input->post('name', true),
            "email" => $this->input->post('email', true)
        ];
        $this->db->where('email', $this->input->post('email'));
        $this->db->update('login', $data);
    }
}
