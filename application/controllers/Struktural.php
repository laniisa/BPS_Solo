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
        $data['kepala'] = $this->Kepala_Model->get_kepala_by_user_id($user_id); 


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

    public function insert_kepala() {
        // Load the model
        $this->load->model('Kepala_Model');
        
        // Retrieve form data
        $tindak_lanjut = $this->input->post('tindak_lanjut');
        $user_id = $this->input->post('user_id');
        
        if ($tindak_lanjut) {
            if ($tindak_lanjut == 'dilaksanakan') {
                // Prepare data to insert into kepala table
                $data = [
                    'tindak_lanjut' => $tindak_lanjut,
                    'catatan_kepala' => 'sukses',
                    'user_id' => $user_id
                ];
                
                // Insert data into the kepala table
                $insert_result = $this->Kepala_Model->insert_kepala($data);
    
                if ($insert_result) {
                    // Return a JSON response indicating success
                    echo json_encode(['status' => 'success', 'message' => 'Data successfully inserted.']);
                } else {
                    // Return a JSON response indicating failure
                    echo json_encode(['status' => 'error', 'message' => 'Failed to insert data.']);
                }
            } elseif ($tindak_lanjut == 'diteruskan') {
                // Return a JSON response indicating a redirect
                echo json_encode(['status' => 'redirect', 'url' => base_url('controller/surat')]);
            }
        } else {
            // Return a JSON response indicating an error
            echo json_encode(['status' => 'error', 'message' => 'No action selected.']);
        }
    
    }
    public function edit_tindakan($user_id) {
       

        redirect('struktural');
    }

    
    }
?>