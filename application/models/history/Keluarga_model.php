<?php

class Keluarga_model extends CI_model
{

    //Query untuk onchange mencari data karyawan berdasarkan nik karyawan
    function get_karyawan_bynik($nik_karyawan)
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->where('nik_karyawan', $nik_karyawan);
        $hsl = $this->db->get()->row_array();
        return $hsl;

        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'nik_karyawan'               => $data->nik_karyawan,
                    'nama_karyawan'              => $data->nama_karyawan,
                    'jabatan'                    => $data->jabatan,
                    'penempatan'                 => $data->penempatan
                );
            }
        }
        return $hasil;
    }

    //mengambil data berdasarkan NIK Karyawan untuk form tampil history keluarga
    public function getKaryawanByNIK()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('history_keluarga', 'history_keluarga.karyawan_id=karyawan.nik_karyawan');
        $this->db->where('nik_karyawan', $nikkaryawan);
        $datakaryawan = $this->db->get()->result_array();
        return $datakaryawan;
    }

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

    //Mengambil semua data karyawan untuk form tambah history keluarga
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

    //Mengambil semua data karyawan untuk form tambah history keluarga
    public function getAllHistoryKeluargaByID($id_history_keluarga)
    {
        $this->db->select('*');
        $this->db->from('history_keluarga');
        $this->db->join('karyawan', 'history_keluarga.karyawan_id=karyawan.nik_karyawan');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->where('id_history_keluarga', $id_history_keluarga);
        $query = $this->db->get()->row_array();
        return $query;
    }

    //Edit History Keluarga
    public function editKeluarga()
    {
        //query edit
        $data = [
        "hubungan_keluarga"                         => $this->input->post('hubungan_keluarga', true),
        "nik_history_keluarga"                      => $this->input->post('nik_history_keluarga', true),
        "nomor_bpjs_kesehatan_history_keluarga"     => $this->input->post('nomor_bpjs_kesehatan_history_keluarga', true),
        "nama_history_keluarga"                     => $this->input->post('nama_history_keluarga', true),
        "jenis_kelamin_history_keluarga"            => $this->input->post('jenis_kelamin_history_keluarga', true),
        "tempat_lahir_history_keluarga"             => $this->input->post('tempat_lahir_history_keluarga', true),
        "tanggal_lahir_history_keluarga"            => $this->input->post('tanggal_lahir_history_keluarga', true),
        "golongan_darah_history_keluarga"           => $this->input->post('golongan_darah_history_keluarga', true)
        ];
        $this->db->where('id_history_keluarga', $this->input->post('id_history_keluarga'));
        $this->db->update('history_keluarga', $data);
    }

    //melakukan query hapus keluarga
    public function hapusKeluarga($id_history_keluarga)
    {
        $this->db->delete('history_keluarga', ['id_history_keluarga' => $id_history_keluarga]);
    }

}
