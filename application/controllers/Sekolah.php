<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Sekolah extends CI_Controller
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
        //Memanggil model sekolah
        $this->load->model('sekolah/Sekolah_model', 'sekolah');
    }

    //Menampilkan halaman awal data sekolah 
    public function sekolah()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Sekolah';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Mengambil data sekolah 
        $data['sekolah'] = $this->sekolah->datasekolah();

        //menampilkan halaman data sekolah
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sekolah/datasekolah', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman form tambah sekolah 
    public function tambahsekolah()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Tambah Data Sekolah';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Mengambil data absensi di join dengan data karyawan pada tahun 2018
        $data['sekolah'] = $this->sekolah->datasekolah();

        //validation
        $this->form_validation->set_rules('nama_sekolah', 'Nama Sekolah', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('alamat_sekolah', 'Alamat Sekolah', 'required|trim');
        $this->form_validation->set_rules('nomor_telepon_sekolah', 'Nomor Telepon Sekolah', 'required|trim');
        $this->form_validation->set_rules('email_sekolah', 'Email Sekolah', 'required|trim|valid_email|is_unique[sekolah.email_sekolah]');
        $this->form_validation->set_rules('nama_guru_pembimbing', 'Nama Guru Pembimbing', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('nomor_handphone_guru_pembimbing', 'No HP Guru Pembimbing', 'required|trim');

        //Jika form input ada yang salah
        if ($this->form_validation->run() == false) {
            //menampilkan halaman data karyawan
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('sekolah/tambahsekolah', $data);
            $this->load->view('templates/footer');
        }
        //Jika benar
        else {
            //Memanggil model absensi dengan method tambahAbsensi2019
            $this->sekolah->tambahSekolah();
            //Menampilkan pesan berhasil
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Sekolah</div>');
            //redirect ke halaman data absensi
            redirect('sekolah/sekolah');
        }

        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Edit Sekolah
    public function editsekolah($id_sekolah)
    {

        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Edit Data Sekolah';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Mengambil data sekolah
        $data['sekolah'] = $this->sekolah->getSekolahByID($id_sekolah);

        //validation
        $this->form_validation->set_rules('nama_sekolah', 'Nama Sekolah', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('alamat_sekolah', 'Alamat Sekolah', 'required|trim');
        $this->form_validation->set_rules('nomor_telepon_sekolah', 'Nomor Telepon Sekolah', 'required|trim');
        $this->form_validation->set_rules('email_sekolah', 'Email Sekolah', 'required|trim|valid_email');
        $this->form_validation->set_rules('nama_guru_pembimbing', 'Nama Guru Pembimbing', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('nomor_handphone_guru_pembimbing', 'No HP Guru Pembimbing', 'required|trim');

        //Jika form input ada yang salah
        if ($this->form_validation->run() == false) {
            //menampilkan halaman data sekolah
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('sekolah/editsekolah', $data);
            $this->load->view('templates/footer');
        }
        //Jika Benar
        else {
            //Memanggil model sekolah dengan method editSekolah
            $this->sekolah->editSekolah();
            //Menampilkan pesan berhasil
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Sekolah</div>');
            //redirect ke halaman data sekolah
            redirect('sekolah/sekolah');
        }

        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Method Hapus Data Sekolah
    public function hapussekolah($id_sekolah)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {
            
        //mendelete kedalam database melalui method pada model sekolah berdasarkan id nya
        $this->sekolah->hapusSekolah($id_sekolah);
        //menampikan pesan sukses
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Sekolah</div>');
        //dan mendirect kehalaman sekolah
        redirect('sekolah/sekolah');

        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }
}
