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
        // Ambil data dari input
        $catatan_kepala = $this->input->post('catatan_kepala');
        $tindak_lanjut = $this->input->post('tindak_lanjut');
        $no_surat = $this->input->post('no_surat');
        $tujuan = $this->input->post('tujuan'); // Array of user IDs
    
        // Load model
        $this->load->model('Struktural_Model');
        
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
        $id_ds_kepala = $this->Struktural_Model->insert_kepala($data_kepala);
    
        // Insert data into pegawai table for each tujuan
        $id_ds_pegawai = [];
        if (!empty($tujuan)) {
            foreach ($tujuan as $id_user_fungsional) {
                $data_pegawai = [
                    'id_user' => $id_user_fungsional,
                    'id_surat' => $id_ds_surat,
                    'id_ds_kepala' => $id_ds_kepala,
                ];
                $id_ds_pegawai[] = $this->Struktural_Model->insert_pegawai($data_pegawai); // Collect the IDs of the inserted records
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
                $no_disposisi_array[] = $this->Struktural_Model->insert_disposisi($data_disposisi); // Collect the no_disposisi values
            }
        }
    
        // Update surat table with the collected no_disposisi
        if (!empty($no_disposisi_array)) {
            $no_disposisi = implode(',', $no_disposisi_array); // Combine all no_disposisi values into a comma-separated string
            $this->Struktural_Model->update_surat_disposisi($no_surat, $no_disposisi);
        }
    
        // Update surat status based on tindak lanjut
        if ($tindak_lanjut == 'diteruskan') {
            $this->Struktural_Model->update_surat_disposisi($no_surat, $no_disposisi);
        }
    
        // Set flashdata and pass data to the view
        $data = [
            'success' => 'Surat berhasil didisposisi'
        ];
        $this->load->view('struktural/index', $data); // Use your desired view
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
        $this->Struktural_Model->insert_kepala($data);
    
        if ($tindak_lanjut == 'dilaksanakan') {
            $this->Struktural_Model->update_surat_tgl_dilaksanakan($no_surat);
            $this->Struktural_Model->update_surat_status($no_surat, 'dilaksanakan');
        } elseif ($tindak_lanjut == 'diteruskan') {
            $this->Struktural_Model->update_surat_disposisi($no_surat);
            $data = [
                'user_id' => $id_user,
                'no_surat' => $no_surat
            ];
            
            $this->load->view('struktural/surat', $data); // Send data to the view without using URL
        }
    
        // Set flashdata and pass data to the view if necessary
        $data = [
            'success' => 'Surat berhasil diproses'
        ];
        $this->load->view('struktural/index', $data); // Redirect or load a view as needed
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
        $user_id = $this->input->post('user_id');
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