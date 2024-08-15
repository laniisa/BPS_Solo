<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fumgsional extends CI_Controller {

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
    $this->load->view('fungsional/index', $data);
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
    $this->load->view('fungsional/surat', $data);
    $this->load->view('template_struk/footer');
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
        
        redirect('fungsional/surat?' . $query_string);
    }
    
    
    
    
    
    
    
    
    
    }
?>
