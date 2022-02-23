<?php

class Magang_model extends CI_model
{
    //Query untuk mencari data karyawan berdasarkan NIK Karyawan
    function get_karyawan_bynik($nik_magang)
    {
        $this->db->select('*');
        $this->db->from('karyawan_keluar');
        $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
        $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
        $this->db->join('perusahaan', 'karyawan_keluar.perusahaan_id=perusahaan.id');
        $this->db->where('nik_karyawan_keluar', $nik_magang);
        $hsl = $this->db->get()->row_array();
        return $hsl;

        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'nik_magang'                        => $data->nik_karyawan_keluar,
                    'nama_magang'                       => $data->nama_karyawan_keluar,
                    'tempat_lahir_magang'               => $data->tempat_lahir_karyawan_keluar,
                    'tanggal_lahir_magang'              => $data->tanggal_lahir_karyawan_keluar,
                    'agama_magang'                      => $data->agama_karyawan_keluar,
                    'jenis_kelamin_magang'              => $data->jenis_kelamin_karyawan_keluar,
                    'nomor_handphone_magang'            => $data->nomor_handphone_karyawan_keluar,
                    'pendidikan_terakhir_magang'        => $data->pendidikan_terakhir_karyawan_keluar,
                    'alamat_magang'                     => $data->alamat_karyawan_keluar,
                    'rt_magang'                         => $data->rt_karyawan_keluar,
                    'rw_magang'                         => $data->rw_karyawan_keluar,
                    'kelurahan_magang'                  => $data->kelurahan_karyawan_keluar,
                    'kecamatan_magang'                  => $data->kecamatan_karyawan_keluar,
                    'kota_magang'                       => $data->kota_karyawan_keluar,
                    'provinsi_magang'                   => $data->provinsi_karyawan_keluar,
                    'kode_pos_magang'                   => $data->kode_pos_karyawan_keluar
                );
            }
        }
        return $hasil;
    }

    //Query untuk menampilkan data magang join dengan data penempatan
    public function dataMagang()
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
            $this->db->select('*');
            $this->db->from('magang');
            $this->db->join('penempatan', 'magang.penempatan_id=penempatan.id');
            $this->db->order_by('tanggal_masuk_magang', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah Selain Diatas
        else {
            $this->db->select('*');
            $this->db->from('magang');
            $this->db->join('penempatan', 'magang.penempatan_id=penempatan.id');
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('tanggal_masuk_magang', 'asc');
            return $this->db->get()->result_array();
        }
    }
    
    //Query untuk menampilkan data magang join dengan data penempatan
    public function DownloaddataMagang()
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
            $this->db->select('*');
            $this->db->from('magang');
            $this->db->join('penempatan', 'magang.penempatan_id=penempatan.id');
            $this->db->join('jabatan', 'magang.jabatan_id=jabatan.id');
            $this->db->order_by('nama_magang', 'asc');
            $query = $this->db->get();
            return $query->result();
        }
        //Jika Yang Login Adalah Selain Diatas
        else {
            $this->db->select('*');
            $this->db->from('magang');
            $this->db->join('penempatan', 'magang.penempatan_id=penempatan.id');
            $this->db->join('jabatan', 'magang.jabatan_id=jabatan.id');
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('nama_magang', 'asc');
            $query = $this->db->get();
            return $query->result();
        }
    }

    //Query untuk menampilkan data penempatan untuk combo box tambah dan edit data magang
    public function dataPenempatan()
    {
        $this->db->select('*');
        $this->db->from('penempatan');
        $this->db->order_by('penempatan', 'asc');
        return $this->db->get()->result_array();
    }

    //Query untuk menampilkan data penempatan untuk combo box tambah dan edit data magang
    public function dataJabatan()
    {
        $this->db->select('*');
        $this->db->from('jabatan');
        $this->db->order_by('jabatan', 'asc');
        return $this->db->get()->result_array();
    }

    //Query untuk menampilkan data magang join dengan data penempatan berdasarkan id_magang
    public function getdataMagangByID($id_magang)
    {
        $this->db->select('*');
        $this->db->from('magang');
        $this->db->join('penempatan', 'magang.penempatan_id=penempatan.id');
        $this->db->join('jabatan', 'magang.jabatan_id=jabatan.id');
        $this->db->where('id_magang', $id_magang);
        return $this->db->get()->row_array();
    }

    //Melakukan query untuk tambah data magang
    public function tambahMagang()
    {
        $data = [
            "penempatan_id"                 => $this->input->post('penempatan_id', true),
            "jabatan_id"                    => $this->input->post('jabatan_id', true),
            "tanggal_masuk_magang"          => $this->input->post('tanggal_masuk_magang', true),
            "tanggal_selesai_magang"        => $this->input->post('tanggal_selesai_magang', true),
            "nik_magang"                    => $this->input->post('nik_magang', true),
            "nama_magang"                   => htmlspecialchars($this->input->post('nama_magang', true)),
            "tempat_lahir_magang"           => $this->input->post('tempat_lahir_magang', true),
            "tanggal_lahir_magang"          => $this->input->post('tanggal_lahir_magang', true),
            "agama_magang"                  => $this->input->post('agama_magang', true),
            "jenis_kelamin_magang"          => $this->input->post('jenis_kelamin_magang', true),
            "nomor_handphone_magang"        => $this->input->post('nomor_handphone_magang', true),
            "pendidikan_terakhir_magang"    => $this->input->post('pendidikan_terakhir_magang', true),
            "alamat_magang"                 => $this->input->post('alamat_magang', true),
            "rt_magang"                     => $this->input->post('rt_magang', true),
            "rw_magang"                     => $this->input->post('rw_magang', true),
            "kelurahan_magang"              => $this->input->post('kelurahan_magang', true),
            "kecamatan_magang"              => $this->input->post('kecamatan_magang', true),
            "kota_magang"                   => $this->input->post('kota_magang', true),
            "provinsi_magang"               => $this->input->post('provinsi_magang', true),
            "kode_pos_magang"               => $this->input->post('kode_pos_magang', true)
        ];
        $this->db->insert('magang', $data);
    }

    //Query untuk proses edit data magang
    public function editMagang()
    {
        //query edit data magang
        $data = [
            "penempatan_id"                 => $this->input->post('penempatan_id', true),
            "jabatan_id"                    => $this->input->post('jabatan_id', true),
            "tanggal_masuk_magang"          => $this->input->post('tanggal_masuk_magang', true),
            "tanggal_selesai_magang"        => $this->input->post('tanggal_selesai_magang', true),
            "nik_magang"                    => $this->input->post('nik_magang', true),
            "nama_magang"                   => htmlspecialchars($this->input->post('nama_magang', true)),
            "tempat_lahir_magang"           => $this->input->post('tempat_lahir_magang', true),
            "tanggal_lahir_magang"          => $this->input->post('tanggal_lahir_magang', true),
            "agama_magang"                  => $this->input->post('agama_magang', true),
            "jenis_kelamin_magang"          => $this->input->post('jenis_kelamin_magang', true),
            "nomor_handphone_magang"        => $this->input->post('nomor_handphone_magang', true),
            "pendidikan_terakhir_magang"    => $this->input->post('pendidikan_terakhir_magang', true),
            "alamat_magang"                 => $this->input->post('alamat_magang', true),
            "rt_magang"                     => $this->input->post('rt_magang', true),
            "rw_magang"                     => $this->input->post('rw_magang', true),
            "kelurahan_magang"              => $this->input->post('kelurahan_magang', true),
            "kecamatan_magang"              => $this->input->post('kecamatan_magang', true),
            "kota_magang"                   => $this->input->post('kota_magang', true),
            "provinsi_magang"               => $this->input->post('provinsi_magang', true),
            "kode_pos_magang"               => $this->input->post('kode_pos_magang', true)
        ];
        $this->db->where('id_magang', $this->input->post('id_magang'));
        $this->db->update('magang', $data);
    }

    //melakukan query hapus data magang
    public function hapusMagang($id_magang)
    {
        $this->db->delete('magang', ['id_magang' => $id_magang]);
    }

    
}
