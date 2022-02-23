<?php
defined('BASEPATH') or exit('No direct script access allowed');

//Controller untuk halaman user
class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //untuk mengecek, dia sudah login apa belum, dan dia rolenya apa..?
        is_logged_in();
    }

    //method index
    public function index()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'My Profile';
        //session
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    //method edit user
    public function edit()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Edit Profile';
        //session
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();

        //validasi form
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');

        //jika salah
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        }
        //jika benar
        else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            //cek jika ada gambar yang akan di upload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                //file yang diperbolehkan hanya png dan jpg
                $config['allowed_types'] = 'jpg|png';
                //max file 2 mb
                $config['max_size'] = '1024';
                //lokasi penyimpanan file
                $config['upload_path'] = './assets/img/profile/';
                //memanggil library upload
                $this->load->library('upload', $config);


                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('login');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your Profile has been update!</div>');
            redirect('profile');
        }
    }

    //method ganti password
    public function changepassword()
    {
        //Mengambil data dari session, yang sebelumnya sudah diinputkan dari dalam form login
        $data['title'] = 'Change Password';
        //session
        $data['user'] = $this->db->get_where('login', ['email' => $this->session->userdata('email')])->row_array();
        //validation form
        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'Password', 'required|trim|min_length[6]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[6]|matches[new_password1]');

        //jika salah
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer');
        }
        //jika benar 
        else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong Password !</div>');
                redirect('user/changepassword');
            } else {
                if ($current_password ==  $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New Password Cannot be the same as current password!</div>');
                    redirect('user/changepassword');
                } else {
                    //password oke
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('login');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password Change !</div>');
                    redirect('profile');
                }
            }
        }
    }
}
