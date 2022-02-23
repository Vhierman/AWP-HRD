<?php

class Jabatan_model extends CI_model
{
    //mengambil data berdasarkan NIK Karyawan untuk form tampil history Jabatan
    public function getKaryawanByNIK()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);

        $this->db->select('*');
        $this->db->from('history_jabatan');
        $this->db->join('karyawan', 'history_jabatan.karyawan_id=karyawan.nik_karyawan');
        $this->db->join('penempatan', 'history_jabatan.penempatan_id_history_jabatan=penempatan.id');
        $this->db->join('jabatan', 'history_jabatan.jabatan_id_history_jabatan=jabatan.id');
        $this->db->where('karyawan_id', $nikkaryawan);
        $datakaryawan = $this->db->get()->result_array();
        return $datakaryawan;
    }

    //Mengambil semua data karyawan Untuk Validasi Form Tampil History Jabatan
    public function getAllKaryawan()
    {
        $nik_karyawan             = $this->input->post('nik_karyawan');

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->where('nik_karyawan', $nik_karyawan);
        $query = $this->db->get()->row_array();
        return $query;
    }

    //Mengambil semua data karyawan untuk form tambah history jabatan
    public function getAllKaryawanByNIK($nik_karyawan)
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->where('nik_karyawan', $nik_karyawan);
        $query = $this->db->get()->row_array();
        return $query;
    }

    //Mengambil semua data jabatan Untuk Form Tambah History Jabatan
    public function getAllJabatan()
    {
        $this->db->select('*');
        $this->db->from('jabatan');
        $query = $this->db->get()->result_array();
        return $query;
    }

    //Mengambil semua data penempatan Untuk Form Tambah History Jabatan
    public function getAllPenempatan()
    {
        $this->db->select('*');
        $this->db->from('penempatan');
        $query = $this->db->get()->result_array();
        return $query;
    }

    //Mengambil semua data karyawan untuk form tambah history Jabatan
    public function getAllHistoryJabatanByID($id_history_jabatan)
    {
        $this->db->select('*');
        $this->db->from('history_jabatan');
        $this->db->join('karyawan', 'history_jabatan.karyawan_id=karyawan.nik_karyawan');
        $this->db->join('penempatan', 'history_jabatan.penempatan_id_history_jabatan=penempatan.id');
        $this->db->join('jabatan', 'history_jabatan.jabatan_id_history_jabatan=jabatan.id');
        $this->db->where('id_history_jabatan', $id_history_jabatan);
        $query = $this->db->get()->row_array();

        return $query;
    }

    //Edit Jabatan Pada Table Karyawan
    public function editJabatanKaryawan()
    {

        $nik_karyawan             = $this->input->post('nik_karyawan');

        //query edit
        $data = [
            "penempatan_id"     => $this->input->post('penempatan_id_history_jabatan', true),
            "jabatan_id"        => $this->input->post('jabatan_id_history_jabatan', true)
        ];
        $this->db->where('nik_karyawan', $this->input->post('nik_karyawan'));
        $this->db->update('karyawan', $data);
    }

    //Edit History Jabatan
    public function editJabatan()
    {
        //query edit
        $data = [
            "penempatan_id_history_jabatan"     => $this->input->post('penempatan_id_history_jabatan', true),
            "jabatan_id_history_jabatan"        => $this->input->post('jabatan_id_history_jabatan', true),
            "tanggal_mutasi"                    => $this->input->post('tanggal_mutasi', true)
        ];
        $this->db->where('id_history_jabatan', $this->input->post('id_history_jabatan'));
        $this->db->update('history_jabatan', $data);
    }

    //melakukan query hapus jabatam
    public function hapusJabatan($id_history_jabatan)
    {
        $this->db->delete('history_jabatan', ['id_history_jabatan' => $id_history_jabatan]);
    }
}
