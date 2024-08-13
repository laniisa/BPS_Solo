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
            redirect('struktural/surat');
        }
        redirect('struktural');
    }
    
    
    
    
    
    public function detail_surat($no_surat) {
        $this->load->model('Surat_Model');
        
        // Get the surat details
        $surat = $this->Surat_Model->get_surat_by_no($no_surat);
        
        // Retrieve temporary data from the session
        $temp_data = $this->session->userdata('temp_data');
    
        // Pass the surat and temporary data to the view
        $data = [
            'title' => 'Detail Surat',
            'surat' => $surat,
            'catatan_kepala' => $this->Surat_Model->get_catatan_kepala($no_surat),
            'catatan_pegawai' => $this->Surat_Model->get_catatan_pegawai($no_surat),
            'temp_data' => $temp_data // Passing temp_data to the view
        ];
    
        $this->load->view('surat/detail_surat', $data);
    }
    
    
    }
?>