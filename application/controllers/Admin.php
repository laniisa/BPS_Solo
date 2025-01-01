<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Surat_Model');
        $this->load->model('User_Model');
        $this->load->model('Pegawai_Model');
        $this->load->library('pagination');

        if (!$this->session->userdata('email')) {
            redirect('login');
        }
        

    }

    public function index() {
        if (!$this->session->userdata('email')) {
            redirect('login');
        }
    
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('users', ['email' => $email])->row_array();
        $data['title'] = 'Dashboard';
    
        // Data Info Box
        $data['jumlah_surat'] = $this->Surat_Model->get_jumlah_surat();
        $data['total_users'] = $this->User_Model->get_jumlah_user();
    
        $tahun = $this->input->get('tahun') ?: date('Y'); // Default tahun sekarang

        $data['tahun'] = $tahun;
        $data['tahun_surat'] = $this->Surat_Model->get_tahun_surat(); // Daftar tahun untuk dropdown
        $status_data = $this->Surat_Model->get_status_data($tahun); // Data surat berdasarkan status

        // Ekstraksi data untuk grafik
        $data['bulan'] = array_keys($status_data);
        $data['masuk'] = array_column($status_data, 'masuk');
        $data['dilaksanakan'] = array_column($status_data, 'dilaksanakan');
        $data['diteruskan'] = array_column($status_data, 'diteruskan');

        // Data User Roles Chart
        $data['data_user_roles'] = $this->User_Model->get_user_roles_count();
    
        // Load views
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
    $data['title'] = 'Surat';
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

    $data['title'] = 'Insert Surat';
    $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();


        $data['title'] = 'Tambah Surat';
        $data['surat'] = $this->Surat_Model->get_all_surat();
        $data['kepala'] = $this->User_Model->get_users_by_role(1);
        $this->load->model('Surat_Model');
    
        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/insert_surat', $data); // Ensure this view exists
        $this->load->view('template_admin/footer');
}

public function save_surat() {
    $this->load->library('upload');

    // Konfigurasi upload file
    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'pdf';
    $config['max_size'] = 2048;

    // Mengambil tanggal surat dari inputan form
    $tgl_surat = $this->input->post('tgl_surat');
    $no_surat = $this->input->post('no_surat');

    // Mengambil ekstensi file asli
    $file_ext = pathinfo($_FILES['berkas']['name'], PATHINFO_EXTENSION);
    $new_file_name = $no_surat.'-' . $tgl_surat . '.' . $file_ext;


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
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Surat berhasil ditambahkan!</div>');
            
        // Redirect ke halaman daftar surat
        redirect('admin/surat');
    }
}
    
    public function update_surat($id) {
        if (!$this->session->userdata('email')) {
            redirect('login');
        }
    
        $data['title'] = 'Update Surat';
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    
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
        // Validasi form
        $this->form_validation->set_rules('no_surat', 'No Surat', 'required');
        $this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'required');
        $this->form_validation->set_rules('perihal', 'Perihal', 'required');
        $this->form_validation->set_rules('asal', 'Asal', 'required');
        $this->form_validation->set_rules('jenis_surat', 'Jenis Surat', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
    
        // Validasi file upload
        if ($_FILES['berkas']['name'] != '') {
            $this->form_validation->set_rules('berkas', 'Berkas', 'callback_check_berkas');
        }
    
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, set flash message dan redirect
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data tidak lengkap!</div>');
            redirect('admin/update_surat/' . $this->input->post('id_ds_surat'));
        } else {
            // Ambil ID dan file baru jika ada
            $id = $this->input->post('id_ds_surat');
            $berkas_baru = $this->upload_berkas();
            
            $data = [
                'no_surat' => $this->input->post('no_surat'),
                'tgl_surat' => $this->input->post('tgl_surat'),
                'tgl_input' => date('Y-m-d'), // Sesuaikan jika perlu
                'tgl_dilaksanakan' => $this->input->post('tgl_dilaksanakan'),
                'perihal' => $this->input->post('perihal'),
                'asal' => $this->input->post('asal'),
                'jenis_surat' => $this->input->post('jenis_surat'),
                'status' => $this->input->post('status'),
                'user_id' => $this->input->post('user_id')
            ];
    
            // Tambahkan file baru jika di-upload
            if ($berkas_baru) {
                $data['berkas'] = $berkas_baru;
            }
    
            // Update surat
            $this->Surat_Model->update_surat($id, $data);
    
            // Set pesan sukses dan redirect
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Surat berhasil diperbarui!</div>');
            redirect('admin/surat');
        }
    }
    
    // Callback validasi untuk file berkas
    public function check_berkas() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 2048;
    
        $this->load->library('upload', $config);
    
        if (!$this->upload->do_upload('berkas')) {
            $this->form_validation->set_message('check_berkas', $this->upload->display_errors());
            return false;
        }
        return true;
    }
    
    
    private function upload_berkas() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 2048;
        
        // Memuat library upload
        $this->load->library('upload', $config);
    
        // Menentukan nama file baru berdasarkan 'no_surat' dan 'tgl_surat'
        $no_surat = $this->input->post('no_surat');
        $tgl_surat = $this->input->post('tgl_surat');
        $file_ext = pathinfo($_FILES['berkas']['name'], PATHINFO_EXTENSION);
        $new_file_name = $no_surat . ' - ' . $tgl_surat . '.' . $file_ext;
    
        // Mengubah nama file yang diupload
        $config['file_name'] = $new_file_name;
    
        // Cek jika upload berhasil
        if ($this->upload->do_upload('berkas')) {
            return $this->upload->data('file_name');
        } else {
            // Mengambil file lama jika tidak ada upload baru
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
    

    // Admin.php (Controller)

// Admin.php (Controller)
public function edit_status($id_user) {
    if (!$this->session->userdata('email')) {
        redirect('login');
    }
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
    if (!$this->session->userdata('email')) {
        redirect('login'); 
    }
    $data['title'] = 'Data Users';
    $email = $this->session->userdata('email');
    $data['user'] = $this->db->get_where('users', ['email' => $email])->row_array();


    $this->load->library('pagination');

    $config['base_url'] = site_url('admin/operator');
    $config['total_rows'] = $this->db->count_all('users'); 
    $config['per_page'] = 10; 
    $config['uri_segment'] = 3; 
    $this->pagination->initialize($config);

    
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    $this->db->limit($config['per_page'], $page);
    $data['users'] = $this->db->get('users')->result_array(); 

   
    $this->load->view('template_admin/navbar', $data);
    $this->load->view('template_admin/sidebar', $data);
    $this->load->view('admin/operator', $data);
    $this->load->view('template_admin/footer');
}

public function filter_user() {
    $role = $this->input->get('role');
    if ($role == 'all') {
        $users = $this->db->get('users')->result_array(); 
    } else {
        $this->db->where('role', $role);
        $users = $this->db->get('users')->result_array(); 
    }
    echo json_encode($users); 
}

    
public function insert_op() {
    if (!$this->session->userdata('email')) {
        redirect('login');
    }

    $data['title'] = 'Update Surat';
    $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

    $data['roles'] = $this->User_Model->get_roles();  
    $this->load->view('template_admin/navbar', $data);
    $this->load->view('template_admin/sidebar', $data);
    $this->load->view('admin/insert_op', $data);
    $this->load->view('template_admin/footer');
    
}

public function insert_user() {
    $this->form_validation->set_rules('nama', 'Nama', 'required');
    $this->form_validation->set_rules('usr', 'Username', 'required|is_unique[users.usr]');
    $this->form_validation->set_rules('role', 'Role', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('whatsApp', 'WhatsApp', 'required');
    $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
    $this->form_validation->set_rules('status', 'Status', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
    $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'required|matches[password]');

    if ($this->form_validation->run() == FALSE) {
        // Reload the form view with validation errors and roles data
        $this->insert_op();
    } else {
        // Handle file upload for Foto
        $foto = '';
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path'] = './assets/img/foto-users/'; 
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048; 
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $foto = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('message', $this->upload->display_errors());
                redirect('admin/insert_op');
                return;
            }
        }
        $status = $this->input->post('status');  

        
        $data_user = [
            'nama' => $this->input->post('nama'),
            'usr' => $this->input->post('usr'),
            'role' => $this->input->post('role'),
            'email' => $this->input->post('email'),
            'whatsApp' => $this->input->post('whatsApp'),
            'jabatan' => $this->input->post('jabatan'),
            'status' => $this->input->post('status'),
            'foto' => $foto, // Simpan nama file foto
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
        ];

        // Insert user data into database
        if ($this->User_Model->insert_user($data_user)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Users berhasil ditambahkan!</div>');
            redirect('admin/operator');
        } else {
            $this->session->set_flashdata('message', 'Failed to add user.');
            redirect('admin/insert_op');
        }
    }
    }



    public function users_list() {
        $data['users'] = $this->User_Model->get_all_users();
        $this->load->view('admin/users_list', $data);
    }

    public function update_op($id_user)
    {
    if (!$this->session->userdata('email')) {
        redirect('login');
    }

    $data['title'] = 'Update User';
    $data['current_user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

    $data['user'] = $this->User_Model->get_user_by_id($id_user);
    if (!$data['user']) {
        show_404();
        return;
    }
    $data['roles'] = $this->User_Model->get_roles();


    $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
    $this->form_validation->set_rules('usr', 'Username', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
    $this->form_validation->set_rules('role', 'Role', 'required');
    $this->form_validation->set_rules('status', 'Status', 'required');
    $this->form_validation->set_rules('password', 'Password', 'min_length[8]|trim'); // Opsional

    // Jika validasi gagal
    if ($this->form_validation->run() == FALSE) {
        // **Load semua views di bagian bawah setelah semua data diproses**
        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data); // Sidebar menampilkan data user login
        $this->load->view('admin/update_op', $data); // Form update user
        $this->load->view('template_admin/footer');
    } else {
        // Proses update data jika validasi berhasil
        $update_data = [
            'nama' => $this->input->post('nama', true),
            'usr' => $this->input->post('usr', true),
            'email' => $this->input->post('email', true),
            'role' => $this->input->post('role'),
            'status' => $this->input->post('status'),
            'jabatan' => $this->input->post('jabatan'),
            'whatsApp' => $this->input->post('whatsApp'),
        ];

        // Proses upload foto baru
        $foto = $data['user']['foto']; // Gunakan foto lama sebagai default
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path'] = './assets/img/foto-users/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048; // Maks 2MB
            $config['file_name'] = uniqid(); // Buat nama file unik

            // Pastikan folder ada
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0755, true);
            }

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                // Hapus foto lama jika ada dan bukan foto default
                if (file_exists('./assets/img/foto-users/' . $foto) && $foto != 'default.jpg') {
                    unlink('./assets/img/foto-users/' . $foto);
                }
                $foto = $this->upload->data('file_name');
            } else {
                // Jika upload gagal, tampilkan pesan kesalahan
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Upload gagal: ' . $this->upload->display_errors('', '') . '</div>');
                redirect("admin/update_op/$id_user");
                return;
            }
        }

        // Masukkan foto ke data yang akan di-update
        $update_data['foto'] = $foto;

        // Jika password diisi, update password
        if ($this->input->post('password') !== '') {
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $update_data['password'] = $password;
        }

        // Update data user ke database
        $this->User_Model->update_user($id_user, $update_data);

        // Beri flash message sukses
        $this->session->set_flashdata('message', '<div class="alert alert-success">User berhasil diperbarui.</div>');

        // Redirect ke halaman operator
        redirect('admin/operator');
    }
}

    public function delete_op($id) {
        // Pastikan hanya pengguna yang sudah login yang bisa mengakses halaman ini
        if (!$this->session->userdata('email')) {
            redirect('login');
        }

        $this->User_Model->delete_user($id);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User berhasil dihapus.</div>');
        redirect('admin/operator');
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


    public function detail_surat($id) {
        if (!$this->session->userdata('email')) {
            redirect('login');
        }

        $data['title'] = 'Detail Surat';
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
    
        // Ambil data surat berdasarkan ID
        $data['surat'] = $this->Surat_Model->get_surat_by_id($id);
    
        // Jika surat tidak ditemukan, redirect ke halaman daftar surat
        if (!$data['surat']) {
            redirect('admin/surat');
        }
    
        // Ambil catatan pegawai berdasarkan ID surat
        $data['catatan_pegawai'] = $this->Surat_Model->get_catatan_pegawai_by_surat($id);
    
        // Tambahkan tanggal dilaksanakan jika ada
        $data['tgl_dilaksanakan'] = $data['surat']['tgl_dilaksanakan'];
    
        // Load views
        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/detail_surat', $data);
        $this->load->view('template_admin/footer');
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
        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/profile', $data);
        $this->load->view('template_admin/footer');
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
        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/update_profile', $data);
        $this->load->view('template_admin/footer');
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
                    redirect('admin/update_profile');
                }
            }
            

            // Update data pengguna
            $this->User_Model->update_user($id_user, $data);
            $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
            redirect('admin/profile');
        }
    }
    
    
}


?>