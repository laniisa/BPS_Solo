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
        // Check if temp data exists in session
        $temp_data = $this->session->userdata('temp_data');
    
        if ($temp_data) {
            // Load the model
            $this->load->model('Struktural_model');
    
            // Get data based on temp data
            $data['temp_data'] = $temp_data;
            
            // Optionally, you can retrieve more data or do more operations here
            
            // Load view
            $data['title'] = 'Surat Page'; // Adjust title as needed
            $this->load->view('template_struk/header', $data);
            $this->load->view('struktural/surat', $data);
            $this->load->view('template_struk/footer');
        } else {
            // Redirect back if no temp data exists
            redirect('struktural');
        }
    }
    
    public function insert_kepala() {
        // Load the model
        $this->load->model('Struktural_model');
        
        // Get user_id and other form data
        $id_user = $this->input->post('user_id');
        $tindak_lanjut = $this->input->post('tindak_lanjut');
        $no_surat = $this->input->post('no_surat'); // Add this if you need to pass no_surat or other data
        
        // Check if 'tindak_lanjut' is 'diteruskan'
        if ($tindak_lanjut == 'diteruskan') {
            // Store data temporarily in session
            $this->session->set_userdata('temp_data', [
                'user_id' => $id_user,
                'tindak_lanjut' => $tindak_lanjut,
                'no_surat' => $no_surat // Add this if needed
            ]);
    
            // Redirect to surat.php
            redirect('struktural/surat');
        } else {
            // Prepare data to insert
            $data = [
                'user_id' => $id_user,
                'tindak_lanjut' => $tindak_lanjut,
                'catatan_kepala' => 'sukses'
            ];
        
            // Insert data into kepala table
            $this->Struktural_model->insert_kepala($data);
    
            // Redirect to a success page or back to the form
            redirect('struktural');
        }
    }
    
    public function edit_aksi($id_ds_kepala) {
        $status = $this->input->post('tindak_lanjut');
        
        // Debugging: periksa apakah ID dan status diterima dengan benar
        error_log("ID: $id_ds_kepala, Aksi: $tindak_lanjut"); // Logging
        
        if ($id_ds_kepala && $tindak_lanjut !== null) {
            // Update status berdasarkan id_user
            if ($this->Struktural_Model->update_status($id_ds_kepala, $tindak_lanjut)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Status berhasil diupdate!</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal mengupdate status!</div>');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Status harus diisi!</div>');
        }
        
        // Redirect ke halaman daftar admin
        redirect('struktural');
    }
    
    
    
    }
?>