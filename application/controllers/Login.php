<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('User_Model');
        $this->load->model('Surat_Model');
        $this->load->model('Admin_Model');
        $this->load->model('Struktural_Model');
        $this->load->model('Fungsional_Model');
        $this->load->model('Operator_Model');
        $this->load->library('session');
    }

    public function index()
    {
        if ($this->input->post()) {
            $this->_login();
        } else {
            $data['title'] = 'Disposisi BPS | Login';
            $data['pesan'] = $this->session->flashdata('pesan');
            $this->load->view('login/index', $data);
        }
    }
    
    private function _login()
{
    // Aturan validasi formulir
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');

    if ($this->form_validation->run() == FALSE) {
        // Validasi gagal
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Email dan Password harus diisi dengan benar.</div>');
        redirect('login');
    } else {
        // Validasi berhasil, coba login
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        // Ambil data pengguna dari database
        $user = $this->User_Model->get_user_by_email($email);

        if ($user) {
            // Pengguna ditemukan, verifikasi password
            if (password_verify($password, $user['password'])) {
                // Password benar, buat data sesi
                $data = [
                    'id_user' => $user['id_user'],
                    'email' => $user['email'],
                    'id_role' => $user['role']
                ];
                $this->session->set_userdata($data);

                // Set flash message berhasil login
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Login berhasil! Selamat datang.</div>');

                // Redirect berdasarkan peran pengguna
                switch ($user['role']) {
                    case 0:
                        redirect('admin'); // Admin
                        break;
                    case 1:
                        redirect('struktural'); // Struktural
                        break;
                    case 2:
                        redirect('fungsional'); // Fungsional
                        break;
                    case 3:
                        redirect('operator'); // Operator
                        break;
                    default:
                        redirect('login'); // Redirect default ke halaman login
                        break;
                }
            } else {
                // Password salah
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Password salah! Silahkan coba lagi!!</div>');
                redirect('login');
            }
        } else {
            // Email tidak ditemukan
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Email tidak ditemukan. Silahkan coba lagi!!</div>');
            redirect('login');
        }
    }
}

    public function regis()
    {
        // Aturan validasi formulir untuk registrasi
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.usr]');
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[4]');
        $this->form_validation->set_rules('password2', 'Confirm Password', 'required|trim|matches[password1]');
    
        if ($this->form_validation->run() == false) {
            // Validasi gagal
            $data['title'] = 'Registrasi Pegawai';
            $this->load->view('login/regis', $data);
        } else {
            $this->aksi_regis();
        }
    }

    public function aksi_regis()
    {
        // Tentukan peran berdasarkan domain email
        $email = htmlspecialchars($this->input->post('email', true));
        $domain = substr(strrchr($email, "@"), 1); // Ambil domain dari email

        $role = 2; // Default ke Fungsional
        if ($domain === 'admin.com') {
            $role = 0; // Admin
        } elseif ($domain === 'struktural.com') {
            $role = 1; // Struktural
        } elseif ($domain === 'operator.com') {
            $role = 3; // Operator
        }

        $data_user = array(
            'nama' => htmlspecialchars($this->input->post('nama', true)),
            'usr' => htmlspecialchars($this->input->post('username', true)),
            'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            'role' => $role,
            'status' => 'active', // Default status ke active
            'email' => $email,
            'whatsApp' => htmlspecialchars($this->input->post('telp', true)),
        );

        $this->User_Model->insert_user($data_user);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Registrasi berhasil. Silahkan login.</div>');
        redirect('login');
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('id_role');
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Anda Berhasil Keluar!</div>');
        redirect('login');
    }

    public function blocked()
    {
        $this->load->view('login/blocked');
    }
}
    
?>
