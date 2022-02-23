<?php

class Pendidikanformal_model extends CI_model
{
    //Mengambil semua data karyawan Untuk Validasi Form Tampil History Keluarga
    public function getAllKaryawan()
    {
        $nik_karyawan             = $this->input->post('nik_karyawan');

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->where('nik_karyawan', $nik_karyawan);
        $query = $this->db->get()->row_array();
        return $query;
    }

    //mengambil data berdasarkan NIK Karyawan untuk form tampil history pendidikan formal
    public function getKaryawanByNIK()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('history_pendidikan_formal', 'history_pendidikan_formal.karyawan_id=karyawan.nik_karyawan');
        $this->db->where('nik_karyawan', $nikkaryawan);
        $datakaryawan = $this->db->get()->result_array();
        return $datakaryawan;
    }

    //Mengambil semua data karyawan untuk form tambah history pendidikan formal
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

    //Mengambil semua data karyawan untuk form tambah history pendidikan formal
    public function getAllHistoryPendidikanFormalByID($id_history_pendidikan_formal)
    {
        $this->db->select('*');
        $this->db->from('history_pendidikan_formal');
        $this->db->join('karyawan', 'history_pendidikan_formal.karyawan_id=karyawan.nik_karyawan');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->where('id_history_pendidikan_formal', $id_history_pendidikan_formal);
        $query = $this->db->get()->row_array();
        return $query;
    }

    //Edit History Pendidikan Formal
    public function editPendidikanFormal()
    {
        //query edit
        $data = [
            "tingkat_pendidikan_formal"             => $this->input->post('tingkat_pendidikan_formal', true),
            "nama_instansi_pendidikan"              => $this->input->post('nama_instansi_pendidikan', true),
            "jurusan"                               => $this->input->post('jurusan', true),
            "tahun_lulus"                           => $this->input->post('tahun_lulus', true)
        ];
        $this->db->where('id_history_pendidikan_formal', $this->input->post('id_history_pendidikan_formal'));
        $this->db->update('history_pendidikan_formal', $data);
    }

    //melakukan query hapus pendidikan formal
    public function hapusPendidikanFormal($id_history_pendidikan_formal)
    {
        $this->db->delete('history_pendidikan_formal', ['id_history_pendidikan_formal' => $id_history_pendidikan_formal]);
    }
}
