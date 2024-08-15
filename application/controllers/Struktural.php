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
        $this->load->model('Struktural_Model');
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
    
        $data['surat'] = $this->Surat_Model->get_surat_by_user_id($user_id); 

        error_log(print_r($data['surat'], true));
    
        $data['title'] = 'Daftar Surat';
        $data['user'] = $user;
    
        $this->load->view('template_struk/header', $data);
        $this->load->view('struktural/index', $data);
        $this->load->view('template_struk/footer');
    }

    public function surat() {
        if (!$this->session->userdata('email')) {
            redirect('login');
        }
    
        $email = $this->session->userdata('email');
        $user = $this->db->get_where('users', ['email' => $email])->row_array();
        $user_id = $user['id_user']; 
        
        $no_surat = $this->input->get('no_surat');
        $tindak_lanjut = $this->input->get('tindak_lanjut'); // Capture the selected tindak_lanjut
        
        $this->load->model('Struktural_Model');
        $data['surat'] = $this->Struktural_Model->get_surat_by_no_surat($no_surat);
        $data['users_fungsional'] = $this->User_Model->get_users_by_role(2);
        
        // Pass the selected tindak_lanjut to the view
        $data['selected_tindak_lanjut'] = $tindak_lanjut; 
        
        $data['title'] = 'Surat Page'; 
        $this->load->view('template_struk/header', $data);
        $this->load->view('struktural/surat', $data);
        $this->load->view('template_struk/footer');
    }
    

    public function detail_surat($id) {
        $data['title'] = 'Detail Surat';
        
        $data['surat'] = $this->db->get_where('surat', ['id' => $id])->row_array();

        $this->db->where('role_id', 2);
        $data['users_fungsional'] = $this->db->get('users')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('struktural/detail_surat', $data);
        $this->load->view('templates/footer');
    }

    public function proses_tujuan() {
        $catatan_kepala = $this->input->post('catatan_kepala');
        $tindak_lanjut = $this->input->post('tindak_lanjut');
        $no_surat = $this->input->post('no_surat');
        $tujuan = $this->input->post('tujuan'); // Array of user IDs
    
        // Retrieve the id_ds_surat from the surat table
        $surat = $this->Struktural_Model->get_surat_by_no_surat($no_surat);
        $id_ds_surat = $surat['id_ds_surat'];
    
        // Insert data into kepala table
        $data_kepala = [
            'user_id' => $this->session->userdata('id_user'),
            'catatan_kepala' => $catatan_kepala,
            'tindak_lanjut' => $tindak_lanjut,
            'tgl_disposisi' => ($tindak_lanjut == 'diteruskan') ? date('Y-m-d H:i:s') : null,
            'tgl_dilaksanakan' => ($tindak_lanjut == 'dilaksanakan') ? date('Y-m-d H:i:s') : null,
        ];
        $this->db->insert('kepala', $data_kepala);
        $id_ds_kepala = $this->db->insert_id(); // Get the ID of the inserted record
    
        // Insert data into pegawai table for each tujuan
        $id_ds_pegawai = [];
        if (!empty($tujuan)) {
            foreach ($tujuan as $id_user_fungsional) {
                $data_pegawai = [
                    'id_user' => $id_user_fungsional,
                    'id_surat' => $id_ds_surat,
                    'id_ds_kepala' => $id_ds_kepala,
                ];
                $this->db->insert('pegawai', $data_pegawai);
                $id_ds_pegawai[] = $this->db->insert_id(); // Collect the IDs of the inserted records
            }
        }
    
        // Insert data into disposisi table and collect no_disposisi
        $no_disposisi_array = [];
        if (!empty($id_ds_pegawai)) {
            foreach ($id_ds_pegawai as $id_pegawai) {
                $data_disposisi = [
                    'id_ds_kepala' => $id_ds_kepala,
                    'id_ds_surat' => $id_ds_surat,
                    'id_ds_pegawai' => $id_pegawai
                ];
                $this->db->insert('disposisi', $data_disposisi);
                $no_disposisi = $this->db->insert_id(); // Get the ID of the inserted disposisi record
                $no_disposisi_array[] = $no_disposisi;
            }
        }
    
        // Update surat table with the collected no_disposisi
        if (!empty($no_disposisi_array)) {
            $no_disposisi = implode(',', $no_disposisi_array); // Combine all no_disposisi values into a comma-separated string
            $this->Struktural_Model->update_surat_disposisi($no_surat, $no_disposisi);
        }
    
        // Update surat status based on tindak lanjut
        if ($tindak_lanjut == 'dilaksanakan') {
            $this->Struktural_Model->update_surat_tgl_dilaksanakan($no_surat);
            $this->Struktural_Model->update_surat_status($no_surat, 'dilaksanakan');
            $this->Struktural_Model->delete_surat($no_surat);
        return; // Stop execution here, no redirect
        } elseif ($tindak_lanjut == 'diteruskan') {
            $this->Struktural_Model->update_surat_disposisi($no_surat, $no_disposisi);
        }
    
        $this->session->set_flashdata('success', 'Surat berhasil didisposisi');
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
        $current_datetime = date('Y-m-d H:i:s'); 
        
        $data = [
            'user_id' => $id_user,
            'tindak_lanjut' => $tindak_lanjut,
            'catatan_kepala' => ($tindak_lanjut == 'dilaksanakan') ? 'sukses' : '',
            'tgl_disposisi' => ($tindak_lanjut == 'diteruskan') ? $current_datetime : null,
            'tgl_dilaksanakan' => ($tindak_lanjut == 'dilaksanakan') ? $current_datetime : null
        ];
        var_dump($data);
        $this->Struktural_Model->insert_kepala($data);
        
        if ($tindak_lanjut == 'dilaksanakan') {
            $this->Struktural_Model->update_surat_tgl_dilaksanakan($no_surat);
            $this->Struktural_Model->update_surat_status($no_surat, 'dilaksanakan');
        } elseif ($tindak_lanjut == 'diteruskan') {
            $this->Struktural_Model->update_surat_disposisi($no_surat);
        }
        
        $query_string = http_build_query([
            'no_surat' => $no_surat
        ]);
        
        redirect('struktural/surat?' . $query_string);
    }
    
    
    
    
    
    
    
    
    
    }
?>