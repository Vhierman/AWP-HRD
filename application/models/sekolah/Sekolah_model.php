<?php

class Sekolah_model extends CI_model
{
    //Query untuk menampilkan data sekolah 
    public function datasekolah()
    {
        $this->db->select('*');
        $this->db->from('sekolah');
        $this->db->order_by('nama_sekolah', 'asc');
        return $this->db->get()->result_array();
    }

    //Query untuk cari data sekolah berdasarkan id_sekolah
    public function getSekolahByID($id_sekolah)
    {
        $this->db->select('*');
        $this->db->from('sekolah');
        $this->db->where('id_sekolah', $id_sekolah);
        return $this->db->get()->row_array();
    }

    //Melakukan query untuk tambah data absensi
    public function tambahSekolah()
    {
        //query input sekolah
        $datasekolah = [
            "nama_sekolah"                              => $this->input->post('nama_sekolah', true),
            "alamat_sekolah"                            => $this->input->post('alamat_sekolah', true),
            "nomor_telepon_sekolah"                     => $this->input->post('nomor_telepon_sekolah', true),
            "email_sekolah"                             => $this->input->post('email_sekolah', true),
            "nama_guru_pembimbing"                      => $this->input->post('nama_guru_pembimbing', true),
            "nomor_handphone_guru_pembimbing"           => $this->input->post('nomor_handphone_guru_pembimbing', true)
        ];
        $this->db->insert('sekolah', $datasekolah);
    }

    //Query untuk proses edit sekolah
    public function editSekolah()
    {
        //query edit sekolah
        $data = [
            "nama_sekolah"                      => $this->input->post('nama_sekolah', true),
            "alamat_sekolah"                    => $this->input->post('alamat_sekolah', true),
            "nomor_telepon_sekolah"             => $this->input->post('nomor_telepon_sekolah', true),
            "email_sekolah"                     => $this->input->post('email_sekolah', true),
            "nama_guru_pembimbing"              => htmlspecialchars($this->input->post('nama_guru_pembimbing', true)),
            "nomor_handphone_guru_pembimbing"   => $this->input->post('nomor_handphone_guru_pembimbing', true)
        ];
        $this->db->where('id_sekolah', $this->input->post('id_sekolah'));
        $this->db->update('sekolah', $data);
    }

    //melakukan query hapus sekolah
    public function hapusSekolah($id_sekolah)
    {
        $this->db->delete('sekolah', ['id_sekolah' => $id_sekolah]);
    }
}
