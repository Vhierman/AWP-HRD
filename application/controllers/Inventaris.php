<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventaris extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Memanggil model inventaris laptop
        $this->load->model('inventaris_laptop/Inventarislaptop_model', 'laptop');
        //Memanggil model inventaris motor
        $this->load->model('inventaris_motor/Inventarismotor_model', 'motor');
        //Memanggil model inventaris mobil
        $this->load->model('inventaris_mobil/Inventarismobil_model', 'mobil');
        //Memanggil library validation
        $this->load->library('form_validation');
        //Memanggil Helper Login
        is_logged_in();
        //Memanggil Helper
        $this->load->helper('wpp');
    }

    //Menampilkan halaman awal data inventaris laptop
    public function inventarislaptop()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Inventaris Laptop';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data inventaris laptop, dari model, dengan di join dengan data karyawan dan penempatan
        $data['laptop'] = $this->laptop->dataInventarislaptop();

        //menampilkan halaman data inventaris laptop
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inventaris_laptop/data_inventaris_laptop', $data);
        $this->load->view('templates/footer');
    }

    //untuk mencari data karyawan berdasarkan NIK Karyawan
    public function get_datakaryawan()
    {
        $nikkaryawan = $this->input->post('nik_karyawan');
        $data = $this->laptop->get_karyawan_bynik($nikkaryawan);
        echo json_encode($data);
    }

    //Method Tambah Data Inventaris Laptop
    public function tambahinventarislaptop()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Tambah Inventaris Laptop';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
            //Mengambil data inventaris laptop, dari model, dengan di join dengan data karyawan dan penempatan
            $data['laptop'] = $this->laptop->dataInventarislaptop();

            //Validation Form Input
            $this->form_validation->set_rules('nik_karyawan', 'NIK Karyawan', 'required|is_unique[inventaris_laptop.karyawan_id]|min_length[16]');
            $this->form_validation->set_rules('nama_karyawan', 'Nama Karyawan', 'required');
            $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
            $this->form_validation->set_rules('penempatan', 'Penempatan', 'required');
            $this->form_validation->set_rules('merk_laptop', 'Merk Laptop', 'required');
            $this->form_validation->set_rules('type_laptop', 'Type Laptop', 'required');
            $this->form_validation->set_rules('processor', 'Processor', 'required');
            $this->form_validation->set_rules('ram', 'RAM', 'required');
            $this->form_validation->set_rules('vga', 'VGA', 'required');
            $this->form_validation->set_rules('sistem_operasi', 'Sistem Operasi', 'required');
            $this->form_validation->set_rules('tanggal_penyerahan_laptop', 'Tanggal Penyerahan Laptop', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman data inventaris laptop
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('inventaris_laptop/tambah_inventaris_laptop', $data);
                $this->load->view('templates/footer');
            }
            //Jika semua form input benar 
            else {

                //Upload Foto Laptop 
                //file yang diperbolehkan hanya png dan jpg
                $config['allowed_types'] = 'jpg|png';
                //max file 500 kb
                $config['max_size'] = '500';
                //lokasi penyimpanan file
                $config['upload_path'] = './assets/img/inventaris/laptop/';
                //memanggil library upload
                $this->load->library('upload', $config);
                //membedakan nama file jika ada yang sama
                $this->upload->initialize($config);

                //JIka file Foto Kosong / File Foto Lebih Dari 500 Kb, Maka Tampil Pesan Kesalahan 
                if (!$this->upload->do_upload('foto_laptop')) {
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Periksa kembali file upload anda..! ( Maksimal File 500 Kb Dan Format File jpg dan png )</div>');
                    redirect('inventaris/inventarislaptop');
                }
                // Menyimpan Ke Database
                else {
                    $new_image_laptop = $this->upload->data('file_name');
                    $data = [
                        "karyawan_id"                   => $this->input->post('nik_karyawan', true),
                        "merk_laptop"                   => $this->input->post('merk_laptop', true),
                        "type_laptop"                   => $this->input->post('type_laptop', true),
                        "processor"                     => $this->input->post('processor', true),
                        "ram"                           => $this->input->post('ram', true),
                        "hardisk"                       => $this->input->post('hardisk', true),
                        "vga"                           => $this->input->post('vga', true),
                        "sistem_operasi"                => $this->input->post('sistem_operasi', true),
                        "tanggal_penyerahan_laptop"     => $this->input->post('tanggal_penyerahan_laptop', true),
                        "foto_laptop"                   => $new_image_laptop
                    ];
                    $this->db->insert('inventaris_laptop', $data);

                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Inventaris Laptop</div>');
                    //redirect ke halaman data inventaris laptop
                    redirect('inventaris/inventarislaptop');
                }
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman lihat data inventaris laptop
    public function lihatinventarislaptop($id_inventaris_laptop)
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Lihat Data Inventaris Laptop';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data inventaris laptop, dari model, dengan di join dengan data karyawan dan penempatan
        $data['lihat'] = $this->laptop->getdataInventarislaptopByID($id_inventaris_laptop);
        $datatanggal = $this->laptop->getdataInventarislaptopByID($id_inventaris_laptop);
        $data['tanggalpenyerahan']               = date('d-m-Y', strtotime($datatanggal['tanggal_penyerahan_laptop']));
        //menampilkan halaman data inventaris laptop
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inventaris_laptop/lihat_inventaris_laptop', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman edit data inventaris laptop
    public function editinventarislaptop($id_inventaris_laptop)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Edit Data Inventaris Laptop';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Mengambil data inventaris laptop, dari model, dengan di join dengan data karyawan dan penempatan
            $data['lihat'] = $this->laptop->getdataInventarislaptopByID($id_inventaris_laptop);

            //Validation Form Edit
            $this->form_validation->set_rules('nik_karyawan', 'NIK Karyawan', 'required');
            $this->form_validation->set_rules('nama_karyawan', 'Nama Karyawan', 'required');
            $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
            $this->form_validation->set_rules('penempatan', 'Penempatan', 'required');
            $this->form_validation->set_rules('merk_laptop', 'Merk Laptop', 'required');
            $this->form_validation->set_rules('type_laptop', 'Type Laptop', 'required');
            $this->form_validation->set_rules('processor', 'Processor', 'required');
            $this->form_validation->set_rules('ram', 'RAM', 'required');
            $this->form_validation->set_rules('vga', 'VGA', 'required');
            $this->form_validation->set_rules('sistem_operasi', 'Sistem Operasi', 'required');
            $this->form_validation->set_rules('tanggal_penyerahan_laptop', 'Tanggal Penyerahan Laptop', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman data inventaris laptop
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('inventaris_laptop/edit_inventaris_laptop', $data);
                $this->load->view('templates/footer');
            } else {

                $upload_inventaris_laptop = $_FILES['foto_laptop']['name'];

                //Jika Foto Laptop Di EDIT
                if (!empty($upload_inventaris_laptop)) {
                    //Upload Foto Laptop 
                    //file yang diperbolehkan hanya png dan jpg
                    $config['allowed_types'] = 'jpg|png';
                    //max file 1 mb
                    $config['max_size'] = '500';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/img/inventaris/laptop/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload foto
                    $this->upload->do_upload('foto_laptop');
                    //unlink foto lama
                    $old_image_laptop = $data['lihat']['foto_laptop'];
                    unlink(FCPATH . 'assets/img/inventaris/laptop/' . $old_image_laptop);

                    //mengganti nama foto yang ada di database
                    $new_image = $this->upload->data('file_name');

                    //mencari berdasarkan id inventaris laptop
                    $idinventarislaptop =  $this->input->post('id_inventaris_laptop');
                    $this->db->set('foto_laptop', $new_image);
                    $this->db->where('id_inventaris_laptop', $idinventarislaptop);
                    $this->db->update('inventaris_laptop');
                    //end Upload Foto Laptop

                    $this->laptop->editInventarislaptop();
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Inventaris Laptop</div>');
                    //redirect ke halaman data inventaris laptop
                    redirect('inventaris/inventarislaptop');
                }
                //Jika Foto Laptop Tidak Di EDIT
                else {
                    $this->laptop->editInventarislaptop();
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Inventaris Laptop</div>');
                    //redirect ke halaman data inventaris laptop
                    redirect('inventaris/inventarislaptop');
                }
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Method Hapus Data Inventaris Laptop
    public function hapusinventarislaptop($id_inventaris_laptop)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            $data['lihat'] = $this->laptop->getdataInventarislaptopByID($id_inventaris_laptop);
            $old_image_laptop = $data['lihat']['foto_laptop'];
            unlink(FCPATH . 'assets/img/inventaris/laptop/' . $old_image_laptop);

            //mendelete kedalam database melalui method pada model laptop berdasarkan id nya
            $this->laptop->hapusInventarislaptop($id_inventaris_laptop);
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Inventaris Laptop</div>');
            //dan mendirect kehalaman inventaris laptop
            redirect('inventaris/inventarislaptop');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman awal data inventaris motor
    public function inventarismotor()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Inventaris Motor';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data inventaris motor, dari model, dengan di join dengan data karyawan dan penempatan
        $data['motor'] = $this->motor->dataInventarismotor();

        //menampilkan halaman data inventaris motor
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inventaris_motor/data_inventaris_motor', $data);
        $this->load->view('templates/footer');
    }

    //Method Tambah Data Inventaris Motor
    public function tambahinventarismotor()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Tambah Inventaris Motor';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
            //Mengambil data inventaris motor, dari model, dengan di join dengan data karyawan dan penempatan
            $data['motor'] = $this->motor->dataInventarismotor();

            //Validation Form Input
            $this->form_validation->set_rules('nik_karyawan', 'NIK Karyawan', 'required|is_unique[inventaris_motor.karyawan_id]|min_length[16]');
            $this->form_validation->set_rules('merk_motor', 'Merk Motor', 'required');
            $this->form_validation->set_rules('type_motor', 'Type Motor', 'required');
            $this->form_validation->set_rules('nomor_polisi', 'Nomor Polisi', 'required');
            $this->form_validation->set_rules('warna_motor', 'Warna Motor', 'required');
            $this->form_validation->set_rules('nomor_rangka_motor', 'Nomor Rangka Motor', 'required');
            $this->form_validation->set_rules('nomor_mesin_motor', 'Nomor Mesin Motor', 'required');
            $this->form_validation->set_rules('tahun_pembuatan_motor', 'Tahun Pembuatan Motor', 'required');
            $this->form_validation->set_rules('tanggal_akhir_pajak_motor', 'Tanggal Akhir Pajak Motor', 'required');
            $this->form_validation->set_rules('tanggal_akhir_plat_motor', 'Tanggal Akhir Plat Motor', 'required');
            $this->form_validation->set_rules('tanggal_penyerahan_motor', 'Tanggal Penyerahan Motor', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman data inventaris motor
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('inventaris_motor/tambah_inventaris_motor', $data);
                $this->load->view('templates/footer');
            }
            //Jika semua form input benar 
            else {

                $upload_foto_stnk_motor     = $_FILES['foto_stnk_motor']['name'];
                $upload_foto_motor          = $_FILES['foto_motor']['name'];

                //Jika File Foto Tidak Kosong
                if (!empty($upload_foto_stnk_motor) && !empty($upload_foto_motor)) {

                    //Upload Foto Laptop 
                    //file yang diperbolehkan hanya png dan jpg
                    $config['allowed_types'] = 'jpg|png';
                    //max file 500 kb
                    $config['max_size'] = '500';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/img/inventaris/motor/stnk/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload foto
                    $this->upload->do_upload('foto_stnk_motor');
                    $stnk_motor = $this->upload->data('file_name');

                    //Upload Foto Laptop 
                    //file yang diperbolehkan hanya png dan jpg
                    $config['allowed_types'] = 'jpg|png';
                    //max file 500 kb
                    $config['max_size'] = '500';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/img/inventaris/motor/motor/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload foto
                    $this->upload->do_upload('foto_motor');
                    $motor = $this->upload->data('file_name');

                    //Jika File Melebihi dari 500 Kb
                    if (!$this->upload->do_upload('foto_stnk_motor') && !$this->upload->do_upload('foto_motor')) {
                        //Menampilkan pesan berhasil
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Periksa kembali file upload anda..! ( Maksimal File 500 Kb Dan Format File jpg dan png )</div>');
                        redirect('inventaris/inventarismotor');
                    } else {

                        $data = [
                            "karyawan_id"                   => $this->input->post('nik_karyawan', true),
                            "merk_motor"                    => $this->input->post('merk_motor', true),
                            "type_motor"                    => $this->input->post('type_motor', true),
                            "nomor_polisi"                  => $this->input->post('nomor_polisi', true),
                            "warna_motor"                   => $this->input->post('warna_motor', true),
                            "nomor_rangka_motor"            => $this->input->post('nomor_rangka_motor', true),
                            "nomor_mesin_motor"             => $this->input->post('nomor_mesin_motor', true),
                            "tahun_pembuatan_motor"         => $this->input->post('tahun_pembuatan_motor', true),
                            "tanggal_akhir_pajak_motor"     => $this->input->post('tanggal_akhir_pajak_motor', true),
                            "tanggal_akhir_plat_motor"      => $this->input->post('tanggal_akhir_plat_motor', true),
                            "tanggal_penyerahan_motor"      => $this->input->post('tanggal_penyerahan_motor', true),
                            "foto_stnk_motor"               => $stnk_motor,
                            "foto_motor"                    => $motor
                        ];

                        $this->db->insert('inventaris_motor', $data);

                        //Menampilkan pesan berhasil
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Inventaris Motor</div>');
                        //redirect ke halaman data inventaris motor
                        redirect('inventaris/inventarismotor');
                        //
                    }
                }
                //Jika File Foto Kosong
                else {

                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Periksa kembali file anda..! ( File Foto Tidak Boleh Kosong )</div>');
                    redirect('inventaris/inventarismotor');
                }
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman edit data inventaris motor
    public function editinventarismotor($id_inventaris_motor)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Edit Data Inventaris Motor';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Mengambil data inventaris motor, dari model, dengan di join dengan data karyawan dan penempatan
            $data['lihat'] = $this->motor->getdataInventarismotorByID($id_inventaris_motor);

            //Validation Form Edit
            $this->form_validation->set_rules('nik_karyawan', 'NIK Karyawan', 'required');
            $this->form_validation->set_rules('merk_motor', 'Merk Motor', 'required');
            $this->form_validation->set_rules('type_motor', 'Type Motor', 'required');
            $this->form_validation->set_rules('nomor_polisi', 'Nomor Polisi', 'required');
            $this->form_validation->set_rules('warna_motor', 'Warna Motor', 'required');
            $this->form_validation->set_rules('nomor_rangka_motor', 'Nomor Rangka Motor', 'required');
            $this->form_validation->set_rules('nomor_mesin_motor', 'Nomor Mesin Motor', 'required');
            $this->form_validation->set_rules('tahun_pembuatan_motor', 'Tahun Pembuatan Motor', 'required');
            $this->form_validation->set_rules('tanggal_akhir_pajak_motor', 'Tanggal Akhir Pajak Motor', 'required');
            $this->form_validation->set_rules('tanggal_akhir_plat_motor', 'Tanggal Akhir Plat Motor', 'required');
            $this->form_validation->set_rules('tanggal_penyerahan_motor', 'Tanggal Penyerahan Motor', 'required');

            //Jika form edit ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman data inventaris motor
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('inventaris_motor/edit_inventaris_motor', $data);
                $this->load->view('templates/footer');
            } else {

                $upload_foto_stnk_motor = $_FILES['foto_stnk_motor']['name'];
                $upload_foto_motor = $_FILES['foto_motor']['name'];

                //Jika Foto STNK Dan Motor Di EDIT
                if (!empty($upload_foto_stnk_motor) && !empty($upload_foto_motor)) {

                    //Upload Foto STNK Motor 
                    //file yang diperbolehkan hanya png dan jpg
                    $config['allowed_types'] = 'jpg|png';
                    //max file 1 mb
                    $config['max_size'] = '500';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/img/inventaris/motor/stnk/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload foto
                    $this->upload->do_upload('foto_stnk_motor');
                    //unlink foto lama
                    $old_image_foto_stnk_motor = $data['lihat']['foto_stnk_motor'];
                    unlink(FCPATH . 'assets/img/inventaris/motor/stnk/' . $old_image_foto_stnk_motor);
                    //mengganti nama foto yang ada di database
                    $new_image_stnk_motor = $this->upload->data('file_name');
                    //mencari berdasarkan id inventaris motor
                    $idinventarismotor =  $this->input->post('id_inventaris_motor');
                    $this->db->set('foto_stnk_motor', $new_image_stnk_motor);
                    $this->db->where('id_inventaris_motor', $idinventarismotor);
                    $this->db->update('inventaris_motor');
                    //end Upload Foto STNK Motor


                    //Upload Foto Motor 
                    //file yang diperbolehkan hanya png dan jpg
                    $config['allowed_types'] = 'jpg|png';
                    //max file 1 mb
                    $config['max_size'] = '500';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/img/inventaris/motor/motor/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload foto
                    $this->upload->do_upload('foto_motor');
                    //unlink foto lama
                    $old_image_foto_motor = $data['lihat']['foto_motor'];
                    unlink(FCPATH . 'assets/img/inventaris/motor/motor/' . $old_image_foto_motor);
                    //mengganti nama foto yang ada di database
                    $new_image_motor = $this->upload->data('file_name');
                    //mencari berdasarkan id inventaris motor
                    $idinventarismotor =  $this->input->post('id_inventaris_motor');
                    $this->db->set('foto_motor', $new_image_motor);
                    $this->db->where('id_inventaris_motor', $idinventarismotor);
                    $this->db->update('inventaris_motor');
                    //end Upload Foto Motor


                    $this->motor->editInventarismotor();
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Inventaris Motor</div>');
                    //redirect ke halaman data inventaris motor
                    redirect('inventaris/inventarismotor');
                }
                //Jika Foto Motor Di EDIT
                elseif (empty($upload_foto_stnk_motor) && !empty($upload_foto_motor)) {

                    //Upload Foto Motor 
                    //file yang diperbolehkan hanya png dan jpg
                    $config['allowed_types'] = 'jpg|png';
                    //max file 1 mb
                    $config['max_size'] = '500';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/img/inventaris/motor/motor/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload foto
                    $this->upload->do_upload('foto_motor');
                    //unlink foto lama
                    $old_image_foto_motor = $data['lihat']['foto_motor'];
                    unlink(FCPATH . 'assets/img/inventaris/motor/motor/' . $old_image_foto_motor);
                    //mengganti nama foto yang ada di database
                    $new_image_motor = $this->upload->data('file_name');
                    //mencari berdasarkan id inventaris motor
                    $idinventarismotor =  $this->input->post('id_inventaris_motor');
                    $this->db->set('foto_motor', $new_image_motor);
                    $this->db->where('id_inventaris_motor', $idinventarismotor);
                    $this->db->update('inventaris_motor');
                    //end Upload Foto Motor


                    $this->motor->editInventarismotor();
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Inventaris Motor</div>');
                    //redirect ke halaman data inventaris motor
                    redirect('inventaris/inventarismotor');
                }
                //Jika Foto STNK Di EDIT
                elseif (!empty($upload_foto_stnk_motor) && empty($upload_foto_motor)) {

                    //Upload Foto STNK Motor 
                    //file yang diperbolehkan hanya png dan jpg
                    $config['allowed_types'] = 'jpg|png';
                    //max file 1 mb
                    $config['max_size'] = '500';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/img/inventaris/motor/stnk/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload foto
                    $this->upload->do_upload('foto_stnk_motor');
                    //unlink foto lama
                    $old_image_foto_stnk_motor = $data['lihat']['foto_stnk_motor'];
                    unlink(FCPATH . 'assets/img/inventaris/motor/stnk/' . $old_image_foto_stnk_motor);
                    //mengganti nama foto yang ada di database
                    $new_image_stnk_motor = $this->upload->data('file_name');
                    //mencari berdasarkan id inventaris motor
                    $idinventarismotor =  $this->input->post('id_inventaris_motor');
                    $this->db->set('foto_stnk_motor', $new_image_stnk_motor);
                    $this->db->where('id_inventaris_motor', $idinventarismotor);
                    $this->db->update('inventaris_motor');
                    //end Upload Foto STNK Motor


                    $this->motor->editInventarismotor();
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Inventaris Motor</div>');
                    //redirect ke halaman data inventaris motor
                    redirect('inventaris/inventarismotor');
                }
                //Jika Foto STNK Dan Motor Tidak di EDIT
                else {
                    $this->motor->editInventarismotor();
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Inventaris Motor</div>');
                    //redirect ke halaman data inventaris motor
                    redirect('inventaris/inventarismotor');
                }
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Method Hapus Data Inventaris Motor
    public function hapusinventarismotor($id_inventaris_motor)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            $data['lihat'] = $this->motor->getdataInventarismotorByID($id_inventaris_motor);

            //unlink foto lama
            $old_image_foto_motor = $data['lihat']['foto_motor'];
            unlink(FCPATH . 'assets/img/inventaris/motor/motor/' . $old_image_foto_motor);
            $old_image_foto_stnk_motor = $data['lihat']['foto_stnk_motor'];
            unlink(FCPATH . 'assets/img/inventaris/motor/stnk/' . $old_image_foto_stnk_motor);

            //mendelete kedalam database melalui method pada model motor berdasarkan id nya
            $this->motor->hapusInventarismotor($id_inventaris_motor);
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Inventaris Motor</div>');
            //dan mendirect kehalaman perusahaan
            redirect('inventaris/inventarismotor');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman lihat data inventaris motor
    public function lihatinventarismotor($id_inventaris_motor)
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Lihat Data Inventaris Motor';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data inventaris motor, dari model, dengan di join dengan data karyawan dan penempatan
        $data['lihat'] = $this->motor->getdataInventarismotorByID($id_inventaris_motor);
        $datatanggal = $this->motor->getdataInventarismotorByID($id_inventaris_motor);
        $data['tanggal_akhir_pajak_motor']                = date('d-m-Y', strtotime($datatanggal['tanggal_akhir_pajak_motor']));
        $data['tanggal_akhir_plat_motor']                 = date('d-m-Y', strtotime($datatanggal['tanggal_akhir_plat_motor']));
        $data['tanggal_penyerahan_motor']                 = date('d-m-Y', strtotime($datatanggal['tanggal_penyerahan_motor']));
        //menampilkan halaman data inventaris motor
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inventaris_motor/lihat_inventaris_motor', $data);
        $this->load->view('templates/footer');
    }

    //Menampilkan halaman awal data inventaris mobil
    public function inventarismobil()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Data Inventaris Mobil';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data inventaris mobil, dari model, dengan di join dengan data karyawan dan penempatan
        $data['mobil'] = $this->mobil->dataInventarismobil();

        //menampilkan halaman data inventaris mobil
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inventaris_mobil/data_inventaris_mobil', $data);
        $this->load->view('templates/footer');
    }

    //Method Tambah Data Inventaris Mobil
    public function tambahinventarismobil()
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Tambah Inventaris Mobil';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
            //Mengambil data inventaris mobil, dari model, dengan di join dengan data karyawan dan penempatan
            $data['mobil'] = $this->mobil->dataInventarismobil();

            //Validation Form Input
            $this->form_validation->set_rules('nik_karyawan', 'NIK Karyawan', 'required|is_unique[inventaris_mobil.karyawan_id]|min_length[16]');
            $this->form_validation->set_rules('merk_mobil', 'Merk Mobil', 'required');
            $this->form_validation->set_rules('type_mobil', 'Type Mobil', 'required');
            $this->form_validation->set_rules('nomor_polisi', 'Nomor Polisi', 'required');
            $this->form_validation->set_rules('warna_mobil', 'Warna Mobil', 'required');
            $this->form_validation->set_rules('nomor_rangka_mobil', 'Nomor Rangka Mobil', 'required');
            $this->form_validation->set_rules('nomor_mesin_mobil', 'Nomor Mesin Mobil', 'required');
            $this->form_validation->set_rules('tahun_pembuatan_mobil', 'Tahun Pembuatan Mobil', 'required');
            $this->form_validation->set_rules('tanggal_akhir_pajak_mobil', 'Tanggal Akhir Pajak Mobil', 'required');
            $this->form_validation->set_rules('tanggal_akhir_plat_mobil', 'Tanggal Akhir Plat Mobil', 'required');
            $this->form_validation->set_rules('tanggal_penyerahan_mobil', 'Tanggal Penyerahan Mobil', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman data inventaris mobil
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('inventaris_mobil/tambah_inventaris_mobil', $data);
                $this->load->view('templates/footer');
            }
            //Jika semua form input benar 
            else {

                $upload_foto_stnk_mobil     = $_FILES['foto_stnk_mobil']['name'];
                $upload_foto_mobil          = $_FILES['foto_mobil']['name'];

                //Jika Foto STNK Mobil Dan Foto Mobil Tidak Kosong
                if (!empty($upload_foto_stnk_mobil) && !empty($upload_foto_mobil)) {

                    //Upload Foto Laptop 
                    //file yang diperbolehkan hanya png dan jpg
                    $config['allowed_types'] = 'jpg|png';
                    //max file 500 kb
                    $config['max_size'] = '500';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/img/inventaris/mobil/stnk/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload foto
                    $this->upload->do_upload('foto_stnk_mobil');
                    $stnk_mobil = $this->upload->data('file_name');

                    //Upload Foto Laptop 
                    //file yang diperbolehkan hanya png dan jpg
                    $config['allowed_types'] = 'jpg|png';
                    //max file 500 kb
                    $config['max_size'] = '500';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/img/inventaris/mobil/mobil/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload foto
                    $this->upload->do_upload('foto_mobil');
                    $mobil = $this->upload->data('file_name');

                    //Jika File Melebihi dari 500 Kb
                    if (!$this->upload->do_upload('foto_stnk_mobil') && !$this->upload->do_upload('foto_mobil')) {
                        //Menampilkan pesan berhasil
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Periksa kembali file upload anda..! ( Maksimal File 500 Kb Dan Format File jpg dan png )</div>');
                        redirect('inventaris/inventarismobil');
                    } else {

                        $data = [
                            "karyawan_id"                   => $this->input->post('nik_karyawan', true),
                            "merk_mobil"                    => $this->input->post('merk_mobil', true),
                            "type_mobil"                    => $this->input->post('type_mobil', true),
                            "nomor_polisi"                  => $this->input->post('nomor_polisi', true),
                            "warna_mobil"                   => $this->input->post('warna_mobil', true),
                            "nomor_rangka_mobil"            => $this->input->post('nomor_rangka_mobil', true),
                            "nomor_mesin_mobil"             => $this->input->post('nomor_mesin_mobil', true),
                            "tahun_pembuatan_mobil"         => $this->input->post('tahun_pembuatan_mobil', true),
                            "tanggal_akhir_pajak_mobil"     => $this->input->post('tanggal_akhir_pajak_mobil', true),
                            "tanggal_akhir_plat_mobil"      => $this->input->post('tanggal_akhir_plat_mobil', true),
                            "tanggal_penyerahan_mobil"      => $this->input->post('tanggal_penyerahan_mobil', true),
                            "foto_stnk_mobil"               => $stnk_mobil,
                            "foto_mobil"                    => $mobil
                        ];

                        $this->db->insert('inventaris_mobil', $data);

                        //Menampilkan pesan berhasil
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Tambah Data Inventaris Mobil</div>');
                        //redirect ke halaman data inventaris mobil
                        redirect('inventaris/inventarismobil');
                        //
                    }
                }
                //Jika Foto STNK Mobil Dan Foto Mobil Tidak Kosong
                else {
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Periksa kembali file anda..! ( File Foto Tidak Boleh Kosong )</div>');
                    redirect('inventaris/inventarismobil');
                }
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman edit data inventaris mobil
    public function editinventarismobil($id_inventaris_mobil)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
            $data['title'] = 'Edit Data Inventaris Mobil';
            //Menyimpan session dari login
            $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

            //Mengambil data inventaris mobil, dari model, dengan di join dengan data karyawan dan penempatan
            $data['lihat'] = $this->mobil->getdataInventarismobilByID($id_inventaris_mobil);

            //Validation Form EDIT
            $this->form_validation->set_rules('nik_karyawan', 'NIK Karyawan', 'required');
            $this->form_validation->set_rules('merk_mobil', 'Merk Mobil', 'required');
            $this->form_validation->set_rules('type_mobil', 'Type Mobil', 'required');
            $this->form_validation->set_rules('nomor_polisi', 'Nomor Polisi', 'required');
            $this->form_validation->set_rules('warna_mobil', 'Warna Mobil', 'required');
            $this->form_validation->set_rules('nomor_rangka_mobil', 'Nomor Rangka Mobil', 'required');
            $this->form_validation->set_rules('nomor_mesin_mobil', 'Nomor Mesin Mobil', 'required');
            $this->form_validation->set_rules('tahun_pembuatan_mobil', 'Tahun Pembuatan Mobil', 'required');
            $this->form_validation->set_rules('tanggal_akhir_pajak_mobil', 'Tanggal Akhir Pajak Mobil', 'required');
            $this->form_validation->set_rules('tanggal_akhir_plat_mobil', 'Tanggal Akhir Plat Mobil', 'required');
            $this->form_validation->set_rules('tanggal_penyerahan_mobil', 'Tanggal Penyerahan Mobil', 'required');

            //Jika form input ada yang salah
            if ($this->form_validation->run() == false) {
                //menampilkan halaman data inventaris mobil
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('inventaris_mobil/edit_inventaris_mobil', $data);
                $this->load->view('templates/footer');
            } else {

                $upload_foto_stnk_mobil = $_FILES['foto_stnk_mobil']['name'];
                $upload_foto_mobil = $_FILES['foto_mobil']['name'];

                //Jika Foto STNK Dan Mobil Di EDIT
                if (!empty($upload_foto_stnk_mobil) && !empty($upload_foto_mobil)) {

                    //Upload Foto STNK Mobil 
                    //file yang diperbolehkan hanya png dan jpg
                    $config['allowed_types'] = 'jpg|png';
                    //max file 1 mb
                    $config['max_size'] = '500';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/img/inventaris/mobil/stnk/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload foto
                    $this->upload->do_upload('foto_stnk_mobil');
                    //unlink foto lama
                    $old_image_foto_stnk_mobil = $data['lihat']['foto_stnk_mobil'];
                    unlink(FCPATH . 'assets/img/inventaris/mobil/stnk/' . $old_image_foto_stnk_mobil);
                    //mengganti nama foto yang ada di database
                    $new_image_stnk_mobil = $this->upload->data('file_name');
                    //mencari berdasarkan id inventaris mobil
                    $idinventarismobil =  $this->input->post('id_inventaris_mobil');
                    $this->db->set('foto_stnk_mobil', $new_image_stnk_mobil);
                    $this->db->where('id_inventaris_mobil', $idinventarismobil);
                    $this->db->update('inventaris_mobil');
                    //end Upload Foto STNK Mobil


                    //Upload Foto Mobil 
                    //file yang diperbolehkan hanya png dan jpg
                    $config['allowed_types'] = 'jpg|png';
                    //max file 1 mb
                    $config['max_size'] = '500';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/img/inventaris/mobil/mobil/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload foto
                    $this->upload->do_upload('foto_mobil');
                    //unlink foto lama
                    $old_image_foto_mobil = $data['lihat']['foto_mobil'];
                    unlink(FCPATH . 'assets/img/inventaris/mobil/mobil/' . $old_image_foto_mobil);
                    //mengganti nama foto yang ada di database
                    $new_image_mobil = $this->upload->data('file_name');
                    //mencari berdasarkan id inventaris mobil
                    $idinventarismobil =  $this->input->post('id_inventaris_mobil');
                    $this->db->set('foto_mobil', $new_image_mobil);
                    $this->db->where('id_inventaris_mobil', $idinventarismobil);
                    $this->db->update('inventaris_mobil');
                    //end Upload Foto Mobil


                    $this->mobil->editInventarismobil();
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Inventaris Mobil</div>');
                    //redirect ke halaman data inventaris mobil
                    redirect('inventaris/inventarismobil');
                }
                //Jika Foto STNK Tidak Di EDI
                elseif (empty($upload_foto_stnk_mobil) && !empty($upload_foto_mobil)) {

                    //Upload Foto Mobil 
                    //file yang diperbolehkan hanya png dan jpg
                    $config['allowed_types'] = 'jpg|png';
                    //max file 1 mb
                    $config['max_size'] = '500';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/img/inventaris/mobil/mobil/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload foto
                    $this->upload->do_upload('foto_mobil');
                    //unlink foto lama
                    $old_image_foto_mobil = $data['lihat']['foto_mobil'];
                    unlink(FCPATH . 'assets/img/inventaris/mobil/mobil/' . $old_image_foto_mobil);
                    //mengganti nama foto yang ada di database
                    $new_image_mobil = $this->upload->data('file_name');
                    //mencari berdasarkan id inventaris mobil
                    $idinventarismobil =  $this->input->post('id_inventaris_mobil');
                    $this->db->set('foto_mobil', $new_image_mobil);
                    $this->db->where('id_inventaris_mobil', $idinventarismobil);
                    $this->db->update('inventaris_mobil');
                    //end Upload Foto Mobil


                    $this->mobil->editInventarismobil();
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Inventaris Mobil</div>');
                    //redirect ke halaman data inventaris mobil
                    redirect('inventaris/inventarismobil');
                }
                //Jika Foto Mobil Tidak Di EDIT
                elseif (!empty($upload_foto_stnk_mobil) && empty($upload_foto_mobil)) {

                    //Upload Foto STNK Mobil 
                    //file yang diperbolehkan hanya png dan jpg
                    $config['allowed_types'] = 'jpg|png';
                    //max file 1 mb
                    $config['max_size'] = '500';
                    //lokasi penyimpanan file
                    $config['upload_path'] = './assets/img/inventaris/mobil/stnk/';
                    //memanggil library upload
                    $this->load->library('upload', $config);
                    //membedakan nama file jika ada yang sama
                    $this->upload->initialize($config);
                    //melakukan upload foto
                    $this->upload->do_upload('foto_stnk_mobil');
                    //unlink foto lama
                    $old_image_foto_stnk_mobil = $data['lihat']['foto_stnk_mobil'];
                    unlink(FCPATH . 'assets/img/inventaris/mobil/stnk/' . $old_image_foto_stnk_mobil);
                    //mengganti nama foto yang ada di database
                    $new_image_stnk_mobil = $this->upload->data('file_name');
                    //mencari berdasarkan id inventaris mobil
                    $idinventarismobil =  $this->input->post('id_inventaris_mobil');
                    $this->db->set('foto_stnk_mobil', $new_image_stnk_mobil);
                    $this->db->where('id_inventaris_mobil', $idinventarismobil);
                    $this->db->update('inventaris_mobil');
                    //end Upload Foto STNK Mobil


                    $this->mobil->editInventarismobil();
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Inventaris Mobil</div>');
                    //redirect ke halaman data inventaris mobil
                    redirect('inventaris/inventarismobil');
                }
                //Jika Foto STNK Dan Mobil Tidak Di EDIT
                else {
                    $this->mobil->editInventarismobil();
                    //Menampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Inventaris Mobil</div>');
                    //redirect ke halaman data inventaris mobil
                    redirect('inventaris/inventarismobil');
                }
            }
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Method Hapus Data Inventaris Mobil
    public function hapusinventarismobil($id_inventaris_mobil)
    {
        //Mengambil Session
        $role_id = $this->session->userdata("role_id");
        //Jika yang login HRD
        if ($role_id == 1 || $role_id == 11) {

            $data['lihat'] = $this->mobil->getdataInventarismobilByID($id_inventaris_mobil);

            //unlink foto lama
            $old_image_foto_mobil = $data['lihat']['foto_mobil'];
            unlink(FCPATH . 'assets/img/inventaris/mobil/mobil/' . $old_image_foto_mobil);
            $old_image_foto_stnk_mobil = $data['lihat']['foto_stnk_mobil'];
            unlink(FCPATH . 'assets/img/inventaris/mobil/stnk/' . $old_image_foto_stnk_mobil);

            //mendelete kedalam database melalui method pada model mobil berdasarkan id nya
            $this->mobil->hapusInventarismobil($id_inventaris_mobil);
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Inventaris Mobil</div>');
            //dan mendirect kehalaman perusahaan
            redirect('inventaris/inventarismobil');
        }
        //Jika Yang Login Bukan HRD
        else {
            $this->load->view('auth/blocked');
        }
    }

    //Menampilkan halaman lihat data inventaris mobil
    public function lihatinventarismobil($id_inventaris_mobil)
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Lihat Data Inventaris Mobil';
        //Menyimpan session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Mengambil data inventaris mobil, dari model, dengan di join dengan data karyawan dan penempatan
        $data['lihat'] = $this->mobil->getdataInventarismobilByID($id_inventaris_mobil);
        $datatanggal = $this->mobil->getdataInventarismobilByID($id_inventaris_mobil);
        $data['tanggal_akhir_pajak_mobil']                 = date('d-m-Y', strtotime($datatanggal['tanggal_akhir_pajak_mobil']));
        $data['tanggal_akhir_plat_mobil']                 = date('d-m-Y', strtotime($datatanggal['tanggal_akhir_plat_mobil']));
        $data['tanggal_penyerahan_mobil']                 = date('d-m-Y', strtotime($datatanggal['tanggal_penyerahan_mobil']));
        //menampilkan halaman data inventaris mobil
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('inventaris_mobil/lihat_inventaris_mobil', $data);
        $this->load->view('templates/footer');
    }
}
