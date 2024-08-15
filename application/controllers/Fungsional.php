<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fungsional extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library('form_validation');
        $this->load->model('Surat_Model');
        $this->load->model('User_Model');
        $this->load->library('session');
        $this->load->model('Fungsional_Model');
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
    
        // Fetch surat data based on user ID
        $this->load->model('Fungsional_Model');
        $data['surat'] = $this->Fungsional_Model->get_surat_by_user_id($user_id);
    
        error_log(print_r($data['surat'], true));
    
        $data['title'] = 'Daftar Surat';
        $data['user'] = $user;
    
        $this->load->view('template_struk/header', $data);
        $this->load->view('fungsional/index', $data);
        $this->load->view('template_struk/footer');
    }
    public function insert_pegawai() {
        $user_id = $this->input->post('user_id');
        $no_surat = $this->input->post('no_surat');
        $tindak_lanjut = $this->input->post('tindak_lanjut');
        
        // Load model
        $this->load->model('Fungsional_Model');
        
        if ($tindak_lanjut == 'dilaksanakan') {
            // Update data di tabel 'surat'
            $this->Fungsional_Model->update_surat($no_surat, [
                'tgl_dilaksanakan' => date('Y-m-d H:i:s'),
                'status' => 'dilaksanakan'
            ]);
            
            // Dapatkan id_surat dari no_surat
            $id_surat = $this->Fungsional_Model->get_id_surat_by_no($no_surat);
            
            // Update data di tabel 'pegawai'
            $this->Fungsional_Model->update_pegawai($user_id, $id_surat, [
                'catatan' => 'sukses',
                'tindak_lanjut' => 'dilaksanakan',
                'tanggal' => date('Y-m-d H:i:s')
            ]);
            
            // Redirect ke index dan hilangkan baris surat dari tampilan
            $this->session->set_flashdata('message', 'Surat berhasil diproses.');
            redirect('fungsional');
            
        } elseif ($tindak_lanjut == 'diteruskan') {
            $data = [
                'user_id' => $user_id,
                'no_surat' => $no_surat
            ];
            
            // Redirect ke halaman lain dengan data yang diperlukan
            $this->load->view('fungsional/diteruskan', $data);
        }
    }
    
    


}
?>