<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operator extends CI_Controller {

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

    public function index(){
    if (!$this->session->userdata('email')) {
        redirect('login');
    }

    $data['title'] = ' Operator ';
    $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

    $data['jumlah_surat'] = $this->Surat_Model->get_jumlah_surat();
    $data['surat_dilaksanakan'] = $this->Surat_Model->get_surat_dilaksanakan();
    $data['surat_masuk'] = $this->Surat_Model->get_surat_masuk();

    // Get list of surat (letters) from the Surat_Model
    $data['surat'] = $this->Surat_Model->get_all_surat(); // Fetch all surat
    $data['struktural_users'] = $this->User_Model->get_users_by_role(1);
    
    // Load view with the collected data
    $this->load->view('template/navbar', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('operator/index', $data); // Ensure this view is created to display surat
    $this->load->view('template/footer');
    }


    public function dashboard() {
        if (!$this->session->userdata('email')) {
            log_message('error', 'Email session not found');
            redirect('login');
        }
    
        $email = $this->session->userdata('email');
    
        // Get user information
        $data['user'] = $this->db->get_where('users', ['email' => $email])->row_array();
    
        
        $data['title'] = 'Tambah Surat';
        $data['surat'] = $this->Surat_Model->get_all_surat();

        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('operator/index', $data);
        $this->load->view('template/footer');
    }

    public function update_tujuan() {
        $id_ds_surat = $this->input->post('id_ds_surat');
        $user_id = $this->input->post('tujuan');
        
        $data = array(
            'user_id' => $user_id
        );

        $this->Surat_Model->update_surat($id_ds_surat, $data);

        echo json_encode(array('status' => 'success'));
    }


    public function insert_surat() {
        if (!$this->session->userdata('email')) {
            redirect('login');
        }
    
        $data['title'] = 'Insert Surat';
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    

            $data['title'] = 'Tambah Surat';
            $data['surat'] = $this->Surat_Model->get_all_surat();
            $data['kepala'] = $this->User_Model->get_users_by_role(1);
            $this->load->model('Surat_Model');
        
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('operator/insert_surat', $data);
        $this->load->view('template/footer');
    }

    public function save_surat() {
        $this->load->library('upload');
    
        // Konfigurasi upload file
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 2048;
    
        // Mengambil tanggal surat dari inputan form
        $tgl_surat = $this->input->post('tgl_surat');
        $tahun = date('Y', strtotime($tgl_surat));
        $tanggal = date('Y-m-d', strtotime($tgl_surat));
    
        // Mengambil ekstensi file asli
        $file_ext = pathinfo($_FILES['berkas']['name'], PATHINFO_EXTENSION);
        $new_file_name = $tahun . '-' . $tanggal . '.' . $file_ext;
    
        // Set nama file yang akan diupload
        $config['file_name'] = $new_file_name;
    
        $this->upload->initialize($config);
    
        if (!$this->upload->do_upload('berkas')) {
            // Menampilkan error upload
            echo $this->upload->display_errors();
        } else {
            // Mengambil data file yang diupload
            $file_data = $this->upload->data();
    
            // Data surat yang akan disimpan
            $data = array(
                'no_surat' => $this->input->post('no_surat'),
                'tgl_surat' => $this->input->post('tgl_surat'),
                'tgl_input' => $this->input->post('tgl_input'),
                'perihal' => $this->input->post('perihal'),
                'asal' => $this->input->post('asal'),
                'jenis_surat' => $this->input->post('jenis_surat'),
                'berkas' => $file_data['file_name'],
                'user_id' => $this->input->post('user_id'),
                'status' => $this->input->post('status') // Ambil status surat dari form
  
                
            );
    
            // Menyimpan data ke database
            $this->Surat_Model->insert_surat($data);
    
            // Redirect ke halaman daftar surat
            redirect('operator/index');
        }
    }
    
    public function update_surat($id) {
        if (!$this->session->userdata('email')) {
            redirect('login');
        }
    
        $data['title'] = 'Update Surat';
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    

        $data['title'] = 'Update Surat';
        $data['surat'] = $this->Surat_Model->get_surat_by_id($id);
        $data['kepala'] = $this->User_Model->get_users_by_role(1); // Mengambil user dengan role 1

        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('operator/update_surat', $data);
        $this->load->view('template/footer');
    }

    public function update_surat_action() {
        $this->form_validation->set_rules('no_surat', 'No Surat', 'required');
        $this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'required');
        $this->form_validation->set_rules('perihal', 'Perihal', 'required');
        $this->form_validation->set_rules('asal', 'Asal', 'required');
        $this->form_validation->set_rules('jenis_surat', 'Jenis Surat', 'required');
        $this->form_validation->set_rules('user_id', 'Tujuan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak lengkap!</div>');
            redirect('operator/update_surat/' . $this->input->post('id'));
        } else {
            $id = $this->input->post('id');
            $data = [
                'no_surat' => $this->input->post('no_surat'),
                'tgl_surat' => $this->input->post('tgl_surat'),
                'tgl_input' => $this->input->post('tgl_input'),
                'perihal' => $this->input->post('perihal'),
                'asal' => $this->input->post('asal'),
                'jenis_surat' => $this->input->post('jenis_surat'),
                'user_id' => $this->input->post('user_id'),
                'berkas' => $this->upload_berkas()
            ];

            if (empty($data['berkas'])) {
                unset($data['berkas']);
            }

            $this->Surat_Model->update_surat($id, $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Surat berhasil diperbarui!</div>');
            redirect('operator/index');
        }
    }

    private function upload_berkas() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 2048;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('berkas')) {
            return $this->upload->data('file_name');
        } else {
            return $this->input->post('berkas_lama');
        }
    }
    

    public function delete_surat($id) {
        $this->Surat_Model->delete_surat($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Surat berhasil dihapus</div>');
        redirect('operator/index');
    }

    public function surat()
{
    if (!$this->session->userdata('email')) {
        log_message('error', 'Email session not found');
        redirect('login');
    }

    $email = $this->session->userdata('email');

    // Load model
    $this->load->model('Surat_Model');

    // Get user information
    $data['user'] = $this->db->get_where('users', ['email' => $email])->row_array();

    // Get list of surat
    $data['surat'] = $this->Surat_Model->get_all_surat();

    // Load views with collected data
    $this->load->view('template/navbar', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('operator/surat', $data); // Ensure this view exists
    $this->load->view('template/footer');
}

public function detail($id) {
    if (!$this->session->userdata('email')) {
        redirect('login');
    }
    
    $data['title'] = 'Detail Surat';
    $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

    // Ambil data surat berdasarkan ID
    $data['surat'] = $this->Surat_Model->get_surat_by_id($id);

    // Jika surat tidak ditemukan, redirect ke halaman daftar surat
    if (!$data['surat']) {
        redirect('operator/surat');
    }

    // Ambil catatan pegawai berdasarkan ID surat
    $data['catatan_pegawai'] = $this->Surat_Model->get_catatan_pegawai_by_surat($id);

    // Tambahkan tanggal dilaksanakan jika ada
    $data['tgl_dilaksanakan'] = $data['surat']['tgl_dilaksanakan'];

    // Load views
    $this->load->view('template/navbar', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('operator/detail', $data);
    $this->load->view('template/footer');
}


public function rekap() {
    if (!$this->session->userdata('email')) {
        redirect('login');
    }

    $email = $this->session->userdata('email');
    $data['user'] = $this->db->get_where('users', ['email' => $email])->row_array();
    
    // Ambil data bulan dan tahun dari URL atau gunakan bulan dan tahun saat ini sebagai default
    $bulan = $this->input->get('bulan', TRUE);
    $tahun = $this->input->get('tahun', TRUE);
    
    // Jika tidak ada filter bulan atau tahun, tampilkan semua data
    if (!$bulan || !$tahun) {
        $data['rekap'] = $this->Surat_Model->get_rekapitulasi_all(); // Ambil semua data
    } else {
        $data['rekap'] = $this->Surat_Model->get_rekapitulasi($bulan, $tahun);
    }
    
    $data['bulan'] = $bulan;
    $data['tahun'] = $tahun;
    
    // Muat view dengan data yang diambil
    $this->load->view('template/navbar', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('operator/rekap', $data);
    $this->load->view('template/footer');
}

public function profile() {
    if (!$this->session->userdata('email')) {
        redirect('login');
    }

    // Ambil ID user dari session
    $id_user = $this->session->userdata('id_user');

    // Data yang dikirim ke view
    $data['title'] = 'Profile';
    $data['user'] = $this->User_Model->get_user_by_id($id_user);

    // Load template dan halaman profil
    $this->load->view('template/navbar', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('operator/profile', $data);
    $this->load->view('template/footer');
}

public function update_profile() {
    if (!$this->session->userdata('email')) {
        redirect('login');
    }

    // Ambil ID user dari session
    $id_user = $this->session->userdata('id_user');

    // Data yang dikirim ke view
    $data['title'] = 'Update Profile';
    $data['user'] = $this->User_Model->get_user_by_id($id_user);

    // Load template dan halaman update
    $this->load->view('template/navbar', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('operator/update_profile', $data);
    $this->load->view('template/footer');
}

public function update() {
    $id_user = $this->session->userdata('id_user');

    // Validasi form
    $this->form_validation->set_rules('nama', 'Nama', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'min_length[6]|matches[password_confirm]');
    $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'matches[password]');

    if ($this->form_validation->run() == FALSE) {
        $this->update_profile();
    } else {
        $data = [
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'whatsApp' => $this->input->post('whatsApp'),
            'jabatan' => $this->input->post('jabatan')
        ];

        // Update password jika diisi
        if (!empty($this->input->post('password'))) {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }

        // Jika ada upload foto
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path'] = './assets/img/foto-users/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048; // 2 MB
        
            $this->load->library('upload', $config);
        
            // Cek jika upload berhasil
            if ($this->upload->do_upload('foto')) {
                // Dapatkan nama foto lama dari database
                $old_foto = $this->input->post('old_foto');
                
                // Hapus foto lama jika ada
                if (!empty($old_foto) && file_exists(FCPATH . 'assets/img/foto-users/' . $old_foto)) {
                    unlink(FCPATH . 'assets/img/foto-users/' . $old_foto); // Menghapus foto lama
                }
        
                // Menyimpan nama file foto baru
                $data['foto'] = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('operator/update_profile');
            }
        }
        

        // Update data pengguna
        $this->User_Model->update_user($id_user, $data);
        $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
        redirect('operator/profile');
    }
}


}

    
?>