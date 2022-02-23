<?php

class Keteranganlembur_model extends CI_model
{
    //mengambil semua data keteranganlembur
    public function getAllKeteranganlembur()
    {
        $query = $this->db->get('keterangan_lembur')->result_array();
        return $query;
    }

    //melakukan query tambah keteranganlembur
    public function tambahKeteranganlembur()
    {
        $dataketeranganlembur = [
            "keterangan_lembur"     => $this->input->post('keterangan_lembur', true)
        ];
        $this->db->insert('keterangan_lembur', $dataketeranganlembur);
    }

    //mengambil id_keterangan_lembur
    public function getKeteranganLemburByID($id_keterangan_lembur)
    {
        return $this->db->get_where('keterangan_lembur', ['id_keterangan_lembur' => $id_keterangan_lembur])->row_array();
    }

    //melakukan query edit keterangan lembur
    public function editKeteranganLembur()
    {
        $dataketeranganlembur = [
            "keterangan_lembur"     => $this->input->post('keterangan_lembur', true)
        ];
        $this->db->where('id_keterangan_lembur', $this->input->post('id_keterangan_lembur'));
        $this->db->update('keterangan_lembur', $dataketeranganlembur);
    }

    //melakukan query hapus keterangan lembur
    public function hapusKeteranganLembur($id_keterangan_lembur)
    {
        $this->db->delete('keterangan_lembur', ['id_keterangan_lembur' => $id_keterangan_lembur]);
    }
}
