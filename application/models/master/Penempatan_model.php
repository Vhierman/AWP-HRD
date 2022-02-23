<?php

class Penempatan_model extends CI_model
{
    //mengambil semua data penempatan
    public function getAllPenempatan()
    {
        $query = $this->db->get('penempatan')->result_array();
        return $query;
    }

    //mengambil data penempatan berdasarkan ID nya
    public function getPenempatanByID($id)
    {
        return $this->db->get_where('penempatan', ['id' => $id])->row_array();
    }

    //melakukan query tambah penempatan
    public function tambahPenempatan()
    {
        $datapenempatan = [
            "penempatan" => $this->input->post('penempatan', true)
        ];
        $this->db->insert('penempatan', $datapenempatan);
    }

    //melakukan query edit penempatan
    public function editPenempatan()
    {
        $data = [
            "penempatan" => $this->input->post('penempatan', true)
        ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('penempatan', $data);
    }

    //melakukan query hapus penempatan
    public function hapusPenempatan($id)
    {
        $this->db->delete('penempatan', ['id' => $id]);
    }
}
