<?php

class Menu_model extends CI_model
{
    //mengambil id menu
    public function getMenuByID($id)
    {
        return $this->db->get_where('user_menu', ['id' => $id])->row_array();
    }

    //melakukan query tambah menu
    public function tambahMenu()
    {
        $datamenu = [
            "menu" => $this->input->post('menu', true)
        ];
        $this->db->insert('user_menu', $datamenu);
    }

    //melakukan query edit menu
    public function editMenu()
    {
        $data = [
            "menu" => $this->input->post('menu', true)
        ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('user_menu', $data);
    }

    //melakukan query hapus menu
    public function hapusMenu($id)
    {
        $this->db->delete('user_menu', ['id' => $id]);
    }

    //melakukan query menampilkan semua data dari table user_sub_menu dan join je table user_menu
    public function getSubMenu()
    {
        $query = " SELECT `user_sub_menu`.*,`user_menu`.`menu`
                    FROM `user_sub_menu` JOIN `user_menu`
                    ON `user_sub_menu`.`menu_id` = `user_menu`.`id` ";
        return $this->db->query($query)->result_array();
    }

    //melakukan query menampilkan semua data dari table user_menu
    public function getUserMenu()
    {
        return $this->db->get('user_menu')->result_array();
    }

    //melakukan query untuk menambahkan submenu
    public function tambahSubMenu()
    {
        $data = [
            'title' => $this->input->post('title'),
            'menu_id' => $this->input->post('menu_id'),
            'url' => $this->input->post('url'),
            'icon' => $this->input->post('icon'),
            'is_active' => $this->input->post('is_active')
        ];
        $this->db->insert('user_sub_menu', $data);
    }

    //melakukan query hapus sub menu
    public function hapusSubMenu($id)
    {
        $this->db->delete('user_sub_menu', ['id' => $id]);
    }

    //mengambil id sub menu
    public function getSubMenuByID($id)
    {
        return $this->db->get_where('user_sub_menu', ['id' => $id])->row_array();
    }

    //melakukan query edit sub menu
    public function editSubMenu()
    {
        $data = [
            "menu_id" => $this->input->post('menu_id', true),
            "title" => $this->input->post('title', true),
            "url" => $this->input->post('url', true),
            "icon" => $this->input->post('icon', true),
            "is_active" => $this->input->post('is_active', true)
        ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('user_sub_menu', $data);
    }
}
