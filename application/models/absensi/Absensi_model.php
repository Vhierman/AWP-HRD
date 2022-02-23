<?php

class Absensi_model extends CI_model
{
    //Query untuk menampilkan data absensi join data karyawan
    public function dataabsensi()
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

        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11|| $role_id == 17|| $role_id == 18) {

            $this->db->select('*');
            $this->db->from('absensi');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=absensi.nik_karyawan_absen');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_absen >= ', '2020-01-01');
            $this->db->where('tanggal_absen <= ', '2020-12-31');
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('absensi');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=absensi.nik_karyawan_absen');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_absen >= ', '2020-01-01');
            $this->db->where('tanggal_absen <= ', '2020-12-31');
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 || $role_id == 14) {
            $this->db->select('*');
            $this->db->from('absensi');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=absensi.nik_karyawan_absen');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_absen >= ', '2020-01-01');
            $this->db->where('tanggal_absen <= ', '2020-12-31');
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah Selain Diatas
        else {
            $this->db->select('*');
            $this->db->from('absensi');
            $this->db->join('karyawan', 'karyawan.nik_karyawan=absensi.nik_karyawan_absen');
            $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
            $this->db->where('tanggal_absen >= ', '2020-01-01');
            $this->db->where('tanggal_absen <= ', '2020-12-31');
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('nama_karyawan', 'asc');
            return $this->db->get()->result_array();
        }
    }

    //Query untuk mencari data karyawan Berdasarkan NIK Karyawan
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

    //Query untuk cari data absensi join karyawan berdasarkan id_absen 
    public function getAbsensiByID($id_absen)
    {
        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->join('karyawan', 'karyawan.nik_karyawan=absensi.nik_karyawan_absen');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->where('id_absen', $id_absen);
        return $this->db->get()->row_array();
    }

    //Melakukan query untuk tambah data absensi
    public function tambahAbsensi()
    {
        //merubah format tanggal ke indonesia
        $tanggal_absen                   = date('d-m-Y', strtotime($this->input->post('tanggal_absen')));
        $tanggal_selesai                 = date('d-m-Y', strtotime($this->input->post('tanggal_selesai')));
        //Rumus menghitung lama absen
        $lama_absen                     = hitungcuti($tanggal_absen, $tanggal_selesai, "-");
        //query input data absen
        $dataabsensi = [
            "nik_karyawan_absen"        => $this->input->post('nik_karyawan', true),
            "tanggal_absen"             => $this->input->post('tanggal_absen', true),
            "tanggal_selesai"           => $this->input->post('tanggal_selesai', true),
            "keterangan_absen"          => $this->input->post('keterangan_absen', true),
            "lama_absen"                => $lama_absen,
            "keterangan"                => $this->input->post('keterangan', true),
            "jenis_cuti"                => $this->input->post('jenis_cuti', true)
        ];
        $this->db->insert('absensi', $dataabsensi);
    }

    //Query untuk proses edit absensi
    public function editAbsensi()
    {
        //merubah format tanggal ke indonesia
        $tanggal_absen                   = date('d-m-Y', strtotime($this->input->post('tanggal_absen')));
        $tanggal_selesai                 = date('d-m-Y', strtotime($this->input->post('tanggal_selesai')));
        //menghitung lama absen
        $lama_absen                     = hitungcuti($tanggal_absen, $tanggal_selesai, "-");

        //query edit absensi
        $data = [
            "tanggal_absen"                 => $this->input->post('tanggal_absen', true),
            "tanggal_selesai"               => $this->input->post('tanggal_selesai', true),
            "keterangan_absen"              => $this->input->post('keterangan_absen', true),
            "lama_absen"                    => $lama_absen,
            "keterangan"                    => htmlspecialchars($this->input->post('keterangan', true)),
            "jenis_cuti"                    => $this->input->post('jenis_cuti', true)
        ];
        $this->db->where('id_absen', $this->input->post('id_absen'));
        $this->db->update('absensi', $data);
    }

    //melakukan query hapus absensi
    public function hapusAbsensi($id_absen)
    {
        $this->db->delete('absensi', ['id_absen' => $id_absen]);
    }
}
