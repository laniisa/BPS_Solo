<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktural extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library('form_validation');
        $this->load->model('Surat_Model');
        $this->load->model('User_Model');
        $this->load->library('session');
        $this->load->model('Struktural_model');
        // Cek login di konstruktor
        if (!$this->session->userdata('email')) {
            redirect('login');
        }
    }

    public function index() {
        if (!$this->session->userdata('email')) {
            redirect('login');
        }
    
        $email = $this->session->userdata('email');
        $user = $this->db->get_where('users', ['email' => $email])->row_array();
        $user_id = $user['id_user']; 
    
        // Retrieve data
        $data['surat'] = $this->Surat_Model->get_surat_by_user_id($user_id); 

        // Log the data to check for 'id_ds_kepala'
        error_log(print_r($data['surat'], true));
    
        $data['title'] = 'Daftar Surat';
        $data['user'] = $user;
    
        // Load view
        $this->load->view('template_struk/header', $data);
        $this->load->view('struktural/index', $data);
        $this->load->view('template_struk/footer');
    }

    public function struktural() {
        // Role ID for 'struktural' is 1
        $role_id = 1;
        
        // Get users with 'struktural' role
        $users = $this->Kepala_Model->get_users_by_role($role_id);
        
        // Output the result as JSON
        echo json_encode($users);
    }

    public function surat() {
        if (!$this->session->userdata('email')) {
            redirect('login');
        }
        
        $email = $this->session->userdata('email');
        $user = $this->db->get_where('users', ['email' => $email])->row_array();
        $user_id = $user['id_user']; 
        
        // Retrieve the no_surat from the query string
        $no_surat = $this->input->get('no_surat');
        
        // Fetch the data for the given no_surat
        $this->load->model('Struktural_Model');
        $data['surat'] = $this->Struktural_Model->get_surat_by_no_surat($no_surat);
        
        // Fetch all users with role 2 (fungsional)
        $data['users_fungsional'] = $this->User_Model->get_users_by_role(2);
        
        $data['title'] = 'Surat Page'; // Adjust title as needed
        $this->load->view('template_struk/header', $data);
        $this->load->view('struktural/surat', $data);
        $this->load->view('template_struk/footer');
    }

    public function detail_surat($id) {
        $data['title'] = 'Detail Surat';
        
        // Ambil data surat berdasarkan ID
        $data['surat'] = $this->db->get_where('surat', ['id' => $id])->row_array();

        // Ambil data pengguna fungsional (role ID 2)
        $this->db->where('role_id', 2);
        $data['users_fungsional'] = $this->db->get('users')->result_array();

        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('struktural/detail_surat', $data);
        $this->load->view('templates/footer');
    }

    public function proses_tujuan() {
        // Ambil data dari form
        $catatan_kepala = $this->input->post('catatan_kepala');
        $tujuan = $this->input->post('tujuan');
        $no_disposisi = $this->input->post('no_disposisi');

        // Simpan catatan kepala ke tabel `kepala`
        $data_kepala = [
            'catatan_kepala' => $catatan_kepala,
            'no_disposisi' => $no_disposisi,
            // tambahkan kolom lain yang diperlukan
        ];
        $this->db->insert('kepala', $data_kepala);

        // Simpan tujuan ke tabel `pegawai`
        if (!empty($tujuan)) {
            foreach ($tujuan as $id_user_fungsional) {
                $data_pegawai = [
                    'id_user' => $id_user_fungsional,
                    'no_disposisi' => $no_disposisi,
                    'status' => 'diterima', // atau status lain yang relevan
                    // tambahkan kolom lain yang diperlukan
                ];
                $this->db->insert('pegawai', $data_pegawai);
            }
        }

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        $this->session->set_flashdata('message', 'Data berhasil disimpan');
        redirect('struktural');
    }
    
    public function get_users_by_role($role_id) {
        $this->db->where('role', $role_id);
        $query = $this->db->get('users');
        return $query->result_array();
    }
    
    
    public function insert_kepala() {
        $this->load->model('Struktural_Model');
        
        $id_user = $this->input->post('user_id');
        $tindak_lanjut = $this->input->post('tindak_lanjut');
        $no_surat = $this->input->post('no_surat');
        $current_datetime = date('Y-m-d H:i:s'); // Get the current datetime
        
        // Prepare data for insertion into kepala table
        $data = [
            'user_id' => $id_user,
            'tindak_lanjut' => $tindak_lanjut,
            'catatan_kepala' => ($tindak_lanjut == 'dilaksanakan') ? 'sukses' : '',
            'tgl_disposisi' => ($tindak_lanjut == 'diteruskan') ? $current_datetime : null,
            'tgl_dilaksanakan' => ($tindak_lanjut == 'dilaksanakan') ? $current_datetime : null
        ];
        
        // Insert data into kepala table
        $this->Struktural_Model->insert_kepala($data);
        
        if ($tindak_lanjut == 'dilaksanakan') {
            // Update the surat status to reflect it's been handled
            $this->Struktural_Model->update_surat_tgl_dilaksanakan($no_surat);
            $this->Struktural_Model->update_surat_status($no_surat, 'dilaksanakan');
        } elseif ($tindak_lanjut == 'diteruskan') {
            // Update surat for disposisi
            $this->Struktural_Model->update_surat_disposisi($no_surat);
        }
        
        // Prepare query string parameters
        $query_string = http_build_query([
            'no_surat' => $no_surat
        ]);
        
        redirect('struktural/surat?' . $query_string);
    }
    
    
    
    
    
    
    
    
    
    }
?>