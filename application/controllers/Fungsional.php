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
    
        // Fetch surat data based on user ID
        $this->load->model('Fungsional_Model');
        $data['surat'] = $this->Fungsional_Model->get_surat_by_user_id($user_id);
    
        error_log(print_r($data['surat'], true));
    
        $data['title'] = 'Daftar Surat';
        $data['user'] = $user;
    
        $this->load->view('template_fung/header', $data);
        $this->load->view('fungsional/index', $data);
        $this->load->view('template_fung/footer');
    }
    public function diteruskan() {
        if (!$this->session->userdata('email')) {
            redirect('login');
        }
    
        $email = $this->session->userdata('email');
        $user = $this->db->get_where('users', ['email' => $email])->row_array();
        $user_id = $user['id_user']; 
        
        $no_surat = $this->input->get('no_surat');
        $tindak_lanjut = $this->input->get('tindak_lanjut'); 
        
        $this->load->model('Struktural_Model');
        $data['surat'] = $this->Struktural_Model->get_surat_by_no_surat($no_surat);
        $data['users_fungsional'] = $this->User_Model->get_users_by_role(2);
        
        $data['selected_tindak_lanjut'] = $tindak_lanjut; 
        
        $data['title'] = 'Surat Page'; 
        $this->load->view('template_fung/header', $data);
        $this->load->view('fungsional/diteruskan', $data);
        $this->load->view('template_fung/footer');
    }
    public function insert_pegawai() {
        $this->load->model('Fungsional_Model');

        $id_user = $this->input->post('id_user');
        $no_surat = $this->input->post('no_surat');
        $current_datetime = date('Y-m-d H:i:s');
        $tindak_lanjut = $this->input->post('tindak_lanjut');
        $action_click_count = $this->input->post('action_click');
        if (empty($id_user)) {
            $this->session->set_flashdata('error', 'User ID is missing. Please log in again.');
            redirect('login');
            return;
        }
        $surat_data = $this->Surat_Model->get_surat_by_no($no_surat);
        
        if (!$surat_data) {
            $this->session->set_flashdata('error', 'No matching surat found.');
            redirect('struktural');
            return;
        }
        $id_surat = $surat_data['id_ds_surat'];
        
        if ($tindak_lanjut == 'dilaksanakan') {
            $pegawai_data = [
                'id_user' => $id_user,
                'id_surat' => $id_surat,
                'catatan' => 'sukses',
                'tindak_lanjut' => 'dilaksanakan',
                'tanggal' => $current_datetime,
                'action_click' => $action_click_count 
            ];
    
            $this->db->insert('pegawai', $pegawai_data);
            $id_disposisi = $this->db->insert_id();

            $disposisi_data = [
                'id_ds_surat' => $id_surat,
                'status' => 'dilaksanakan',
                'id_disposisi' => $id_disposisi,
                'user_tujuan' => NULL 
            ];

            $this->db->insert('disposisi', $disposisi_data);

            $surat_update_data = [
                'tgl_dilaksanakan' => $current_datetime,
                'status' => 'dilaksanakan'
            ];
    
            $this->Surat_Model->update_surat($id_surat, $surat_update_data);
            
            $this->session->set_flashdata('success', 'Surat berhasil dilaksanakan');
            redirect('fungsional');
            
        } elseif ($tindak_lanjut == 'diteruskan') {
            $surat_update_data = [
                'status' => 'diteruskan',
            ];
            $this->db->where('no_surat', $no_surat);  
            $this->db->update('surat', $surat_update_data);
            redirect('fungsional/diteruskan?no_surat=' . urlencode($no_surat) . '&user_id=' . urlencode($id_user));
        } else {
            $this->session->set_flashdata('error', 'Tindak lanjut tidak valid.');
            redirect('fungsional');
        }
    }

    private function get_action_click_count($id_surat) {
        // Count the number of actions for this surat
        $this->db->from('pegawai');
        $this->db->where('id_surat', $id_surat);
        return $this->db->count_all_results(); // This will return the count of rows
    }

    public function proses_tujuan() {
        $catatan = $this->input->post('catatan');
        $no_surat = $this->input->post('no_surat');
        $tujuan = $this->input->post('tujuan'); 
        
        $this->db->trans_start();
    
        $surat = $this->Struktural_Model->get_surat_by_no_surat($no_surat);
        
        $id_ds_surat = $surat['id_ds_surat'];
        $tindak_lanjut = $surat['status'];
    
        $this->db->where('id_ds_surat', $id_ds_surat);
        $this->db->update('surat', ['status' => $tindak_lanjut]);
        if (!empty($tujuan)) {
            $id_user_fungsional = $tujuan[0];
            
            $data_ds = [
                'id_user' => $this->session->userdata('id_user'),
                'id_surat' => $id_ds_surat,
                'catatan' => $catatan,
                'tindak_lanjut' => $tindak_lanjut,
                'tanggal' => date('Y-m-d H:i:s'),
                'action_click' => 1,
            ];
            $this->db->insert('pegawai', $data_ds);
            $id_disposisi = $this->db->insert_id();
        }

        if (!empty($tujuan)) {
            foreach ($tujuan as $id_user_fungsional) {
                $data_disposisi = [
                    'id_ds_surat' => $id_ds_surat,
                    'id_disposisi' => $id_disposisi,
                    'user_tujuan' => $id_user_fungsional, 
                    'status' => $tindak_lanjut,
                ];
                $this->db->insert('disposisi', $data_disposisi);
            }
        }

        $this->db->trans_complete();
    
        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat memproses data.');
        } else {
            $this->session->set_flashdata('success', 'Surat berhasil didisposisi');
        }
        $data['surat'] = $surat; 
        $this->load->view('fungsional/diteruskan', $data);
        redirect('fungsional');
    }
    
    public function detail_surat($id) {
        $data['title'] = 'Detail Surat';
        
        $data['surat'] = $this->db->get_where('surat', ['id' => $id])->row_array();

        $this->db->where('role_id', 2);
        $data['users_fungsional'] = $this->db->get('users')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('fungsional/detail_surat', $data);
        $this->load->view('templates/footer');
    }

    public function rekap() {
        if (!$this->session->userdata('email')) {
            redirect('login');
        }

        // Ambil email dari session
        $email = $this->session->userdata('email');

        // Dapatkan informasi pengguna
        $data['user'] = $this->db->get_where('users', ['email' => $email])->row_array();

        // Ambil daftar semua surat
        $data['surat'] = $this->Surat_Model->get_all_surat();

        // Load views dengan data yang dikumpulkan
        $this->load->view('template_fung/header', $data);
        $this->load->view('fungsional/rekap', $data);
        $this->load->view('template_fung/footer');
    }

    public function filter_rekap() {
        $tanggal_awal = $this->input->get('tanggal_awal');
        $tanggal_akhir = $this->input->get('tanggal_akhir');
    
        // Jika tidak ada filter tanggal, ambil semua surat
        if (empty($tanggal_awal) || empty($tanggal_akhir)) {
            $result = $this->Surat_Model->get_all_surat();
        } else {
            $result = $this->Surat_Model->get_filtered_surat($tanggal_awal, $tanggal_akhir);
        }
    
        // Mengembalikan data dalam bentuk JSON
        echo json_encode($result);
    }

    public function detail_rekap($id) {
        // Ambil data surat berdasarkan ID
        $data['surat'] = $this->Surat_Model->get_surat_by_id($id);

        // Load views dengan data surat yang diambil
        $this->load->view('template_fung/header', $data);
        $this->load->view('fungsional/detail_rekap', $data);
        $this->load->view('template_fung/footer');
    }
    
    public function kumpulan_surat() {
        if (!$this->session->userdata('email')) {
            redirect('login');
        }
    
        $email = $this->session->userdata('email');
        $user = $this->db->get_where('users', ['email' => $email])->row_array();
        $user_id = $user['id_user']; 
    
        // Retrieve data
        $data['surat'] = $this->Fungsional_Model->get_surat_by_user_id($user_id); 
         // Load views dengan data surat yang diambil
         $this->load->view('template_fung/header', $data);
         $this->load->view('fungsional/kumpulan_surat', $data);
         $this->load->view('template_fung/footer');
    }

    // Menangani tindak lanjut surat
    public function surat_kepala() {
        $user_id = $this->input->post('user_id');
        $no_surat = $this->input->post('no_surat');
        $tindak_lanjut = $this->input->post('tindak_lanjut');

        if ($this->Surat_Model->update_tindak_lanjut($no_surat, $tindak_lanjut)) {
            $this->session->set_flashdata('success', 'Tindak lanjut surat berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('message', 'Terjadi kesalahan saat memperbarui tindak lanjut surat.');
        }

        redirect('fungsional/kumpulan_surat');
    }

    public function detail($id) {
        if (!$this->session->userdata('email')) {
            redirect('login');
        }
    
        $email = $this->session->userdata('email');
        $user = $this->db->get_where('users', ['email' => $email])->row_array();
        $user_id = $user['id_user'];
    
        // Ambil data surat berdasarkan ID surat yang dipilih
        $this->load->model('Surat_Model');
        $data['surat'] = $this->Surat_Model->get_surat_by_id($id);
    
        // Ambil catatan kepala terkait user dari tabel kepala
        // $this->load->model('Kepala_Model');
        // $data['kepala'] = $this->Kepala_Model->get_kepala_by_user($user_id);
    
        // Set judul halaman
        $data['title'] = 'Detail Surat';
    
        // Load view dengan data surat dan catatan kepala
        $this->load->view('template_fung/header', $data);
        $this->load->view('fungsional/detail', $data);
        $this->load->view('template_fung/footer');
    }
    
    
    
    


}
?>