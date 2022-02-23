<?php

class Bpjsks_model extends CI_model
{
    //mengambil semua data iuran bpjs kesehatan
    public function getAllBPJSKS()
    {
        $query = $this->db->get('potongan_bpjs_kesehatan')->result_array();
        return $query;
    }

    //mengambil data iuran bpjs kesehatan berdasarkan ID nya
    public function getBPJSKSByID($id_potongan_bpjs_kesehatan)
    {
        return $this->db->get_where('potongan_bpjs_kesehatan', ['id_potongan_bpjs_kesehatan' => $id_potongan_bpjs_kesehatan])->row_array();
    }

    //melakukan query edit iuran bpjs kesehatan
    public function editBPJSKS()
    {
        $data = [
            "potongan_bpjs_kesehatan_karyawan"      => $this->input->post('potongan_bpjs_kesehatan_karyawan', true),
            "potongan_bpjs_kesehatan_perusahaan"    => $this->input->post('potongan_bpjs_kesehatan_perusahaan', true),
            "maksimal_iuran_bpjs_kesehatan"         => $this->input->post('maksimal_iuran_bpjs_kesehatan', true)
        ];
        $this->db->where('id_potongan_bpjs_kesehatan', $this->input->post('id_potongan_bpjs_kesehatan'));
        $this->db->update('potongan_bpjs_kesehatan', $data);
    }
}
