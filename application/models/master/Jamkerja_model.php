<?php

class Jamkerja_model extends CI_model
{
    //mengambil semua data jamkerja
    public function getAllJamkerja()
    {
        $query = $this->db->get('jam_kerja')->result_array();
        return $query;
    }

    //melakukan query tambah jam kerja
    public function tambahJamkerja()
    {
        $datajamkerja = [
            "jam_masuk"     => $this->input->post('jam_masuk', true),
            "jam_pulang"    => $this->input->post('jam_pulang', true)
        ];
        $this->db->insert('jam_kerja', $datajamkerja);
    }

    //mengambil id_jam_kerja
    public function getJamkerjaByID($id_jam_kerja)
    {
        return $this->db->get_where('jam_kerja', ['id_jam_kerja' => $id_jam_kerja])->row_array();
    }

    //melakukan query edit jam kerja
    public function editJamkerja()
    {
        $datajamkerja = [
            "jam_masuk"     => $this->input->post('jam_masuk', true),
            "jam_pulang"    => $this->input->post('jam_pulang', true)
        ];
        $this->db->where('id_jam_kerja', $this->input->post('id_jam_kerja'));
        $this->db->update('jam_kerja', $datajamkerja);
    }

    //melakukan query hapus jam kerja
    public function hapusJamkerja($id_jam_kerja)
    {
        $this->db->delete('jam_kerja', ['id_jam_kerja' => $id_jam_kerja]);
    }
}
