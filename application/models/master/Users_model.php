<?php

class Users_model extends CI_model
{
    //mengambil semua data role
    public function getAllRole()
    {
        $this->db->select('*');
        $this->db->from('login_role');
        $this->db->order_by('role');
        $query = $this->db->get()->result_array();
        return $query;
    }

    //mengambil semua data users
    public function getAllUsers()
    {
        $this->db->select('*');
        $this->db->from('login');
        $this->db->order_by('name');
        $query = $this->db->get()->result_array();
        return $query;
    }

    //mengambil id login
    public function getUsersByID($id)
    {
        return $this->db->get_where('login', ['id' => $id])->row_array();
    }

    //melakukan query edit users
    public function editUsers()
    {
        $datausers = [
            "name"      => $this->input->post('name', true),
            "email"     => $this->input->post('email', true),
            "role_id"   => $this->input->post('role_id', true)
        ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('login', $datausers);
    }

    //melakukan query hapus users
    public function hapusUsers($id)
    {
        $this->db->delete('login', ['id' => $id]);
    }
}
