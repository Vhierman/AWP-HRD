<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Check extends CI_Controller
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
        //Memanggil model cek lembur
        $this->load->model('check/Ceklemburan_model', 'ceklembur');
    }

    //Menampilkan halaman awal data cek lemburan
    public function ceklemburan()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Cek Lemburan';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Mengambil data penempatan
        $data['penempatan'] = $this->ceklembur->datapenempatan();

        //menampilkan halaman data cek lemburan
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('check/Datalemburan', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal data tampil data lemburan
    public function tampildatalemburan()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Tampil Data Lemburan';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data lembur di join dengan data karyawan
        $data['ceklembur'] = $this->ceklembur->datalembur();

        //Jika Data Kosong
        if ($data['ceklembur'] == NULL) {
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Tidak Ada</div>');
            redirect('check/ceklemburan');
        }
        //Jika ada data
        else {
            //menampilkan halaman data cek lemburan
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('check/Tampildatalemburan', $data);
            $this->load->view('templates/footer');
        }
    }

    //Menampilkan halaman awal data verifikasi data lemburan
    public function verifikasidatalemburan()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Verifikasi Data Lemburan';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Mengambil data lembur di join dengan data karyawan
        $data['ceklembur'] = $this->ceklembur->datalembur();

        //mengupdate kedalam database melalui method pada model cek lemburan
        $this->ceklembur->verifikasidatalembur();

        //menampikan pesan sukses
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Verifikasi Data Lembur</div>');

        //menampilkan halaman data cek lemburan
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('check/Datalemburan', $data);
        $this->load->view('templates/footer');
    }
}
