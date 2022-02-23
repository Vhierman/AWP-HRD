<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Memberikan nama alias menu, pada model Menu_model, sehingga, 
        //nanti yang dipanggil oleh method adalah menu, bukan lagi Menu_model
        $this->load->model('Menu_model', 'menu');
        //library form validation agar dapat dipanggil di semua method
        $this->load->library('form_validation');
        //untuk mengecek, dia sudah login apa belum, dan dia rolenya apa..?
        is_logged_in();
    }

    //Menampilkan halaman awal menu management
    public function index()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Menu Management';
        //session
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        //form validation
        $this->form_validation->set_rules('menu', 'Menu', 'required');

        //Jika salah
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        }
        //Jika benar 
        else {
            $this->menu->tambahMenu();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Add New Menu</div>');
            redirect('menu');
        }
    }

    //Method Edit Menu
    public function edit($id)
    {
        $data['title'] = 'Menu Management';
        //session
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memanggil data user_menu berdasarkan id nya
        $data['user_menu'] = $this->menu->getMenuByID($id);
        //form validation 
        $this->form_validation->set_rules('menu', 'Nama Menu Harus Diisi', 'required');

        //Jika salah
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/edit_menu', $data);
            $this->load->view('templates/footer');
        }
        //Jika benar 
        else {
            $this->menu->editMenu();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Menu</div>');
            redirect('menu');
        }
    }

    //Method Hapus Menu
    public function hapus($id)
    {
        $this->menu->hapusMenu($id);
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Menu</div>');
        redirect('menu');
    }

    //Method Menampilkan Semua Sub Menu
    public function submenu()
    {
        $data['title'] = 'Sub Menu Management';
        //session
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //Memanggil semua model data sub menu
        $data['subMenu'] = $this->menu->getSubMenu();
        //Memanggil semua model data user menu
        $data['menu'] = $this->menu->getUserMenu();
        //form validation
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('url', 'Url ', 'required');
        $this->form_validation->set_rules('icon', 'Icon ', 'required');

        //Jika salah
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        }
        //Jika benar 
        else {
            $this->menu->tambahSubMenu();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Add New Sub Menu</div>');
            redirect('menu/submenu');
        }
    }

    //Method Hapus Sub Menu
    public function hapussubmenu($id)
    {
        $this->menu->hapusSubMenu($id);
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Success Delete Sub Menu</div>');
        redirect('menu/submenu');
    }

    //Method Edit Sub Menu
    public function editsubmenu($id)
    {
        $data['title'] = 'Sub Menu Management';
        //session
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //mengambil data sub menu berdasarkan id nya
        $data['user_submenu'] = $this->menu->getSubMenuByID($id);
        //mengambil data menu berdasarkan id nya
        $data['menu'] = $this->menu->getUserMenu();
        //validation form
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('url', 'Url ', 'required');
        $this->form_validation->set_rules('icon', 'Icon ', 'required');

        //jika salah
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/edit_submenu', $data);
            $this->load->view('templates/footer');
        }
        //jika benar 
        else {
            $this->menu->editSubMenu();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Sub Menu</div>');
            redirect('menu/submenu');
        }
    }
}
