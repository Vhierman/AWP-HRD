<?php

class Kontrak_model extends CI_model
{

	//mengambil data berdasarkan NIK Karyawan untuk form cetak pkwt
    public function CetakPKWT($id_history_kontrak)
    {
		$this->db->select('*');
        $this->db->from('history_kontrak');
        $this->db->join('karyawan', 'history_kontrak.karyawan_id=karyawan.nik_karyawan');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('id_history_kontrak', $id_history_kontrak);
        $datakaryawan = $this->db->get()->row_array();
        return $datakaryawan;
	}
	

    //mengambil data berdasarkan NIK Karyawan untuk form tampil history kontrak
    public function getKaryawanByNIK()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('history_kontrak', 'history_kontrak.karyawan_id=karyawan.nik_karyawan');
        $this->db->where('nik_karyawan', $nikkaryawan);
        $datakaryawan = $this->db->get()->result_array();
        return $datakaryawan;
    }

    //Mengambil semua data karyawan Untuk Validasi Form Tampil History Kontrak
    public function getAllKaryawan()
    {
        $nik_karyawan             = $this->input->post('nik_karyawan');

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->where('nik_karyawan', $nik_karyawan);
        $query = $this->db->get()->row_array();
        return $query;
    }

    //Query untuk menampilkan data karyawan join dengan jabatan dan penempatan untuk select nama karyawan pada form history kontrak
    public function datakaryawan()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->order_by('nama_karyawan', 'asc');
        return $this->db->get()->result_array();
    }

    //Query untuk menambahkan data kontrak pada data history kontrak
    public function tambahdatakontrak($nikkaryawan, $tanggal_awal_kontrak, $hasiltanggalakhirkontrak, $status_kontrak_kerja, $hasilmasakontrak, $hasiljumlahkontrak)
    {
        $this->db->trans_start();

        //Mengambil Zona Waktu
        date_default_timezone_set("Asia/Jakarta");

        //Input Slip Lembur
        $result = array();
        foreach ($nikkaryawan as $key => $val) {
            $result[] = array(
                'karyawan_id'               => $_POST['nik_karyawan'][$key],
                'tanggal_awal_kontrak'      => $tanggal_awal_kontrak,
                'tanggal_akhir_kontrak'     => $hasiltanggalakhirkontrak,
                'status_kontrak_kerja'      => $status_kontrak_kerja,
                'masa_kontrak'              => $hasilmasakontrak,
                'jumlah_kontrak'            => $hasiljumlahkontrak
            );
        }
        //MULTIPLE INSERT TO HISTORY KONTRAK
        $this->db->insert_batch('history_kontrak', $result);
        $this->db->trans_complete();
    }

    //Query untuk update data kontrak pada data karyawan
    public function updatedatakontrak($nikkaryawan, $tanggal_awal_kontrak, $hasiltanggalakhirkontrak, $status_kontrak_kerja, $hasilmasakontrak)
    {
        $this->db->trans_start();

        $result = array();
        foreach ($nikkaryawan as $key => $val) {
            $result = [
                'tanggal_akhir_kerja'     => $hasiltanggalakhirkontrak,
                'status_kerja'            => $status_kontrak_kerja
            ];
            $this->db->where('nik_karyawan', $nikkaryawan[$key]);
            $this->db->update('karyawan', $result);
        }

        $this->db->trans_complete();
    }
    
    //Melakukan query untuk tambah data karyawan
    public function tambahdetaildatakontrak($nikkaryawan, $tanggal_awal_kontrak, $hasiltanggalakhirkontrak, $status_kontrak_kerja, $hasilmasakontrak, $hasiljumlahkontrak)
    {
        $datakaryawan = [
            'karyawan_id'               => $nikkaryawan,
            'tanggal_awal_kontrak'      => $tanggal_awal_kontrak,
            'tanggal_akhir_kontrak'     => $hasiltanggalakhirkontrak,
            'status_kontrak_kerja'      => $status_kontrak_kerja,
            'masa_kontrak'              => $hasilmasakontrak,
            'jumlah_kontrak'            => $hasiljumlahkontrak
        ];
        $this->db->insert('history_kontrak', $datakaryawan);
    }

    //Query untuk update data kontrak pada data karyawan
    public function updatedetaildatakontrak($nikkaryawan, $tanggal_awal_kontrak, $hasiltanggalakhirkontrak, $status_kontrak_kerja, $hasilmasakontrak)
    {
        //query edit
        $data = [
            'tanggal_akhir_kerja'     => $hasiltanggalakhirkontrak,
            'status_kerja'            => $status_kontrak_kerja
        ];
        $this->db->where('nik_karyawan', $nikkaryawan);
        $this->db->update('karyawan', $data);
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

    //mengambil data berdasarkan ID History Kontrak
    public function getHistoryKontrakByID($id_history_kontrak)
    {

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('history_kontrak', 'history_kontrak.karyawan_id=karyawan.nik_karyawan');
        $this->db->where('id_history_kontrak', $id_history_kontrak);
        $datakontrak = $this->db->get()->row_array();
        return $datakontrak;
    }

    public function editdatakontrak()
    {
        //Dari Form
        $nik_karyawan               = $this->input->post('nik_karyawan');
        $tanggal_awal_kontrak       = $this->input->post('tanggal_awal_kontrak');
        $tanggal_akhir_kontrak      = $this->input->post('tanggal_akhir_kontrak');
        $status_kontrak_kerja       = $this->input->post('status_kontrak_kerja');

        //Menghitung Jumlah Tahun Dan Bulan
        $awal_kontrak               = date_create($tanggal_awal_kontrak);
        $akhir_kontrak              = date_create($tanggal_akhir_kontrak);

        if ($status_kontrak_kerja == "PKWTT") {
            $bulan                      = 0;
            $hasiltanggalakhirkontrak   = 0000 - 00 - 00;
            $hasiljumlahkontrak         = 0;
        } else {
            $bulan                      = diffInMonths($awal_kontrak, $akhir_kontrak);
            $hasiltanggalakhirkontrak   = $tanggal_akhir_kontrak;
            $hasiljumlahkontrak         = 1;
        }

        $masakontrak                = $bulan;

        if ($masakontrak == 12) {
            $hasilmasakontrak = "1 Tahun";
        } else {
            $hasilmasakontrak = $masakontrak . " Bulan";
        }

        //query edit
        $data = [
            "karyawan_id"           => $nik_karyawan,
            "tanggal_awal_kontrak"  => $tanggal_awal_kontrak,
            "tanggal_akhir_kontrak" => $hasiltanggalakhirkontrak,
            "status_kontrak_kerja"  => $status_kontrak_kerja,
            "masa_kontrak"          => $hasilmasakontrak,
            "jumlah_kontrak"        => $hasiljumlahkontrak
        ];
        $this->db->where('id_history_kontrak', $this->input->post('id_history_kontrak'));
        $this->db->update('history_kontrak', $data);
    }

    //Edit Pada Table Karyawan
    public function editdatakontrakkaryawan()
    {
        //Dari Form
        $nik_karyawan               = $this->input->post('nik_karyawan');
        $tanggal_awal_kontrak       = $this->input->post('tanggal_awal_kontrak');
        $tanggal_akhir_kontrak      = $this->input->post('tanggal_akhir_kontrak');
        $status_kontrak_kerja       = $this->input->post('status_kontrak_kerja');

        //Menghitung Jumlah Tahun Dan Bulan
        $awal_kontrak               = date_create($tanggal_awal_kontrak);
        $akhir_kontrak              = date_create($tanggal_akhir_kontrak);

        if ($status_kontrak_kerja == "PKWTT") {
            $bulan                      = 0;
            $hasiltanggalakhirkontrak   = 0000 - 00 - 00;
            $hasiljumlahkontrak         = 0;
        } else {
            $bulan                      = diffInMonths($awal_kontrak, $akhir_kontrak);
            $hasiltanggalakhirkontrak   = $tanggal_akhir_kontrak;
            $hasiljumlahkontrak         = 1;
        }

        $masakontrak                = $bulan;

        if ($masakontrak == 12) {
            $hasilmasakontrak = "1 Tahun";
        } else {
            $hasilmasakontrak = $masakontrak . " Bulan";
        }

        //query edit
        $data = [
            "nik_karyawan"          => $nik_karyawan,
            "tanggal_akhir_kerja"   => $hasiltanggalakhirkontrak,
            "status_kerja"          => $status_kontrak_kerja
        ];
        $this->db->where('nik_karyawan', $this->input->post('nik_karyawan'));
        $this->db->update('karyawan', $data);
    }

    //melakukan query hapus history kontrak
    public function hapusdatakontrak($id_history_kontrak)
    {
        $this->db->delete('history_kontrak', ['id_history_kontrak' => $id_history_kontrak]);
    }
}
