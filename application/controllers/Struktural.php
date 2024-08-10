<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktural extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library('form_validation');
        $this->load->model('Surat_Model');
        $this->load->model('User_Model');
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
        $user_id = $user['id_user']; // Get user_id
    
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
    
    
    public function edit_tindakan($id_user) {
        // Load model jika belum dimuat di constructor
        $this->load->model('User_Model');
    
        $csrf_token_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();
    
        $tindak_lanjut = $this->input->post('tindak_lanjut');
        error_log("ID: $id_user, Aksi: $tindak_lanjut"); // Logging
    
        if ($id_user && $tindak_lanjut !== null) {
            // Panggil metode model untuk menambah atau memperbarui data di tabel kepala
            $result = $this->User_Model->update_tindakan($id_user, $tindak_lanjut);
            
            if ($result) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Aksi berhasil diupdate!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal mengupdate aksi!</div>');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aksi harus diisi!</div>');
        }
    
        redirect('struktural');
    }
    
    }
?>