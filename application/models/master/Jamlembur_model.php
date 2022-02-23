<?php

class Jamlembur_model extends CI_model
{
    //mengambil semua data jamlembur
    public function getAllJamlembur()
    {
        $query = $this->db->get('jam_lembur')->result_array();
        return $query;
    }

    //melakukan query tambah jamlembur
    public function tambahJamlembur()
    {
        $datajamlembur = [
            "jam_masuk"     => $this->input->post('jam_masuk', true),
            "jam_istirahat" => $this->input->post('jam_istirahat', true),
            "jam_pulang"    => $this->input->post('jam_pulang', true)
        ];
        $this->db->insert('jam_lembur', $datajamlembur);
    }

    //mengambil id_jam_lembur
    public function getJamLemburByID($id_jam_lembur)
    {
        return $this->db->get_where('jam_lembur', ['id_jam_lembur' => $id_jam_lembur])->row_array();
    }

    //melakukan query edit jam lembur
    public function editJamLembur()
    {
        $datajamlembur = [
            "jam_masuk"     => $this->input->post('jam_masuk', true),
            "jam_istirahat" => $this->input->post('jam_istirahat', true),
            "jam_pulang"    => $this->input->post('jam_pulang', true)
        ];
        $this->db->where('id_jam_lembur', $this->input->post('id_jam_lembur'));
        $this->db->update('jam_lembur', $datajamlembur);
    }

    //melakukan query hapus jam lembur
    public function hapusJamLembur($id_jam_lembur)
    {
        $this->db->delete('jam_lembur', ['id_jam_lembur' => $id_jam_lembur]);
    }
}
