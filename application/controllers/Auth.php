<?php
defined('BASEPATH') or exit('No direct script access allowed');

//Controller halaman Login
class Auth extends CI_Controller
{
    //Memanggil library form_validation, agar bisa diakses di semua class Auth
    public function __construct()
    {
        parent::__construct();
        //load library validation
        $this->load->library('form_validation');
    }

    //Method Halaman Login, halaman yang di set default oleh controller
    public function index()
    {
        //Agar ketika kita sudah login, dan kita akses /auth, 
        //kita ga balik lagi ke halaman login, namun ke halaman utama 
        //sesuai dengan session nya.
        if ($this->session->userdata('email')) {
            redirect('profile');
        }

        //Validasi
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        //Jika Validasinya login gagal
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Form Login';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        }
        //validasinya sukses
        else {
            $this->_login();
        }
    }

    //method _login() tersebut bersifat private, 
    //agar hanya method index saja yang bisa mengakses method tersebut
    private function _login()
    {
        //Mengambil inputan pada form login, dan menyimpannya kedalam variabel $email dan $password
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        //mengambil data email dari table login, 
        //dan menyimpannya kedalam $user
        $user = $this->db->get_where('login', ['email' => $email])->row_array();

        //jika usernya ada
        if ($user) {
            //jika usernya aktif
            if ($user['is_active'] == 1) {
                //cek password, jika passwordnya benar
                if (password_verify($password, $user['password'])) {
                    //Menyimpan session kedalam $data
                    $data = [
                        'nik' => $user['nik'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    //menyimpan session kedalam userdata dan mendirect kedalam method user
                    $this->session->set_userdata($data);
                    //Membuat kondisi jika hak aksesnya atau role_id nya 1 atau admin maka akan me redirect ke halaman admin,
                    //Namun jika hak aksesnya atau role_id nya 2 atau user maka akan me redirect ke halaman user
                    if ($user['role_id'] == 1 || $user['role_id'] == 9 || $user['role_id'] == 10 || $user['role_id'] == 11) {
                        redirect('home');
                    } else {
                        redirect('profile');
                    }
                } else {
                    //Jika Passwordnya salah
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong Password</div>');
                    redirect('auth');
                }
            } else {
                //Jika email belum teraktivasi
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">This email has not been activated</div>');
                redirect('auth');
            }
        } else {
            //jika tidak ada usernya, atau belum daftar
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered</div>');
            redirect('auth');
        }
    }

    //Method form registrasi
    public function registration()
    {
        //agar ketika kita sudah login, dan kita akses /auth, kita ga balik lagi ke halaman login, namun ke halaman utama sesuai dengan session nya.
        if ($this->session->userdata('email')) {
            redirect('profile');
        }

        //Validasi Form Registrasi
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|min_length[16]');
        $this->form_validation->set_rules('name', 'Name', 'required|trim');

        $this->form_validation->set_rules('password1', 'Password1', 'required|trim|min_length[6]|matches[password2]', [
            'matches' => 'password dont match!',
            'min_length' => 'Password to short'
        ]);
        $this->form_validation->set_rules('password2', 'Password2', 'required|trim|matches[password1]', [
            'matches' => 'password dont match!',
            'min_length' => 'Password to short'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[login.email]', [
            'is_unique' => 'This email has already registered!'
        ]);

        //Jika yang diiputkan salah, atau tidak sesuai, maka akan menampilkan halaman registrasi lagi
        if ($this->form_validation->run() == false) {
            $data['title'] = 'User Registration';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        }

        //Jika yang diinputkan benar, maka akan menyimpan kedalam database 
        else {
            $email = $this->input->post('email', true);
            $data = [
                'nik' => htmlspecialchars($this->input->post('nik', true)),
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time()
            ];
            //siapkan token berupa bilangan random
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            //insert table login
            $this->db->insert('login', $data);
            //insert table token
            $this->db->insert('login_token', $user_token);

            //mengirimkan token kedalam email dengan type verify
            $this->_sendEmail($token, 'verify');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratulation your account has been created. Please check email and activated your account!</div>');
            redirect('auth');
        }
    }

    //method _sendEmail() tersebut bersifat private, 
    //agar hanya method registration saja yang bisa mengakses method tersebut
    //kirim email aktivasi
    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'achmadfirmansyah856@gmail.com',
            'smtp_pass' => 'achmadfi',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->from('achmadfirmansyah856@gmail.com', 'Achmad Firmansyah');
        //jika type token verify
        if ($type == 'verify') {
            $this->email->to($this->input->post('email'));
            $this->email->subject('Account Verification');
            $this->email->message('Click this link to verify your account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>');
        }
        //jika type token forgot password  
        else if ($type == 'forgot') {
            $this->email->to($this->input->post('email'));
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to reset your password : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
        }

        //jika benar akan menampilkan token ke email
        if ($this->email->send()) {
            return true;
        }
        //jika salah akan menampilkan pesan kesalahan
        else {
            echo $this->email->print_debugger();
            die;
        }
    }

    //Method ini akan dijalankan jika type token verify / verifikasi
    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $user = $this->db->get_where('login', ['email' => $email])->row_array();
        if ($user) {
            $user_token = $this->db->get_where('login_token', ['token' => $token])->row_array();
            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('login');
                    $this->db->delete('login_token', ['email' => $email]);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $email . ' Has been activated ! Please Login</div>');
                    redirect('auth');
                } else {
                    $this->db->delete('login', ['email' => $email]);
                    $this->db->delete('login_token', ['email' => $email]);
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed ! Token expired</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed ! Wrong Token</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed ! Wrong Email</div>');
            redirect('auth');
        }
    }

    //method logout
    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You have been logged out!</div>');
        redirect('auth');
    }

    //halaman blocked
    public function blocked()
    {
        $this->load->view('auth/blocked');
    }

    //halaman blocked
    public function coomingsoon()
    {
        $this->load->view('auth/coomingsoon');
    }

    //method forgot password
    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot_password');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('login', ['email' => $email, 'is_active' => 1])->row_array();
            if ($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];
                $this->db->insert('login_token', $user_token);
                $this->_sendEmail($token, 'forgot');
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Please check your email to reset your password !</div>');
                redirect('auth/forgotPassword');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered or activated !</div>');
                redirect('auth/forgotPassword');
            }
        }
    }

    //method reset password
    public function resetPassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $user = $this->db->get_where('login', ['email' => $email])->row_array();
        if ($user) {
            $user_token = $this->db->get_where('login_token', ['token' => $token])->row_array();

            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->changePassword();
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! Wrong token.</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! Wrong email.</div>');
            redirect('auth');
        }
    }

    //method change password
    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }
        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[6]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Password', 'trim|required|min_length[6]|matches[password1]');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Change Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/change_password');
            $this->load->view('templates/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('login');

            $this->session->unset_userdata('reset_email');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been change! Please Login</div>');
            redirect('auth');
        }
    }
}
