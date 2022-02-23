<?php

class Jabatan_model extends CI_model
{
    //mengambil semua data jabatan
    public function getAllJabatan()
    {
        $query = $this->db->get('jabatan')->result_array();
        return $query;
    }

    //mengambil data jabatan berdasarkan ID nya
    public function getJabatanByID($id)
    {
        return $this->db->get_where('jabatan', ['id' => $id])->row_array();
    }

    //melakukan query tambah jabatan
    public function tambahJabatan()
    {
        $datajabatan = [
            "jabatan" => $this->input->post('jabatan', true)
        ];
        $this->db->insert('jabatan', $datajabatan);
    }

    //melakukan query edit jabatan
    public function editJabatan()
    {
        $data = [
            "jabatan" => $this->input->post('jabatan', true)
        ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('jabatan', $data);
    }

    //melakukan query hapus jabatan
    public function hapusJabatan($id)
    {
        $this->db->delete('jabatan', ['id' => $id]);
    }
}
