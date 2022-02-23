<?php

class Bpjstk_model extends CI_model
{
    //mengambil semua data iuran bpjs ketenagakerjaan
    public function getAllBPJSTK()
    {
        $query = $this->db->get('potongan_bpjs_ketenagakerjaan')->result_array();
        return $query;
    }

    //mengambil data iuran bpjs ketenagakerjaan berdasarkan ID nya
    public function getBPJSTKByID($id_potongan_bpjs_ketenagakerjaan)
    {
        return $this->db->get_where('potongan_bpjs_ketenagakerjaan', ['id_potongan_bpjs_ketenagakerjaan' => $id_potongan_bpjs_ketenagakerjaan])->row_array();
    }

    //melakukan query edit iuran bpjs ketenagakerjaan
    public function editBPJSTK()
    {

        $potongan_jht_karyawan          = $this->input->post('potongan_jht_karyawan', true);
        $potongan_jht_perusahaan        = $this->input->post('potongan_jht_perusahaan', true);
        $potongan_jp_karyawan           = $this->input->post('potongan_jp_karyawan', true);
        $potongan_jp_perusahaan         = $this->input->post('potongan_jp_perusahaan', true);
        $potongan_jkk_perusahaan        = $this->input->post('potongan_jkk_perusahaan', true);
        $potongan_jkm_perusahaan        = $this->input->post('potongan_jkm_perusahaan', true);

        $jumlah_potongan_karyawan       = $potongan_jht_karyawan + $potongan_jp_karyawan;
        $jumlah_potongan_perusahaan     = $potongan_jht_perusahaan + $potongan_jp_perusahaan + $potongan_jkk_perusahaan + $potongan_jkm_perusahaan;

        $data = [
            "potongan_jht_karyawan"         => $this->input->post('potongan_jht_karyawan', true),
            "potongan_jht_perusahaan"       => $this->input->post('potongan_jht_perusahaan', true),
            "potongan_jp_karyawan"          => $this->input->post('potongan_jp_karyawan', true),
            "potongan_jp_perusahaan"        => $this->input->post('potongan_jp_perusahaan', true),
            "potongan_jkk_perusahaan"       => $this->input->post('potongan_jkk_perusahaan', true),
            "potongan_jkm_perusahaan"       => $this->input->post('potongan_jkm_perusahaan', true),
            "jumlah_potongan_karyawan"      => $jumlah_potongan_karyawan,
            "jumlah_potongan_perusahaan"    => $jumlah_potongan_perusahaan,
            "maksimal_iuran_jp"             => $this->input->post('maksimal_iuran_jp', true)
        ];
        $this->db->where('id_potongan_bpjs_ketenagakerjaan', $this->input->post('id_potongan_bpjs_ketenagakerjaan'));
        $this->db->update('potongan_bpjs_ketenagakerjaan', $data);
    }
}
