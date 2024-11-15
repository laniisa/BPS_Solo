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
        $catatan = $this->input->post('catatan');
        $tindak_lanjut = $this->input->post('tindak_lanjut');
        $no_surat = $this->input->post('no_surat');
        $tujuan = $this->input->post('tujuan'); // Array of user IDs
    
        // Mulai Transaksi
        $this->db->trans_start();
    
        // Retrieve the id_ds_surat from the surat table
        $surat = $this->Struktural_Model->get_surat_by_no_surat($no_surat);
        
        $id_ds_surat = $surat['id_ds_surat'];
    
    
        // Insert data into pegawai table for each tujuan
        $id_ds_pegawai = [];
        if (!empty($tujuan)) {
            foreach ($tujuan as $id_user_fungsional) {
                $data_ds = [
                    'user_id' => $this->session->userdata('id_user'),
                    'catatan' => $catatan,
                    'tindak_lanjut' => $tindak_lanjut,
                    'tanggal' => ($tindak_lanjut == 'diteruskan') ? date('Y-m-d H:i:s') : null,
                    //'tgl_dilaksanakan' => ($tindak_lanjut == 'dilaksanakan') ? date('Y-m-d H:i:s') : null,
                ];
                $this->db->insert('pegawai', $data_ds);
                $id_disposisi[] = $this->db->insert_id();
            }
        }
    
        // Insert data into disposisi table and collect no_disposisi
        $no_disposisi_array = [];
        if (!empty($id_ds_pegawai)) {
            foreach ($id_ds_pegawai as $id_pegawai) {
                $data_disposisi = [
                    'id_ds_surat' => $id_ds_surat,
                    'id_disposisi' => $id_disposisi
                ];
                $this->db->insert('disposisi', $data_disposisi);
                $no_disposisi = $this->db->insert_id();
                $no_disposisi_array[] = $no_disposisi;
            }
        }
    
        // Update surat table with the collected no_disposisi
        if (!empty($no_disposisi_array)) {
            $no_disposisi = implode(',', $no_disposisi_array);
            $this->Struktural_Model->update_surat_disposisi($no_surat, $no_disposisi);
        }
    
        // Update surat status based on tindak lanjut
        if ($tindak_lanjut == 'diteruskan') {
            
            $this->Struktural_Model->update_surat_disposisi($no_surat, $no_disposisi);
        }
    
        // Selesaikan Transaksi
        $this->db->trans_complete();
    
        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat memproses data.');
        } else {
            $this->session->set_flashdata('success', 'Surat berhasil didisposisi');
        }

        $data['surat'] = $surat; 
        $this->load->view('struktural/surat', $data);
        redirect('struktural');
    }
    
    public function insert_pegawai() {
        $this->load->model('Struktural_Model');
    
        $id_user = $this->session->userdata('id_user'); 
        $tindak_lanjut = $this->input->post('tindak_lanjut');
        $no_surat = $this->input->post('no_surat');
        $current_datetime = date('Y-m-d H:i:s');
        $action_click = $this->input->post('action_click'); 
        
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
        $action_click_count = $this->get_action_click_count($id_surat);
        
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
                'id_disposisi' => $id_disposisi 
            ];
    
            $this->db->insert('disposisi', $disposisi_data);
    
            $surat_update_data = [
                'tgl_dilaksanakan' => $current_datetime,
                'status' => 'dilaksanakan',
                'user_id' => $id_user 
            ];
    
            $this->Surat_Model->update_surat($id_surat, $surat_update_data);
            
            $this->session->set_flashdata('success', 'Surat berhasil dilaksanakan');
            redirect('struktural');
            
        } elseif ($tindak_lanjut == 'diteruskan') {
            redirect('struktural/surat?no_surat=' . urlencode($no_surat) . '&user_id=' . urlencode($id_user));
        } else {
            $this->session->set_flashdata('error', 'Tindak lanjut tidak valid.');
            redirect('struktural');
        }
    }
    private function get_action_click_count($id_surat) {
        // Count the number of actions for this surat
        $this->db->from('pegawai');
        $this->db->where('id_surat', $id_surat);
        return $this->db->count_all_results(); // This will return the count of rows
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
        $this->load->view('template_struk/header', $data);
        $this->load->view('struktural/rekap', $data);
        $this->load->view('template_struk/footer');
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
        $this->load->view('template_struk/header', $data);
        $this->load->view('struktural/detail_rekap', $data);
        $this->load->view('template_struk/footer');
    }
    
    public function kumpulan_surat() {
        if (!$this->session->userdata('email')) {
            redirect('login');
        }
    
        $email = $this->session->userdata('email');
        $user = $this->db->get_where('users', ['email' => $email])->row_array();
        $user_id = $user['id_user']; 
    
        // Retrieve data
        $data['surat'] = $this->Surat_Model->get_surat_by_user_id($user_id); 
         // Load views dengan data surat yang diambil
         $this->load->view('template_struk/header', $data);
         $this->load->view('struktural/kumpulan_surat', $data);
         $this->load->view('template_struk/footer');
    }

    // Menangani tindak lanjut surat
    public function surat_kepala() {
        $id_user = $this->input->post('id_user');
        $no_surat = $this->input->post('no_surat');
        $tindak_lanjut = $this->input->post('tindak_lanjut');

        if ($this->Surat_Model->update_tindak_lanjut($no_surat, $tindak_lanjut)) {
            $this->session->set_flashdata('success', 'Tindak lanjut surat berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('message', 'Terjadi kesalahan saat memperbarui tindak lanjut surat.');
        }

        redirect('struktural/kumpulan_surat');
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
        $this->load->model('Kepala_Model');
        $data['kepala'] = $this->Kepala_Model->get_kepala_by_user($user_id);
    
        // Set judul halaman
        $data['title'] = 'Detail Surat';
    
        // Load view dengan data surat dan catatan kepala
        $this->load->view('template_struk/header', $data);
        $this->load->view('struktural/detail', $data);
        $this->load->view('template_struk/footer');
    }
    
    
    }
?>