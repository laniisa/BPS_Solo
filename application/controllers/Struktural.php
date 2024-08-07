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

    public function index()
    {
        if (!$this->session->userdata('email')) {
			redirect('login'); 
		}

        $email = $this->session->userdata('email');
		$data['user'] = $this->db->get_where('users', ['email' => $email])->row_array();
        // Get list of surat (letters) from the Surat_Model

        $data['surat'] = $this->Surat_Model->get_all_surat(); // Fetch all surat
        $data['struktural_users'] = $this->User_Model->get_users_by_role(1);
        $data['title'] = 'Daftar Admin';
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $data['users'] = $this->User_Model->get_users_by_role(0); // Get users with role 0 (Admin)

        // Load view with the collected data
        $this->load->view('template_struk/header', $data);
        $this->load->view('struktural/index', $data);
        $this->load->view('template_struk/footer');
    }
    public function edit_status($id_user) {
        $tindak_lanjut = $this->input->post('tindak_lanjut');
        
        // Debugging: periksa apakah ID dan status diterima dengan benar
        error_log("ID: $id_user, Aksi: $tindak_lanjut"); // Logging
        
        if ($id_user && $tindak_lanjut !== null) {
            // Update status berdasarkan id_user
            if ($this->User_Model->update_status($id_user, $tindak_lanjut)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Aksi berhasil diupdate!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal mengupdate aksi!</div>');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aksi harus diisi!</div>');
        }
        
        // Redirect ke halaman daftar admin
        redirect('struktural');
    }

}
?>