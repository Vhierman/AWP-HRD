<?php

class Perusahaan_model extends CI_model
{
    //mengambil semua data perusahaan
    public function getAllPerusahaan()
    {
        $query = $this->db->get('perusahaan')->result_array();
        return $query;
    }

    //mengambil data perusahaan berdasarkan ID
    public function getPerusahaanByID($id)
    {
        return $this->db->get_where('perusahaan', ['id' => $id])->row_array();
    }

    //melakukan query tambah perusahaan
    public function tambahPerusahaan()
    {
        $dataperusahaan = [
            "perusahaan" => $this->input->post('perusahaan', true)
        ];
        $this->db->insert('perusahaan', $dataperusahaan);
    }

    //melakukan query edit perusahaan
    public function editPerusahaan()
    {
        $data = [
            "perusahaan" => $this->input->post('perusahaan', true)
        ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('perusahaan', $data);
    }

    //melakukan query hapus perusahaan
    public function hapusPerusahaan($id)
    {
        $this->db->delete('perusahaan', ['id' => $id]);
    }
}
