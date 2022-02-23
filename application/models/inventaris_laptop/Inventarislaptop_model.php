<?php

class Inventarislaptop_model extends CI_model
{
    //Query untuk menampilkan data inventaris laptop join dengan data karyawan
    public function dataInventarislaptop()
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

        //Jika Yang Login Adalah HRD,dan Accounting Maka Akan Tampil Semua Data
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17|| $role_id == 18) {
            $this->db->select('*');
            $this->db->from('inventaris_laptop');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_laptop.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('inventaris_laptop');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_laptop.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah PPC 
        elseif ($role_id == 13 || $role_id == 14) {
            $this->db->select('*');
            $this->db->from('inventaris_laptop');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_laptop.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah Selain Diatas
        else {
            $this->db->select('*');
            $this->db->from('inventaris_laptop');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_laptop.karyawan_id');
            $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
            $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
    }

    //Query untuk mencari data karyawan berdasarkan nik karyawan
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
                    'nik_karyawan'      => $data->nik_karyawan,
                    'nama_karyawan'     => $data->nama_karyawan,
                    'jabatan'           => $data->jabatan,
                    'penempatan'        => $data->penempatan
                );
            }
        }
        return $hasil;
    }

    //Query untuk menampilkan data inventaris laptop join dengan data karyawan
    public function getdataInventarislaptopByID($id_inventaris_laptop)
    {
        $this->db->select('*');
        $this->db->from('inventaris_laptop');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_laptop.karyawan_id');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('id_inventaris_laptop', $id_inventaris_laptop);
        return $this->db->get()->row_array();
    }

    //Melakukan query untuk tambah data inventaris laptop
    public function tambahInventarislaptop()
    {
        $data = [
            "karyawan_id"                   => $this->input->post('id', true),
            "merk_laptop"                   => $this->input->post('merk_laptop', true),
            "type_laptop"                   => $this->input->post('type_laptop', true),
            "processor"                     => $this->input->post('processor', true),
            "ram"                           => $this->input->post('ram', true),
            "hardisk"                       => $this->input->post('hardisk', true),
            "vga"                           => $this->input->post('vga', true),
            "sistem_operasi"                => $this->input->post('sistem_operasi', true),
            "tanggal_penyerahan_laptop"     => $this->input->post('tanggal_penyerahan_laptop', true)
        ];
        $this->db->insert('inventaris_laptop', $data);
    }

    //Query untuk proses edit data inventaris laptop
    public function editInventarislaptop()
    {
        //query edit data inventaris laptop
        $data = [
            "merk_laptop"                   => $this->input->post('merk_laptop', true),
            "type_laptop"                   => $this->input->post('type_laptop', true),
            "processor"                     => $this->input->post('processor', true),
            "ram"                           => $this->input->post('ram', true),
            "hardisk"                       => $this->input->post('hardisk', true),
            "vga"                           => $this->input->post('vga', true),
            "sistem_operasi"                => $this->input->post('sistem_operasi', true),
            "tanggal_penyerahan_laptop"     => $this->input->post('tanggal_penyerahan_laptop', true)
        ];
        $this->db->where('id_inventaris_laptop', $this->input->post('id_inventaris_laptop'));
        $this->db->update('inventaris_laptop', $data);
    }

    //melakukan query hapus data inventaris laptop
    public function hapusInventarislaptop($id_inventaris_laptop)
    {
        $this->db->delete('inventaris_laptop', ['id_inventaris_laptop' => $id_inventaris_laptop]);
    }
}
