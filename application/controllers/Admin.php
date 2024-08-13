<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Surat_Model');
        $this->load->model('User_Model');
        $this->load->model('Kepala_Model');
        $this->load->model('Pegawai_Model');

        if (!$this->session->userdata('email')) {
            redirect('login');
        }
        

    }

    public function index()
    {
        if (!$this->session->userdata('email')) {
			redirect('login'); 
		}

        $email = $this->session->userdata('email');
		$data['user'] = $this->db->get_where('users', ['email' => $email])->row_array();
        $data['title'] = 'Dashboard';
        
        $data['jumlah_surat'] = $this->Surat_Model->get_jumlah_surat();
        $data['total_users'] = $this->User_Model->get_jumlah_user();
       
        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('template_admin/footer');
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
    $this->load->view('template_admin/navbar', $data);
    $this->load->view('template_admin/sidebar', $data);
    $this->load->view('admin/surat', $data); // Ensure this view exists
    $this->load->view('template_admin/footer');
}



    public function insert_surat() {
        if (!$this->session->userdata('email')) {
            redirect('login'); 
        }
    
        $data['title'] = 'Tambah Surat';
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    
        $this->load->model('Surat_Model');
        $data['surat'] = $this->Surat_Model->get_all_surat();
    
        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/insert_surat', $data);
        $this->load->view('template_admin/footer');
    }
    


    public function save_surat() {
        $this->form_validation->set_rules('no_surat', 'No Surat', 'required');
        $this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'required');
        $this->form_validation->set_rules('perihal', 'Perihal', 'required');
        $this->form_validation->set_rules('asal', 'Asal', 'required');
        $this->form_validation->set_rules('jenis_surat', 'Jenis Surat', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Tambah Surat - Admin';
            $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    
            $this->load->view('template_admin/navbar', $data);
            $this->load->view('template_admin/sidebar', $data);
            $this->load->view('admin/insert_surat', $data);
            $this->load->view('template_admin/footer');
        } else {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 2048; // 2MB
    
            $this->load->library('upload', $config);
    
            if (!$this->upload->do_upload('berkas')) {
                $data['error'] = $this->upload->display_errors();
                $data['title'] = 'Tambah Surat - Admin';
                $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    
                $this->load->view('template_admin/navbar', $data);
                $this->load->view('template_admin/sidebar', $data);
                $this->load->view('admin/insert_surat', $data);
                $this->load->view('template_admin/footer');
            } else {
                $file_data = $this->upload->data();
                $data = [
                    'no_surat' => $this->input->post('no_surat'),
                    'tgl_surat' => $this->input->post('tgl_surat'),
                    'tgl_input' => date('Y-m-d H:i:s'),
                    'perihal' => $this->input->post('perihal'),
                    'asal' => $this->input->post('asal'),
                    'jenis_surat' => $this->input->post('jenis_surat'),
                    'berkas' => $file_data['file_name'],
                    'status' => $this->input->post('status') // Jika status dibutuhkan
                ];
    
                $this->load->model('Surat_Model');
                $this->Surat_Model->insert_surat($data);
                $this->session->set_flashdata('message', '<div class="alert alert-success">Surat berhasil ditambahkan</div>');
                redirect('admin/surat');
            }
        }
    }
    
    public function update_surat($id) {
        if (!$this->session->userdata('email')) {
            redirect('login');
        }
    
        $data['title'] = 'Update Surat';
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    
        // Debugging: Lihat ID yang diterima
        echo "ID yang diterima: " . $id;
    
        // Mengambil data surat berdasarkan ID
        $this->load->model('Surat_Model');
        $data['surat'] = $this->Surat_Model->get_surat_by_id($id);
    
        if (!$data['surat']) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Surat tidak ditemukan!</div>');
            redirect('admin/surat');
        }
    
        // Memuat view
        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/update_surat', $data);
        $this->load->view('template_admin/footer');
    }
    
    
    
    public function update_surat_action() {
        $this->form_validation->set_rules('no_surat', 'No Surat', 'required');
        $this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'required');
        $this->form_validation->set_rules('perihal', 'Perihal', 'required');
        $this->form_validation->set_rules('asal', 'Asal', 'required');
        $this->form_validation->set_rules('jenis_surat', 'Jenis Surat', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak lengkap!</div>');
            redirect('admin/update_surat/' . $this->input->post('id_ds_surat'));
        } else {
            $id = $this->input->post('id_ds_surat');
            $data = [
                'no_surat' => $this->input->post('no_surat'),
                'tgl_surat' => $this->input->post('tgl_surat'),
                'tgl_input' => $this->input->post('tgl_input'),
                'tgl_disposisi' => $this->input->post('tgl_disposisi'),
                'tgl_dilaksanakan' => $this->input->post('tgl_dilaksanakan'),
                'perihal' => $this->input->post('perihal'),
                'asal' => $this->input->post('asal'),
                'jenis_surat' => $this->input->post('jenis_surat'),
                'status' => $this->input->post('status'),
                'user_id' => $this->input->post('user_id'),
                'berkas' => $this->upload_berkas()
            ];
    
            if (empty($data['berkas'])) {
                unset($data['berkas']);
            }
    
            // Update data surat
            $this->Surat_Model->update_surat($id, $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Surat berhasil diperbarui!</div>');
            redirect('admin/surat');
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
        if (!$this->session->userdata('email')) {
            redirect('login');
        }

        if ($this->Surat_Model->delete_surat($id)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success">Surat berhasil dihapus</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Surat gagal dihapus</div>');
        }
        
        redirect('admin/surat');
    }


    private function _upload_berkas($no_disposisi, $no_surat, $existing_file = null) 
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 2048;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('berkas')) {
            $file_data = $this->upload->data();
            $new_file_name = $no_disposisi . '_' . $no_surat . $file_data['file_ext'];
            rename($file_data['full_path'], $file_data['file_path'] . $new_file_name);
            return $new_file_name;
        } else {
            return $existing_file;
        }
    }
    public function users() {
        if (!$this->session->userdata('email')) {
            redirect('login');
        }
    
        $role = $this->input->get('role'); // Get the role filter from the URL
        if ($role == 'all' || $role == '') {
            $data['users'] = $this->User_Model->get_all_users();
        } else {
            $data['users'] = $this->User_Model->get_users_by_role($role);
        }
    
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('users', ['email' => $email])->row_array();
    
        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/user', $data);
        $this->load->view('template_admin/footer');
    }
    
    public function filter_users() {
        $role = $this->input->get('role');
        if ($role == 'all') {
            $users = $this->User_Model->get_all_users();
        } else {
            $users = $this->User_Model->get_users_by_role($role);
        }
        echo json_encode($users);
    }
    

    public function admin()
    {
        if (!$this->session->userdata('email')) {
			redirect('login'); 
		}

        $data['title'] = 'Daftar Admin';
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $data['users'] = $this->User_Model->get_users_by_role(0); // Get users with role 0 (Admin)

        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/admin', $data);
        $this->load->view('template_admin/footer');
    }

    // Admin.php (Controller)

// Admin.php (Controller)
public function edit_status($id_user) {
    $status = $this->input->post('status');
    
    // Debugging: periksa apakah ID dan status diterima dengan benar
    error_log("ID: $id_user, Status: $status"); // Logging
    
    if ($id_user && $status !== null) {
        // Update status berdasarkan id_user
        if ($this->User_Model->update_status($id_user, $status)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Status berhasil diupdate!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal mengupdate status!</div>');
        }
    } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Status harus diisi!</div>');
    }
    
    // Redirect ke halaman daftar admin
    redirect('admin/operator');
}


    public function operator() {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('users', ['email' => $email])->row_array();

        // Load library pagination
        $this->load->library('pagination');

        // Konfigurasi pagination
        $config['base_url'] = site_url('admin/operator');
        $config['total_rows'] = $this->db->count_all('users'); // Jumlah total data
        $config['per_page'] = 10; // Jumlah data per halaman
        $config['uri_segment'] = 3; // Uri segment untuk pagination

        // Inisialisasi pagination
        $this->pagination->initialize($config);

        // Ambil data sesuai halaman yang sedang diakses
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['users'] = $this->db->get('users', $config['per_page'], $page)->result_array();
        $data['pagination'] = $this->pagination->create_links();

        // Tampilkan view dengan data
        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/operator', $data);
        $this->load->view('template_admin/footer');
    }

    public function filter_user() {
        $role = $this->input->get('role');
        if (strtolower($role) == 'all') {
            $users = $this->User_Model->get_all_user();
        } else {
            $role_id = null;
            switch (strtolower($role)) {
                case 'admin':
                    $role_id = 0;
                    break;
                case 'struktural':
                    $role_id = 1;
                    break;
                case 'fungsional':
                    $role_id = 2;
                    break;
                case 'operator':
                    $role_id = 3;
                    break;
            }
            if ($role_id !== null) {
                $users = $this->User_Model->get_users_by_role($role_id);
            } else {
                $users = [];
            }
        }
        echo json_encode($users);
    }


    
    public function insert_op() {
        // Pastikan hanya pengguna yang sudah login yang bisa mengakses halaman ini
        if (!$this->session->userdata('email')) {
            redirect('login');
        }

        $data['title'] = 'Tambah User';
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('role', 'Role', 'required|trim');
        $this->form_validation->set_rules('usr', 'Username', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('whatsApp', 'WhatsApp', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');

        if ($this->form_validation->run() == false) {
            // Validasi form gagal, tampilkan kembali halaman tambah user dengan pesan error
            $this->load->view('template_admin/navbar', $data);
            $this->load->view('template_admin/sidebar', $data);
            $this->load->view('admin/insert_op', $data);
            $this->load->view('template_admin/footer');
        } else {
            // Validasi form berhasil, lanjutkan ke proses penyimpanan user baru
            $this->save_op();
        }
    }

    public function save_op() {
        // Pastikan hanya pengguna yang sudah login yang bisa mengakses halaman ini
        if (!$this->session->userdata('email')) {
            redirect('login');
        }

        $data = [
            'nama' => htmlspecialchars($this->input->post('nama', true)),
            'role' => htmlspecialchars($this->input->post('role', true)),
            'status' => 'active',
            'usr' => htmlspecialchars($this->input->post('usr', true)),
            'email' => htmlspecialchars($this->input->post('email', true)),
            'whatsApp' => htmlspecialchars($this->input->post('whatsApp', true)),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
        ];

        $this->User_Model->insert_user($data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User baru berhasil ditambahkan.</div>');
        redirect('admin/operator');
    }

    public function update_op($id) {
        // Ambil data pengguna dari model
        $data['user'] = $this->User_Model->get_user_by_id($id);
        
        if (empty($data['user'])) {
            show_404(); // Jika pengguna tidak ditemukan
        }

        // Atur aturan validasi
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[0,1,2,3]');
        $this->form_validation->set_rules('status', 'Status', 'required|in_list[active,inactive]');
        $this->form_validation->set_rules('usr', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('whatsApp', 'WhatsApp', 'required');
        $this->form_validation->set_rules('password', 'Password', 'min_length[6]');

        if ($this->form_validation->run() === FALSE) {
            // Jika validasi gagal, tampilkan form edit dengan pesan error
            $this->load->view('template_admin/navbar');
            $this->load->view('template_admin/sidebar');
            $this->load->view('admin/update_op', $data);
            $this->load->view('template_admin/footer');
        } else {
            // Ambil data dari form
            $update_data = [
                'nama' => $this->input->post('nama'),
                'role' => $this->input->post('role'),
                'status' => $this->input->post('status'),
                'usr' => $this->input->post('usr'),
                'email' => $this->input->post('email'),
                'whatsApp' => $this->input->post('whatsApp')
            ];

            // Periksa apakah password diisi, jika ya tambahkan ke data update
            $password = $this->input->post('password');
            if (!empty($password)) {
                $update_data['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            // Update data pengguna
            if ($this->User_Model->update_user($id, $update_data)) {
                $this->session->set_flashdata('message', 'User updated successfully.');
                redirect('admin/operator');
            } else {
                $this->session->set_flashdata('message', 'Failed to update user.');
                redirect('admin/update_op/' . $id);
            }
        }
    }

    public function update_user($id) {
        // Pastikan hanya pengguna yang sudah login yang bisa mengakses halaman ini
        if (!$this->session->userdata('email')) {
            redirect('login');
        }

        $data = [
            'nama' => htmlspecialchars($this->input->post('nama', true)),
            'role' => htmlspecialchars($this->input->post('role', true)),
            'status' => htmlspecialchars($this->input->post('status', true)),
            'usr' => htmlspecialchars($this->input->post('usr', true)),
            'email' => htmlspecialchars($this->input->post('email', true)),
            'whatsApp' => htmlspecialchars($this->input->post('whatsApp', true))
        ];

        // Update password jika diisi
        if ($this->input->post('password')) {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }

        $this->User_Model->update_user($id, $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User berhasil diupdate.</div>');
        redirect('admin/operator');
    }

    public function delete_user($id) {
        // Pastikan hanya pengguna yang sudah login yang bisa mengakses halaman ini
        if (!$this->session->userdata('email')) {
            redirect('login');
        }

        $this->User_Model->delete_user($id);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User berhasil dihapus.</div>');
        redirect('users');
    }

    
    public function berkas() {
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
        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/berkas', $data);
        $this->load->view('template_admin/footer');
    }
    
    
    
    public function filter_surat() {
        // Ambil parameter tanggal dari query string dengan XSS filtering
        $tanggal_awal = $this->input->get('tanggal_awal', true); 
        $tanggal_akhir = $this->input->get('tanggal_akhir', true);
    
        // Validasi input tanggal
        $tanggal_awal = !empty($tanggal_awal) ? $tanggal_awal : null;
        $tanggal_akhir = !empty($tanggal_akhir) ? $tanggal_akhir : null;
    
        // Ambil data surat yang sudah difilter menggunakan model
        $this->load->model('Surat_Model'); // Pastikan model di-load
        $data['surat'] = $this->Surat_Model->get_filtered_surat($tanggal_awal, $tanggal_akhir);
    
        // Kirim data dalam format JSON
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data['surat']));
    }

    public function detail_surat($id) {
        $data['surat'] = $this->Surat_Model->get_surat_by_id($id);

        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/detail_surat', $data);
        $this->load->view('template_admin/footer');
    }
}


?>