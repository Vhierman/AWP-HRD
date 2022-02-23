<?php

class Surat_model extends CI_model
{
    //Query untuk onchange mencari data karyawan keluar berdasarkan nik karyawan
    function get_karyawankeluar_bynik($nik_karyawan_keluar)
    {
        $this->db->select('*');
        $this->db->from('karyawan_keluar');
        $this->db->where('nik_karyawan_keluar', $nik_karyawan_keluar);
        $hsl = $this->db->get()->row_array();
        return $hsl;

        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'nik_karyawan_keluar'               => $data->nik_karyawan_keluar,
                    'nama_karyawan_keluar'              => $data->nama_karyawan_keluar,
                    'jabatan_id'                        => $data->jabatan_id,
                    'penempatan_id'                     => $data->penempatan_id,
                    'tanggal_masuk_karyawan_keluar'     => $data->tanggal_masuk_karyawan_keluar,
                    'tanggal_keluar_karyawan_keluar'    => $data->tanggal_keluar_karyawan_keluar
                );
            }
        }
        return $hasil;
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

    //Query untuk onchange mencari data inventaris laptop berdasarkan nik karyawan
    function get_inventarislaptop_bynik($nik_karyawan)
    {

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->join('inventaris_laptop', 'karyawan.nik_karyawan=inventaris_laptop.karyawan_id');
        $this->db->where('karyawan_id', $nik_karyawan);
        $hsl = $this->db->get()->row_array();
        return $hsl;

        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'nik_karyawan'               => $data->nik_karyawan,
                    'nama_karyawan'              => $data->nama_karyawan,
                    'jabatan'                    => $data->jabatan,
                    'penempatan'                 => $data->penempatan,
                    'merk_laptop'                => $data->merk_laptop,
                    'type_laptop'                => $data->type_laptop
                );
            }
        }
        return $hasil;
    }

    //Query untuk onchange mencari data inventaris motor berdasarkan nik karyawan
    function get_inventarismotor_bynik($nik_karyawan)
    {

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->join('inventaris_motor', 'inventaris_motor.karyawan_id=karyawan.nik_karyawan');
        $this->db->where('karyawan_id', $nik_karyawan);
        $hsl = $this->db->get()->row_array();
        return $hsl;

        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'nik_karyawan'               => $data->nik_karyawan,
                    'nama_karyawan'              => $data->nama_karyawan,
                    'jabatan'                    => $data->jabatan,
                    'penempatan'                 => $data->penempatan,
                    'merk_motor'                 => $data->merk_motor,
                    'type_motor'                 => $data->type_motor
                );
            }
        }
        return $hasil;
    }

    //Query untuk onchange mencari data inventaris mobil berdasarkan nik karyawan
    function get_inventarismobil_bynik($nik_karyawan)
    {

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->join('inventaris_mobil', 'inventaris_mobil.karyawan_id=karyawan.nik_karyawan');
        $this->db->where('karyawan_id', $nik_karyawan);
        $hsl = $this->db->get()->row_array();
        return $hsl;

        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'nik_karyawan'               => $data->nik_karyawan,
                    'nama_karyawan'              => $data->nama_karyawan,
                    'jabatan'                    => $data->jabatan,
                    'penempatan'                 => $data->penempatan,
                    'merk_mobil'                 => $data->merk_mobil,
                    'type_mobil'                 => $data->type_mobil
                );
            }
        }
        return $hasil;
    }

    //mengambil data karyawan keluar berdasarkan NIK Karyawan Keluar untuk form cetak surat pengalaman kerja
    public function getKaryawanKeluarByNIK()
    {
        $nikkaryawankeluar = $this->input->post('nik_karyawan_keluar', true);

        $this->db->select('*');
        $this->db->from('karyawan_keluar');
        $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
        $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
        $this->db->where('nik_karyawan_keluar', $nikkaryawankeluar);
        $karyawankeluar = $this->db->get()->row_array();
        return $karyawankeluar;
    }

    //mengambil data berdasarkan NIK Karyawan untuk form cetak surat
    public function getKaryawanByNIK()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->where('nik_karyawan', $nikkaryawan);
        $datakaryawan = $this->db->get()->row_array();
        return $datakaryawan;
    }

    //mengambil data berdasarkan NIK Karyawan untuk form cetak surat inventaris laptop
    public function getInventarisLaptopByNIK()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('inventaris_laptop', 'inventaris_laptop.karyawan_id=karyawan.nik_karyawan');
        $this->db->where('nik_karyawan', $nikkaryawan);
        $datakaryawan = $this->db->get()->row_array();
        return $datakaryawan;
    }

    //mengambil data berdasarkan NIK Karyawan untuk form cetak surat inventaris motor
    public function getInventarisMotorByNIK()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('inventaris_motor', 'inventaris_motor.karyawan_id=karyawan.nik_karyawan');
        $this->db->where('nik_karyawan', $nikkaryawan);
        $datakaryawan = $this->db->get()->row_array();
        return $datakaryawan;
    }

    //mengambil data berdasarkan NIK Karyawan untuk form cetak surat inventaris mobil
    public function getInventarisMobilByNIK()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);

        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('inventaris_mobil', 'inventaris_mobil.karyawan_id=karyawan.nik_karyawan');
        $this->db->where('nik_karyawan', $nikkaryawan);
        $datakaryawan = $this->db->get()->row_array();
        return $datakaryawan;
    }

    //mengambil semua data karyawan untuk form cetak surat
    public function getAllKaryawan()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $allkaryawan = $this->db->get()->result_array();
        return $allkaryawan;
    }

    //mengambil semua data karyawan keluar untuk form cetak surat
    public function getAllKaryawanKeluar()
    {
        $nikkaryawankeluar = $this->input->post('nik_karyawan_keluar', true);
        $this->db->select('*');
        $this->db->from('karyawan_keluar');
        $this->db->where('nik_karyawan_keluar', $nikkaryawankeluar);
        $allkaryawankeluar = $this->db->get()->row_array();
        return $allkaryawankeluar;
    }
}
