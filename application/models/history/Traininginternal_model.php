<?php

class Traininginternal_model extends CI_model
{
    //mengambil data berdasarkan NIK Karyawan untuk form tampil history training internal
    public function getKaryawanByNIK()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('history_training_internal', 'history_training_internal.karyawan_id=karyawan.nik_karyawan');
        $this->db->where('nik_karyawan', $nikkaryawan);
        $datakaryawan = $this->db->get()->result_array();
        return $datakaryawan;
    }

    //Mengambil semua data karyawan Untuk Validasi Form Tampil History Training Internal
    public function getAllKaryawan()
    {
        $nik_karyawan             = $this->input->post('nik_karyawan');

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->where('nik_karyawan', $nik_karyawan);
        $query = $this->db->get()->row_array();
        return $query;
    }

    //Query untuk menampilkan data karyawan join dengan jabatan dan penempatan untuk select nama karyawan pada form history training internal
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

    //Mengambil semua data karyawan untuk form Edit History Training Internal
    public function getAllHistoryTrainingInternalByID($id_history_training_internal)
    {
        $this->db->select('*');
        $this->db->from('history_training_internal');
        $this->db->join('karyawan', 'history_training_internal.karyawan_id=karyawan.nik_karyawan');
        $this->db->where('id_history_training_internal', $id_history_training_internal);
        $query = $this->db->get()->row_array();
        return $query;
    }

    //Edit Training Internal
    public function editTrainingInternal()
    {
        //Dari Form
        $nik_karyawan                           = $this->input->post('nik_karyawan');
        $tanggal_training_internal              = $this->input->post('tanggal_training_internal');
        $jam_training_internal                  = $this->input->post('jam_training_internal');
        $lokasi_training_internal               = $this->input->post('lokasi_training_internal');
        $materi_training_internal               = $this->input->post('materi_training_internal');
        $penilaian_sebelum_training_internal    = $this->input->post('penilaian_sebelum_training_internal');
        $penilaian_sesudah_training_internal    = $this->input->post('penilaian_sesudah_training_internal');
        $trainer_training_internal              = $this->input->post('trainer_training_internal');

        date_default_timezone_set("Asia/Jakarta");
        $tahun                          = date('Y');
        $bulan                          = date('m');
        $tanggal                        = date('d');
        $hari                           = date("w");

        $tanggaltraininginternal        = IndonesiaTgl($tanggal_training_internal);
        //Mengambil masing masing 2 digit
        $tanggal                        = substr($tanggaltraininginternal, 0, -8);
        $bulan                          = substr($tanggaltraininginternal, 3, -5);
        $tahun                          = substr($tanggaltraininginternal, -4);
        $nama_hari                      = date('w', mktime(0, 0, 0, $bulan, $tanggal, $tahun));
        $hari_training_internal         = hari($nama_hari);
        //Mencari Nama Hari

        //Input Database
        $data = [
            "karyawan_id"                           => $nik_karyawan,
            "hari_training_internal"                => $hari_training_internal,
            "tanggal_training_internal"             => $tanggal_training_internal,
            "jam_training_internal"                 => $jam_training_internal,
            "lokasi_training_internal"              => $lokasi_training_internal,
            "materi_training_internal"              => $materi_training_internal,
            "penilaian_sebelum_training_internal"   => $penilaian_sebelum_training_internal,
            "penilaian_sesudah_training_internal"   => $penilaian_sesudah_training_internal,
            "trainer_training_internal"             => $trainer_training_internal
        ];
        $this->db->where('id_history_training_internal', $this->input->post('id_history_training_internal'));
        $this->db->update('history_training_internal', $data);
    }

    //melakukan query hapus training internal
    public function hapusTrainingInternal($id_history_training_internal)
    {
        $this->db->delete('history_training_internal', ['id_history_training_internal' => $id_history_training_internal]);
	}
	
	
}
