<?php
defined('BASEPATH') or exit('No direct script access allowed');

class History extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Memanggil model History
        $this->load->model('history/Keluarga_model', 'keluarga');
        $this->load->model('history/Kontrak_model', 'kontrak');
        $this->load->model('history/Jabatan_model', 'jabatan');
        $this->load->model('history/Traininginternal_model', 'traininginternal');
        $this->load->model('history/Trainingeksternal_model', 'trainingeksternal');
        $this->load->model('history/Pendidikanformal_model', 'pendidikanformal');
        $this->load->model('history/Pendidikannonformal_model', 'pendidikannonformal');
        //Memanggil library validation
		$this->load->library('form_validation');
		//Memanggil library fpdf
        $this->load->library('pdf');
        //Memanggil Helper Login
        is_logged_in();
        //Memanggil Helper
        $this->load->helper('wpp');
    }

    //JSON untuk mencari data berdasarkan NIK Karyawan

    //untuk mencari data karyawan berdasarkan NIK Karyawan
    public function get_datakaryawan()
    {
        $nikkaryawan = $this->input->post('nik_karyawan');
        $data = $this->keluarga->get_karyawan_bynik($nikkaryawan);
        echo json_encode($data);
    }

    //Menampilkan halaman awal form history data Keluarga
    public function keluarga()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data History Keluarga';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //menampilkan halaman history keluarga
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('history/form_history_keluarga', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal form history data Keluarga
    public function tampilkeluarga()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data History Keluarga';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model History Keluarga
        $data['keluarga'] = $this->keluarga->getKaryawanByNIK();

        //Mengambil NPP Dari Form
        $nik = $this->input->post('nik_karyawan');
        //Untuk Validasi Form Tampil
        $cek = $this->keluarga->getAllKaryawan();

        //Jika Data NIK Karyawan Tidak Sesuai
        if ($nik != $cek['nik_karyawan']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">NIK Karyawan Tidak Valid ( Masukan NIK Karyawan Yang Sesuai )</div>');
            //dan mendirect kehalaman keluarga
            redirect('history/keluarga');
        }
        //Jika Data Kosong
        else if ($nik == NULL) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Yang Dipilih Tidak Ada ( Masukan NIK Terlebih Dahulu )</div>');
            //dan mendirect kehalaman keluarga
            redirect('history/keluarga');
        }
        //Jika OK
        else {
            //menampilkan halaman history keluarga
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('history/tampil_history_keluarga', $data);
            $this->load->view('templates/footer');
        }
    }

    //Menampilkan halaman awal form history tambah data Keluarga
    public function tambahkeluarga($nik_karyawan)
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Data History Keluarga';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Mengambil data dari model History Keluarga
            $data['keluarga'] = $this->keluarga->getAllKaryawanByNIK($nik_karyawan);

            //Validation Form Input
            $this->form_validation->set_rules('hubungan_keluarga', 'Hubungan Keluarga', 'required');
            $this->form_validation->set_rules('nik_history_keluarga', 'NIK', 'required|is_unique[history_keluarga.nik_history_keluarga]|min_length[16]');

            $this->form_validation->set_rules('nama_history_keluarga', 'Nama Lengkap', 'required');
            $this->form_validation->set_rules('jenis_kelamin_history_keluarga', 'Jenis Kelamin', 'required');
            $this->form_validation->set_rules('tempat_lahir_history_keluarga', 'Tempat Lahir', 'required');
            $this->form_validation->set_rules('tanggal_lahir_history_keluarga', 'Tanggal Lahir', 'required');
            $this->form_validation->set_rules('golongan_darah_history_keluarga', 'Golongan Darah', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman tambah history keluarga
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('history/tambah_history_keluarga', $data);
                $this->load->view('templates/footer');
            }
            //Jika form input benar
            else {

                //Upload Foto File History Keluarga 
                //file yang diperbolehkan hanya png dan jpg
                $config['allowed_types'] = 'jpg|jpeg|png';
                //max file 500 kb
                $config['max_size'] = '500';
                //lokasi penyimpanan file
                $config['upload_path'] = './assets/img/keluarga/';
                //memanggil library upload
                $this->load->library('upload', $config);
                //membedakan nama file jika ada yang sama
                $this->upload->initialize($config);

                //JIka file Foto Kosong / File Foto Lebih Dari 500 Kb, Maka Tampil Pesan Kesalahan 
                if (!$this->upload->do_upload('file_history_keluarga')) {
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Periksa kembali file upload anda..! ( Maksimal File 500 Kb Dan Format File jpg dan png )</div>');
                    redirect('history/keluarga');
                }
                // Menyimpan Ke Database
                else {

                    //Mengambil Nama File
                    $new_image_file_history_keluarga = $this->upload->data('file_name');

                    //Input Database
                    $datakeluarga = [
                        "karyawan_id"                               => $this->input->post('nik_karyawan', true),
                        "hubungan_keluarga"                         => $this->input->post('hubungan_keluarga', true),
                        "nik_history_keluarga"                      => $this->input->post('nik_history_keluarga', true),
                        "nomor_bpjs_kesehatan_history_keluarga"     => $this->input->post('nomor_bpjs_kesehatan_history_keluarga', true),
                        "nama_history_keluarga"                     => $this->input->post('nama_history_keluarga', true),
                        "jenis_kelamin_history_keluarga"            => $this->input->post('jenis_kelamin_history_keluarga', true),
                        "tempat_lahir_history_keluarga"             => $this->input->post('tempat_lahir_history_keluarga', true),
                        "tanggal_lahir_history_keluarga"            => $this->input->post('tanggal_lahir_history_keluarga', true),
                        "golongan_darah_history_keluarga"           => $this->input->post('golongan_darah_history_keluarga', true),
                        "file_history_keluarga"                     => $new_image_file_history_keluarga
                    ];
                    $this->db->insert('history_keluarga', $datakeluarga);
                    //

                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Keluarga</div>');
                    //redirect ke halaman history keluarga
                    redirect('history/keluarga');
                }
            }
            //Jika Yang Login Bukan HRD
        } else {
            $this->load->view('auth/blocked');
        }
        //
    }

    //Menampilkan halaman awal form history edit data Keluarga
    public function editkeluarga($id_history_keluarga)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Data History Keluarga';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Mengambil data dari model History Keluarga
            $data['keluarga'] = $this->keluarga->getAllHistoryKeluargaByID($id_history_keluarga);

            //Edit Select Option
            $data['hubungan_keluarga'] = [
                '' => 'Pilih Hubungan Keluarga',
                'Suami' => 'Suami',
                'Istri' => 'Istri',
                'Anak' => 'Anak'
            ];

            $data['jenis_kelamin_history_keluarga'] = [
                '' => 'Pilih Jenis Kelamin',
                'Pria' => 'Pria',
                'Wanita' => 'Wanita'
            ];

            $data['golongan_darah_history_keluarga'] = [
                '' => 'Pilih Golongan Darah',
                'A' => 'A',
                'B' => 'B',
                'AB' => 'AB',
                'O' => 'O'
            ];

            //Validation Form Edit
            $this->form_validation->set_rules('hubungan_keluarga', 'Hubungan Keluarga', 'required');
            $this->form_validation->set_rules('nik_history_keluarga', 'NIK', 'required|min_length[16]');

            $this->form_validation->set_rules('nama_history_keluarga', 'Nama Lengkap', 'required');
            $this->form_validation->set_rules('jenis_kelamin_history_keluarga', 'Jenis Kelamin', 'required');
            $this->form_validation->set_rules('tempat_lahir_history_keluarga', 'Tempat Lahir', 'required');
            $this->form_validation->set_rules('tanggal_lahir_history_keluarga', 'Tanggal Lahir', 'required');
            $this->form_validation->set_rules('golongan_darah_history_keluarga', 'Golongan Darah', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman edit history keluarga
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('history/edit_history_keluarga', $data);
                $this->load->view('templates/footer');
            }
            //Jika semua form input benar 
            else {

                //Memanggil Nama File
                $upload_file_keluarga = $_FILES['file_history_keluarga']['name'];

                //Jika Foto Di Edit
                if (!empty($upload_file_keluarga)) {
                    //Upload Foto File Keluarga 
                    //file yang diperbolehkan hanya png dan jpg
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    //max file 1 mb
                    $config['max_size'] = '500';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/img/keluarga/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload foto
                    $this->upload->do_upload('file_history_keluarga');

                    //unlink foto lama
                    $old_image_keluarga = $data['keluarga']['file_history_keluarga'];
                    unlink(FCPATH . 'assets/img/keluarga/' . $old_image_keluarga);
                    //
                    //mengganti nama foto yang ada di database
                    $new_image = $this->upload->data('file_name');
                    //
                    //mencari berdasarkan id history keluarga
                    $idhistorykeluarga =  $this->input->post('id_history_keluarga');
                    $this->db->set('file_history_keluarga', $new_image);
                    $this->db->where('id_history_keluarga', $idhistorykeluarga);
                    $this->db->update('history_keluarga');
                    //end Upload Foto Keluarga

                    //Memanggil model history keluarga dengan method editKeluarga
                    $this->keluarga->editKeluarga();
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Keluarga</div>');
                    //redirect ke halaman data keluarga
                    redirect('history/keluarga');
                }
                //Jika Foto Tidak Di Edit
                else {
                    //Memanggil model history keluarga dengan method editKeluarga
                    $this->keluarga->editKeluarga();
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Keluarga</div>');
                    //redirect ke halaman data keluarga
                    redirect('history/keluarga');
                }
            }
            //Jika Yang Login Bukan HRD
        } else {
            $this->load->view('auth/blocked');
        }
        //
    }

    //Method Hapus Data History Keluarga
    public function hapuskeluarga($id_history_keluarga)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //mengambil data keluarga berdasarkan id history keluarga nya
            $data['keluarga'] = $this->keluarga->getAllHistoryKeluargaByID($id_history_keluarga);

            //foto lama history keluarga
            $old_image_keluarga = $data['keluarga']['file_history_keluarga'];

            //Unlink Foto Lama
            unlink(FCPATH . 'assets/img/keluarga/' . $old_image_keluarga);

            //mendelete kedalam database 
            $this->keluarga->hapusKeluarga($id_history_keluarga);

            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Keluarga</div>');
            //dan mendirect kehalaman keluarga
            redirect('history/keluarga');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal form history data kontrak
    public function kontrak()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Tambah Data History Kontrak';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Data Untuk Select Option Pada Tambah History Kontrak
        $data['karyawan']   = $this->kontrak->datakaryawan();

        //menampilkan halaman history kontrak
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('history/form_history_kontrak', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal form history data Keluarga
    public function carikontrak()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Cari Data History Kontrak';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //menampilkan halaman history kontrak
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('history/form_cari_history_kontrak', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal form history data Keluarga
    public function tampilkontrak()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Tampil Data History Kontrak';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model History Kontrak
        $data['kontrak'] = $this->kontrak->getKaryawanByNIK();

        //Mengambil NPP Dari Form
        $nik = $this->input->post('nik_karyawan');
        //Untuk Validasi Form Tampil
        $cek = $this->kontrak->getAllKaryawan();

        //Jika Data NIK Karyawan Tidak Sesuai
        if ($nik != $cek['nik_karyawan']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">NIK Karyawan Tidak Valid ( Masukan NIK Karyawan Yang Sesuai )</div>');
            //dan mendirect kehalaman kontrak
            redirect('history/carikontrak');
        }
        //Jika Data Kosong
        else if ($nik == NULL) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Yang Dipilih Tidak Ada ( Masukan NIK Terlebih Dahulu )</div>');
            //dan mendirect kehalaman kontrak
            redirect('history/carikontrak');
        }
        //Jika OK
        else {
            //menampilkan halaman history kontrak
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('history/tampil_history_kontrak', $data);
            $this->load->view('templates/footer');
        }
    }

    //Menampilkan halaman awal form history data kontrak
    public function tambahdetailkontrak($nik_karyawan)
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Tambah Data History Kontrak';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Data Untuk Select Option Pada Tambah History Kontrak
            $data['karyawan']   = $this->kontrak->datadetailkaryawan($nik_karyawan);

            //menampilkan halaman history kontrak
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('history/form_tambah_detail_history_kontrak', $data);
            $this->load->view('templates/footer');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal form history data kontrak
    public function tambahkontrak()
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Tambah Data History Kontrak';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Data Untuk Select Option Pada Tambah History Kontrak
            $data['karyawan']   = $this->kontrak->datakaryawan();

            //menampilkan halaman history kontrak
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('history/form_tambah_history_kontrak', $data);
            $this->load->view('templates/footer');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal form history data kontrak
    public function aksitambahkontrak()
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Tambah Data History Kontrak';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Data Untuk Select Option Pada Tambah History Kontrak
            $data['karyawan']   = $this->kontrak->datakaryawan();

            //Validation Form Input
            $this->form_validation->set_rules('tanggal_awal_kontrak', 'Tanggal Awal Kontrak', 'required');
            $this->form_validation->set_rules('tanggal_akhir_kontrak', 'Tanggal AKhir Kontrak', 'required');
            $this->form_validation->set_rules('status_kontrak_kerja', 'Status Kontrak Kerja', 'required');

            //jika validasinya salah akan menampilkan halaman kontrak
            if ($this->form_validation->run() == false) {
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('history/form_history_kontrak', $data);
                $this->load->view('templates/footer');
            }
            //jika validasinya benar
            else {
                //Mengambil Data Dari FORM
                $nikkaryawan                = $this->input->post('nik_karyawan', TRUE);
                $tanggal_awal_kontrak       = $this->input->post('tanggal_awal_kontrak', TRUE);
                $tanggal_akhir_kontrak      = $this->input->post('tanggal_akhir_kontrak', TRUE);
                $status_kontrak_kerja       = $this->input->post('status_kontrak_kerja', TRUE);

                //Menghitung Jumlah Tahun Dan Bulan
                $awal_kontrak               = date_create($tanggal_awal_kontrak);
                $akhir_kontrak              = date_create($tanggal_akhir_kontrak);

                if ($status_kontrak_kerja == "PKWTT") {
                    $bulan                      = 0;
                    $hasiltanggalakhirkontrak   = "0000-00-00";
                    $hasiljumlahkontrak         = 0;
                } else {
                    $bulan                      = diffInMonths($awal_kontrak, $akhir_kontrak);
                    $hasiltanggalakhirkontrak   = $tanggal_akhir_kontrak;
                    $hasiljumlahkontrak         = 1;
                }

                $masakontrak                = $bulan;

                if ($masakontrak == 12) {
                    $hasilmasakontrak = "1 Tahun";
                } else {
                    $hasilmasakontrak = $masakontrak . " Bulan";
                }

                //Mengirimkan data ke model
                $this->kontrak->tambahdatakontrak($nikkaryawan, $tanggal_awal_kontrak, $hasiltanggalakhirkontrak, $status_kontrak_kerja, $hasilmasakontrak, $hasiljumlahkontrak);

                $this->kontrak->updatedatakontrak($nikkaryawan, $tanggal_awal_kontrak, $hasiltanggalakhirkontrak, $status_kontrak_kerja, $hasilmasakontrak);

                //menampikan pesan sukses
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Kontrak</div>');
                //dan mendirect kehalaman kontrak
                redirect('history/kontrak');
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal form history data kontrak
    public function aksitambahdetailkontrak()
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Tambah Data History Kontrak';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Data Untuk Select Option Pada Tambah History Kontrak
            $data['karyawan']   = $this->kontrak->datakaryawan();

            //Validation Form Input
            $this->form_validation->set_rules('nik_karyawan', 'NIK Karyawan', 'required');
            $this->form_validation->set_rules('tanggal_awal_kontrak', 'Tanggal Awal Kontrak', 'required');
            $this->form_validation->set_rules('tanggal_akhir_kontrak', 'Tanggal AKhir Kontrak', 'required');
            $this->form_validation->set_rules('status_kontrak_kerja', 'Status Kontrak Kerja', 'required');

            //jika validasinya salah akan menampilkan halaman kontrak
            if ($this->form_validation->run() == false) {
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('history/form_history_kontrak', $data);
                $this->load->view('templates/footer');
            }
            //jika validasinya benar
            else {
                //Mengambil Data Dari FORM
                $nikkaryawan                = $this->input->post('nik_karyawan', TRUE);
                $tanggal_awal_kontrak       = $this->input->post('tanggal_awal_kontrak', TRUE);
                $tanggal_akhir_kontrak      = $this->input->post('tanggal_akhir_kontrak', TRUE);
                $status_kontrak_kerja       = $this->input->post('status_kontrak_kerja', TRUE);

                //Menghitung Jumlah Tahun Dan Bulan
                $awal_kontrak               = date_create($tanggal_awal_kontrak);
                $akhir_kontrak              = date_create($tanggal_akhir_kontrak);

                if ($status_kontrak_kerja == "PKWTT") {
                    $bulan                      = 0;
                    $hasiltanggalakhirkontrak   = 0000 - 00 - 00;
                    $hasiljumlahkontrak         = 0;
                } else {
                    $bulan                      = diffInMonths($awal_kontrak, $akhir_kontrak);
                    $hasiltanggalakhirkontrak   = $tanggal_akhir_kontrak;
                    $hasiljumlahkontrak         = 1;
                }

                $masakontrak                = $bulan;

                if ($masakontrak == 12) {
                    $hasilmasakontrak = "1 Tahun";
                } else {
                    $hasilmasakontrak = $masakontrak . " Bulan";
                }

                //Mengirimkan data ke model
                $this->kontrak->tambahdetaildatakontrak($nikkaryawan, $tanggal_awal_kontrak, $hasiltanggalakhirkontrak, $status_kontrak_kerja, $hasilmasakontrak, $hasiljumlahkontrak);

                $this->kontrak->updatedetaildatakontrak($nikkaryawan, $tanggal_awal_kontrak, $hasiltanggalakhirkontrak, $status_kontrak_kerja, $hasilmasakontrak);

                //menampikan pesan sukses
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Kontrak</div>');
                //dan mendirect kehalaman kontrak
                redirect('history/kontrak');
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
	}
	
	//Menampilkan halaman awal form cetak pkwt
    public function cetakpkwtt($id_history_kontrak)
    {

		//Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {
            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Edit Data History Kontrak';
            //Menyimpan session dari login
			$data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

			//Mengambil data dari model history kontrak untuk cetak pkwt
			$karyawan = $this->kontrak->CetakPKWT($id_history_kontrak);

			//Mengambil data Tanggal Bulan Dan Tahun Sekarang
			date_default_timezone_set("Asia/Jakarta");
			$tahun      = date('Y');
			$bulan      = date('m');
			$tanggal    = date('d');
			$hari       = date("w");

			//Mengambil data nik 
			$nikkaryawan = $karyawan['nik_karyawan'];

			//Mengambil 4 Digit NIK Terakhir Karyawan
			$nik                 = substr($nikkaryawan, 12);

			//Jika tidak ada data yang dicetak
			if ($karyawan == NULL) {
				redirect('history/carikontrak');
			}
			//Jika ada
			else {
				//Jika statusnya karyawan kontrak, maka tidak bisa cetak PKWTT
				if ($karyawan['status_kerja'] == "PKWTT") {
					echo "
				<script> alert('Karyawan Tersebut Masih Menjadi Karyawan Kontrak ');
				window . close();
				</script>
				";
				} else {
					// membuat halaman baru Format Potrait Kertas A4
					$pdf = new FPDF('P', 'mm', 'A4');
					$pdf->AddPage();
	
					//Mengambil masing masing 2 digit tanggal, bulan, dan 4 digit tahun tanggal mulai kerja
                    $tanggalmulaikerja      = IndonesiaTgl($karyawan['tanggal_awal_kontrak']);

					$tanggalmulai           = substr($tanggalmulaikerja, 0, -8);
					$bulankerja             = substr($tanggalmulaikerja, 3, -5);
					$tahunkerja             = substr($tanggalmulaikerja, -4);
	
					//Mengambil masing masing 2 digit tanggal, bulan, dan 4 digit tahun tanggal akhir kerja
					$tanggalakhirkerja      = IndonesiaTgl($karyawan['tanggal_akhir_kontrak']);
					$tanggalakhir           = substr($tanggalakhirkerja, 0, -8);
					$bulanakhir             = substr($tanggalakhirkerja, 3, -5);
					$tahunakhir             = substr($tanggalakhirkerja, -4);

					//Merubah Format Tanggal Inggris Ke Indonesia
					$tanggal_lahir          = date('d-m-Y', strtotime($karyawan['tanggal_lahir']));

					$pdf->SetFont('Arial', 'BU', '10');
					$pdf->Cell(190, 10, 'PERJANJIAN KERJA WAKTU TERTENTU', 0, 0, 'C');
					$pdf->Ln(5);

					$pdf->SetFont('Arial', 'B', '10');
					$pdf->Cell(60);
					$pdf->Cell(70, 10, 'No.' . $nik . '/ HRD / PK / ' . bulanromawi($bulan) . ' / ' . $tahun . '', 0, 0, 'C');

					$pdf->Ln(10);

					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(20);
					$pdf->Cell(60, 7, 'Yang bertanda tangan dibawah ini :', 0, 0, 'L');

					$pdf->Ln(10);

					$pdf->Cell(20);
					$pdf->Cell(30, 5, 'Nama', 0, 0, 'L');
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(30, 5, ': Rudiyanto', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(30, 5, 'Jabatan', 0, 0, 'L');
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(30, 5, ': Manager ( HRD - GA )', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(30, 5, 'Alamat', 0, 0, 'L');
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(140, 5, ': Kawasan Industri Taman Tekno, Blok F2. No.10-11 / F1J', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(50);
					$pdf->Cell(140, 5, '  Kelurahan Setu, Kecamatan Setu, Tangerang Selatan, 15314.', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'Dalam hal ini bertindak untuk dan atas nama PT Prima Komponen Indonesia yang selanjutnya disebut pihak PERTAMA :', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->Cell(30, 5, 'Nama', 0, 0, 'L');
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(50, 5, ': ' . $karyawan['nama_karyawan'] . '', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(30, 5, 'Tempat & Tgl Lahir', 0, 0, 'L');
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(50, 5, ': ' . $karyawan['tempat_lahir'] . ',' . $tanggal_lahir . '', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(30, 5, 'Alamat', 0, 0, 'L');
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(140, 5, ': ' . $karyawan['alamat'] . ', RT.' . $karyawan['rt'] . ' / ' . $karyawan['rw'] . ', Kecamatan ' . $karyawan['kecamatan'] . '', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(50);
					$pdf->Cell(140, 5, '  Kelurahan ' . $karyawan['kelurahan'] . ', Kota ' . $karyawan['kota'] . ', Provinsi ' . $karyawan['provinsi'] . ',' . $karyawan['kode_pos'] . '', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'Dalam hal ini bertindak untuk dan atas nama dirinya sendiri dan selanjutnya disebut PIHAK KEDUA. Pada hari', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, '' . hari($hari) . ', ' . $tanggal . ' ' . bulan($bulan) . ' ' . $tahun . ' bertempat di gedung PT Prima Komponen Indonesia, kedua belah pihak dengan ini sepakat untuk', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'mengadakan perjanjian / ikatan kerja dalam jangka waktu tertentu, yaitu melalui kontrak kerja yang hubungan kerjanya', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'berpegang pada syarat - syarat dan ketentuan sebagai berikut : ', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(170, 5, 'Pasal 1', 0, 0, 'C');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(170, 5, 'STATUS KARYAWAN DARI PIHAK KEDUA', 0, 0, 'C');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'PIHAK PERTAMA memberi tugas kepada PIHAK KEDUA, dan PIHAK KEDUA menyetujui dan menerima status sebagai', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'karyawan kontrak berjangka di PT Prima Komponen Indonesia.', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(170, 5, 'Pasal 2', 0, 0, 'C');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(170, 5, 'JANGKA WAKTU KONTRAK KERJA', 0, 0, 'C');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(150, 5, 'PIHAK KEDUA bersedia bekerja sebagai karyawan kontrak pada PIHAK PERTAMA untuk jangka waktu ', 0, 0, 'L');

					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(20, 5, $karyawan['masa_kontrak'], 0, 0, 'C');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(85, 5,'terhitung sejak perjanjian kerja ini ditandatangani yaitu dari ', 0, 0, 'L');

					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(32, 5,  $tanggalmulai . ' ' . bulan($bulankerja) . ' ' . $tahunkerja . '', 0, 0, 'C');

					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(24, 5, ' sampai dengan ', 0, 0, 'C');

					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(27, 5, ' ' . $tanggalakhir . ' ' . bulan($bulanakhir) . ' ' . $tahunakhir . ' ', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(170, 5, 'Pasal 3', 0, 0, 'C');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(170, 5, 'TUGAS TUGAS POKOK PIHAK KEDUA', 0, 0, 'C');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'PIHAK KEDUA menerima tugas dari PIHAK PERTAMA sebagai berikut : ', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(40, 5, 'Nama Jabatan / Cabang ', 0, 0, 'L');

					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(100, 5, ': ' . $karyawan['jabatan'] . ' / ' . $karyawan['penempatan'] . '', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(40, 5, 'Tempat Tugas ', 0, 0, 'L');

					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(100, 5, ': PT Prima Komponen Indonesia', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'PIHAK KEDUA menyatakan tidak keberatan melakukan tugas lain dari tugas pokoknya, apabila PIHAK PERTAMA', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'memerlukannya.', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(170, 5, 'Pasal 4', 0, 0, 'C');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(170, 5, 'HARI KERJA DAN JAM KERJA', 0, 0, 'C');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'a. Guna kelancaran penuaian tugas tersebut pada pasal 3 diatas, PIHAK KEDUA harus sudah berada di kantor atau', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, '    ditempat lain yang ditentukan oleh PIHAK PERTAMA selama hari kerja an jam kerja yang berlaku di PT Prima ', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, '    Komponen Indonesia.', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'b. PIHAK KEDUA menyetujui untuk bekerja menurut ketentuan hari kerja dan jam kerja pada PIHAK PERTAMA sesuai', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, '    dengan ketentuan yang berlaku.', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'c. PIHAK KEDUA juga menyatakan bersedia untuk bekerja diluar hari tau jam kerja tersebut bilamana PIHAK PERTAMA ', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, '    memerlukannya.', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(170, 5, 'Pasal 5', 0, 0, 'C');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(170, 5, 'PENDAPATAN YANG DITERIMA DARI PIHAK KEDUA DARI PIHAK PERTAMA', 0, 0, 'C');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'Sesuai dengan kesepakatan antara kedua belah pihak, dalam perjanjian kerja ini, PIHAK KEDUA menyetujui untuk', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'menerima imbalan jasa pendapatan / upah dari PIHAK PERTAMA sebagai berikut :', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'a. Honorium / perhari sebesar sebagai berikut :', 0, 0, 'L');

					$pdf->Ln(10);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(65, 5, 'Gaji Perbulan Yang Diterima', 0, 0, 'L');
					$pdf->Cell(65, 5, ': Rp.4.416.186', 0, 0, 'L');


					$pdf->Ln(10);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'b. Pihak KEDUA termasuk level karyawan non staff', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'c. Sistem pengupahan yang berlaku untuk PIHAK KEDUA adalah sistem No Work No Pay sesuai dengan ketentuan ', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, '    yang berlaku di PT Prima Komponen Indonesia.', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(170, 5, 'Pasal 6', 0, 0, 'C');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(170, 5, 'PAJAK PENDAPATAN', 0, 0, 'C');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'PIHAK PERTAMA menanggung Pajak Pendapatan PIHAK KEDUA pada Pasal 5 Di atas.', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(170, 5, 'Pasal 7', 0, 0, 'C');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(170, 5, 'KEWAJIBAN PIHAK KEDUA', 0, 0, 'C');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'a. PIHAK KEDUA wajib melaksanakan tugas dengan sebaik-baiknya dan dengan penuh Tanggung Jawab.', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, '    PIHAK KEDUA bersedia dan wajib mentaati segala peraturan perusahaan PT Prima Komponen Indonesia dan menjaga', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, '    semua rahasia perusahaan.', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(170, 5, 'Pasal 8', 0, 0, 'C');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(170, 5, 'PEMUTUSAN HUBUNGAN KERJA', 0, 0, 'C');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'a. Hubungan kerja antar PIHAK PERTAMA dengan PIHAK KEDUA menjadi putus dengan sendirinya tanpa perlu', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, '    pemberitahuan dari PIHAK PERTAMA pada PIHAK KEDUA. Apabila perjanjian kerja yang telah disepakati ini habis', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(37, 5, '    waktunya yaitu tanggal ', 0, 0, 'L');

					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(40, 5, $tanggalakhir . ' ' . bulan($bulanakhir) . ' ' . $tahunakhir . ' ', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'b. Pemutusan hubungan kerja atas permintaan PIHAK KEDUA harus disampaikan paling sedikit satu bulan setengah', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, '    sebelum tanggal pengun duran diri PIHAK KEDUA pada PIHAK PERTAMA.', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'c. Pemutusan hubungan kerja oleh PIHAK PERTAMA terhadap PIHAK KEDUA dapat segera dilakukan jika PIHAK', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, '    KEDUA melakukan pelanggaran sesuai ketentua Tata Tertib yang diatur pada Peraturan Perusahaan.', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(170, 5, 'Pasal 9', 0, 0, 'C');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(170, 5, 'LAIN - LAIN', 0, 0, 'C');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'a. Perjanjian kerjasama ini dibuat dan ditandatangani oleh PIHAK PERTAMA dan PIHAK KEDUA dalam keadaan sadar,', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, '    sehat jasmani dan rohani, tanpa paksaan dari pihak manapun dan merupakan dasar bagi hubungan kerja berdasar', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, '    kontrak, sesuai dengan kesepakatan bersama PIHAK PERTAMA dan PIHAK KEDUA.', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'b. Perjanjian kerja ini dibuat dalam rangkap 2 ( Dua ) dan ditandatangani oleh PIHAK PERTAMA dan PIHAK KEDUA.', 0, 0, 'L');

					$pdf->Ln(5);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, 'c. Jika terdapat perselisihan dalam perjanjian kerja ini. Maka kedua belah pihak sepakat untuk menyelesaikan secara', 0, 0, 'L');

					$pdf->Ln(5);

					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(170, 5, '    musyawarah dan mufakat.', 0, 0, 'L');

					$pdf->Ln(15);
					$pdf->Cell(60);
					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Cell(70, 5, 'Tangerang Selatan, ' . $tanggal . ' ' . bulan($bulan) . ' ' . $tahun . '.', 0, 0, 'C');

					$pdf->Ln(10);
					$pdf->Cell(20);
					$pdf->SetFont('Arial', '', '9');
					$pdf->Cell(70, 5, 'Memahami dan menyetujui', 0, 0, 'C');

					$pdf->Cell(30);
					$pdf->Cell(70, 5, 'Perjanjian Kerja ini', 0, 0, 'C');

					$pdf->Ln(4);
					$pdf->Cell(20);
					$pdf->Cell(70, 5, 'PIHAK KEDUA', 0, 0, 'C');

					$pdf->Cell(30);
					$pdf->Cell(70, 5, 'PIHAK PERTAMA', 0, 0, 'C');

					$pdf->SetFont('Arial', 'B', '9');
					$pdf->Ln(40);
					$pdf->Cell(20);
					$pdf->Cell(70, 5, '( ' . strtoupper($karyawan['nama_karyawan']) . ' )', 0, 0, 'C');

					$pdf->Cell(30);
					$pdf->Cell(70, 5, '( RUDIYANTO )', 0, 0, 'C');

					$pdf->Output();
					//Akhir Fpdf


				}
			}

		}
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }

	}

    //Menampilkan halaman awal form edit history data kontrak
    public function editkontrak($id_history_kontrak)
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {
            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Edit Data History Kontrak';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Data Edit History Kontrak
            $data['kontrak']   = $this->kontrak->getHistoryKontrakByID($id_history_kontrak);

            //Edit Select Option
            $data['status_kontrak_kerja'] = [
                '' => 'Pilih Status Kontrak',
                'PKWT'          => 'PKWT',
                'PKWTT'         => 'PKWTT',
                'Outsourcing'   => 'Outsourcing'
            ];

            //Validation Form Edit
            $this->form_validation->set_rules('tanggal_awal_kontrak', 'Tanggal Awal Kontrak', 'required');
            $this->form_validation->set_rules('tanggal_akhir_kontrak', 'Tanggal AKhir Kontrak', 'required');
            $this->form_validation->set_rules('status_kontrak_kerja', 'Status Kontrak Kerja', 'required');

            //jika validasinya salah akan menampilkan halaman kontrak
            if ($this->form_validation->run() == false) {
                //menampilkan halaman edit history kontrak
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('history/form_edit_history_kontrak', $data);
                $this->load->view('templates/footer');
            }
            //jika validasinya benar
            else {
                $this->kontrak->editdatakontrak();
                $this->kontrak->editdatakontrakkaryawan();
                //menampikan pesan sukses
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Kontrak</div>');
                //dan mendirect kehalaman kontrak
                redirect('history/kontrak');
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Method Hapus Data History Kontrak
    public function hapuskontrak($id_history_kontrak)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //mendelete kedalam database 
            $this->kontrak->hapusdatakontrak($id_history_kontrak);

            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Kontrak</div>');
            //dan mendirect kehalaman kontrak
            redirect('history/kontrak');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }


    //Menampilkan halaman awal form history data jabatan
    public function jabatan()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data History Jabatan';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //menampilkan halaman history jabatan
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('history/form_history_jabatan', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal form history data jabatan
    public function tampiljabatan()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Tambah Data History Jabatan';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model History Jabatan
        $data['datajabatan'] = $this->jabatan->getKaryawanByNIK();

        //Mengambil NPP Dari Form
        $nik = $this->input->post('nik_karyawan');
        //Untuk Validasi Form Tampil
        $cek = $this->jabatan->getAllKaryawan();

        //Jika Data NIK Karyawan Tidak Sesuai
        if ($nik != $cek['nik_karyawan']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">NIK Karyawan Tidak Valid ( Masukan NIK Karyawan Yang Sesuai )</div>');
            //dan mendirect kehalaman jabatan
            redirect('history/jabatan');
        }
        //Jika Data Kosong
        else if ($nik == NULL) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Yang Dipilih Tidak Ada ( Masukan NIK Terlebih Dahulu )</div>');
            //dan mendirect kehalaman jabatan
            redirect('history/jabatan');
        }
        //Jika OK
        else {
            //menampilkan halaman history jabatan
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('history/tampil_history_jabatan', $data);
            $this->load->view('templates/footer');
        }
    }

    //Menampilkan halaman awal form history tambah data Jabatan
    public function tambahjabatan($nik_karyawan)
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Data History Jabatan';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Mengambil data dari model History Jabatan
            $data['datajabatan'] = $this->jabatan->getAllKaryawanByNIK($nik_karyawan);
            $data['jabatan'] = $this->jabatan->getAllJabatan();
            $data['penempatan'] = $this->jabatan->getAllPenempatan();

            //Validation Form Input
            $this->form_validation->set_rules('penempatan_id_history_jabatan', 'Penempatan', 'required');
            $this->form_validation->set_rules('jabatan_id_history_jabatan', 'Jabatan', 'required');
            $this->form_validation->set_rules('tanggal_mutasi', 'Tanggal Mutasi', 'required');


            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman tambah history jabatan
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('history/tambah_history_jabatan', $data);
                $this->load->view('templates/footer');
            }
            //Jika form input benar
            else {

                //Upload Foto File History Jabatan 
                //file yang diperbolehkan hanya png dan jpg
                $config['allowed_types'] = 'jpg|png';
                //max file 500 kb
                $config['max_size'] = '500';
                //lokasi penyimpanan file
                $config['upload_path'] = './assets/img/jabatan/';
                //memanggil library upload
                $this->load->library('upload', $config);
                //membedakan nama file jika ada yang sama
                $this->upload->initialize($config);

                //JIka file Foto Kosong / File Foto Lebih Dari 500 Kb, Maka Tampil Pesan Kesalahan 
                if (!$this->upload->do_upload('file_surat_mutasi')) {
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Periksa kembali file upload anda..! ( Maksimal File 500 Kb Dan Format File jpg dan png )</div>');
                    redirect('history/jabatan');
                }
                // Menyimpan Ke Database
                else {

                    //Mengambil Nama File
                    $new_image_file_history_jabatan = $this->upload->data('file_name');

                    //Input Database
                    $data = [
                        "karyawan_id"                   => $this->input->post('nik_karyawan', true),
                        "penempatan_id_history_jabatan" => $this->input->post('penempatan_id_history_jabatan', true),
                        "jabatan_id_history_jabatan"    => $this->input->post('jabatan_id_history_jabatan', true),
                        "tanggal_mutasi"                => $this->input->post('tanggal_mutasi', true),
                        "file_surat_mutasi"             => $new_image_file_history_jabatan
                    ];
                    $this->db->insert('history_jabatan', $data);
                    //

                    //Edit Jabatan Pada Table Karyawan
                    $this->jabatan->editJabatanKaryawan();
                    //

                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Jabatan</div>');
                    //redirect ke halaman history jabatan
                    redirect('history/jabatan');
                }
            }
            //Jika Yang Login Bukan HRD
        } else {
            $this->load->view('auth/blocked');
        }
        //
    }

    //Menampilkan halaman awal form history edit data Jabatan
    public function editjabatan($id_history_jabatan)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Data History Jabatan';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Mengambil data dari model History Jabatan
            $data['datajabatan'] = $this->jabatan->getAllHistoryJabatanByID($id_history_jabatan);

            $data['jabatan'] = $this->jabatan->getAllJabatan();
            $data['penempatan'] = $this->jabatan->getAllPenempatan();


            //Validation Form Edit
            $this->form_validation->set_rules('penempatan_id_history_jabatan', 'Penempatan', 'required');
            $this->form_validation->set_rules('jabatan_id_history_jabatan', 'Jabatan', 'required');
            $this->form_validation->set_rules('tanggal_mutasi', 'Tanggal Mutasi', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman edit history jabatan
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('history/edit_history_jabatan', $data);
                $this->load->view('templates/footer');
            }
            //Jika semua form input benar 
            else {

                //Memanggil Nama File
                $upload_file_jabatan = $_FILES['file_surat_mutasi']['name'];

                //Jika Foto Di Edit
                if (!empty($upload_file_jabatan)) {
                    //Upload Foto File Jabatan 
                    //file yang diperbolehkan hanya png dan jpg
                    $config['allowed_types'] = 'jpg|png';
                    //max file 1 mb
                    $config['max_size'] = '500';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/img/jabatan/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload foto
                    $this->upload->do_upload('file_surat_mutasi');

                    //unlink foto lama
                    $old_image_jabatan = $data['datajabatan']['file_surat_mutasi'];
                    unlink(FCPATH . 'assets/img/jabatan/' . $old_image_jabatan);
                    //
                    //mengganti nama foto yang ada di database
                    $new_image = $this->upload->data('file_name');
                    //
                    //mencari berdasarkan id history jabatan
                    $idhistoryjabatan =  $this->input->post('id_history_jabatan');
                    $this->db->set('file_surat_mutasi', $new_image);
                    $this->db->where('id_history_jabatan', $idhistoryjabatan);
                    $this->db->update('history_jabatan');
                    //end Upload Foto Jabatan

                    //Memanggil model history jabatan dengan method editjabatan
                    $this->jabatan->editJabatan();
                    //
                    //Edit Jabatan Pada Table Karyawan
                    $this->jabatan->editJabatanKaryawan();
                    //
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Jabatan</div>');
                    //redirect ke halaman data jabatan
                    redirect('history/jabatan');
                }
                //Jika Foto Tidak Di Edit
                else {
                    //Memanggil model history jabatan dengan method editjabatan
                    $this->jabatan->editJabatan();
                    //
                    //Edit Jabatan Pada Table Karyawan
                    $this->jabatan->editJabatanKaryawan();
                    //
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Jabatan</div>');
                    //redirect ke halaman data jabatan
                    redirect('history/jabatan');
                }
            }
            //Jika Yang Login Bukan HRD
        } else {
            $this->load->view('auth/blocked');
        }
        //
    }

    //Method Hapus Data History Jabatan
    public function hapusjabatan($id_history_jabatan)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //mengambil data jabatan berdasarkan id history jabatan nya
            $data['datajabatan'] = $this->jabatan->getAllHistoryJabatanByID($id_history_jabatan);

            //foto lama history jabatan
            $old_image_jabatan = $data['datajabatan']['file_surat_mutasi'];

            //Unlink Foto Lama
            unlink(FCPATH . 'assets/img/jabatan/' . $old_image_jabatan);

            //mendelete kedalam database 
            $this->jabatan->hapusJabatan($id_history_jabatan);

            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Jabatan</div>');
            //dan mendirect kehalaman jabatan
            redirect('history/jabatan');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }


    //Menampilkan halaman awal form history data Training Internal
    public function traininginternal()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Training Internal';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //menampilkan halaman history training internal
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('history/form_history_training_internal', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal form history data training internal
    public function caritraininginternal()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Cari Data History Training Internal';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //menampilkan halaman history training internal
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('history/form_cari_history_training_internal', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal form history data training internal
    public function tampiltraininginternal()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Tampil Data History Training Internal';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model History Training Internal
        $data['traininginternal'] = $this->traininginternal->getKaryawanByNIK();

        //Mengambil NPP Dari Form
        $nik = $this->input->post('nik_karyawan');
        //Untuk Validasi Form Tampil
        $cek = $this->traininginternal->getAllKaryawan();

        //Jika Data NIK Karyawan Tidak Sesuai
        if ($nik != $cek['nik_karyawan']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">NIK Karyawan Tidak Valid ( Masukan NIK Karyawan Yang Sesuai )</div>');
            //dan mendirect kehalaman traininginternal
            redirect('history/caritraininginternal');
        }
        //Jika Data Kosong
        else if ($nik == NULL) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Yang Dipilih Tidak Ada ( Masukan NIK Terlebih Dahulu )</div>');
            //dan mendirect kehalaman traininginternal
            redirect('history/caritraininginternal');
        }
        //Jika OK
        else {
            //menampilkan halaman history training internal
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('history/tampil_history_training_internal', $data);
            $this->load->view('templates/footer');
        }
    }

    //Menampilkan halaman awal form history data training internal
    public function tambahtraininginternal()
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Tambah Data History Training Internal';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Data Untuk Select Option Pada Tambah History Training Internal
            $data['karyawan']   = $this->traininginternal->datakaryawan();

            //menampilkan halaman history training internal
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('history/form_tambah_history_training_internal', $data);
            $this->load->view('templates/footer');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
	}
	
	//Menampilkan halaman awal form history data training internal
    public function tambahdetailtraininginternal($nik_karyawan)
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Tambah Data History Training Internal';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Data Untuk Select Option Pada Tambah History Training Internal
            $data['karyawan']   = $this->traininginternal->datadetailkaryawan($nik_karyawan);

            //menampilkan halaman history training internal
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('history/form_tambah_detail_history_training_internal', $data);
            $this->load->view('templates/footer');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal form history tambah data training internal
    public function aksitambahdetailtraininginternal()
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Tambah Data History Training Internal';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Data Untuk Select Option Pada Tambah History Training Internal
            $data['karyawan']   = $this->traininginternal->datakaryawan();

            //Validation Form Input
            $this->form_validation->set_rules('tanggal_training_internal', 'Tanggal Training Internal', 'required');
            $this->form_validation->set_rules('jam_training_internal', 'Jam Training Internal', 'required');
            $this->form_validation->set_rules('lokasi_training_internal', 'Lokasi Training Internal', 'required');
            $this->form_validation->set_rules('materi_training_internal', 'Materi Training Internal', 'required');
            $this->form_validation->set_rules('trainer_training_internal', 'Trainer Training Internal', 'required');

            //jika validasinya salah akan menampilkan halaman Training Internal
            if ($this->form_validation->run() == false) {
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('history/form_tambah_detail_history_training_internal', $data);
                $this->load->view('templates/footer');
            }
            //jika validasinya benar
            else {
                //Mengambil Data Dari FORM
                $nikkaryawan                = $this->input->post('nik_karyawan', TRUE);
                $tanggal_training_internal  = $this->input->post('tanggal_training_internal', TRUE);
                $jam_training_internal      = $this->input->post('jam_training_internal', TRUE);
                $lokasi_training_internal   = $this->input->post('lokasi_training_internal', TRUE);
                $materi_training_internal   = $this->input->post('materi_training_internal', TRUE);
                $trainer_training_internal  = $this->input->post('trainer_training_internal', TRUE);

                //Mencari Nama Hari
                $tanggaltraininginternal      = IndonesiaTgl($tanggal_training_internal);

                date_default_timezone_set("Asia/Jakarta");
                $tahun                      = date('Y');
                $bulan                      = date('m');
                $tanggal                    = date('d');
                $hari                       = date("w");

                //Mengambil masing masing 2 digit
                $tanggal                    = substr($tanggaltraininginternal, 0, -8);
                $bulan                      = substr($tanggaltraininginternal, 3, -5);
                $tahun                      = substr($tanggaltraininginternal, -4);
                $nama_hari                  = date('w', mktime(0, 0, 0, $bulan, $tanggal, $tahun));
                $hari_training_internal     = hari($nama_hari);
                //Mencari Nama Hari

                //Upload Foto File History Training Internak 
                //file yang diperbolehkan hanya pdf dan ppt
                $config['allowed_types'] = 'pdf|jpg|jpeg|ppt|pptx|doc|docx';
                //max file 1024 kb
                $config['max_size'] = '1024';
                //lokasi penyimpanan file
                $config['upload_path'] = './assets/file/traininginternal/';
                //memanggil library upload
                $this->load->library('upload', $config);
                //membedakan nama file jika ada yang sama
                $this->upload->initialize($config);

                //JIka file Foto Kosong / File Foto Lebih Dari 1 Mb, Maka Tampil Pesan Kesalahan 
                if (!$this->upload->do_upload('dokumen_materi_training_internal')) {
                    //Menampilkan pesan Kesalahan
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Periksa kembali file upload anda..! ( Maksimal File 1 Mb Dan Format File pdf dan ppt )</div>');
                    redirect('history/traininginternal');
                }
                // Menyimpan Ke Database
                else {

                    //Mengambil Nama File Training Internal
                    $new_image_file_history_training_internal = $this->upload->data('file_name');
                    //Mengambil Nama File Training Internal

					//Query Insert Training Internal
					$datatraininginternal = [
						'karyawan_id'                               => $_POST['nik_karyawan'],
						'hari_training_internal'                    => $hari_training_internal,
						'tanggal_training_internal'                 => $tanggal_training_internal,
						'jam_training_internal'                     => $jam_training_internal,
						'lokasi_training_internal'                  => $lokasi_training_internal,
						'materi_training_internal'                  => $materi_training_internal,
						'penilaian_sebelum_training_internal'       => 0,
						'penilaian_sesudah_training_internal'       => 0,
						'trainer_training_internal'                 => $trainer_training_internal,
						'dokumen_materi_training_internal'          => $new_image_file_history_training_internal
					];
                

                    // INSERT TO HISTORY TRAINING INTERNAL
                    $this->db->insert('history_training_internal', $datatraininginternal);

                    //menampikan pesan sukses
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Training Internal</div>');
                    //dan mendirect kehalaman training internal
                    redirect('history/traininginternal');
                }
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
	}
	
	//Menampilkan halaman awal form history tambah data training internal
    public function aksitambahtraininginternal()
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Tambah Data History Training Internal';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Data Untuk Select Option Pada Tambah History Training Internal
            $data['karyawan']   = $this->traininginternal->datakaryawan();

            //Validation Form Input
            $this->form_validation->set_rules('tanggal_training_internal', 'Tanggal Training Internal', 'required');
            $this->form_validation->set_rules('jam_training_internal', 'Jam Training Internal', 'required');
            $this->form_validation->set_rules('lokasi_training_internal', 'Lokasi Training Internal', 'required');
            $this->form_validation->set_rules('materi_training_internal', 'Materi Training Internal', 'required');
            $this->form_validation->set_rules('trainer_training_internal', 'Trainer Training Internal', 'required');

            //jika validasinya salah akan menampilkan halaman Training Internal
            if ($this->form_validation->run() == false) {
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('history/form_tambah_history_training_internal', $data);
                $this->load->view('templates/footer');
            }
            //jika validasinya benar
            else {
                //Mengambil Data Dari FORM
                $nikkaryawan                = $this->input->post('nik_karyawan', TRUE);
                $tanggal_training_internal  = $this->input->post('tanggal_training_internal', TRUE);
                $jam_training_internal      = $this->input->post('jam_training_internal', TRUE);
                $lokasi_training_internal   = $this->input->post('lokasi_training_internal', TRUE);
                $materi_training_internal   = $this->input->post('materi_training_internal', TRUE);
                $trainer_training_internal  = $this->input->post('trainer_training_internal', TRUE);

                //Mencari Nama Hari
                $tanggaltraininginternal      = IndonesiaTgl($tanggal_training_internal);

                date_default_timezone_set("Asia/Jakarta");
                $tahun                      = date('Y');
                $bulan                      = date('m');
                $tanggal                    = date('d');
                $hari                       = date("w");

                //Mengambil masing masing 2 digit
                $tanggal                    = substr($tanggaltraininginternal, 0, -8);
                $bulan                      = substr($tanggaltraininginternal, 3, -5);
                $tahun                      = substr($tanggaltraininginternal, -4);
                $nama_hari                  = date('w', mktime(0, 0, 0, $bulan, $tanggal, $tahun));
                $hari_training_internal     = hari($nama_hari);
                //Mencari Nama Hari

                //Upload Foto File History Training Internak 
                //file yang diperbolehkan hanya pdf dan ppt
                $config['allowed_types'] = 'pdf|jpg|jpeg|ppt|pptx|doc|docx';
                //max file 1024 kb
                $config['max_size'] = '1024';
                //lokasi penyimpanan file
                $config['upload_path'] = './assets/file/traininginternal/';
                //memanggil library upload
                $this->load->library('upload', $config);
                //membedakan nama file jika ada yang sama
                $this->upload->initialize($config);

                //JIka file Foto Kosong / File Foto Lebih Dari 1 Mb, Maka Tampil Pesan Kesalahan 
                if (!$this->upload->do_upload('dokumen_materi_training_internal')) {
                    //Menampilkan pesan Kesalahan
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Periksa kembali file upload anda..! ( Maksimal File 1 Mb Dan Format File pdf dan ppt )</div>');
                    redirect('history/traininginternal');
                }
                // Menyimpan Ke Database
                else {

                    //Mengambil Nama File Training Internal
                    $new_image_file_history_training_internal = $this->upload->data('file_name');
                    //Mengambil Nama File Training Internal

                    //Input Ke Dalam Database
                    $this->db->trans_start();

                    //Input Training Internal
                    $result = array();
                    foreach ($nikkaryawan as $key => $val) {
                        $result[] = array(
                            'karyawan_id'                               => $_POST['nik_karyawan'][$key],
                            'hari_training_internal'                    => $hari_training_internal,
                            'tanggal_training_internal'                 => $tanggal_training_internal,
                            'jam_training_internal'                     => $jam_training_internal,
                            'lokasi_training_internal'                  => $lokasi_training_internal,
                            'materi_training_internal'                  => $materi_training_internal,
                            'penilaian_sebelum_training_internal'       => 0,
                            'penilaian_sesudah_training_internal'       => 0,
                            'trainer_training_internal'                 => $trainer_training_internal,
                            'dokumen_materi_training_internal'          => $new_image_file_history_training_internal
                        );
                    }

                    //MULTIPLE INSERT TO HISTORY TRAINING INTERNAL
                    $this->db->insert_batch('history_training_internal', $result);
                    $this->db->trans_complete();

                    //menampikan pesan sukses
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Training Internal</div>');
                    //dan mendirect kehalaman training internal
                    redirect('history/traininginternal');
                }
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal form history edit data History Training Internal
    public function edittraininginternal($id_history_training_internal)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Data History Training Internal';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Mengambil data dari model History Training Internal
            $data['datatraininginternal'] = $this->traininginternal->getAllHistoryTrainingInternalByID($id_history_training_internal);

            //Validation Form Edit
            $this->form_validation->set_rules('tanggal_training_internal', 'Tanggal Training Internal', 'required');
            $this->form_validation->set_rules('jam_training_internal', 'Jam Training Internal', 'required');
            $this->form_validation->set_rules('lokasi_training_internal', 'Lokasi Training Internal', 'required');
            $this->form_validation->set_rules('materi_training_internal', 'Materi Training Internal', 'required');
            $this->form_validation->set_rules('trainer_training_internal', 'Trainer Training Internal', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman edit history training internal
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('history/edit_history_training_internal', $data);
                $this->load->view('templates/footer');
            }
            //Jika semua form input benar 
            else {

                //Memanggil Nama File
                $upload_file_training_internal = $_FILES['dokumen_materi_training_internal']['name'];

                //Jika Foto Di Edit
                if (!empty($upload_file_training_internal)) {
                    //Upload Foto File Training Internal
                    //file yang diperbolehkan hanya pdf
                    $config['allowed_types'] = 'pdf|jpg|jpeg|ppt|pptx|doc|docx';
                    //max file 1 mb
                    $config['max_size'] = '1024';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/file/traininginternal/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload file
                    $this->upload->do_upload('dokumen_materi_training_internal');

                    //unlink file lama
                    $old_image_file_training_internal = $data['datatraininginternal']['dokumen_materi_training_internal'];
                    unlink(FCPATH . 'assets/file/traininginternal/' . $old_image_file_training_internal);
                    //
                    //mengganti nama file yang ada di database
                    $new_image = $this->upload->data('file_name');
                    //
                    //mencari berdasarkan id history training internal
                    $idhistorytraininginternal =  $this->input->post('id_history_training_internal');
                    $this->db->set('dokumen_materi_training_internal', $new_image);
                    $this->db->where('tanggal_training_internal', $this->input->post('tanggal_training_internal'));
                    $this->db->update('history_training_internal');
                    //end Upload File Training Internal

                    //Memanggil model history training Internal dengan method edittraininginternal
                    $this->traininginternal->editTrainingInternal();
                    //
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Training Internal</div>');
                    //redirect ke halaman data training Internal
                    redirect('history/traininginternal');
                }
                //Jika Foto Tidak Di Edit
                else {
                    //Memanggil model history training internal dengan method editTrainingInternal
                    $this->traininginternal->editTrainingInternal();
                    //
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Training Internal</div>');
                    //redirect ke halaman data traininginternal
                    redirect('history/traininginternal');
                }
            }
            //Jika Yang Login Bukan HRD
        } else {
            $this->load->view('auth/blocked');
        }
        //
    }

    //Method Hapus Data History Training Internal
    public function hapustraininginternal($id_history_training_internal)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //mendelete kedalam database 
            $this->traininginternal->hapusTrainingInternal($id_history_training_internal);

            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Training Internal</div>');
            //dan mendirect kehalaman Training Internal
            redirect('history/traininginternal');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal form history data Training Eksternal
    public function trainingeksternal()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Training Eksternal';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //menampilkan halaman history training eksternal
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('history/form_history_training_eksternal', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal form history data training eksternal
    public function caritrainingeksternal()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Cari Data History Training Eksternal';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //menampilkan halaman history training eksternal
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('history/form_cari_history_training_eksternal', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal form history data training eksternal
    public function tampiltrainingeksternal()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Tampil Data History Training Eksternal';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model History Training Eksternal
        $data['trainingeksternal'] = $this->trainingeksternal->getKaryawanByNIK();

        //Mengambil NPP Dari Form
        $nik = $this->input->post('nik_karyawan');
        //Untuk Validasi Form Tampil
        $cek = $this->trainingeksternal->getAllKaryawan();

        //Jika Data NIK Karyawan Tidak Sesuai
        if ($nik != $cek['nik_karyawan']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">NIK Karyawan Tidak Valid ( Masukan NIK Karyawan Yang Sesuai )</div>');
            //dan mendirect kehalaman trainingeksternal
            redirect('history/caritrainingeksternal');
        }
        //Jika Data Kosong
        else if ($nik == NULL) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Yang Dipilih Tidak Ada ( Masukan NIK Terlebih Dahulu )</div>');
            //dan mendirect kehalaman trainingeksternal
            redirect('history/caritrainingeksternal');
        }
        //Jika OK
        else {
            //menampilkan halaman history training eksternal
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('history/tampil_history_training_eksternal', $data);
            $this->load->view('templates/footer');
        }
    }

    //Menampilkan halaman awal form history data training eksternal
    public function tambahtrainingeksternal()
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Tambah Data History Training Eksternal';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Data Untuk Select Option Pada Tambah History Training Eksternal
            $data['karyawan']   = $this->trainingeksternal->datakaryawan();

            //menampilkan halaman history training eksternal
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('history/form_tambah_history_training_eksternal', $data);
            $this->load->view('templates/footer');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
	}
	
	//Menampilkan halaman awal form history data training eksternal
    public function tambahdetailtrainingeksternal($nik_karyawan)
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Tambah Data History Training Eksternal';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Data Untuk Select Option Pada Tambah History Training Eksternal
            $data['karyawan']   = $this->trainingeksternal->datadetailkaryawan($nik_karyawan);

            //menampilkan halaman history training eksternal
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('history/form_tambah_detail_history_training_eksternal', $data);
            $this->load->view('templates/footer');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal form history tambah data training eksternal
    public function aksitambahtrainingeksternal()
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Tambah Data History Training Eksternal';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Data Untuk Select Option Pada Tambah History Training Eksternal
            $data['karyawan']   = $this->trainingeksternal->datakaryawan();

            //Validation Form Input
            $this->form_validation->set_rules('tanggal_awal_training_eksternal', 'Tanggal Awal', 'required');
            $this->form_validation->set_rules('tanggal_akhir_training_eksternal', 'Tanggal Akhir', 'required');
            $this->form_validation->set_rules('institusi_penyelenggara_training_eksternal', 'Institusi Penyelenggara', 'required');
            $this->form_validation->set_rules('perihal_training_eksternal', 'Perihal Training Eksternal', 'required');
            $this->form_validation->set_rules('jam_training_eksternal', 'Jam Training Eksternal', 'required');
            $this->form_validation->set_rules('lokasi_training_eksternal', 'Lokasi Training Eksternal', 'required');
            $this->form_validation->set_rules('alamat_training_eksternal', 'Alamat Training Eksternal', 'required');
            $this->form_validation->set_rules('nomor_surat_training_eksternal', 'Nomor Surat Training Eksternal', 'required');

            //jika validasinya salah akan menampilkan halaman Training Eksternal
            if ($this->form_validation->run() == false) {
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('history/form_tambah_history_training_eksternal', $data);
                $this->load->view('templates/footer');
            }
            //jika validasinya benar
            else {
                //Mengambil Data Dari FORM
                $nikkaryawan                                = $this->input->post('nik_karyawan', TRUE);
                $tanggal_awal_training_eksternal            = $this->input->post('tanggal_awal_training_eksternal', TRUE);
                $tanggal_akhir_training_eksternal           = $this->input->post('tanggal_akhir_training_eksternal', TRUE);
                $institusi_penyelenggara_training_eksternal = $this->input->post('institusi_penyelenggara_training_eksternal', TRUE);
                $perihal_training_eksternal                 = $this->input->post('perihal_training_eksternal', TRUE);
                $jam_training_eksternal                     = $this->input->post('jam_training_eksternal', TRUE);
                $lokasi_training_eksternal                  = $this->input->post('lokasi_training_eksternal', TRUE);
                $alamat_training_eksternal                  = $this->input->post('alamat_training_eksternal', TRUE);
                $nomor_surat_training_eksternal             = $this->input->post('nomor_surat_training_eksternal', TRUE);

                //Mencari Nama Hari
                $tanggalawaltrainingeksternal      = IndonesiaTgl($tanggal_awal_training_eksternal);
                $tanggalakhirtrainingeksternal     = IndonesiaTgl($tanggal_akhir_training_eksternal);

                date_default_timezone_set("Asia/Jakarta");
                $tahun                              = date('Y');
                $bulan                              = date('m');
                $tanggal                            = date('d');
                $hari                               = date("w");

                //Mencari Nama Hari Awal
                $tanggalawal                        = substr($tanggalawaltrainingeksternal, 0, -8);
                $bulanawal                          = substr($tanggalawaltrainingeksternal, 3, -5);
                $tahunawal                          = substr($tanggalawaltrainingeksternal, -4);
                $nama_hari_awal                     = date('w', mktime(0, 0, 0, $bulanawal, $tanggalawal, $tahunawal));
                $hari_training_eksternal_awal       = hari($nama_hari_awal);
                //Mencari Nama Hari Awal

                //Mencari Nama Hari Akhir
                $tanggalakhir                       = substr($tanggalakhirtrainingeksternal, 0, -8);
                $bulanakhir                         = substr($tanggalakhirtrainingeksternal, 3, -5);
                $tahunakhir                         = substr($tanggalakhirtrainingeksternal, -4);
                $nama_hari_akhir                    = date('w', mktime(0, 0, 0, $bulanakhir, $tanggalakhir, $tahunakhir));
                $hari_training_eksternal_akhir      = hari($nama_hari_akhir);
                //Mencari Nama Hari Akhir

                //Upload Foto File History Training Internak 
                //file yang diperbolehkan hanya pdf dan ppt
                $config['allowed_types'] = 'pdf|jpg|jpeg|ppt|pptx|doc|docx';
                //max file 1024 kb
                $config['max_size'] = '1024';
                //lokasi penyimpanan file
                $config['upload_path'] = './assets/file/trainingeksternal/';
                //memanggil library upload
                $this->load->library('upload', $config);
                //membedakan nama file jika ada yang sama
                $this->upload->initialize($config);



                //JIka file Foto Kosong / File Foto Lebih Dari 1 Mb, Maka Tampil Pesan Kesalahan 
                if (!$this->upload->do_upload('dokumen_materi_training_eksternal')) {
                    //Menampilkan pesan Kesalahan
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Periksa kembali file upload anda..! ( Maksimal File 1 Mb Dan Format File pdf dan ppt )</div>');
                    redirect('history/trainingeksternal');
                }
                // Menyimpan Ke Database
                else {

                    //Mengambil Nama File Training eksternal
                    $new_image_file_history_training_eksternal = $this->upload->data('file_name');
                    //Mengambil Nama File Training eksternal

                    //Input Ke Dalam Database
                    $this->db->trans_start();

                    //Input Training eksternal
                    $result = array();
                    foreach ($nikkaryawan as $key => $val) {
                        $result[] = array(
                            'karyawan_id'                                   => $_POST['nik_karyawan'][$key],
                            'institusi_penyelenggara_training_eksternal'    => $institusi_penyelenggara_training_eksternal,
                            'perihal_training_eksternal'                    => $perihal_training_eksternal,
                            'hari_awal_training_eksternal'                  => $hari_training_eksternal_awal,
                            'hari_akhir_training_eksternal'                 => $hari_training_eksternal_akhir,
                            'tanggal_awal_training_eksternal'               => $tanggal_awal_training_eksternal,
                            'tanggal_akhir_training_eksternal'              => $tanggal_akhir_training_eksternal,
                            'jam_training_eksternal'                        => $jam_training_eksternal,
                            'lokasi_training_eksternal'                     => $lokasi_training_eksternal,
                            'alamat_training_eksternal'                     => $alamat_training_eksternal,
                            'nomor_surat_training_eksternal'                => $nomor_surat_training_eksternal,
                            'dokumen_materi_training_eksternal'             => $new_image_file_history_training_eksternal
                        );
                    }

                    //MULTIPLE INSERT TO HISTORY TRAINING EKSTERNAL
                    $this->db->insert_batch('history_training_eksternal', $result);
                    $this->db->trans_complete();

                    //menampikan pesan sukses
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Training Eksternal</div>');
                    //dan mendirect kehalaman training eksternal
                    redirect('history/trainingeksternal');
                }
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
	}
	
	//Menampilkan halaman awal form history tambah data training eksternal
    public function aksitambahdetailtrainingeksternal()
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Tambah Data History Training Eksternal';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Data Untuk Select Option Pada Tambah History Training Eksternal
            $data['karyawan']   = $this->trainingeksternal->datakaryawan();

            //Validation Form Input
            $this->form_validation->set_rules('tanggal_awal_training_eksternal', 'Tanggal Awal', 'required');
            $this->form_validation->set_rules('tanggal_akhir_training_eksternal', 'Tanggal Akhir', 'required');
            $this->form_validation->set_rules('institusi_penyelenggara_training_eksternal', 'Institusi Penyelenggara', 'required');
            $this->form_validation->set_rules('perihal_training_eksternal', 'Perihal Training Eksternal', 'required');
            $this->form_validation->set_rules('jam_training_eksternal', 'Jam Training Eksternal', 'required');
            $this->form_validation->set_rules('lokasi_training_eksternal', 'Lokasi Training Eksternal', 'required');
            $this->form_validation->set_rules('alamat_training_eksternal', 'Alamat Training Eksternal', 'required');
            $this->form_validation->set_rules('nomor_surat_training_eksternal', 'Nomor Surat Training Eksternal', 'required');

            //jika validasinya salah akan menampilkan halaman Training Eksternal
            if ($this->form_validation->run() == false) {
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('history/form_tambah_detail_history_training_eksternal', $data);
                $this->load->view('templates/footer');
            }
            //jika validasinya benar
            else {
                //Mengambil Data Dari FORM
                $nikkaryawan                                = $this->input->post('nik_karyawan', TRUE);
                $tanggal_awal_training_eksternal            = $this->input->post('tanggal_awal_training_eksternal', TRUE);
                $tanggal_akhir_training_eksternal           = $this->input->post('tanggal_akhir_training_eksternal', TRUE);
                $institusi_penyelenggara_training_eksternal = $this->input->post('institusi_penyelenggara_training_eksternal', TRUE);
                $perihal_training_eksternal                 = $this->input->post('perihal_training_eksternal', TRUE);
                $jam_training_eksternal                     = $this->input->post('jam_training_eksternal', TRUE);
                $lokasi_training_eksternal                  = $this->input->post('lokasi_training_eksternal', TRUE);
                $alamat_training_eksternal                  = $this->input->post('alamat_training_eksternal', TRUE);
                $nomor_surat_training_eksternal             = $this->input->post('nomor_surat_training_eksternal', TRUE);

                //Mencari Nama Hari
                $tanggalawaltrainingeksternal      = IndonesiaTgl($tanggal_awal_training_eksternal);
                $tanggalakhirtrainingeksternal     = IndonesiaTgl($tanggal_akhir_training_eksternal);

                date_default_timezone_set("Asia/Jakarta");
                $tahun                              = date('Y');
                $bulan                              = date('m');
                $tanggal                            = date('d');
                $hari                               = date("w");

                //Mencari Nama Hari Awal
                $tanggalawal                        = substr($tanggalawaltrainingeksternal, 0, -8);
                $bulanawal                          = substr($tanggalawaltrainingeksternal, 3, -5);
                $tahunawal                          = substr($tanggalawaltrainingeksternal, -4);
                $nama_hari_awal                     = date('w', mktime(0, 0, 0, $bulanawal, $tanggalawal, $tahunawal));
                $hari_training_eksternal_awal       = hari($nama_hari_awal);
                //Mencari Nama Hari Awal

                //Mencari Nama Hari Akhir
                $tanggalakhir                       = substr($tanggalakhirtrainingeksternal, 0, -8);
                $bulanakhir                         = substr($tanggalakhirtrainingeksternal, 3, -5);
                $tahunakhir                         = substr($tanggalakhirtrainingeksternal, -4);
                $nama_hari_akhir                    = date('w', mktime(0, 0, 0, $bulanakhir, $tanggalakhir, $tahunakhir));
                $hari_training_eksternal_akhir      = hari($nama_hari_akhir);
                //Mencari Nama Hari Akhir

                //Upload Foto File History Training Internak 
                //file yang diperbolehkan hanya pdf dan ppt
                $config['allowed_types'] = 'pdf|jpg|jpeg|ppt|pptx|doc|docx';
                //max file 1024 kb
                $config['max_size'] = '1024';
                //lokasi penyimpanan file
                $config['upload_path'] = './assets/file/trainingeksternal/';
                //memanggil library upload
                $this->load->library('upload', $config);
                //membedakan nama file jika ada yang sama
                $this->upload->initialize($config);

                //JIka file Foto Kosong / File Foto Lebih Dari 1 Mb, Maka Tampil Pesan Kesalahan 
                if (!$this->upload->do_upload('dokumen_materi_training_eksternal')) {
                    //Menampilkan pesan Kesalahan
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Periksa kembali file upload anda..! ( Maksimal File 1 Mb Dan Format File pdf dan ppt )</div>');
                    redirect('history/trainingeksternal');
                }
                // Menyimpan Ke Database
                else {

                    //Mengambil Nama File Training eksternal
                    $new_image_file_history_training_eksternal = $this->upload->data('file_name');
                    //Mengambil Nama File Training eksternal

                    //Input Ke Dalam Database
                    //Input Training eksternal
                        $datatrainingeksternal = [
                            'karyawan_id'                                   => $_POST['nik_karyawan'],
                            'institusi_penyelenggara_training_eksternal'    => $institusi_penyelenggara_training_eksternal,
                            'perihal_training_eksternal'                    => $perihal_training_eksternal,
                            'hari_awal_training_eksternal'                  => $hari_training_eksternal_awal,
                            'hari_akhir_training_eksternal'                 => $hari_training_eksternal_akhir,
                            'tanggal_awal_training_eksternal'               => $tanggal_awal_training_eksternal,
                            'tanggal_akhir_training_eksternal'              => $tanggal_akhir_training_eksternal,
                            'jam_training_eksternal'                        => $jam_training_eksternal,
                            'lokasi_training_eksternal'                     => $lokasi_training_eksternal,
                            'alamat_training_eksternal'                     => $alamat_training_eksternal,
                            'nomor_surat_training_eksternal'                => $nomor_surat_training_eksternal,
                            'dokumen_materi_training_eksternal'             => $new_image_file_history_training_eksternal
						];
                    

                    //MULTIPLE INSERT TO HISTORY TRAINING EKSTERNAL
                    $this->db->insert('history_training_eksternal', $datatrainingeksternal);

                    //menampikan pesan sukses
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Training Eksternal</div>');
                    //dan mendirect kehalaman training eksternal
                    redirect('history/trainingeksternal');
                }
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal form history edit data History Training eksternal
    public function edittrainingeksternal($id_history_training_eksternal)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Data History Training Eksternal';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Mengambil data dari model History Training Eksternal
            $data['datatrainingeksternal'] = $this->trainingeksternal->getAllHistoryTrainingEksternalByID($id_history_training_eksternal);

            //Validation Form Edit
            $this->form_validation->set_rules('tanggal_awal_training_eksternal', 'Tanggal Awal', 'required');
            $this->form_validation->set_rules('tanggal_akhir_training_eksternal', 'Tanggal Akhir', 'required');
            $this->form_validation->set_rules('institusi_penyelenggara_training_eksternal', 'Institusi Penyelenggara', 'required');
            $this->form_validation->set_rules('perihal_training_eksternal', 'Perihal Training Eksternal', 'required');
            $this->form_validation->set_rules('jam_training_eksternal', 'Jam Training Eksternal', 'required');
            $this->form_validation->set_rules('lokasi_training_eksternal', 'Lokasi Training Eksternal', 'required');
            $this->form_validation->set_rules('alamat_training_eksternal', 'Alamat Training Eksternal', 'required');
            $this->form_validation->set_rules('nomor_surat_training_eksternal', 'Nomor Surat Training Eksternal', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman edit history training eksternal
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('history/edit_history_training_eksternal', $data);
                $this->load->view('templates/footer');
            }
            //Jika semua form input benar 
            else {

                //Memanggil Nama File
                $upload_file_training_eksternal = $_FILES['dokumen_materi_training_eksternal']['name'];

                //Jika Foto Di Edit
                if (!empty($upload_file_training_eksternal)) {
                    //Upload Foto File Training eksternal
                    //file yang diperbolehkan hanya pdf
                    $config['allowed_types'] = 'pdf|jpg|jpeg|ppt|pptx|doc|docx';
                    //max file 1 mb
                    $config['max_size'] = '1024';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/file/trainingeksternal/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload file
                    $this->upload->do_upload('dokumen_materi_training_eksternal');

                    //unlink file lama
                    $old_image_file_training_eksternal = $data['datatrainingeksternal']['dokumen_materi_training_eksternal'];
                    unlink(FCPATH . 'assets/file/trainingeksternal/' . $old_image_file_training_eksternal);
                    //
                    //mengganti nama file yang ada di database
                    $new_image = $this->upload->data('file_name');
                    //
                    //mencari berdasarkan id history training eksternal
                    $idhistorytrainingeksternal =  $this->input->post('id_history_training_eksternal');
                    $this->db->set('dokumen_materi_training_eksternal', $new_image);
                    $this->db->where('tanggal_awal_training_eksternal', $this->input->post('tanggal_awal_training_eksternal'));
                    $this->db->update('history_training_eksternal');
                    //end Upload File Training eksternal

                    //Memanggil model history training eksternal dengan method edittrainingeksternal
                    $this->trainingeksternal->editTrainingEksternal();
                    //
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Training Eksternal</div>');
                    //redirect ke halaman data training eksternal
                    redirect('history/trainingeksternal');
                }
                //Jika Foto Tidak Di Edit
                else {
                    //Memanggil model history training eksternal dengan method editTrainingeksternal
                    $this->trainingeksternal->editTrainingEksternal();
                    //
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Training Eksternal</div>');
                    //redirect ke halaman data trainingeksternal
                    redirect('history/trainingeksternal');
                }
            }
            //Jika Yang Login Bukan HRD
        } else {
            $this->load->view('auth/blocked');
        }
        //
    }

    //Method Hapus Data History Training Eksternal
    public function hapustrainingeksternal($id_history_training_eksternal)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //mendelete kedalam database 
            $this->trainingeksternal->hapusTrainingEksternal($id_history_training_eksternal);

            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Training Eksternal</div>');
            //dan mendirect kehalaman Training Eksternal
            redirect('history/trainingeksternal');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal form history data pendidikan formal
    public function pendidikanformal()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data History Pendidikan Formal';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //menampilkan halaman history pendidikan formal
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('history/form_history_pendidikan_formal', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal form history data Keluarga
    public function tampilpendidikanformal()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data History Pendidikan Formal';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model History Pendidikan Formal
        $data['pendidikanformal'] = $this->pendidikanformal->getKaryawanByNIK();

        //Mengambil NPP Dari Form
        $nik = $this->input->post('nik_karyawan');
        //Untuk Validasi Form Tampil
        $cek = $this->pendidikanformal->getAllKaryawan();

        //Jika Data NIK Karyawan Tidak Sesuai
        if ($nik != $cek['nik_karyawan']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">NIK Karyawan Tidak Valid ( Masukan NIK Karyawan Yang Sesuai )</div>');
            //dan mendirect kehalaman pendidikan formal
            redirect('history/pendidikanformal');
        }
        //Jika Data Kosong
        else if ($nik == NULL) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Yang Dipilih Tidak Ada ( Masukan NIK Terlebih Dahulu )</div>');
            //dan mendirect kehalaman pendidikanformal
            redirect('history/pendidikanformal');
        }
        //Jika OK
        else {
            //menampilkan halaman history pendidikanformal
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('history/tampil_history_pendidikan_formal', $data);
            $this->load->view('templates/footer');
        }
    }

    //Menampilkan halaman awal form history tambah data pendidikan formal
    public function tambahpendidikanformal($nik_karyawan)
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Data History Pendidikan Formal';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Mengambil data dari model History Pendidikan Formal
            $data['pendidikanformal'] = $this->pendidikanformal->getAllKaryawanByNIK($nik_karyawan);

            //Validation Form Input
            $this->form_validation->set_rules('tingkat_pendidikan_formal', 'Tingkat Pendidikan', 'required');
            $this->form_validation->set_rules('nama_instansi_pendidikan', 'Nama Instansi Pendidikan', 'required');
            $this->form_validation->set_rules('tahun_lulus', 'Tahun Lulus', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman tambah history pendidikan formal
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('history/tambah_history_pendidikan_formal', $data);
                $this->load->view('templates/footer');
            }
            //Jika form input benar
            else {

                //Upload Foto File History Pendidikan Formal 
                //file yang diperbolehkan hanya png dan jpg
                $config['allowed_types'] = 'jpg|png';
                //max file 500 kb
                $config['max_size'] = '500';
                //lokasi penyimpanan file
                $config['upload_path'] = './assets/file/pendidikanformal/';
                //memanggil library upload
                $this->load->library('upload', $config);
                //membedakan nama file jika ada yang sama
                $this->upload->initialize($config);

                //JIka file Foto Kosong / File Foto Lebih Dari 500 Kb, Maka Tampil Pesan Kesalahan 
                if (!$this->upload->do_upload('dokumen_pendidikan_formal')) {
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Periksa kembali file upload anda..! ( Maksimal File 500 Kb Dan Format File jpg dan png )</div>');
                    redirect('history/pendidikanformal');
                }
                // Menyimpan Ke Database
                else {

                    //Mengambil Nama File
                    $new_image_file_history_pendidikan_formal = $this->upload->data('file_name');

                    //Input Database
                    $data = [
                        "karyawan_id"                   => $this->input->post('nik_karyawan', true),
                        "tingkat_pendidikan_formal"     => $this->input->post('tingkat_pendidikan_formal', true),
                        "nama_instansi_pendidikan"      => $this->input->post('nama_instansi_pendidikan', true),
                        "jurusan"                       => $this->input->post('jurusan', true),
                        "tahun_lulus"                   => $this->input->post('tahun_lulus', true),
                        "dokumen_pendidikan_formal"     => $new_image_file_history_pendidikan_formal
                    ];
                    $this->db->insert('history_pendidikan_formal', $data);
                    //

                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Pendidikan Formal</div>');
                    //redirect ke halaman history pendidikan formal
                    redirect('history/pendidikanformal');
                }
            }
            //Jika Yang Login Bukan HRD
        } else {
            $this->load->view('auth/blocked');
        }
        //
    }

    //Menampilkan halaman awal form history edit data pendidikan formal
    public function editpendidikanformal($id_history_pendidikan_formal)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Data History Pendidikan Formal';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Mengambil data dari model History Pendidikan Formal
            $data['pendidikanformal'] = $this->pendidikanformal->getAllHistoryPendidikanFormalByID($id_history_pendidikan_formal);

            //Edit Select Option
            $data['tingkat_pendidikan_formal'] = [
                ''          => 'Pilih Tingkat Pendidikan Formal',
                'SD'        => 'SD',
                'SMP'       => 'SMP',
                'SMA/SMK'   => 'SMA/SMK',
                'D1'        => 'D1',
                'D2'        => 'D2',
                'D3'        => 'D3',
                'S1'        => 'S1',
                'S2'        => 'S2',
                'S3'        => 'S3'
            ];


            //Validation Form Edit
            $this->form_validation->set_rules('tingkat_pendidikan_formal', 'Tingkat Pendidikan', 'required');
            $this->form_validation->set_rules('nama_instansi_pendidikan', 'Nama Instansi Pendidikan', 'required');
            $this->form_validation->set_rules('tahun_lulus', 'Tahun Lulus', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman edit history pendidikan formal
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('history/edit_history_pendidikan_formal', $data);
                $this->load->view('templates/footer');
            }
            //Jika semua form input benar 
            else {

                //Memanggil Nama File
                $upload_file_pendidikan_formal = $_FILES['dokumen_pendidikan_formal']['name'];

                //Jika Foto Di Edit
                if (!empty($upload_file_pendidikan_formal)) {
                    //Upload Foto File Keluarga 
                    //file yang diperbolehkan hanya png dan jpg
                    $config['allowed_types'] = 'jpg|png';
                    //max file 1 mb
                    $config['max_size'] = '500';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/file/pendidikanformal/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload foto
                    $this->upload->do_upload('dokumen_pendidikan_formal');

                    //unlink foto lama
                    $old_image_pendidikan_formal = $data['pendidikanformal']['dokumen_pendidikan_formal'];
                    unlink(FCPATH . 'assets/file/pendidikanformal/' . $old_image_pendidikan_formal);
                    //
                    //mengganti nama foto yang ada di database
                    $new_image = $this->upload->data('file_name');
                    //
                    //mencari berdasarkan id history pendidikan formal
                    $idhistorypendidikanformal =  $this->input->post('id_history_pendidikan_formal');
                    $this->db->set('dokumen_pendidikan_formal', $new_image);
                    $this->db->where('id_history_pendidikan_formal', $idhistorypendidikanformal);
                    $this->db->update('history_pendidikan_formal');
                    //end Upload Foto Pendidikan Formal

                    //Memanggil model history pendidikan formal dengan method editPendidikanFormal
                    $this->pendidikanformal->editPendidikanFormal();
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Pendidikan Formal</div>');
                    //redirect ke halaman data pendidikan formal
                    redirect('history/pendidikanformal');
                }
                //Jika Foto Tidak Di Edit
                else {
                    //Memanggil model history pendidikan formal dengan method editPendidikanFormal
                    $this->pendidikanformal->editPendidikanFormal();
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Pendidikan Formal</div>');
                    //redirect ke halaman data pendidikan formal
                    redirect('history/pendidikanformal');
                }
            }
            //Jika Yang Login Bukan HRD
        } else {
            $this->load->view('auth/blocked');
        }
        //
    }

    //Method Hapus Data History Pendidikan Formal
    public function hapuspendidikanformal($id_history_pendidikan_formal)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //mengambil data pendidikan formal berdasarkan id history pendidikan formal nya
            $data['pendidikanformal'] = $this->pendidikanformal->getAllHistoryPendidikanFormalByID($id_history_pendidikan_formal);

            //foto lama history pendidikan formal
            $old_image_pendidikan_formal = $data['pendidikanformal']['dokumen_pendidikan_formal'];

            //Unlink Foto Lama
            unlink(FCPATH . 'assets/file/pendidikanformal/' . $old_image_pendidikan_formal);

            //mendelete kedalam database 
            $this->pendidikanformal->hapusPendidikanFormal($id_history_pendidikan_formal);

            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Pendidikan Formal</div>');
            //dan mendirect kehalaman pendidikanformal
            redirect('history/pendidikanformal');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal form history data pendidikan non formal
    public function pendidikannonformal()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data History Pendidikan Non Formal';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //menampilkan halaman history pendidikan non formal
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('history/form_history_pendidikan_non_formal', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal form history data Keluarga
    public function tampilpendidikannonformal()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data History Pendidikan Non Formal';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data dari model History Pendidikan Non Formal
        $data['pendidikannonformal'] = $this->pendidikannonformal->getKaryawanByNIK();

        //Mengambil NPP Dari Form
        $nik = $this->input->post('nik_karyawan');
        //Untuk Validasi Form Tampil
        $cek = $this->pendidikannonformal->getAllKaryawan();

        //Jika Data NIK Karyawan Tidak Sesuai
        if ($nik != $cek['nik_karyawan']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">NIK Karyawan Tidak Valid ( Masukan NIK Karyawan Yang Sesuai )</div>');
            //dan mendirect kehalaman pendidikan non formal
            redirect('history/pendidikannonformal');
        }
        //Jika Data Kosong
        else if ($nik == NULL) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Yang Dipilih Tidak Ada ( Masukan NIK Terlebih Dahulu )</div>');
            //dan mendirect kehalaman pendidikan non formal
            redirect('history/pendidikannonformal');
        }
        //Jika OK
        else {
            //menampilkan halaman history pendidikan non formal
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('history/tampil_history_pendidikan_non_formal', $data);
            $this->load->view('templates/footer');
        }
    }

    //Menampilkan halaman awal form history tambah data pendidikan non formal
    public function tambahpendidikannonformal($nik_karyawan)
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Data History Pendidikan Non Formal';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Mengambil data dari model History Pendidikan Non Formal
            $data['pendidikannonformal'] = $this->pendidikannonformal->getAllKaryawanByNIK($nik_karyawan);

            //Validation Form Input
            $this->form_validation->set_rules('nama_instansi_pendidikan_non_formal', 'Instansi Pendidikan', 'required');
            $this->form_validation->set_rules('tanggal_awal_pendidikan_non_formal', 'Awal Pendidikan', 'required');
            $this->form_validation->set_rules('tanggal_akhir_pendidikan_non_formal', 'Akhir Pendidikan', 'required');
            $this->form_validation->set_rules('lokasi_pendidikan_non_formal', 'Lokasi Pendidikan', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman tambah history pendidikan non formal
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('history/tambah_history_pendidikan_non_formal', $data);
                $this->load->view('templates/footer');
            }
            //Jika form input benar
            else {

                //Upload Foto File History Pendidikan Non Formal 
                //file yang diperbolehkan hanya png dan jpg
                $config['allowed_types'] = 'jpg|png';
                //max file 500 kb
                $config['max_size'] = '500';
                //lokasi penyimpanan file
                $config['upload_path'] = './assets/file/pendidikannonformal/';
                //memanggil library upload
                $this->load->library('upload', $config);
                //membedakan nama file jika ada yang sama
                $this->upload->initialize($config);

                //JIka file Foto Kosong / File Foto Lebih Dari 500 Kb, Maka Tampil Pesan Kesalahan 
                if (!$this->upload->do_upload('dokumen_pendidikan_non_formal')) {
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Periksa kembali file upload anda..! ( Maksimal File 500 Kb Dan Format File jpg dan png )</div>');
                    redirect('history/pendidikannonformal');
                }
                // Menyimpan Ke Database
                else {

                    //Mengambil Nama File
                    $new_image_file_history_pendidikan_non_formal = $this->upload->data('file_name');

                    //Input Database
                    $data = [
                        "karyawan_id"                               => $this->input->post('nik_karyawan', true),
                        "nama_instansi_pendidikan_non_formal"       => $this->input->post('nama_instansi_pendidikan_non_formal', true),
                        "tanggal_awal_pendidikan_non_formal"        => $this->input->post('tanggal_awal_pendidikan_non_formal', true),
                        "tanggal_akhir_pendidikan_non_formal"       => $this->input->post('tanggal_akhir_pendidikan_non_formal', true),
                        "lokasi_pendidikan_non_formal"              => $this->input->post('lokasi_pendidikan_non_formal', true),
                        "dokumen_pendidikan_non_formal"             => $new_image_file_history_pendidikan_non_formal
                    ];
                    $this->db->insert('history_pendidikan_non_formal', $data);
                    //

                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Pendidikan Non Formal</div>');
                    //redirect ke halaman history pendidikan non formal
                    redirect('history/pendidikannonformal');
                }
            }
            //Jika Yang Login Bukan HRD
        } else {
            $this->load->view('auth/blocked');
        }
        //
    }

    //Menampilkan halaman awal form history edit data pendidikan non formal
    public function editpendidikannonformal($id_history_pendidikan_non_formal)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Data History Pendidikan Non Formal';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Mengambil data dari model History Pendidikan Formal
            $data['pendidikannonformal'] = $this->pendidikannonformal->getAllHistoryPendidikanNonFormalByID($id_history_pendidikan_non_formal);

            //Validation Form Edit
            $this->form_validation->set_rules('nama_instansi_pendidikan_non_formal', 'Instansi Pendidikan', 'required');
            $this->form_validation->set_rules('tanggal_awal_pendidikan_non_formal', 'Awal Pendidikan', 'required');
            $this->form_validation->set_rules('tanggal_akhir_pendidikan_non_formal', 'Akhir Pendidikan', 'required');
            $this->form_validation->set_rules('lokasi_pendidikan_non_formal', 'Lokasi Pendidikan', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman edit history pendidikan non formal
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('history/edit_history_pendidikan_non_formal', $data);
                $this->load->view('templates/footer');
            }
            //Jika semua form input benar 
            else {

                //Memanggil Nama File
                $upload_file_pendidikan_non_formal = $_FILES['dokumen_pendidikan_non_formal']['name'];

                //Jika Foto Di Edit
                if (!empty($upload_file_pendidikan_non_formal)) {
                    //Upload Foto File Pendidikan Non Formal 
                    //file yang diperbolehkan hanya png dan jpg
                    $config['allowed_types'] = 'jpg|png';
                    //max file 1 mb
                    $config['max_size'] = '500';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/file/pendidikannonformal/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload foto
                    $this->upload->do_upload('dokumen_pendidikan_non_formal');

                    //unlink foto lama
                    $old_image_pendidikan_non_formal = $data['pendidikannonformal']['dokumen_pendidikan_non_formal'];
                    unlink(FCPATH . 'assets/file/pendidikannonformal/' . $old_image_pendidikan_non_formal);
                    //
                    //mengganti nama foto yang ada di database
                    $new_image = $this->upload->data('file_name');
                    //
                    //mencari berdasarkan id history pendidikan formal
                    $idhistorypendidikannonformal =  $this->input->post('id_history_pendidikan_non_formal');
                    $this->db->set('dokumen_pendidikan_non_formal', $new_image);
                    $this->db->where('id_history_pendidikan_non_formal', $idhistorypendidikannonformal);
                    $this->db->update('history_pendidikan_non_formal');
                    //end Upload Foto Pendidikan Formal

                    //Memanggil model history pendidikan formal dengan method editPendidikanFormal
                    $this->pendidikannonformal->editPendidikanNonFormal();
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Pendidikan Non Formal</div>');
                    //redirect ke halaman data pendidikan non formal
                    redirect('history/pendidikannonformal');
                }
                //Jika Foto Tidak Di Edit
                else {
                    //Memanggil model history pendidikan non formal dengan method editPendidikanNonFormal
                    $this->pendidikannonformal->editPendidikanNonFormal();
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Pendidikan Non Formal</div>');
                    //redirect ke halaman data pendidikan non formal
                    redirect('history/pendidikannonformal');
                }
            }
            //Jika Yang Login Bukan HRD
        } else {
            $this->load->view('auth/blocked');
        }
        //
    }

    //Method Hapus Data History Pendidikan Formal
    public function hapuspendidikannonformal($id_history_pendidikan_non_formal)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login Admin, Dan Staff HRD
        if ($role_id == 1 || $role_id == 11) {

            //mengambil data pendidikan non formal berdasarkan id history pendidikan formal nya
            $data['pendidikannonformal'] = $this->pendidikannonformal->getAllHistoryPendidikanNonFormalByID($id_history_pendidikan_non_formal);

            //foto lama history pendidikan formal
            $old_image_pendidikan_non_formal = $data['pendidikannonformal']['dokumen_pendidikan_non_formal'];

            //Unlink Foto Lama
            unlink(FCPATH . 'assets/file/pendidikannonformal/' . $old_image_pendidikan_non_formal);

            //mendelete kedalam database 
            $this->pendidikannonformal->hapusPendidikanNonFormal($id_history_pendidikan_non_formal);

            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Pendidikan Non Formal</div>');
            //dan mendirect kehalaman pendidikannonformal
            redirect('history/pendidikannonformal');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }
}
