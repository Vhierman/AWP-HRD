<?php

class Inventarismobil_model extends CI_model
{
    //Query untuk menampilkan data inventaris mobil join dengan data karyawan, penempatan, dan jabatan
    public function dataInventarismobil()
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
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17 || $role_id == 18) {
            $this->db->select('*');
            $this->db->from('inventaris_mobil');
            $this->db->join('karyawan', 'inventaris_mobil.karyawan_id=karyawan.nik_karyawan');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('inventaris_mobil');
            $this->db->join('karyawan', 'inventaris_mobil.karyawan_id=karyawan.nik_karyawan');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah PPC 
        elseif ($role_id == 13 || $role_id == 14) {
            $this->db->select('*');
            $this->db->from('inventaris_mobil');
            $this->db->join('karyawan', 'inventaris_mobil.karyawan_id=karyawan.nik_karyawan');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah Bukan Selain Di atas
        else {
            $this->db->select('*');
            $this->db->from('inventaris_mobil');
            $this->db->join('karyawan', 'inventaris_mobil.karyawan_id=karyawan.nik_karyawan');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
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

    //Query untuk menampilkan data inventaris mobil join dengan data karyawan, penempatan, dan jabatan
    public function getdataInventarismobilByID($id_inventaris_mobil)
    {
        $this->db->select('*');
        $this->db->from('inventaris_mobil');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_mobil.karyawan_id');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('id_inventaris_mobil', $id_inventaris_mobil);
        return $this->db->get()->row_array();
    }

    //Melakukan query untuk tambah data inventaris mobil
    public function tambahInventarismobil()
    {
        $data = [
            "karyawan_id"                   => $this->input->post('id', true),
            "merk_mobil"                    => $this->input->post('merk_mobil', true),
            "type_mobil"                    => $this->input->post('type_mobil', true),
            "nomor_polisi"                  => $this->input->post('nomor_polisi', true),
            "warna_mobil"                   => $this->input->post('warna_mobil', true),
            "nomor_rangka_mobil"            => $this->input->post('nomor_rangka_mobil', true),
            "nomor_mesin_mobil"             => $this->input->post('nomor_mesin_mobil', true),
            "tahun_pembuatan_mobil"         => $this->input->post('tahun_pembuatan_mobil', true),
            "tanggal_akhir_pajak_mobil"     => $this->input->post('tanggal_akhir_pajak_mobil', true),
            "tanggal_akhir_plat_mobil"      => $this->input->post('tanggal_akhir_plat_mobil', true),
            "tanggal_penyerahan_mobil"      => $this->input->post('tanggal_penyerahan_mobil', true)
        ];
        $this->db->insert('inventaris_mobil', $data);
    }

    //Query untuk proses edit data inventaris mobil
    public function editInventarismobil()
    {
        //query edit data inventaris mobil
        $data = [
            "merk_mobil"                    => $this->input->post('merk_mobil', true),
            "type_mobil"                    => $this->input->post('type_mobil', true),
            "nomor_polisi"                  => $this->input->post('nomor_polisi', true),
            "warna_mobil"                   => $this->input->post('warna_mobil', true),
            "nomor_rangka_mobil"            => $this->input->post('nomor_rangka_mobil', true),
            "nomor_mesin_mobil"             => $this->input->post('nomor_mesin_mobil', true),
            "tahun_pembuatan_mobil"         => $this->input->post('tahun_pembuatan_mobil', true),
            "tanggal_akhir_pajak_mobil"     => $this->input->post('tanggal_akhir_pajak_mobil', true),
            "tanggal_akhir_plat_mobil"      => $this->input->post('tanggal_akhir_plat_mobil', true),
            "tanggal_penyerahan_mobil"      => $this->input->post('tanggal_penyerahan_mobil', true)
        ];
        $this->db->where('id_inventaris_mobil', $this->input->post('id_inventaris_mobil'));
        $this->db->update('inventaris_mobil', $data);
    }

    //melakukan query hapus data inventaris mobil
    public function hapusInventarismobil($id_inventaris_mobil)
    {
        $this->db->delete('inventaris_mobil', ['id_inventaris_mobil' => $id_inventaris_mobil]);
    }
}
