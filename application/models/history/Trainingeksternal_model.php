<?php

class Trainingeksternal_model extends CI_model
{
    //mengambil data berdasarkan NIK Karyawan untuk form tampil history training eksternal
    public function getKaryawanByNIK()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('history_training_eksternal', 'history_training_eksternal.karyawan_id=karyawan.nik_karyawan');
        $this->db->where('nik_karyawan', $nikkaryawan);
        $datakaryawan = $this->db->get()->result_array();
        return $datakaryawan;
    }

    //Mengambil semua data karyawan Untuk Validasi Form Tampil History Training Eksternal
    public function getAllKaryawan()
    {
        $nik_karyawan             = $this->input->post('nik_karyawan');

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->where('nik_karyawan', $nik_karyawan);
        $query = $this->db->get()->row_array();
        return $query;
    }

    //Query untuk menampilkan data karyawan join dengan jabatan dan penempatan untuk select nama karyawan pada form history training eksternal
    public function datakaryawan()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->order_by('nama_karyawan', 'asc');
        return $this->db->get()->result_array();
	}
	
	//Query untuk menampilkan data karyawan join dengan jabatan dan penempatan untuk select nama karyawan pada form history kontrak
    public function datadetailkaryawan($nik_karyawan)
    {

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nik_karyawan);
        return $this->db->get()->row_array();
    }

    //Mengambil semua data karyawan untuk form Edit History Training Eksternal
    public function getAllHistoryTrainingEksternalByID($id_history_training_eksternal)
    {
        $this->db->select('*');
        $this->db->from('history_training_eksternal');
        $this->db->join('karyawan', 'history_training_eksternal.karyawan_id=karyawan.nik_karyawan');
        $this->db->where('id_history_training_eksternal', $id_history_training_eksternal);
        $query = $this->db->get()->row_array();
        return $query;
    }

    //Edit Training Eksternal
    public function editTrainingEksternal()
    {
        //Dari Form
        $nik_karyawan                                   = $this->input->post('nik_karyawan');
        $institusi_penyelenggara_training_eksternal     = $this->input->post('institusi_penyelenggara_training_eksternal');
        $perihal_training_eksternal                     = $this->input->post('perihal_training_eksternal');
        $tanggal_awal_training_eksternal                = $this->input->post('tanggal_awal_training_eksternal');
        $tanggal_akhir_training_eksternal               = $this->input->post('tanggal_akhir_training_eksternal');
        $jam_training_eksternal                         = $this->input->post('jam_training_eksternal');
        $lokasi_training_eksternal                      = $this->input->post('lokasi_training_eksternal');
        $alamat_training_eksternal                      = $this->input->post('alamat_training_eksternal');
        $nomor_surat_training_eksternal                 = $this->input->post('nomor_surat_training_eksternal');

        date_default_timezone_set("Asia/Jakarta");
        $tahun                          = date('Y');
        $bulan                          = date('m');
        $tanggal                        = date('d');
        $hari                           = date("w");

        $tanggalawaltrainingeksternal   = IndonesiaTgl($tanggal_awal_training_eksternal);
        $tanggalakhirtrainingeksternal  = IndonesiaTgl($tanggal_akhir_training_eksternal);

        //Mencari Nama Hari Awal
        $tanggalawal                        = substr($tanggalawaltrainingeksternal, 0, -8);
        $bulanawal                          = substr($tanggalawaltrainingeksternal, 3, -5);
        $tahunawal                          = substr($tanggalawaltrainingeksternal, -4);
        $nama_hari_awal                     = date('w', mktime(0, 0, 0, $bulanawal, $tanggalawal, $tahunawal));
        $hari_training_eksternal_awal       = hari($nama_hari_awal);
        //Mencari Nama Hari Awal

        //Mencari Nama Hari Akhir
        $tanggalakhir                       = substr($tanggalakhirtrainingeksternal, 0, -8);
        $bulanakhir                         = substr($tanggalakhirtrainingeksternal, 3, -5);
        $tahunakhir                         = substr($tanggalakhirtrainingeksternal, -4);
        $nama_hari_akhir                    = date('w', mktime(0, 0, 0, $bulanakhir, $tanggalakhir, $tahunakhir));
        $hari_training_eksternal_akhir      = hari($nama_hari_akhir);
        //Mencari Nama Hari Akhir

        //Input Database
        $data = [
            "karyawan_id"                                   => $nik_karyawan,
            "institusi_penyelenggara_training_eksternal"    => $institusi_penyelenggara_training_eksternal,
            "perihal_training_eksternal"                    => $perihal_training_eksternal,
            "hari_awal_training_eksternal"                  => $hari_training_eksternal_awal,
            "hari_akhir_training_eksternal"                 => $hari_training_eksternal_akhir,
            "tanggal_awal_training_eksternal"               => $tanggal_awal_training_eksternal,
            "tanggal_akhir_training_eksternal"              => $tanggal_akhir_training_eksternal,
            "jam_training_eksternal"                        => $jam_training_eksternal,
            "lokasi_training_eksternal"                     => $lokasi_training_eksternal,
            "alamat_training_eksternal"                     => $alamat_training_eksternal,
            "nomor_surat_training_eksternal"                => $nomor_surat_training_eksternal
        ];
        $this->db->where('id_history_training_eksternal', $this->input->post('id_history_training_eksternal'));
        $this->db->update('history_training_eksternal', $data);
    }

    //melakukan query hapus training Eksternal
    public function hapusTrainingEksternal($id_history_training_eksternal)
    {
        $this->db->delete('history_training_eksternal', ['id_history_training_eksternal' => $id_history_training_eksternal]);
    }
}
