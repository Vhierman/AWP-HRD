<?php

class Lembur_model extends CI_model
{
    //Query untuk menampilkan data penempatan UNTUK FORM SLIP LEMBUR
    public function datapenempatan()
    {
        $this->db->select('*');
        $this->db->from('penempatan');
        $this->db->order_by('penempatan', 'asc');
        return $this->db->get()->result_array();
    }

    //Query untuk menampilkan data jam lembur UNTUK FORM Edit LEMBUR
    public function getAllJamLembur()
    {
        $this->db->select('*');
        $this->db->from('jam_lembur');
        $this->db->order_by('jam_masuk', 'asc');
        return $this->db->get()->result_array();
    }

    //Query untuk menampilkan data keterangan lembur UNTUK FORM Edit LEMBUR
    public function getAllKeteranganLembur()
    {
        $this->db->select('*');
        $this->db->from('keterangan_lembur');
        $this->db->order_by('keterangan_lembur', 'asc');
        return $this->db->get()->result_array();
    }

    //Query untuk menampilkan data penempatan UNTUK CETAK SLIP LEMBUR Berdasarkan penempatan nya
    public function datapenempatanByID()
    {
        $penempatan         = $this->input->post('penempatan', true);
        $this->db->select('*');
        $this->db->from('penempatan');
        $this->db->where('id', $penempatan);
        $this->db->order_by('penempatan', 'asc');
        return $this->db->get()->row_array();
    }

    //Query Slip Lembur Kecil
    public function datacetaksliplemburkecil()
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

        //Jika Yang Login Adalah HRD Maka Akan Tampil Semua Data
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {

        $mulaitanggal         = $this->input->post('mulai_tanggal', true);
        $sampaitanggal        = $this->input->post('sampai_tanggal', true);
        $penempatan           = $this->input->post('penempatan', true);

        $query = "SELECT * FROM slip_lembur

        JOIN karyawan   ON karyawan.nik_karyawan    = slip_lembur.karyawan_id
        JOIN jabatan    ON jabatan.id               = karyawan.jabatan_id
        JOIN penempatan ON penempatan.id            = karyawan.penempatan_id
        JOIN jam_lembur ON jam_lembur.id_jam_lembur = slip_lembur.jam_lembur_id

        WHERE 
        acc_supervisor != '' AND acc_manager != '' AND acc_hrd != ''
        AND penempatan_id ='$penempatan' 
        AND tanggal_lembur >= '$mulaitanggal' 
        AND tanggal_lembur <='$sampaitanggal'
        
        GROUP BY nama_karyawan
       
        HAVING (COUNT(karyawan_id)) <= 10

        ORDER BY nama_karyawan
        
        ";

        $queryhasil = $this->db->query($query)->result_array();
        return $queryhasil;

        //dan mendirect kehalaman kesalahan
        } 
        else 
        {
            redirect('auth/blocked');
        }
    }

    //Query Slip Lembur Besar
    public function datacetaksliplemburbesar()
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

        //Jika Yang Login Adalah HRD Maka Akan Tampil Semua Data
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {

        $mulaitanggal         = $this->input->post('mulai_tanggal', true);
        $sampaitanggal        = $this->input->post('sampai_tanggal', true);
        $penempatan           = $this->input->post('penempatan', true);

        $query = "SELECT * FROM slip_lembur

        JOIN karyawan   ON karyawan.nik_karyawan    = slip_lembur.karyawan_id
        JOIN jabatan    ON jabatan.id               = karyawan.jabatan_id
        JOIN penempatan ON penempatan.id            = karyawan.penempatan_id
        JOIN jam_lembur ON jam_lembur.id_jam_lembur = slip_lembur.jam_lembur_id

        WHERE 
        acc_supervisor != '' AND acc_manager != '' AND acc_hrd != ''
        AND penempatan_id ='$penempatan' 
        AND tanggal_lembur >= '$mulaitanggal' 
        AND tanggal_lembur <='$sampaitanggal'
        
        GROUP BY nama_karyawan
       
        HAVING (COUNT(karyawan_id)) > 10

        ORDER BY nama_karyawan
        
        ";

        $queryhasil = $this->db->query($query)->result_array();
        return $queryhasil;

        //dan mendirect kehalaman kesalahan
        } 
        else 
        {
            redirect('auth/blocked');
        }
    }

    //Query Rekap Lembur 
    public function datacetakrekaplembur()
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

        //Jika Yang Login Adalah HRD Maka Akan Tampil Semua Data
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {

        $mulaitanggal         = $this->input->post('mulai_tanggal', true);
        $sampaitanggal        = $this->input->post('sampai_tanggal', true);
        $penempatan           = $this->input->post('penempatan', true);

        $query = "SELECT 
        
        karyawan.nik_karyawan,
        karyawan.nama_karyawan,
        karyawan.upah_lembur_perjam,

        penempatan.id,
        penempatan.penempatan,

        jabatan.id,
        jabatan.jabatan,

        history_gaji.id_history_gaji,
        history_gaji.karyawan_id_history,
        history_gaji.upah_lembur_perjam_history,

        slip_lembur.karyawan_id,
        slip_lembur.tanggal_lembur,
        slip_lembur.jumlah_jam_pertama,
        slip_lembur.jumlah_jam_kedua,
        slip_lembur.jumlah_jam_ketiga,
        slip_lembur.jumlah_jam_keempat,
        slip_lembur.uang_makan_lembur,

        
        SUM(jumlah_jam_pertama) AS total_jam_pertama,
        SUM(jumlah_jam_kedua) AS total_jam_kedua,
        SUM(jumlah_jam_ketiga) AS total_jam_ketiga,
        SUM(jumlah_jam_keempat) AS total_jam_keempat,
        SUM(uang_makan_lembur) AS jumlahuangmakanlembur
        
        FROM slip_lembur
        JOIN karyawan       ON karyawan.nik_karyawan                = slip_lembur.karyawan_id
        JOIN history_gaji   ON history_gaji.karyawan_id_history     = karyawan.nik_karyawan
        JOIN jabatan        ON jabatan.id                           = karyawan.jabatan_id
        JOIN penempatan     ON penempatan.id                        = karyawan.penempatan_id
        JOIN jam_lembur     ON jam_lembur.id_jam_lembur             = slip_lembur.jam_lembur_id

        WHERE 
        acc_supervisor != '' AND acc_manager != '' AND acc_hrd != ''
        AND penempatan_id ='$penempatan' 
        AND tanggal_lembur >= '$mulaitanggal' 
        AND tanggal_lembur <='$sampaitanggal'
        AND periode_awal_gaji_history >= '$mulaitanggal' 
        AND periode_akhir_gaji_history <='$sampaitanggal'

        GROUP BY nama_karyawan
       
        ORDER BY nama_karyawan
         ";
        $queryhasil = $this->db->query($query)->result_array();
        return $queryhasil;

        //dan mendirect kehalaman kesalahan
        } 
        else 
        {
            redirect('auth/blocked');
        }
    }

    //Query untuk menampilkan data lembur 
    public function datalembur()
    {
        //Mengambil data Tanggal Bulan Dan Tahun Sekarang
        date_default_timezone_set("Asia/Jakarta");
        $tahun      = date('Y');
        $bulan      = date('m');
        $tanggal    = date('d');
        $hari       = date("w");

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
            $this->db->from('slip_lembur');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=slip_lembur.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->join('keterangan_lembur', 'keterangan_lembur.id_keterangan_lembur=slip_lembur.keterangan_lembur_id');
            $this->db->join('jam_lembur', 'jam_lembur.id_jam_lembur=slip_lembur.jam_lembur_id');
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah Produksi
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('slip_lembur');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=slip_lembur.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->join('keterangan_lembur', 'keterangan_lembur.id_keterangan_lembur=slip_lembur.keterangan_lembur_id');
            $this->db->join('jam_lembur', 'jam_lembur.id_jam_lembur=slip_lembur.jam_lembur_id');
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 || $role_id == 14) {
            $this->db->select('*');
            $this->db->from('slip_lembur');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=slip_lembur.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->join('keterangan_lembur', 'keterangan_lembur.id_keterangan_lembur=slip_lembur.keterangan_lembur_id');
            $this->db->join('jam_lembur', 'jam_lembur.id_jam_lembur=slip_lembur.jam_lembur_id');
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah Selain Diatas
        else {
            $this->db->select('*');
            $this->db->from('slip_lembur');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=slip_lembur.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->join('keterangan_lembur', 'keterangan_lembur.id_keterangan_lembur=slip_lembur.keterangan_lembur_id');
            $this->db->join('jam_lembur', 'jam_lembur.id_jam_lembur=slip_lembur.jam_lembur_id');
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
    }

    //Query untuk menampilkan data karyawan join dengan jabatan dan penempatan untuk select nama karyawan pada form lembur
    public function datakaryawan()
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

        //Jika Yang Login Adalah HRD Maka Data Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah Bukan HRD Maka Data Tidak Akan Tampil Semua
        else {
            $this->db->select('*');
            $this->db->from('karyawan');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
    }

    //Query untuk menampilkan data jam lembur
    public function datajamlembur()
    {
        $this->db->select('*');
        $this->db->from('jam_lembur');
        return $this->db->get()->result_array();
    }

    //Query untuk menampilkan data keterangan lembur
    public function dataketeranganlembur()
    {
        $this->db->select('*');
        $this->db->from('keterangan_lembur');
        return $this->db->get()->result_array();
    }

    //Query Untuk menampilkan detail jam lembur
    public function jamlembur()
    {
        $idjamlembur       = $this->input->post('id_jam_lembur');
        $this->db->select('*');
        $this->db->from('jam_lembur');
        $this->db->where('id_jam_lembur', $idjamlembur);
        return $this->db->get()->row_array();
    }

    //Query untuk menambahkan data lembur 
    public function tambahdatalembur($nikkaryawan, $jenis_lembur, $jam_lembur, $keterangan_lembur, $jamlembur, $jampertama, $jumlahjampertama, $jamkedua, $jumlahjamkedua, $jamketiga, $jumlahjamketiga, $jamkeempat, $jumlahjamkeempat, $uangmakanlembur)
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

        //Jika Yang Login Adalah HRD Maka Akan Tampil Semua Data
        if ($role_id == 1 || $role_id == 11 || $role_id == 8) {

        $this->db->trans_start();

        //Mengambil Zona Waktu
        date_default_timezone_set("Asia/Jakarta");

        //Mengambil Session Nama Yang Login / Menggunakan Sistem
        $name = $this->session->userdata("name");

        //Input Slip Lembur
        $result = array();
        foreach ($nikkaryawan as $key => $val) {
            $result[] = array(

                'jam_lembur_id'             => $jam_lembur,
                'keterangan_lembur_id'      => $keterangan_lembur,
                'karyawan_id'               => $_POST['nik_karyawan'][$key],
                'tanggal_lembur'            => $this->input->post('tanggal_lembur', true),
                'jenis_lembur'              => $jenis_lembur,
                'jam_lembur'                => $jamlembur,
                'jam_pertama'               => $jampertama,
                'jumlah_jam_pertama'        => $jumlahjampertama,
                'jam_kedua'                 => $jamkedua,
                'jumlah_jam_kedua'          => $jumlahjamkedua,
                'jam_ketiga'                => $jamketiga,
                'jumlah_jam_ketiga'         => $jumlahjamketiga,
                'jam_keempat'               => $jamkeempat,
                'jumlah_jam_keempat'        => $jumlahjamkeempat,
                'uang_makan_lembur'         => $uangmakanlembur,
                'input_oleh'                => $name,
                'waktu_input'               => date('Y-m-d H:i:s'),
                'acc_supervisor'            => "",
                'waktu_acc_supervisor'      => "",
                'acc_manager'               => "",
                'waktu_acc_manager'         => "",
                'acc_hrd'                   => "",
                'waktu_acc_hrd'             => ""

            );
        }
        //MULTIPLE INSERT TO SLIP LEMBUR
        $this->db->insert_batch('slip_lembur', $result);

        $this->db->trans_complete();

        //dan mendirect kehalaman kesalahan
        } 
        else 
        {
            redirect('auth/blocked');
        }
    }

    //Query untuk cari data lembur join karyawan berdasarkan id_slip lembur 
    public function getLemburByID($id_slip_lembur)
    {
        $this->db->select('*');
        $this->db->from('slip_lembur');
        $this->db->join('jam_lembur', 'slip_lembur.jam_lembur_id=jam_lembur.id_jam_lembur');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=slip_lembur.karyawan_id');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->where('id_slip_lembur', $id_slip_lembur);
        return $this->db->get()->row_array();
    }

    //Query Untuk menghapus data lembur 
    public function editdatalembur($id_slip_lembur, $jam_lembur, $keterangan_lembur, $jamlembur, $jenis_lembur, $jampertama, $jumlahjampertama, $jamkedua, $jumlahjamkedua, $jamketiga, $jumlahjamketiga, $jamkeempat, $jumlahjamkeempat, $uangmakanlembur)
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

        //Jika Yang Login Adalah HRD Maka Akan Tampil Semua Data
        if ($role_id == 1 || $role_id == 8 || $role_id == 11) {

        //Mengambil Zona Waktu
        date_default_timezone_set("Asia/Jakarta");

        //Mengambil Session Nama Yang Login / Menggunakan Sistem
        $name = $this->session->userdata("name");

        //query edit absensi
        $data = [
            "jam_lembur_id"                 => $jam_lembur,
            "keterangan_lembur_id"          => $keterangan_lembur,
            "jenis_lembur"                  => $jenis_lembur,
            "jam_lembur"                    => $jamlembur,
            "jam_pertama"                   => $jampertama,
            "jumlah_jam_pertama"            => $jumlahjampertama,
            "jam_kedua"                     => $jamkedua,
            "jumlah_jam_kedua"              => $jumlahjamkedua,
            "jam_ketiga"                    => $jumlahjamketiga,
            "jumlah_jam_ketiga"             => $jumlahjamketiga,
            "jam_keempat"                   => $jamkeempat,
            "jumlah_jam_keempat"            => $jumlahjamkeempat,
            "uang_makan_lembur"             => $uangmakanlembur,
            "input_oleh"                    => $name,
            "waktu_input"                   => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_slip_lembur', $id_slip_lembur);
        $this->db->update('slip_lembur', $data);

        //dan mendirect kehalaman kesalahan
        } 
        else 
        {
            redirect('auth/blocked');
        }
    }

    //Query Untuk menghapus data lembur
    public function hapuslembur($id_slip_lembur)
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

        //Jika Yang Login Adalah HRD Maka Akan Tampil Semua Data
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11) {

        $this->db->delete('slip_lembur', ['id_slip_lembur' => $id_slip_lembur]);

        //dan mendirect kehalaman kesalahan
        } 
        else 
        {
            redirect('auth/blocked');
        }
    }
}
