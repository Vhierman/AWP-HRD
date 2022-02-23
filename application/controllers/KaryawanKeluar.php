<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KaryawanKeluar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Memanggil model karyawan keluar
        $this->load->model('karyawan_keluar/Karyawankeluar_model', 'keluar');
        //Memanggil library validation
        $this->load->library('form_validation');
        is_logged_in();
    }

    //Menampilkan halaman awal data karyawan
    public function karyawankeluar()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Karyawan Keluar';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data karyawan keluar, dari model, dengan di join dengan data penempatan, perusahaan, dan data jabatan
        $data['datakeluar'] = $this->keluar->getAllKaryawanKeluar();

        //menampilkan halaman data karyawan keluar
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('karyawan_keluar/data_karyawan_keluar', $data);
        $this->load->view('templates/footer');
    }

    //untuk mencari data karyawan berdasarkan NIK Karyawan
    public function get_datakaryawan()
    {
        $nikkaryawan = $this->input->post('nik_karyawan');
        $data = $this->keluar->get_karyawan_bynik($nikkaryawan);
        echo json_encode($data);
    }

    //Menampilkan halaman awal data karyawan
    public function tambahkaryawankeluar()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Tambah Data Karyawan Keluar';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Validation Form Tambah 
            $this->form_validation->set_rules('tanggal_keluar_karyawan_keluar', 'Tanggal Keluar', 'required');
            $this->form_validation->set_rules('keterangan_keluar', 'Keterangan Keluar', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman data karyawan
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('karyawan_keluar/tambah_karyawan_keluar', $data);
                $this->load->view('templates/footer');
            } else {
                //Memanggil model karyawan keluar dengan method TambahKaryawanKeluar
                $this->keluar->tambahKaryawanKeluar();

                //mengambil data karyawan berdasarkan id nya
                $data['karyawan'] = $this->keluar->getKaryawanByNIK();

                //foto lama karyawan
                $old_image_karyawan = $data['karyawan']['foto_karyawan'];
                $old_image_ktp = $data['karyawan']['foto_ktp'];
                $old_image_npwp = $data['karyawan']['foto_npwp'];
                $old_image_kk = $data['karyawan']['foto_kk'];
                //unlink foto lama
                if ($old_image_karyawan != 'default_karyawan.jpg') {
                    unlink(FCPATH . 'assets/img/karyawan/karyawan/' . $old_image_karyawan);
                }
                if ($old_image_ktp != 'default_ktp.jpg') {
                    unlink(FCPATH . 'assets/img/karyawan/ktp/' . $old_image_ktp);
                }
                if ($old_image_npwp != 'default_npwp.jpg') {
                    unlink(FCPATH . 'assets/img/karyawan/npwp/' . $old_image_npwp);
                }
                if ($old_image_kk != 'default_kk.jpg') {
                    unlink(FCPATH . 'assets/img/karyawan/kk/' . $old_image_kk);
                }

                //mendelete kedalam database melalui method hapusKaryawan berdasarkan nik karyawan nya
                $this->keluar->hapusKaryawan();

                //mendelete kedalam database melalui method hapusAbsenKaryawan berdasarkan nik karyawan nya
                $this->keluar->hapusAbsenKaryawan();

                //mendelete kedalam database melalui method hapusInventarisKaryawan berdasarkan nik karyawan nya
                $this->keluar->hapusInventarisKaryawan();

                //mendelete kedalam database melalui method hapus History Kontrak berdasarkan nik karyawan nya
                $this->keluar->hapusHistoryKontrak();

                //mendelete kedalam database melalui method hapus History Jabatan berdasarkan nik karyawan nya
                $this->keluar->hapusHistoryJabatan();

                //mendelete kedalam database melalui method hapus History Keluarga berdasarkan nik karyawan nya
                $this->keluar->hapusHistoryKeluarga();

                //mendelete kedalam database melalui method hapus History Pendidikan Formal berdasarkan nik karyawan nya
                $this->keluar->hapusHistoryPendidikanFormal();

                //mendelete kedalam database melalui method hapus History Pendidikan NOn Formal berdasarkan nik karyawan nya
                $this->keluar->hapusHistoryPendidikanNonFormal();

                //mendelete kedalam database melalui method hapus History Training Internal berdasarkan nik karyawan nya
                $this->keluar->hapusHistoryTrainingInternal();

                //mendelete kedalam database melalui method hapus History Training Eksternal berdasarkan nik karyawan nya
                $this->keluar->hapusHistoryTrainingEksternal();

                //Menampilkan pesan berhasil
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Karyawan Keluar</div>');
                //redirect ke halaman data karyawan keluar
                redirect('KaryawanKeluar/karyawankeluar');
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal edit data karyawan keluar
    public function editkaryawankeluar($id)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Edit Karyawan Keluar';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //mengambil data karyawan keluar berdasarkan id nya
            $data['karyawankeluar'] = $this->keluar->getKaryawanKeluarByID($id);

            $data['keterangan_keluar'] = [
                '' => 'Pilih Keterangan Keluar',
                'Berakhirnya Kontrak Kerja' => 'Berakhirnya Kontrak Kerja',
                'Berakhirnya Masa Kerja' => 'Berakhirnya Masa Kerja',
                'Pengunduran Diri' => 'Pengunduran Diri',
                'Meninggal Dunia' => 'Meninggal Dunia'
            ];

            //Validation Form EDIT
            $this->form_validation->set_rules('tanggal_keluar_karyawan_keluar', 'Tanggal Keluar', 'required');
            $this->form_validation->set_rules('keterangan_keluar', 'Keterangan Keluar', 'required');
            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman data karyawan
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('karyawan_keluar/edit_karyawan_keluar', $data);
                $this->load->view('templates/footer');
            } else {
                //update kedalam database melalui method editKaryawanKeluar berdasarkan id nya
                $this->keluar->editKaryawanKeluar($id);
                //menampikan pesan sukses
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Karyawan Keluar</div>');
                //dan mendirect kehalaman karyawan keluar
                redirect('KaryawanKeluar/karyawankeluar');
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal hapus data karyawan
    public function hapuskaryawankeluar($id)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Hapus Karyawan Keluar';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //mendelete kedalam database melalui method hapusKaryawanKeluar berdasarkan id nya
            $this->keluar->hapusKaryawanKeluar($id);

            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Karyawan Keluar</div>');
            //dan mendirect kehalaman karyawan keluar
            redirect('KaryawanKeluar/karyawankeluar');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }
}
