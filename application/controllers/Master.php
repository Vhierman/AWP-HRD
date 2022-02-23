<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
    //Memanggil Menu_model dan validation agar dapat dipanggil oleh semua method
    public function __construct()
    {
        parent::__construct();
        //memanggil model penempatan
        $this->load->model('master/Penempatan_model', 'penempatan');
        //memanggil model jabatan
        $this->load->model('master/Jabatan_model', 'jabatan');
        //memanggil model perusahaan
        $this->load->model('master/Perusahaan_model', 'perusahaan');
        //memanggil model jam lembur
        $this->load->model('master/Jamlembur_model', 'jamlembur');
        //memanggil model keterangan lembur
        $this->load->model('master/Keteranganlembur_model', 'keteranganlembur');
        //Memanggil Model Role_model dengan memberikan nama role
        $this->load->model('Role_model', 'role');
        //memanggil model jamkerja
        $this->load->model('master/Jamkerja_model', 'jamkerja');
        //memanggil model users
        $this->load->model('master/Users_model', 'users');
        //memanggil model iuran bpjs kesehatan
        $this->load->model('master/Bpjsks_model', 'bpjskesehatan');
        //memanggil model iuran bpjs ketenagakerjaan
        $this->load->model('master/Bpjstk_model', 'bpjsketenagakerjaan');

        //library validation
        $this->load->library('form_validation');
        //untuk mengecek, dia sudah login apa belum, dan dia rolenya apa..?
        is_logged_in();
    }

    public function role()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Role';
        //Mengambil session dari login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Menampilkan semua data role
        $data['role'] = $this->role->getRole();
        //validation form role
        $this->form_validation->set_rules('role', 'Role', 'required');

        //Jika validation gagal
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/role', $data);
            $this->load->view('templates/footer');
        }
        //Jika Berhasil
        else {
            $this->role->tambahRole();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Add New Role</div>');
            redirect('master/role');
        }
    }

    //Method Edit Role
    public function edit_role($id)
    {
        $data['title'] = 'Role';
        //Mengambil session
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Mengambil data role ID berdasarkan id nya
        $data['role'] = $this->role->getRoleByID($id);
        //Validation form
        $this->form_validation->set_rules('role', 'Nama Role Harus Diisi', 'required');

        //Jika validation salah
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/edit_role', $data);
            $this->load->view('templates/footer');
        }
        //Jika validation benar 
        else {
            $this->role->editRole();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Role</div>');
            redirect('master/role');
        }
    }

    //Method Hapus Role
    public function hapus_role($id)
    {
        $this->role->hapusRole($id);
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Role</div>');
        redirect('master/role');
    }

    //Role Access
    public function roleaccess($role_id)
    {
        $data['title'] = 'Role Access';
        //session
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //mendapatkan semua data role id
        $data['role'] = $this->role->getRoleId($role_id);

        $this->db->where('id !=', 1);
        //mendapatkan semua data menu
        $data['menu'] = $this->role->getMenu();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/access_role', $data);
        $this->load->view('templates/footer');
    }

    //Method Change Access Role
    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');
        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];
        $result = $this->db->get_where('user_access_menu', $data);
        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed</div>');
    }

    //Menampilkan halaman awal menu penempatan
    public function penempatan()
    {
        //Data untuk judul halaman dan Title
        $data['title'] = 'Data Penempatan';
        //memanggil data session yang sudah diipnutkan pada saat login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memangil semua data penempatan yang sudah diload di model
        $data['penempatan'] = $this->penempatan->getAllPenempatan();
        //validasi form penempatan
        $this->form_validation->set_rules('penempatan', 'Penempatan', 'required');

        //jika validasinya salah akan menampilkan halaman penempatan
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/data_penempatan', $data);
            $this->load->view('templates/footer');
        }
        //jika validasinya benar
        else {
            //menyimpan kedalam database melalui method pada model penempatan
            $this->penempatan->tambahPenempatan();
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Add New Penempatan</div>');
            //dan mendirect kehalaman penempatan
            redirect('master/penempatan');
        }
    }

    //Method Edit Penempatan
    public function editpenempatan($id)
    {
        //Data untuk judul halaman dan Title
        $data['title'] = 'Edit Data Penempatan';
        //memanggil data session yang sudah diipnutkan pada saat login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memangil semua data penempatan yang sudah diload di model berdasarkan id nya
        $data['penempatan'] = $this->penempatan->getPenempatanByID($id);
        //validasi form penempatan
        $this->form_validation->set_rules('penempatan', 'Nama Penempatan Harus Diisi', 'required');

        //jika validasinya salah akan menampilkan halaman penempatan
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/edit_penempatan', $data);
            $this->load->view('templates/footer');
        }
        //jika validasinya benar
        else {
            //mengupdate kedalam database melalui method pada model penempatan
            $this->penempatan->editPenempatan();
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Penempatan</div>');
            //dan mendirect kehalaman penempatan
            redirect('master/penempatan');
        }
    }

    //Method Hapus Penempatan
    public function hapuspenempatan($id)
    {
        //mendelete kedalam database melalui method pada model penempatan berdasarkan id nya
        $this->penempatan->hapusPenempatan($id);
        //menampikan pesan sukses
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Penempatan</div>');
        //dan mendirect kehalaman penempatan
        redirect('master/penempatan');
    }

    //METHOD tambah jabatan
    public function jabatan()
    {
        //Data untuk judul halaman dan Title
        $data['title'] = 'Data Jabatan';
        //memanggil data session yang sudah diipnutkan pada saat login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memangil semua data jabatan yang sudah diload di model
        $data['jabatan'] = $this->jabatan->getAllJabatan();
        //validasi form jabatan
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');

        //jika validasinya salah akan menampilkan halaman jabatan
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/data_jabatan', $data);
            $this->load->view('templates/footer');
        }
        //jika validasinya benar
        else {
            //menyimpan kedalam database melalui method pada model jabatan
            $this->jabatan->tambahJabatan();
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Add New Jabatan</div>');
            //dan mendirect kehalaman jabatan
            redirect('master/jabatan');
        }
    }

    //Method Edit Jabatan
    public function editjabatan($id)
    {
        //Data untuk judul halaman dan Title
        $data['title'] = 'Edit Data Jabatan';
        //memanggil data session yang sudah diipnutkan pada saat login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memangil semua data jabatan yang sudah diload di model berdasarkan id nya
        $data['jabatan'] = $this->jabatan->getJabatanByID($id);
        //validasi form jabatan
        $this->form_validation->set_rules('jabatan', 'Nama Jabatan Harus Diisi', 'required');

        //jika validasinya salah akan menampilkan halaman jabatan
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/edit_jabatan', $data);
            $this->load->view('templates/footer');
        }
        //jika validasinya benar
        else {
            //mengupdate kedalam database melalui method pada model jabatan
            $this->jabatan->editJabatan();
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Jabatan</div>');
            //dan mendirect kehalaman jabatan
            redirect('master/jabatan');
        }
    }

    //Method Hapus Jabatan
    public function hapusjabatan($id)
    {
        //mendelete kedalam database melalui method pada model jabatan berdasarkan id nya
        $this->jabatan->hapusJabatan($id);
        //menampikan pesan sukses
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Jabatan</div>');
        //dan mendirect kehalaman jabatan
        redirect('master/jabatan');
    }

    //METHOD PERUSAHAAN

    //view dan tambah perusahaan
    public function perusahaan()
    {
        //Data untuk judul halaman dan Title
        $data['title'] = 'Data Perusahaan';
        //memanggil data session yang sudah diipnutkan pada saat login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memangil semua data perusahaan yang sudah diload di model
        $data['perusahaan'] = $this->perusahaan->getAllPerusahaan();
        //validasi form perusahaan
        $this->form_validation->set_rules('perusahaan', 'Perusahaan', 'required');

        //jika validasinya salah akan menampilkan halaman perusahaan
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/data_perusahaan', $data);
            $this->load->view('templates/footer');
        }
        //jika validasinya benar
        else {
            //menyimpan kedalam database melalui method pada model perusahaan
            $this->perusahaan->tambahPerusahaan();
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Add New Perusahaan</div>');
            //dan mendirect kehalaman perusahaan
            redirect('master/perusahaan');
        }
    }

    //Method Edit Perusahaan
    public function editperusahaan($id)
    {
        //Data untuk judul halaman dan Title
        $data['title'] = 'Edit Data Perusahaan';
        //memanggil data session yang sudah diinputkan pada saat login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memangil semua data perusahaan yang sudah diload di model berdasarkan id nya
        $data['perusahaan'] = $this->perusahaan->getPerusahaanByID($id);
        //validasi form perusahaan
        $this->form_validation->set_rules('perusahaan', 'Nama Perusahaan Harus Diisi', 'required');

        //jika validasinya salah akan menampilkan halaman perusahaan
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/edit_perusahaan', $data);
            $this->load->view('templates/footer');
        }
        //jika validasinya benar
        else {
            //mengupdate kedalam database melalui method pada model perusahaan
            $this->perusahaan->editPerusahaan();
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Perusahaan</div>');
            //dan mendirect kehalaman perusahaan
            redirect('master/perusahaan');
        }
    }

    //Method Hapus Perusahaan
    public function hapusperusahaan($id)
    {
        //mendelete kedalam database melalui method pada model perusahaan berdasarkan id nya
        $this->perusahaan->hapusPerusahaan($id);
        //menampikan pesan sukses
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Perusahaan</div>');
        //dan mendirect kehalaman perusahaan
        redirect('master/perusahaan');
    }

    //view dan tambah data jam lembur
    public function jamlembur()
    {
        //Data untuk judul halaman dan Title
        $data['title'] = 'Data Jam Lembur';
        //memanggil data session yang sudah diipnutkan pada saat login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memangil semua data jam lembur yang sudah diload di model
        $data['jamlembur'] = $this->jamlembur->getAllJamlembur();

        //validasi form jam lembur
        $this->form_validation->set_rules('jam_masuk', 'Jam Masuk', 'trim|numeric|required');
        $this->form_validation->set_rules('jam_istirahat', 'Jam Istirahat', 'trim|numeric|required');
        $this->form_validation->set_rules('jam_pulang', 'Jam Pulang', 'trim|numeric|required');

        //jika validasinya salah akan menampilkan halaman jamlembur
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/data_jamlembur', $data);
            $this->load->view('templates/footer');
        }
        //jika validasinya benar
        else {
            //menyimpan kedalam database melalui method pada model jam lembur
            $this->jamlembur->tambahJamlembur();
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Add Jam Lembur</div>');
            //dan mendirect kehalaman jam lembur
            redirect('master/jamlembur');
        }
    }

    //Method Edit Jam Lembur
    public function editjamlembur($id_jam_lembur)
    {
        //Data untuk judul halaman dan Title
        $data['title'] = 'Edit Jam Lembur';
        //memanggil data session yang sudah diinputkan pada saat login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memangil semua data jam lembur yang sudah diload di model berdasarkan id nya
        $data['jamlembur'] = $this->jamlembur->getJamLemburByID($id_jam_lembur);

        //validasi form jam lembur
        $this->form_validation->set_rules('jam_masuk', 'Jam Masuk', 'trim|numeric|required');
        $this->form_validation->set_rules('jam_istirahat', 'Jam Istirahat', 'trim|numeric|required');
        $this->form_validation->set_rules('jam_pulang', 'Jam Pulang', 'trim|numeric|required');

        //jika validasinya salah akan menampilkan halaman jam lembur
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/edit_jamlembur', $data);
            $this->load->view('templates/footer');
        }
        //jika validasinya benar
        else {
            //mengupdate kedalam database melalui method pada model jam lembur
            $this->jamlembur->editJamLembur();
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Jam Lembur</div>');
            //dan mendirect kehalaman jamlembur
            redirect('master/jamlembur');
        }
    }

    //Method Hapus Jam Lembur
    public function hapusjamlembur($id_jam_lembur)
    {
        //mendelete kedalam database melalui method pada model jamlembur berdasarkan id nya
        $this->jamlembur->hapusJamLembur($id_jam_lembur);
        //menampikan pesan sukses
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Jam Lembur</div>');
        //dan mendirect kehalaman jamlembur
        redirect('master/jamlembur');
    }

    //view dan tambah data keterangan lembur
    public function keteranganlembur()
    {
        //Data untuk judul halaman dan Title
        $data['title'] = 'Data Keterangan Lembur';
        //memanggil data session yang sudah diipnutkan pada saat login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memangil semua data keterangan lembur yang sudah diload di model
        $data['keteranganlembur'] = $this->keteranganlembur->getAllKeteranganlembur();

        //validasi form keterangan lembur
        $this->form_validation->set_rules('keterangan_lembur', 'Keterangan Lembur', 'required');

        //jika validasinya salah akan menampilkan halaman keteranganlembur
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/data_keteranganlembur', $data);
            $this->load->view('templates/footer');
        }
        //jika validasinya benar
        else {
            //menyimpan kedalam database melalui method pada model keterangan lembur
            $this->keteranganlembur->tambahKeteranganlembur();
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Add Keterangan Lembur</div>');
            //dan mendirect kehalaman keterangan lembur
            redirect('master/keteranganlembur');
        }
    }

    //Method Edit Keterangan Lembur
    public function editketeranganlembur($id_keterangan_lembur)
    {
        //Data untuk judul halaman dan Title
        $data['title'] = 'Edit Keterangan Lembur';
        //memanggil data session yang sudah diinputkan pada saat login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memangil semua data keterangan lembur yang sudah diload di model berdasarkan id nya
        $data['keteranganlembur'] = $this->keteranganlembur->getKeteranganLemburByID($id_keterangan_lembur);

        //validasi form keterangan lembur
        $this->form_validation->set_rules('keterangan_lembur', 'Keterangan Lembur', 'required');

        //jika validasinya salah akan menampilkan halaman keterangan lembur
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/edit_keteranganlembur', $data);
            $this->load->view('templates/footer');
        }
        //jika validasinya benar
        else {
            //mengupdate kedalam database melalui method pada model keterangan lembur
            $this->keteranganlembur->editKeteranganLembur();
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Keterangan Lembur</div>');
            //dan mendirect kehalaman keteranganlembur
            redirect('master/keteranganlembur');
        }
    }

    //Method Hapus Keterangan Lembur
    public function hapusketeranganlembur($id_keterangan_lembur)
    {
        //mendelete kedalam database melalui method pada model keteranganlembur berdasarkan id nya
        $this->keteranganlembur->hapusKeteranganLembur($id_keterangan_lembur);
        //menampikan pesan sukses
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Keterangan Lembur</div>');
        //dan mendirect kehalaman keteranganlembur
        redirect('master/keteranganlembur');
    }

    //view dan tambah data jam kerja
    public function jamkerja()
    {
        //Data untuk judul halaman dan Title
        $data['title'] = 'Data Jam Kerja';
        //memanggil data session yang sudah diipnutkan pada saat login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memangil semua data jam kerja yang sudah diload di model
        $data['jamkerja'] = $this->jamkerja->getAllJamkerja();

        //validasi form jam kerja
        $this->form_validation->set_rules('jam_masuk', 'Jam Masuk', 'required');
        $this->form_validation->set_rules('jam_pulang', 'Jam Pulang', 'required');

        //jika validasinya salah akan menampilkan halaman jam kerja
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/data_jam_kerja', $data);
            $this->load->view('templates/footer');
        }
        //jika validasinya benar
        else {
            //menyimpan kedalam database melalui method pada model jam kerja
            $this->jamkerja->tambahJamkerja();
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Add Jam Kerja</div>');
            //dan mendirect kehalaman jam kerja
            redirect('master/jamkerja');
        }
    }

    //Method Edit Jam Kerja
    public function editjamkerja($id_jam_kerja)
    {
        //Data untuk judul halaman dan Title
        $data['title'] = 'Edit Jam Kerja';
        //memanggil data session yang sudah diinputkan pada saat login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memangil semua data jam kerja yang sudah diload di model berdasarkan id nya
        $data['jamkerja'] = $this->jamkerja->getJamkerjaByID($id_jam_kerja);

        //validasi form jam kerja
        $this->form_validation->set_rules('jam_masuk', 'Jam Masuk', 'required');
        $this->form_validation->set_rules('jam_pulang', 'Jam Pulang', 'required');

        //jika validasinya salah akan menampilkan halaman jam kerja
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/edit_jam_kerja', $data);
            $this->load->view('templates/footer');
        }
        //jika validasinya benar
        else {
            //mengupdate kedalam database melalui method pada model jam kerja
            $this->jamkerja->editJamkerja();
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Jam Kerja</div>');
            //dan mendirect kehalaman jam kerja
            redirect('master/jamkerja');
        }
    }

    //Method Hapus Jam Kerja
    public function hapusjamkerja($id_jam_kerja)
    {
        //mendelete kedalam database melalui method pada model jamkerja berdasarkan id nya
        $this->jamkerja->hapusJamkerja($id_jam_kerja);
        //menampikan pesan sukses
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Jam Kerja</div>');
        //dan mendirect kehalaman jamkerja
        redirect('master/jamkerja');
    }

    //Method Users
    public function users()
    {
        //Data untuk judul halaman dan Title
        $data['title'] = 'Data Users';
        //memanggil data session yang sudah diipnutkan pada saat login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memangil semua data users yang sudah diload di model
        $data['users'] = $this->users->getAllUsers();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/data_users', $data);
        $this->load->view('templates/footer');
    }

    //Method Edit Users
    public function editusers($id)
    {
        //Data untuk judul halaman dan Title
        $data['title'] = 'Data Users';
        //memanggil data session yang sudah diipnutkan pada saat login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //Memangil semua data users yang sudah diload di model
        $data['role'] = $this->users->getAllRole();
        $data['users'] = $this->users->getUsersByID($id);

        $this->form_validation->set_rules('name', 'Nama Karyawan', 'required|trim');
        $this->form_validation->set_rules('email', 'Alamat Email', 'valid_email|trim|is_unique[karyawan.email_karyawan]');
        $this->form_validation->set_rules('role_id', 'Role', 'required|trim');

        //jika validasinya salah akan menampilkan halaman users
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/edit_users', $data);
            $this->load->view('templates/footer');
        }
        //jika validasinya benar
        else {
            //mengupdate kedalam database melalui method pada model users
            $this->users->editUsers();
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data Users</div>');
            //dan mendirect kehalaman users
            redirect('master/users');
        }
    }

    //Method Hapus Users
    public function hapususers($id)
    {
        //mendelete kedalam database melalui method pada model users berdasarkan id nya
        $this->users->hapusUsers($id);
        //menampikan pesan sukses
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Data Users</div>');
        //dan mendirect kehalaman users
        redirect('master/users');
    }

    //Method Iuran BPJS Kesehatan
    public function bpjskesehatan()
    {
        //Data untuk judul halaman dan Title
        $data['title'] = 'Iuran BPJS Kesehatan';
        //memanggil data session yang sudah diipnutkan pada saat login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memangil semua data bpjskesehatan yang sudah diload di model
        $data['bpjskesehatan'] = $this->bpjskesehatan->getAllBPJSKS();

        //Memanggil View
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/data_iuran_bpjs_kesehatan', $data);
        $this->load->view('templates/footer');
    }

    //Method Edit Iuran BPJS Kesehatan
    public function editbpjskesehatan($id_potongan_bpjs_kesehatan)
    {
        //Data untuk judul halaman dan Title
        $data['title'] = 'Edit Iuran BPJS Kesehatan';
        //memanggil data session yang sudah diipnutkan pada saat login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memangil semua data bpjskesehatan yang sudah diload di model
        $data['bpjskesehatan'] = $this->bpjskesehatan->getBPJSKSByID($id_potongan_bpjs_kesehatan);

        $this->form_validation->set_rules('potongan_bpjs_kesehatan_karyawan', 'Beban Karyawan', 'required|trim');
        $this->form_validation->set_rules('potongan_bpjs_kesehatan_perusahaan', 'Beban Perusahaan', 'required|trim');
        $this->form_validation->set_rules('maksimal_iuran_bpjs_kesehatan', 'Maksimal Iuran', 'required|trim');

        //jika validasinya salah akan menampilkan halaman bpjs kesehatan
        if ($this->form_validation->run() == FALSE) {
            //Memanggil View Edit
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/edit_iuran_bpjs_kesehatan', $data);
            $this->load->view('templates/footer');
        }
        //jika validasinya benar
        else {
            //mengupdate kedalam database melalui method pada model BPJS Kesehatan
            $this->bpjskesehatan->editBPJSKS();
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data BPJS Kesehatan</div>');
            //dan mendirect kehalaman bpjs kesehatan
            redirect('master/bpjskesehatan');
        }
    }

    //Method Iuran BPJS Ketenagakerjaan
    public function bpjsketenagakerjaan()
    {
        //Data untuk judul halaman dan Title
        $data['title'] = 'Iuran BPJS Ketenagakerjaan';
        //memanggil data session yang sudah diipnutkan pada saat login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memangil semua data bpjs Ketenagakerjaan yang sudah diload di model
        $data['bpjsketenagakerjaan'] = $this->bpjsketenagakerjaan->getAllBPJSTK();

        //Memanggil View
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/data_iuran_bpjs_ketenagakerjaan', $data);
        $this->load->view('templates/footer');
    }

    //Method Edit Iuran BPJS Ketenagakerjaan
    public function editbpjsketenagakerjaan($id_potongan_bpjs_ketenagakerjaan)
    {
        //Data untuk judul halaman dan Title
        $data['title'] = 'Edit Iuran BPJS Kesehatan';
        //memanggil data session yang sudah diipnutkan pada saat login
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memangil semua data BPJS Ketenagakerjaan yang sudah diload di model
        $data['bpjsketenagakerjaan'] = $this->bpjsketenagakerjaan->getBPJSTKByID($id_potongan_bpjs_ketenagakerjaan);

        $this->form_validation->set_rules('potongan_jht_karyawan', 'JHT Beban Karyawan', 'required|trim');
        $this->form_validation->set_rules('potongan_jht_perusahaan', 'JHT Beban Perusahaan', 'required|trim');
        $this->form_validation->set_rules('potongan_jp_karyawan', 'JP Beban Karyawan', 'required|trim');
        $this->form_validation->set_rules('potongan_jp_perusahaan', 'JP Beban Perusahaan', 'required|trim');
        $this->form_validation->set_rules('potongan_jkk_perusahaan', 'JKK Beban Perusahaan', 'required|trim');
        $this->form_validation->set_rules('potongan_jkm_perusahaan', 'JKM Beban Perusahaan', 'required|trim');
        $this->form_validation->set_rules('maksimal_iuran_jp', 'Maksimal Iuran JP', 'required|trim');

        //jika validasinya salah akan menampilkan halaman bpjs Ketenagakerjaan
        if ($this->form_validation->run() == FALSE) {
            //Memanggil View Edit
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/edit_iuran_bpjs_ketenagakerjaan', $data);
            $this->load->view('templates/footer');
        }
        //jika validasinya benar
        else {
            //mengupdate kedalam database melalui method pada model BPJS Ketenagakerjaan
            $this->bpjsketenagakerjaan->editBPJSTK();
            //menampikan pesan sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data BPJS Ketenagakerjaan</div>');
            //dan mendirect kehalaman bpjs Ketenagakerjaan
            redirect('master/bpjsketenagakerjaan');
        }
    }
}
