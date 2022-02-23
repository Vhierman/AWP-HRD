<?php

class Inventarismotor_model extends CI_model
{
    //Query untuk menampilkan data inventaris motor join dengan data karyawan, penempatan, dan jabatan
    public function dataInventarismotor()
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

        //Jika Yang Login Adalah HRD, Maka Akan Tampil Semua Data
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17 || $role_id == 18) {
            $this->db->select('*');
            $this->db->from('inventaris_motor');
            $this->db->join('karyawan', 'inventaris_motor.karyawan_id=karyawan.nik_karyawan');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('inventaris_motor');
            $this->db->join('karyawan', 'inventaris_motor.karyawan_id=karyawan.nik_karyawan');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah PPC 
        elseif ($role_id == 13 || $role_id == 14) {
            $this->db->select('*');
            $this->db->from('inventaris_motor');
            $this->db->join('karyawan', 'inventaris_motor.karyawan_id=karyawan.nik_karyawan');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah Bukan HRD, Maka Akan Tampil Data Sesuai Leadernya
        else {
            $this->db->select('*');
            $this->db->from('inventaris_motor');
            $this->db->join('karyawan', 'inventaris_motor.karyawan_id=karyawan.nik_karyawan');
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

    //Query untuk menampilkan data inventaris motor join dengan data karyawan, penempatan, dan jabatan
    public function getdataInventarismotorByID($id_inventaris_motor)
    {
        $this->db->select('*');
        $this->db->from('inventaris_motor');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=inventaris_motor.karyawan_id');
        $this->db->join('jabatan', 'jabatan.id=karyawan.jabatan_id');
        $this->db->join('penempatan', 'penempatan.id=karyawan.penempatan_id');
        $this->db->where('id_inventaris_motor', $id_inventaris_motor);
        return $this->db->get()->row_array();
    }

    //Melakukan query untuk tambah data inventaris motor
    public function tambahInventarismotor()
    {
        $data = [
            "karyawan_id"                   => $this->input->post('id', true),
            "merk_motor"                    => $this->input->post('merk_motor', true),
            "type_motor"                    => $this->input->post('type_motor', true),
            "nomor_polisi"                  => $this->input->post('nomor_polisi', true),
            "warna_motor"                   => $this->input->post('warna_motor', true),
            "nomor_rangka_motor"            => $this->input->post('nomor_rangka_motor', true),
            "nomor_mesin_motor"             => $this->input->post('nomor_mesin_motor', true),
            "tahun_pembuatan_motor"         => $this->input->post('tahun_pembuatan_motor', true),
            "tanggal_akhir_pajak_motor"     => $this->input->post('tanggal_akhir_pajak_motor', true),
            "tanggal_akhir_plat_motor"      => $this->input->post('tanggal_akhir_plat_motor', true),
            "tanggal_penyerahan_motor"      => $this->input->post('tanggal_penyerahan_motor', true)
        ];
        $this->db->insert('inventaris_motor', $data);
    }

    //Query untuk proses edit data inventaris motor
    public function editInventarismotor()
    {
        //query edit data inventaris motor
        $data = [
            "merk_motor"                    => $this->input->post('merk_motor', true),
            "type_motor"                    => $this->input->post('type_motor', true),
            "nomor_polisi"                  => $this->input->post('nomor_polisi', true),
            "warna_motor"                   => $this->input->post('warna_motor', true),
            "nomor_rangka_motor"            => $this->input->post('nomor_rangka_motor', true),
            "nomor_mesin_motor"             => $this->input->post('nomor_mesin_motor', true),
            "tahun_pembuatan_motor"         => $this->input->post('tahun_pembuatan_motor', true),
            "tanggal_akhir_pajak_motor"     => $this->input->post('tanggal_akhir_pajak_motor', true),
            "tanggal_akhir_plat_motor"      => $this->input->post('tanggal_akhir_plat_motor', true),
            "tanggal_penyerahan_motor"      => $this->input->post('tanggal_penyerahan_motor', true)
        ];
        $this->db->where('id_inventaris_motor', $this->input->post('id_inventaris_motor'));
        $this->db->update('inventaris_motor', $data);
    }

    //melakukan query hapus data inventaris motor
    public function hapusInventarismotor($id_inventaris_motor)
    {
        $this->db->delete('inventaris_motor', ['id_inventaris_motor' => $id_inventaris_motor]);
    }
}
