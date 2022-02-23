<?php

class Role_model extends CI_model
{
    //melakukan query menampilkan semua data dari table login_role
    public function getRole()
    {
        return $this->db->get('login_role')->result_array();
    }

    //mengambil id role
    public function getRoleByID($id)
    {
        return $this->db->get_where('login_role', ['id' => $id])->row_array();
    }

    //melakukan query tambah role
    public function tambahRole()
    {
        $datarole = [
            "role" => $this->input->post('role', true)
        ];
        $this->db->insert('login_role', $datarole);
    }

    //melakukan query edit role
    public function editRole()
    {
        $data = [
            "role" => $this->input->post('role', true)
        ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('login_role', $data);
    }

    //melakukan query hapus role
    public function hapusRole($id)
    {
        $this->db->delete('login_role', ['id' => $id]);
    }

    //mengambil role id
    public function getRoleId($role_id)
    {
        return $this->db->get_where('login_role', ['id' => $role_id])->row_array();
    }

    //melakukan query menampilkan semua data dari table user_menu
    public function getMenu()
    {
        return $this->db->get('user_menu')->result_array();
    }
}
