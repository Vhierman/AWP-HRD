<?php

class Ceklemburan_model extends CI_model
{
    //Query untuk menampilkan data penempatan 
    public function datapenempatan()
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

        //Jika Yang Login Adalah Admin Dan Manager HRD Maka Data Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10) {
            $this->db->select('*');
            $this->db->from('penempatan');
            $this->db->order_by('penempatan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah Produksi
        else if ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('penempatan');
            $this->db->where_in('id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('penempatan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah PPC
        else if ($role_id == 13 || $role_id == 14) {
            $this->db->select('*');
            $this->db->from('penempatan');
            $this->db->where_in('id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('penempatan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah Selain Di atas
        else {
            $this->db->select('*');
            $this->db->from('penempatan');
            $this->db->where('id', $penempatan);
            $this->db->order_by('penempatan', 'asc');
            return $this->db->get()->result_array();
        }
    }

    //Query untuk menampilkan data lembur
    public function datalembur()
    {
        //Mengambil Data Form
        $tanggalawal    = $this->input->post('tanggal_awal', TRUE);
        $tanggalakhir    = $this->input->post('tanggal_akhir', TRUE);
        $penempatanid    = $this->input->post('penempatan_id', TRUE);
        //Mengambil Session
        $role_id        = $this->session->userdata("role_id");

        //Jika Yang Login Adalah Manager HRD
        if ($role_id == 1 || $role_id == 9) {
            $this->db->select('*');
            $this->db->from('slip_lembur');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=slip_lembur.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->join('keterangan_lembur', 'keterangan_lembur.id_keterangan_lembur=slip_lembur.keterangan_lembur_id');
            $this->db->join('jam_lembur', 'jam_lembur.id_jam_lembur=slip_lembur.jam_lembur_id');
            $this->db->where('acc_hrd', '');
            $this->db->where('tanggal_lembur >= ', $tanggalawal);
            $this->db->where('tanggal_lembur <= ', $tanggalakhir);
            $this->db->where('penempatan_id', $penempatanid);
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }

        //Jika Yang Login Adalah Supervisor HRD 
        else if ($role_id == 10) {
            $this->db->select('*');
            $this->db->from('slip_lembur');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=slip_lembur.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->join('keterangan_lembur', 'keterangan_lembur.id_keterangan_lembur=slip_lembur.keterangan_lembur_id');
            $this->db->join('jam_lembur', 'jam_lembur.id_jam_lembur=slip_lembur.jam_lembur_id');
            $this->db->where('acc_supervisor', '');
            $this->db->where('acc_manager', '');
            $this->db->where('tanggal_lembur >= ', $tanggalawal);
            $this->db->where('tanggal_lembur <= ', $tanggalakhir);
            $this->db->where('penempatan_id', 1);
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }

        //Jika Yang Login Adalah Supervisor Bukan HRD
        else if ($role_id == 6 || $role_id == 13 || $role_id == 15) {
            $this->db->select('*');
            $this->db->from('slip_lembur');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=slip_lembur.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->join('keterangan_lembur', 'keterangan_lembur.id_keterangan_lembur=slip_lembur.keterangan_lembur_id');
            $this->db->join('jam_lembur', 'jam_lembur.id_jam_lembur=slip_lembur.jam_lembur_id');
            $this->db->where('acc_supervisor', '');
            $this->db->where('tanggal_lembur >= ', $tanggalawal);
            $this->db->where('tanggal_lembur <= ', $tanggalakhir);
            $this->db->where('penempatan_id', $penempatanid);
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }

        //Jika Yang Login Adalah Manager PPC
        else if ($role_id == 3 || $role_id == 14 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('slip_lembur');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=slip_lembur.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->join('keterangan_lembur', 'keterangan_lembur.id_keterangan_lembur=slip_lembur.keterangan_lembur_id');
            $this->db->join('jam_lembur', 'jam_lembur.id_jam_lembur=slip_lembur.jam_lembur_id');
            $this->db->where('acc_manager', '');
            $this->db->where('tanggal_lembur >= ', $tanggalawal);
            $this->db->where('tanggal_lembur <= ', $tanggalakhir);
            $this->db->where('penempatan_id', $penempatanid);
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        } else {
            redirect('check/ceklemburan');
        }
    }

    //Query untuk verifikasi data lembur
    public function verifikasidatalembur()
    {
        //Mengambil Session
        $role_id        = $this->session->userdata("role_id");
        $nik            = $this->session->userdata("nik");
        $name           = $this->session->userdata("name");

        //Mengambil Data Penempatan
        $this->db->select('*');
        $this->db->from('login');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=login.nik');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('nik_karyawan', $nik);
        $datakaryawan = $this->db->get()->row_array();

        $penempatan = $datakaryawan['penempatan_id'];

        //Mengambil Data Form
        $awal           = $this->input->post('tanggal_awal', true);
        $akhir          = $this->input->post('tanggal_akhir', true);
        $verifikasi     = $this->input->post('verifikasi_lembur', true);
        $penempatanid   = $this->input->post('penempatan_id', TRUE);

        //Mengambil data tahun
        $tahunlembur         = substr($awal, 0, -6);

        //Mengambil Zona Waktu
        date_default_timezone_set("Asia/Jakarta");
        $waktu          = date('Y-m-d H:i:s');

        //Query Update / Verifikasi
        if ($verifikasi == "Verifikasi") {

            //Jika yang login adalah Supervisor Bukan HRD
            if ($role_id == 6 || $role_id == 13 || $role_id == 15) {
                $queryhasil = $this->db->query("UPDATE slip_lembur LEFT JOIN karyawan ON slip_lembur.karyawan_id = karyawan.nik_karyawan SET slip_lembur.acc_supervisor = '$name' , slip_lembur.waktu_acc_supervisor = '$waktu' WHERE karyawan.penempatan_id = '$penempatanid' AND tanggal_lembur >= '$awal' AND tanggal_lembur <= '$akhir' ");
                return $queryhasil;
            }
            //Jika yang login adalah Manager Bukan HRD
            elseif ($role_id == 3 || $role_id == 14 || $role_id == 16) {
                $queryhasil = $this->db->query("UPDATE slip_lembur LEFT JOIN karyawan ON slip_lembur.karyawan_id = karyawan.nik_karyawan SET slip_lembur.acc_manager = '$name' , slip_lembur.waktu_acc_manager = '$waktu' WHERE karyawan.penempatan_id = '$penempatanid' AND tanggal_lembur >= '$awal' AND tanggal_lembur <= '$akhir' ");
                return $queryhasil;
            }

            //Jika yang login adalah Departement Manager HRD
            elseif ($role_id == 9) {
                $queryhasil = $this->db->query("UPDATE slip_lembur LEFT JOIN karyawan ON slip_lembur.karyawan_id = karyawan.nik_karyawan 
                SET 
                slip_lembur.acc_hrd = '$name' , 
                slip_lembur.waktu_acc_hrd = '$waktu'
                WHERE karyawan.penempatan_id = '$penempatanid' AND tanggal_lembur >= '$awal' AND tanggal_lembur <= '$akhir' ");
                return $queryhasil;
            }
            //Jika yang login adalah Departement Supervisor HRD
            elseif ($role_id == 10) {
                $queryhasil = $this->db->query("UPDATE slip_lembur LEFT JOIN karyawan ON slip_lembur.karyawan_id = karyawan.nik_karyawan 
                SET 
                slip_lembur.acc_supervisor = '$name', 
                slip_lembur.waktu_acc_supervisor = '$waktu',
                slip_lembur.acc_manager = '$name', 
                slip_lembur.waktu_acc_manager = '$waktu' 
                WHERE karyawan.penempatan_id = '1' AND tanggal_lembur >= '$awal' AND tanggal_lembur <= '$akhir' ");
                return $queryhasil;
            } else {
                redirect('check/ceklemburan');
            }
        } else {
            redirect('check/ceklemburan');
        }
    }
}
