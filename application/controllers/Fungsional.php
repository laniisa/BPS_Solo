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
    
        $this->load->view('template_struk/header', $data);
        $this->load->view('fungsional/index', $data);
        $this->load->view('template_struk/footer');
    }
    public function diteruskan() {
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
        $this->load->view('fungsional/diteruskan', $data);
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
            // Redirect to surat.php with necessary parameters
            redirect('fungsional/diteruskan?no_surat=' . urlencode($no_surat) . '&user_id=' . urlencode($user_id));
        } else {
            // Handle invalid tindakan_lanjut value
            $this->session->set_flashdata('error', 'Tindak lanjut tidak valid.');
            redirect('fungsional');
        }
    }


    public function proses_tujuan() {
        $catatan_kepala = $this->input->post('catatan_kepala');
        $tindak_lanjut = $this->input->post('tindak_lanjut');
        $no_surat = $this->input->post('no_surat');
        $tujuan = $this->input->post('tujuan'); // Array of user IDs
    
        // Mulai Transaksi
        $this->db->trans_start();
    
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
        $id_ds_kepala = $this->db->insert_id();


        $id_ds_pegawai = [];
        $tanggal_sekarang = date('Y-m-d H:i:s'); // Atau format tanggal sesuai dengan kebutuhan

        if (!empty($tujuan)) {
            foreach ($tujuan as $id_user_fungsional) {
                // Data untuk tabel pegawai
                $data_pegawai = [
                    'id_user' => $id_user_fungsional,
                    'id_surat' => $id_ds_surat,
                    'id_ds_kepala' => $id_ds_kepala,
                    'tanggal' => $tanggal_sekarang, // Tambahkan tanggal
                ];
                $this->db->insert('pegawai', $data_pegawai);
                $id_ds_pegawai[] = $this->db->insert_id();
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
        $this->load->view('fungsional/diteruskan', $data);
        redirect('fungsional');
    }
    


    
    
    


}
?>