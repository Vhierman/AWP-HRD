<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Memanggil library validation
        $this->load->library('form_validation');
        //Memanggil Helper Login
        is_logged_in();
        //Memanggil Helper
        $this->load->helper('wpp');
        //Memanggil model siswa
        $this->load->model('siswa/Siswa_model', 'siswa');
    }

    //Method Data Siswa
    public function siswa()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Siswa';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Mengambil data siswa di join dengan data sekolah dan penempatan
        $data['siswa'] = $this->siswa->dataSiswa();

        //menampilkan halaman data siswa
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('siswa/datasiswa', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal tambah siswa 
    public function tambahsiswa()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Tambah Data Siswa';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
            //Mengambil data siswa di join dengan data sekolah dan penempatan
            $data['siswa'] = $this->siswa->dataSiswa();
            //Mengambil data penempatan dan sekolah untuk ditampilkan kedalam select option pada form tambah dan edit
            $data['sekolah'] = $this->siswa->dataSekolah();
            $data['penempatan'] = $this->siswa->dataPenempatan();

            //Validation Form Data Siswa
            $this->form_validation->set_rules('sekolah_id', 'Nama Sekolah', 'required');
            $this->form_validation->set_rules('penempatan_id', 'Penempatan', 'required');
            $this->form_validation->set_rules('tanggal_masuk_pkl', 'Tanggal Masuk', 'required');
            $this->form_validation->set_rules('tanggal_selesai_pkl', 'Tanggal Selesai', 'required');
            $this->form_validation->set_rules('nis_siswa', 'NIS Siswa', 'required|trim');
            $this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'required|trim');
            $this->form_validation->set_rules('tempat_lahir_siswa', 'Tempat Lahir', 'required');
            $this->form_validation->set_rules('tanggal_lahir_siswa', 'Tanggal Lahir', 'required');
            $this->form_validation->set_rules('jenis_kelamin_siswa', 'Jenis Kelamin', 'required');
            $this->form_validation->set_rules('agama_siswa', 'Agama', 'required');
            $this->form_validation->set_rules('alamat_siswa', 'Alamat', 'required');
            $this->form_validation->set_rules('nomor_handphone_siswa', 'Nomor HP', 'required');
            $this->form_validation->set_rules('jurusan', 'Jurusan', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman tambah data siswa
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('siswa/tambahsiswa', $data);
                $this->load->view('templates/footer');
            }
            //Jika semua form input benar 
            else {
                //Memanggil model siswa dengan method tambahSiswa
                $this->siswa->tambahSiswa();
                //Menampilkan pesan berhasil
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Siswa</div>');
                //redirect ke halaman data siswa
                redirect('siswa/siswa');
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal tambah siswa 
    public function editsiswa($id_siswa)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Edit Data Siswa';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
            //Mengambil data siswa di join dengan data sekolah dan penempatan berdasarkan id_siswa
            $data['siswa'] = $this->siswa->getdataSiswaByID($id_siswa);
            //Mengambil data penempatan dan sekolah untuk ditampilkan kedalam select option pada form tambah dan edit
            $data['sekolah'] = $this->siswa->dataSekolah();
            $data['penempatan'] = $this->siswa->dataPenempatan();

            //Select Option
            //untuk tipe datanya enum
            $data['jenis_kelamin_siswa'] = ['Pria', 'Wanita'];
            $data['agama_siswa'] = ['Islam', 'Kristen Protestan', 'Kristen Katholik', 'Hindu', 'Budha'];

            //Validation Form Data Siswa
            $this->form_validation->set_rules('sekolah_id', 'Nama Sekolah', 'required');
            $this->form_validation->set_rules('penempatan_id', 'Penempatan', 'required');
            $this->form_validation->set_rules('tanggal_masuk_pkl', 'Tanggal Masuk', 'required');
            $this->form_validation->set_rules('tanggal_selesai_pkl', 'Tanggal Selesai', 'required');
            $this->form_validation->set_rules('nis_siswa', 'NIS Siswa', 'required|trim');
            $this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'required|trim');
            $this->form_validation->set_rules('tempat_lahir_siswa', 'Tempat Lahir', 'required');
            $this->form_validation->set_rules('tanggal_lahir_siswa', 'Tanggal Lahir', 'required');
            $this->form_validation->set_rules('jenis_kelamin_siswa', 'Jenis Kelamin', 'required');
            $this->form_validation->set_rules('agama_siswa', 'Agama', 'required');
            $this->form_validation->set_rules('alamat_siswa', 'Alamat', 'required');
            $this->form_validation->set_rules('nomor_handphone_siswa', 'Nomor HP', 'required');
            $this->form_validation->set_rules('jurusan', 'Jurusan', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman edit data siswa
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('siswa/editsiswa', $data);
                $this->load->view('templates/footer');
            }
            //Jika semua form input benar 
            else {
                //Memanggil model siswa dengan method tambahSiswa
                $this->siswa->editSiswa();
                //Menampilkan pesan berhasil
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Siswa</div>');
                //redirect ke halaman data siswa
                redirect('siswa/siswa');
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Method Hapus Data Siswa
    public function hapussiswa($id_siswa)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //mendelete kedalam database melalui method pada model perusahaan berdasarkan id nya
            $this->siswa->hapusSiswa($id_siswa);
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Siswa</div>');
            //dan mendirect kehalaman siswa
            redirect('siswa/siswa');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }
}
