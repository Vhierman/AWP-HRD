<?php

class Karyawankeluar_model extends CI_model
{
    //mengambil semua data karyawan keluar
    public function getAllKaryawanKeluar()
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

        //Mengambil Data Penempatan Berdasarkan Session
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->where('penempatan_id', $penempatan);
        $data = $this->db->get()->row_array();
        $hasil = $data['penempatan_id'];

        //Jika Yang Login Adalah HRD Maka Data Karyawan Akan Tampil Semua
        if ($role_id == 1 || $role_id == 9 || $role_id == 10 || $role_id == 11 || $role_id == 17 || $role_id == 18) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->order_by('nama_karyawan_keluar');
            $query = $this->db->get();
            return $query->result_array();
        }
        //Jika Yang Login Adalah Produksi 
        elseif ($role_id == 15 || $role_id == 16) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where_in('penempatan_id ', [8, 15, 16, 17, 18, 19, 20, 21]);
            $this->db->order_by('nama_karyawan_keluar');
            $query = $this->db->get();
            return $query->result_array();
        }
        //Jika Yang Login Adalah PPC
        elseif ($role_id == 13 || $role_id == 14) {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where_in('penempatan_id ', [7, 9, 10, 11, 12, 22]);
            $this->db->order_by('nama_karyawan_keluar');
            $query = $this->db->get();
            return $query->result_array();
        }
        //Jika Yang Login Adalah Bukan HRD, Maka Akan Tampil Data Sesuai Leadernya
        else {
            $this->db->select('*');
            $this->db->from('karyawan_keluar');
            $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
            $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
            $this->db->where('penempatan_id', $hasil);
            $this->db->order_by('nama_karyawan_keluar');
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    //Query untuk mencari data karyawan berdasarkan NIK Karyawan
    function get_karyawan_bynik($nik_karyawan)
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->join('jabatan', 'karyawan.jabatan_id=jabatan.id');
        $this->db->join('penempatan', 'karyawan.penempatan_id=penempatan.id');
        $this->db->join('perusahaan', 'karyawan.perusahaan_id=perusahaan.id');
        $this->db->where('nik_karyawan', $nik_karyawan);
        $hsl = $this->db->get()->row_array();
        return $hsl;

        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'nik_karyawan'                      => $data->nik_karyawan,
                    'nama_karyawan'                     => $data->nama_karyawan,
                    'perusahaan'                        => $data->perusahaan_id,
                    'jabatan'                           => $data->jabatan_id,
                    'penempatan'                        => $data->penempatan_id,
                    'perusahaan_id'                     => $data->per,
                    'jabatan_id'                        => $data->jab,
                    'penempatan_id'                     => $data->pen,
                    'nomor_npwp'                        => $data->nomor_npwp,
                    'nomor_absen'                       => $data->nomor_absen,
                    'golongan_darah'                    => $data->golongan_darah,
                    'email_karyawan'                    => $data->email_karyawan,
                    'nomor_handphone'                   => $data->nomor_handphone,
                    'tempat_lahir'                      => $data->tempat_lahir,
                    'tanggal_lahir'                     => $data->tanggal_lahir,
                    'pendidikan_terakhir'               => $data->pendidikan_terakhir,
                    'jenis_kelamin'                     => $data->jenis_kelamin,
                    'agama'                             => $data->agama,
                    'alamat'                            => $data->alamat,
                    'rt'                                => $data->rt,
                    'rw'                                => $data->rw,
                    'kelurahan'                         => $data->kelurahan,
                    'kecamatan'                         => $data->kecamatan,
                    'kota'                              => $data->kota,
                    'provinsi'                          => $data->provinsi,
                    'kode_pos'                          => $data->kode_pos,
                    'nomor_kartu_keluarga'              => $data->nomor_kartu_keluarga,
                    'status_nikah'                      => $data->status_nikah,
                    'nama_ayah'                         => $data->nama_ayah,
                    'nama_ibu'                          => $data->nama_ibu,
                    'nomor_jkn'                         => $data->nomor_jkn,
                    'nomor_jht'                         => $data->nomor_jht,
                    'nomor_jp'                          => $data->nomor_jp,
                    'nomor_rekening'                    => $data->nomor_rekening,
                    'tanggal_mulai_kerja'               => $data->tanggal_mulai_kerja,
                    'status_kerja'                      => $data->status_kerja

                );
            }
        }
        return $hasil;
    }



    //Melakukan query untuk tambah data karyawan keluar
    public function tambahKaryawanKeluar()
    {
        $datakaryawankeluar = [
            "nik_karyawan_keluar"                       => htmlspecialchars($this->input->post('nik_karyawan', true)),
            "nama_karyawan_keluar"                      => htmlspecialchars($this->input->post('nama_karyawan', true)),
            "perusahaan_id"                             => $this->input->post('per', true),
            "jabatan_id"                                => $this->input->post('jab', true),
            "penempatan_id"                             => $this->input->post('pen', true),
            "nomor_npwp_karyawan_keluar"                => htmlspecialchars($this->input->post('nomor_npwp', true)),
            "email_karyawan_keluar"                     => htmlspecialchars($this->input->post('email_karyawan', true)),
            "nomor_handphone_karyawan_keluar"           => htmlspecialchars($this->input->post('nomor_handphone', true)),
            "tempat_lahir_karyawan_keluar"              => $this->input->post('tempat_lahir', true),
            "tanggal_lahir_karyawan_keluar"             => $this->input->post('tanggal_lahir', true),
            "pendidikan_terakhir_karyawan_keluar"       => $this->input->post('pendidikan_terakhir', true),
            "jenis_kelamin_karyawan_keluar"             => $this->input->post('jenis_kelamin', true),
            "agama_karyawan_keluar"                     => $this->input->post('agama', true),
            "alamat_karyawan_keluar"                    => $this->input->post('alamat', true),
            "rt_karyawan_keluar"                        => $this->input->post('rt', true),
            "rw_karyawan_keluar"                        => $this->input->post('rw', true),
            "kelurahan_karyawan_keluar"                 => $this->input->post('kelurahan', true),
            "kecamatan_karyawan_keluar"                 => $this->input->post('kecamatan', true),
            "kota_karyawan_keluar"                      => $this->input->post('kota', true),
            "provinsi_karyawan_keluar"                  => $this->input->post('provinsi', true),
            "kode_pos_karyawan_keluar"                  => $this->input->post('kode_pos', true),
            "nomor_absen_karyawan_keluar"               => $this->input->post('nomor_absen', true),
            "golongan_darah_karyawan_keluar"            => $this->input->post('golongan_darah', true),
            "nomor_kartu_keluarga_karyawan_keluar"      => $this->input->post('nomor_kartu_keluarga', true),
            "status_nikah_karyawan_keluar"            	=> $this->input->post('status_nikah', true),
            "nama_ibu_karyawan_keluar"            		=> $this->input->post('nama_ibu', true),
            "nama_ayah_karyawan_keluar"            		=> $this->input->post('nama_ayah', true),
            "nomor_jkn_karyawan_keluar"                 => htmlspecialchars($this->input->post('nomor_jkn', true)),
            "nomor_jht_karyawan_keluar"                 => htmlspecialchars($this->input->post('nomor_jht', true)),
            "nomor_jp_karyawan_keluar"                  => htmlspecialchars($this->input->post('nomor_jp', true)),
            "nomor_rekening_karyawan_keluar"            => htmlspecialchars($this->input->post('nomor_rekening', true)),
            "tanggal_masuk_karyawan_keluar"             => $this->input->post('tanggal_mulai_kerja', true),
            "status_kerja_karyawan_keluar"              => $this->input->post('status_kerja', true),
            "tanggal_keluar_karyawan_keluar"            => $this->input->post('tanggal_keluar_karyawan_keluar', true),
            "keterangan_keluar"                         => $this->input->post('keterangan_keluar', true)
        ];
        $this->db->insert('karyawan_keluar', $datakaryawankeluar);
    }

    //mengambil data karyawan keluar berdasarkan id nya
    public function getKaryawanKeluarByID($id)
    {
        $this->db->select('*');
        $this->db->from('karyawan_keluar');
        $this->db->join('jabatan', 'karyawan_keluar.jabatan_id=jabatan.id');
        $this->db->join('penempatan', 'karyawan_keluar.penempatan_id=penempatan.id');
        $this->db->where('id_karyawan_keluar', $id);
        return $this->db->get()->row_array();
    }

    //Melakukan query untuk edit data karyawan keluar
    public function editKaryawanKeluar()
    {
        $querykaryawankeluar = [
            "tanggal_keluar_karyawan_keluar"            => $this->input->post('tanggal_keluar_karyawan_keluar', true),
            "keterangan_keluar"                         => $this->input->post('keterangan_keluar', true)
        ];
        $this->db->where('id_karyawan_keluar', $this->input->post('id'));
        $this->db->update('karyawan_keluar', $querykaryawankeluar);
    }

    //melakukan query hapus karyawan keluar
    public function hapusKaryawanKeluar($id)
    {
        $this->db->delete('karyawan_keluar', ['id_karyawan_keluar' => $id]);
    }

    //mengambil id karyawan
    public function getKaryawanByNIK()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);
        return $this->db->get_where('karyawan', ['nik_karyawan' => $nikkaryawan])->row_array();
    }

    //melakukan query hapus karyawan
    public function hapusKaryawan()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);
        $this->db->delete('karyawan', ['nik_karyawan' => $nikkaryawan]);
    }

    //melakukan query hapus absen karyawan
    public function hapusAbsenKaryawan()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);
        $this->db->delete('absensi', ['nik_karyawan_absen' => $nikkaryawan]);
    }

    //melakukan query hapus inventaris karyawan
    public function hapusInventarisKaryawan()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);
        $this->db->delete('inventaris_laptop', ['karyawan_id' => $nikkaryawan]);
        $this->db->delete('inventaris_motor', ['karyawan_id' => $nikkaryawan]);
        $this->db->delete('inventaris_mobil', ['karyawan_id' => $nikkaryawan]);
    }

    //melakukan query hapus History Kontrak
    public function hapusHistoryKontrak()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);
        $this->db->delete('history_kontrak', ['karyawan_id' => $nikkaryawan]);
    }

    //melakukan query hapus History Jabatan
    public function hapusHistoryJabatan()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);
        $this->db->delete('history_jabatan', ['karyawan_id' => $nikkaryawan]);
    }

    //melakukan query hapus History Keluarga
    public function hapusHistoryKeluarga()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);
        $this->db->delete('history_keluarga', ['karyawan_id' => $nikkaryawan]);
    }

    //melakukan query hapus History Pendidikan Formal
    public function hapusHistoryPendidikanFormal()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);
        $this->db->delete('history_pendidikan_formal', ['karyawan_id' => $nikkaryawan]);
    }

    //melakukan query hapus History Pendidikan Non Formal
    public function hapusHistoryPendidikanNonFormal()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);
        $this->db->delete('history_pendidikan_non_formal', ['karyawan_id' => $nikkaryawan]);
    }

    //melakukan query hapus History Training Internal
    public function hapusHistoryTrainingInternal()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);
        $this->db->delete('history_training_internal', ['karyawan_id' => $nikkaryawan]);
    }

    //melakukan query hapus History Training Eksternal
    public function hapusHistoryTrainingEksternal()
    {
        $nikkaryawan = $this->input->post('nik_karyawan', true);
        $this->db->delete('history_training_eksternal', ['karyawan_id' => $nikkaryawan]);
    }
}
