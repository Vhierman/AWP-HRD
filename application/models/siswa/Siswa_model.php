<?php

class Siswa_model extends CI_model
{
    //Query untuk menampilkan data siswa join dengan data sekolah dan penempatan
    public function dataSiswa()
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

        //Jika Yang Login Adalah HRD Dan Accounting Maka Data Siswa Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17 || $role_id == 18) {
            $this->db->select('*');
            $this->db->from('siswa');
            $this->db->join('sekolah', 'siswa.sekolah_id=sekolah.id_sekolah');
            $this->db->join('penempatan', 'siswa.penempatan_id=penempatan.id');
            $this->db->order_by('nama_siswa', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('siswa');
            $this->db->join('sekolah', 'siswa.sekolah_id=sekolah.id_sekolah');
            $this->db->join('penempatan', 'siswa.penempatan_id=penempatan.id');
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('nama_siswa', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 || $role_id == 14) {
            $this->db->select('*');
            $this->db->from('siswa');
            $this->db->join('sekolah', 'siswa.sekolah_id=sekolah.id_sekolah');
            $this->db->join('penempatan', 'siswa.penempatan_id=penempatan.id');
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('nama_siswa', 'asc');
            return $this->db->get()->result_array();
        }
        //Jika Yang Login Adalah Selain Diatas
        else {
            $this->db->select('*');
            $this->db->from('siswa');
            $this->db->join('sekolah', 'siswa.sekolah_id=sekolah.id_sekolah');
            $this->db->join('penempatan', 'siswa.penempatan_id=penempatan.id');
            $this->db->where('penempatan_id', $penempatan);
            $this->db->order_by('nama_siswa', 'asc');
            return $this->db->get()->result_array();
        }
    }

    //Query untuk menampilkan data sekolah untuk combo box tambah dan edit data siswa
    public function dataSekolah()
    {
        $this->db->select('*');
        $this->db->from('sekolah');
        $this->db->order_by('nama_sekolah', 'asc');
        return $this->db->get()->result_array();
    }

    //Query untuk menampilkan data penempatan untuk combo box tambah dan edit data siswa
    public function dataPenempatan()
    {
        $this->db->select('*');
        $this->db->from('penempatan');
        $this->db->order_by('penempatan', 'asc');
        return $this->db->get()->result_array();
    }

    //Query untuk menampilkan data siswa join dengan data sekolah dan penempatan berdasarkan id_siswa
    public function getdataSiswaByID($id_siswa)
    {
        $this->db->select('*');
        $this->db->from('siswa');
        $this->db->join('sekolah', 'siswa.sekolah_id=sekolah.id_sekolah');
        $this->db->join('penempatan', 'siswa.penempatan_id=penempatan.id');
        $this->db->where('id_siswa', $id_siswa);
        return $this->db->get()->row_array();
    }

    //Melakukan query untuk tambah data siswa
    public function tambahSiswa()
    {
        $data = [
            "sekolah_id"            => $this->input->post('sekolah_id', true),
            "penempatan_id"         => $this->input->post('penempatan_id', true),
            "tanggal_masuk_pkl"     => $this->input->post('tanggal_masuk_pkl', true),
            "tanggal_selesai_pkl"   => $this->input->post('tanggal_selesai_pkl', true),
            "nis_siswa"             => $this->input->post('nis_siswa', true),
            "nama_siswa"            => htmlspecialchars($this->input->post('nama_siswa', true)),
            "tempat_lahir_siswa"    => $this->input->post('tempat_lahir_siswa', true),
            "tanggal_lahir_siswa"   => $this->input->post('tanggal_lahir_siswa', true),
            "jenis_kelamin_siswa"   => $this->input->post('jenis_kelamin_siswa', true),
            "agama_siswa"           => $this->input->post('agama_siswa', true),
            "alamat_siswa"          => $this->input->post('alamat_siswa', true),
            "nomor_handphone_siswa" => $this->input->post('nomor_handphone_siswa', true),
            "jurusan"               => $this->input->post('jurusan', true)
        ];
        $this->db->insert('siswa', $data);
    }

    //Query untuk proses edit data siswa
    public function editSiswa()
    {
        //query edit data siswa
        $data = [
            "id_siswa"              => $this->input->post('id_siswa', true),
            "sekolah_id"            => $this->input->post('sekolah_id', true),
            "penempatan_id"         => $this->input->post('penempatan_id', true),
            "tanggal_masuk_pkl"     => $this->input->post('tanggal_masuk_pkl', true),
            "tanggal_selesai_pkl"   => $this->input->post('tanggal_selesai_pkl', true),
            "nis_siswa"             => htmlspecialchars($this->input->post('nis_siswa', true)),
            "nama_siswa"            => htmlspecialchars($this->input->post('nama_siswa', true)),
            "tempat_lahir_siswa"    => htmlspecialchars($this->input->post('tempat_lahir_siswa', true)),
            "tanggal_lahir_siswa"   => $this->input->post('tanggal_lahir_siswa', true),
            "jenis_kelamin_siswa"   => $this->input->post('jenis_kelamin_siswa', true),
            "agama_siswa"           => $this->input->post('agama_siswa', true),
            "alamat_siswa"          => htmlspecialchars($this->input->post('alamat_siswa', true)),
            "nomor_handphone_siswa"  => htmlspecialchars($this->input->post('nomor_handphone_siswa', true)),
            "jurusan"               => $this->input->post('jurusan', true)
        ];
        $this->db->where('id_siswa', $this->input->post('id_siswa'));
        $this->db->update('siswa', $data);
    }

    //melakukan query hapus data siswa
    public function hapusSiswa($id_siswa)
    {
        $this->db->delete('siswa', ['id_siswa' => $id_siswa]);
    }
}
