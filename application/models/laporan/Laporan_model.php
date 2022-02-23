<?php

class Laporan_model extends CI_model
{

    //mengambil data berdasarkan Penempatan untuk form cetak laporan karyawan kontrak
    public function getPenempatan()
    {
        //Mengambil data mulai tanggal dan sampai tanggal
        $penempatan       = $this->input->post('penempatan', true);

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->where('penempatan_id', $penempatan);
        $karyawan = $this->db->get()->row_array();
        return $karyawan;
    }

    //mengambil semua data penempatan
    public function getAllPenempatan()
    {
        //Mengambil Session
        $role_id        = $this->session->userdata("role_id");
        $nik            = $this->session->userdata("nik");

        //Mengambil Data Penempatan
        $this->db->select('*');
        $this->db->from('login');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=login.nik');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nik);
        $datakaryawan = $this->db->get()->row_array();

        $penempatan = $datakaryawan['penempatan_id'];

        //Jika Yang Login Adalah HRD Maka Data Karyawan Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {
            $this->db->select('*');
            $this->db->from('penempatan');
            $query = $this->db->get()->result_array();
            return $query;
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('penempatan');
            $this->db->where_in('id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $query = $this->db->get()->result_array();
            return $query;
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 || $role_id == 14) {
            $this->db->select('*');
            $this->db->from('penempatan');
            $this->db->where_in('id ', [7, 9, 10, 11, 12, 22]);
            $query = $this->db->get()->result_array();
            return $query;
        } else {
            $this->db->select('*');
            $this->db->from('penempatan');
            $this->db->where('id', $penempatan);
            $query = $this->db->get()->result_array();
            return $query;
        }
    }

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
                    'penempatan'                 => $data->penempatan,
                    'tanggal_mulai_kerja'        => $data->tanggal_mulai_kerja,
                    'tanggal_akhir_kerja'        => $data->tanggal_akhir_kerja
                );
            }
        }
        return $hasil;
    }

    //mengambil data berdasarkan NIK Karyawan untuk form cetak laporan karyawan masuk
    public function getKaryawanMasukByNIK()
    {

        //Mengambil Session
        $role_id        = $this->session->userdata("role_id");
        $nik            = $this->session->userdata("nik");

        //Mengambil Data Penempatan
        $this->db->select('*');
        $this->db->from('login');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=login.nik');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nik);
        $datakaryawan = $this->db->get()->row_array();

        $penempatan = $datakaryawan['penempatan_id'];

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulaitanggal       = $this->input->post('mulai_tanggal', true);
        $sampaitanggal      = $this->input->post('sampai_tanggal', true);
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Jika Yang Login Adalah HRD Maka Data Karyawan Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11|| $role_id == 17|| $role_id == 18) {

            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->order_by('penempatan');
            $this->db->order_by('tanggal_mulai_kerja');
            $this->db->order_by('nama_karyawan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 && $role_id == 14) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        } else {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
	}
	
	//mengambil data berdasarkan NIK Karyawan Keluar untuk form cetak laporan karyawan masuk
    public function getLaporanKaryawanMasuk()
    {
        //Mengambil Session
        $role_id        = $this->session->userdata("role_id");
        $nik            = $this->session->userdata("nik");

        //Mengambil Data Penempatan
        $this->db->select('*');
        $this->db->from('login');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=login.nik');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nik);
        $datakaryawan = $this->db->get()->row_array();

        $penempatan = $datakaryawan['penempatan_id'];

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulaitanggal       = $this->input->post('mulai_tanggal', true);
        $sampaitanggal      = $this->input->post('sampai_tanggal', true);
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Jika Yang Login Adalah HRD Dan Accounting Maka Data Karyawan Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17 || $role_id == 18) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 && $role_id == 14) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        } else {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
	}
	
	//mengambil data berdasarkan NIK Karyawan Masuk untuk form cetak laporan karyawan masuk
    public function getLaporanKaryawanMasukExcellPrima($mulaitanggal, $sampaitanggal)
    {
        //Mengambil Session
        $role_id        = $this->session->userdata("role_id");
        $nik            = $this->session->userdata("nik");

        //Mengambil Data Penempatan
        $this->db->select('*');
        $this->db->from('login');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=login.nik');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nik);
        $datakaryawan = $this->db->get()->row_array();

        $penempatan = $datakaryawan['penempatan_id'];

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Jika Yang Login Adalah HRD Dan Accounting Maka Data Karyawan Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17 || $role_id == 18) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('perusahaan', 'karyawan.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where('perusahaan', 'PT Prima Komponen Indonesia');
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan');
            $query = $this->db->get();
            return $query->result();
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('perusahaan', 'karyawan.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan');
            $query = $this->db->get();
            return $query->result();
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 && $role_id == 14) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('perusahaan', 'karyawan.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan');
            $query = $this->db->get();
            return $query->result();
        } else {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('perusahaan', 'karyawan.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan');
            $query = $this->db->get();
            return $query->result();
        }
	}

	//mengambil data berdasarkan NIK Karyawan Masuk untuk form cetak laporan karyawan masuk
    public function getLaporanKaryawanMasukPDFPrima($mulaitanggal, $sampaitanggal)
    {
        //Mengambil Session
        $role_id        = $this->session->userdata("role_id");
        $nik            = $this->session->userdata("nik");

        //Mengambil Data Penempatan
        $this->db->select('*');
        $this->db->from('login');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=login.nik');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nik);
        $datakaryawan = $this->db->get()->row_array();

        $penempatan = $datakaryawan['penempatan_id'];

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Jika Yang Login Adalah HRD Dan Accounting Maka Data Karyawan Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17 || $role_id == 18) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('perusahaan', 'karyawan.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where('perusahaan', 'PT Prima Komponen Indonesia');
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('perusahaan', 'karyawan.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 && $role_id == 14) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('perusahaan', 'karyawan.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        } else {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('perusahaan', 'karyawan.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
    }
	
	//mengambil data berdasarkan NIK Karyawan Masuk untuk form cetak laporan karyawan masuk
    public function getLaporanKaryawanMasukExcellPetra($mulaitanggal, $sampaitanggal)
    {
        //Mengambil Session
        $role_id        = $this->session->userdata("role_id");
        $nik            = $this->session->userdata("nik");

        //Mengambil Data Penempatan
        $this->db->select('*');
        $this->db->from('login');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=login.nik');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nik);
        $datakaryawan = $this->db->get()->row_array();

        $penempatan = $datakaryawan['penempatan_id'];

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Jika Yang Login Adalah HRD Dan Accounting Maka Data Karyawan Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17 || $role_id == 18) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('perusahaan', 'karyawan.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where('perusahaan', 'PT Petra Ariesca ( Outsourching )');
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan');
            $query = $this->db->get();
            return $query->result();
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('perusahaan', 'karyawan.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan');
            $query = $this->db->get();
            return $query->result();
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 && $role_id == 14) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('perusahaan', 'karyawan.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan');
            $query = $this->db->get();
            return $query->result();
        } else {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('perusahaan', 'karyawan.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan');
            $query = $this->db->get();
            return $query->result();
        }
	}
	
	//mengambil data berdasarkan NIK Karyawan Masuk untuk form cetak laporan karyawan masuk
    public function getLaporanKaryawanMasukPDFPetra($mulaitanggal, $sampaitanggal)
    {
        //Mengambil Session
        $role_id        = $this->session->userdata("role_id");
        $nik            = $this->session->userdata("nik");

        //Mengambil Data Penempatan
        $this->db->select('*');
        $this->db->from('login');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=login.nik');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nik);
        $datakaryawan = $this->db->get()->row_array();

        $penempatan = $datakaryawan['penempatan_id'];

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Jika Yang Login Adalah HRD Dan Accounting Maka Data Karyawan Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17 || $role_id == 18) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('perusahaan', 'karyawan.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where('perusahaan', 'PT Petra Ariesca ( Outsourching )');
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('perusahaan', 'karyawan.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 && $role_id == 14) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('perusahaan', 'karyawan.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        } else {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('perusahaan', 'karyawan.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_mulai_kerja >= ', $mulaitanggal);
            $this->db->where('tanggal_mulai_kerja <= ', $sampaitanggal);
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
    }

    //mengambil data berdasarkan NIK Karyawan Keluar untuk form cetak laporan karyawan keluar
    public function getLaporanKaryawanKeluar()
    {
        //Mengambil Session
        $role_id        = $this->session->userdata("role_id");
        $nik            = $this->session->userdata("nik");

        //Mengambil Data Penempatan
        $this->db->select('*');
        $this->db->from('login');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=login.nik');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nik);
        $datakaryawan = $this->db->get()->row_array();

        $penempatan = $datakaryawan['penempatan_id'];

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulaitanggal       = $this->input->post('mulai_tanggal', true);
        $sampaitanggal      = $this->input->post('sampai_tanggal', true);
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Jika Yang Login Adalah HRD Dan Accounting Maka Data Karyawan Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17 || $role_id == 18) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 && $role_id == 14) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        } else {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
    }

    //mengambil data berdasarkan NIK Karyawan Keluar untuk form cetak laporan karyawan keluar
    public function getLaporanKaryawanKeluarPDFPrima($mulaitanggal, $sampaitanggal)
    {
        //Mengambil Session
        $role_id        = $this->session->userdata("role_id");
        $nik            = $this->session->userdata("nik");

        //Mengambil Data Penempatan
        $this->db->select('*');
        $this->db->from('login');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=login.nik');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nik);
        $datakaryawan = $this->db->get()->row_array();

        $penempatan = $datakaryawan['penempatan_id'];

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Jika Yang Login Adalah HRD Dan Accounting Maka Data Karyawan Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17 || $role_id == 18) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('perusahaan', 'karyawan_keluar.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where('perusahaan', 'PT Prima Komponen Indonesia');
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan_keluar');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 && $role_id == 14) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        } else {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
    }

    //mengambil data berdasarkan NIK Karyawan Keluar untuk form cetak laporan karyawan keluar
    public function getLaporanKaryawanKeluarExcellPrima($mulaitanggal, $sampaitanggal)
    {
        //Mengambil Session
        $role_id        = $this->session->userdata("role_id");
        $nik            = $this->session->userdata("nik");

        //Mengambil Data Penempatan
        $this->db->select('*');
        $this->db->from('login');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=login.nik');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nik);
        $datakaryawan = $this->db->get()->row_array();

        $penempatan = $datakaryawan['penempatan_id'];

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Jika Yang Login Adalah HRD Dan Accounting Maka Data Karyawan Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17 || $role_id == 18) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('perusahaan', 'karyawan_keluar.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where('perusahaan', 'PT Prima Komponen Indonesia');
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan_keluar');
            $query = $this->db->get();
            return $query->result();
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan_keluar');
            $query = $this->db->get();
            return $query->result();
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 && $role_id == 14) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan_keluar');
            $query = $this->db->get();
            return $query->result();
        } else {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan_keluar');
            $query = $this->db->get();
            return $query->result();
        }
    }

    //mengambil data berdasarkan NIK Karyawan Keluar untuk form cetak laporan karyawan keluar
    public function getLaporanKaryawanKeluarPDFPetra($mulaitanggal, $sampaitanggal)
    {
        //Mengambil Session
        $role_id        = $this->session->userdata("role_id");
        $nik            = $this->session->userdata("nik");

        //Mengambil Data Penempatan
        $this->db->select('*');
        $this->db->from('login');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=login.nik');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nik);
        $datakaryawan = $this->db->get()->row_array();

        $penempatan = $datakaryawan['penempatan_id'];

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Jika Yang Login Adalah HRD Dan Accounting Maka Data Karyawan Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17 || $role_id == 18) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('perusahaan', 'karyawan_keluar.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where('perusahaan', 'PT Petra Ariesca ( Outsourching )');
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan_keluar');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 && $role_id == 14) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        } else {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
    }

    //mengambil data berdasarkan NIK Karyawan Keluar untuk form cetak laporan karyawan keluar
    public function getLaporanKaryawanKeluarExcellPetra($mulaitanggal, $sampaitanggal)
    {
        //Mengambil Session
        $role_id        = $this->session->userdata("role_id");
        $nik            = $this->session->userdata("nik");

        //Mengambil Data Penempatan
        $this->db->select('*');
        $this->db->from('login');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=login.nik');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nik);
        $datakaryawan = $this->db->get()->row_array();

        $penempatan = $datakaryawan['penempatan_id'];

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Jika Yang Login Adalah HRD Dan Accounting Maka Data Karyawan Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17 || $role_id == 18) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('perusahaan', 'karyawan_keluar.perusahaan_id=perusahaan.id');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where('perusahaan', 'PT Petra Ariesca ( Outsourching )');
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan_keluar');
            $query = $this->db->get();
            return $query->result();
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan_keluar');
            $query = $this->db->get();
            return $query->result();
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 && $role_id == 14) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan_keluar');
            $query = $this->db->get();
            return $query->result();
        } else {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('penempatan');
            $this->db->order_by('nama_karyawan_keluar');
            $query = $this->db->get();
            return $query->result();
        }
    }

    //mengambil data berdasarkan NIK Karyawan Keluar untuk form cetak laporan karyawan keluar
    public function getKaryawanKeluarByNIK()
    {
        //Mengambil Session
        $role_id        = $this->session->userdata("role_id");
        $nik            = $this->session->userdata("nik");

        //Mengambil Data Penempatan
        $this->db->select('*');
        $this->db->from('login');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=login.nik');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nik);
        $datakaryawan = $this->db->get()->row_array();

        $penempatan = $datakaryawan['penempatan_id'];

        //Mengambil data mulai tanggal dan sampai tanggal
        $mulaitanggal       = $this->input->post('mulai_tanggal', true);
        $sampaitanggal      = $this->input->post('sampai_tanggal', true);
        $mulai_tanggal      = IndonesiaTgl($mulaitanggal);
        $sampai_tanggal     = IndonesiaTgl($sampaitanggal);

        //Jika Yang Login Adalah HRD Dan Accounting Maka Data Karyawan Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17 || $role_id == 18) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 && $role_id == 14) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        } else {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('tanggal_keluar_karyawan_keluar >= ', $mulaitanggal);
            $this->db->where('tanggal_keluar_karyawan_keluar <= ', $sampaitanggal);
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
    }

    //mengambil data berdasarkan Penempatan untuk form cetak laporan karyawan kontrak
    public function getKaryawanKontrakByPenempatan()
    {

        $penempatan       = $this->input->post('penempatan', true);

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->where('penempatan_id', $penempatan);
        $this->db->where('status_kerja', 'PKWT');
        $karyawan = $this->db->get()->result_array();
        return $karyawan;
    }

    //mengambil data berdasarkan Penempatan untuk form cetak laporan karyawan tetap
    public function getKaryawanTetapByPenempatan()
    {
        $penempatan       = $this->input->post('penempatan', true);

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->where('penempatan_id', $penempatan);
        $this->db->where('status_kerja', 'PKWTT');
        $karyawan = $this->db->get()->result_array();
        return $karyawan;
    }

    //mengambil data berdasarkan Penempatan untuk form cetak laporan siswa
    public function getSiswaByPenempatan()
    {
        $penempatan       = $this->input->post('penempatan', true);

        $this->db->select('*');
        $this->db->from('siswa');
        $this->db->join('penempatan', 'siswa.penempatan_id=penempatan.id');
        $this->db->join('sekolah', 'siswa.sekolah_id=sekolah.id_sekolah');
        $this->db->where('penempatan_id', $penempatan);
        $karyawan = $this->db->get()->result_array();
        return $karyawan;
    }

    //mengambil data berdasarkan Penempatan untuk form cetak laporan magang
    public function getMagangByPenempatan()
    {
        $penempatan       = $this->input->post('penempatan', true);

        $this->db->select('*');
        $this->db->from('magang');
        $this->db->join('penempatan', 'magang.penempatan_id=penempatan.id');
        $this->db->where('penempatan_id', $penempatan);
        $karyawan = $this->db->get()->result_array();
        return $karyawan;
    }

    //mengambil data laporan inventaris laptop
    public function getLaporanInventarisLaptop()
    {
        //Mengambil Session
        $role_id        = $this->session->userdata("role_id");
        $nik            = $this->session->userdata("nik");

        //Mengambil Data Penempatan
        $this->db->select('*');
        $this->db->from('login');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=login.nik');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nik);
        $datakaryawan = $this->db->get()->row_array();

        $penempatan = $datakaryawan['penempatan_id'];

        //Jika Yang Login Adalah HRD Maka Data Karyawan Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17 || $role_id == 18)  {
            $this->db->select('*');
            $this->db->from('inventaris_laptop');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_laptop.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('inventaris_laptop');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_laptop.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 && $role_id == 14) {
            $this->db->select('*');
            $this->db->from('inventaris_laptop');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_laptop.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        } else {
            $this->db->select('*');
            $this->db->from('inventaris_laptop');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_laptop.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
    }

    //mengambil data laporan inventaris motor
    public function getLaporanInventarisMotor()
    {
        //Mengambil Session
        $role_id        = $this->session->userdata("role_id");
        $nik            = $this->session->userdata("nik");

        //Mengambil Data Penempatan
        $this->db->select('*');
        $this->db->from('login');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=login.nik');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nik);
        $datakaryawan = $this->db->get()->row_array();

        $penempatan = $datakaryawan['penempatan_id'];

        //Jika Yang Login Adalah HRD Maka Data Karyawan Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17 || $role_id == 18) {
            $this->db->select('*');
            $this->db->from('inventaris_motor');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_motor.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('inventaris_motor');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_motor.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 || $role_id == 14) {
            $this->db->select('*');
            $this->db->from('inventaris_motor');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_motor.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        } else {
            $this->db->select('*');
            $this->db->from('inventaris_motor');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_motor.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
    }

    //mengambil data laporan inventaris mobil
    public function getLaporanInventarisMobil()
    {
        //Mengambil Session
        $role_id        = $this->session->userdata("role_id");
        $nik            = $this->session->userdata("nik");

        //Mengambil Data Penempatan
        $this->db->select('*');
        $this->db->from('login');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=login.nik');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nik);
        $datakaryawan = $this->db->get()->row_array();

        $penempatan = $datakaryawan['penempatan_id'];

        //Jika Yang Login Adalah HRD Dan Accounting Maka Data Karyawan Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17 || $role_id == 18) {
            $this->db->select('*');
            $this->db->from('inventaris_mobil');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_mobil.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('inventaris_mobil');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_mobil.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
        //Jika Yang Login Adalah Supervisor , Manager , Deputy Manager PPC
        elseif ($role_id == 13 || $role_id == 14) {
            $this->db->select('*');
            $this->db->from('inventaris_mobil');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_mobil.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        } else {
            $this->db->select('*');
            $this->db->from('inventaris_mobil');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_mobil.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('penempatan');
            $karyawan = $this->db->get()->result_array();
            return $karyawan;
        }
    }

    //mengambil data berdasarkan NIK Karyawan untuk form cetak laporan absen Karyawan
    public function getLaporanAbsenKaryawanByNIK()
    {

        //Mengambil data dari form input
        $nikkaryawan       = $this->input->post('nik_karyawan', true);

        $tanggalmulailaporanabsen       = $this->input->post('tanggal_mulai_laporan_absen', true);
        $tanggalselesailaporanabsen     = $this->input->post('tanggal_selesai_laporan_absen', true);

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nikkaryawan);
        $karyawan = $this->db->get()->row_array();
        return $karyawan;
    }

    //mengambil data berdasarkan NIK Karyawan untuk form cetak laporan absen Karyawan
    public function getLaporanAbsenKaryawan()
    {

        //Mengambil data dari form input
        $nikkaryawan       = $this->input->post('nik_karyawan', true);

        $tanggalmulailaporanabsen       = $this->input->post('tanggal_mulai_laporan_absen', true);
        $tanggalselesailaporanabsen     = $this->input->post('tanggal_selesai_laporan_absen', true);

        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=absensi.nik_karyawan_absen');
        $this->db->where('nik_karyawan', $nikkaryawan);
        $this->db->where('tanggal_absen >= ', $tanggalmulailaporanabsen);
        $this->db->where('tanggal_absen <= ', $tanggalselesailaporanabsen);
        $datakaryawan = $this->db->get()->result_array();
        return $datakaryawan;
	}
	

	//mengambil data ABSENSI BERDASARKAN TANGGAL ABSEN
    public function getLaporanKPIAbsensi()
    {

        //Mengambil data dari form input

        $mulai_tanggal       	= $this->input->post('mulai_tanggal', true);
        $sampai_tanggal     	= $this->input->post('sampai_tanggal', true);

        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=absensi.nik_karyawan_absen');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('tanggal_absen >= ', $mulai_tanggal);
		$this->db->where('tanggal_absen <= ', $sampai_tanggal);
		$this->db->where_in('keterangan_absen', ["Sakit","Ijin","Alpa"]);
		$this->db->order_by('penempatan');
		$this->db->order_by('nama_karyawan');
        $data = $this->db->get()->result_array();
        return $data;
	}

	//mengambil data Jumlah Absen
    public function getJumlahAbsenKaryawan()
    {

        //Mengambil data dari form input

        $mulai_tanggal       	= $this->input->post('mulai_tanggal', true);
        $sampai_tanggal     	= $this->input->post('sampai_tanggal', true);

        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=absensi.nik_karyawan_absen');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('tanggal_absen >= ', $mulai_tanggal);
		$this->db->where('tanggal_absen <= ', $sampai_tanggal);
		$this->db->where_in('keterangan_absen', ["Sakit","Ijin","Alpa"]);
		return $this->db->get()->num_rows();
	}
	
	//mengambil data Jumlah Karyawan Untuk KPI
    public function getJumlahKaryawanKPI()
    {

        //Mengambil data dari form input

        $mulai_tanggal       	= $this->input->post('mulai_tanggal', true);
        $sampai_tanggal     	= $this->input->post('sampai_tanggal', true);

        $this->db->select('*');
        $this->db->from('history_gaji');
        $this->db->where('periode_awal_gaji_history >= ', $mulai_tanggal);
		$this->db->where('periode_akhir_gaji_history <= ', $sampai_tanggal);
        return $this->db->get()->num_rows();
    }
}
