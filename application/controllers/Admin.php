<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Surat_Model');
        $this->load->model('User_Model');
        $this->load->model('Berkas_Model');

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
        $data['total_berkas'] = $this->Berkas_Model->get_jumlah_berkas();
       
        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('template_admin/footer');
    }


    public function surat()
    {
    if (!$this->session->userdata('email')) {
        redirect('login'); 
    }
    
    $this->load->model('Surat_Model'); // Load your model for handling surat data
    $email = $this->session->userdata('email');
    
    // Get user information (add more as needed)
    $data['user'] = $this->db->get_where('users', ['usr' => $email])->row_array();
    
    // Get list of surat (letters) from the Surat_Model
    $data['surat'] = $this->Surat_Model->get_all_surat(); // Fetch all surat
    
    // Load view with the collected data
    $this->load->view('template_admin/navbar', $data);
    $this->load->view('template_admin/sidebar', $data);
    $this->load->view('admin/surat', $data); // Ensure this view is created to display surat
    $this->load->view('template_admin/footer');
    }


    public function insert_surat() {
        if (!$this->session->userdata('email')) {
            redirect('login'); 
        }
    
        $data['title'] = 'Tambah Surat';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    
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
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    
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
                $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
    
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
    
    

    public function update_surat($id)
    {
        $this->form_validation->set_rules('no_surat', 'No Surat', 'required');
        $this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'required');
        $this->form_validation->set_rules('perihal', 'Perihal', 'required');
        $this->form_validation->set_rules('asal', 'Asal', 'required');
        $this->form_validation->set_rules('jenis_surat', 'Jenis Surat', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Update Surat';
            $data['surat'] = (array)$this->Surat_Model->get_surat_by_id($id);
            $this->load->view('template_admin/navbar', $data);
            $this->load->view('template_admin/sidebar', $data);
            $this->load->view('admin/update_surat', $data);
            $this->load->view('template_admin/footer');
        } else {
            $berkas = $this->_upload_berkas($this->input->post('no_disposisi'), $this->input->post('no_surat'), $this->input->post('berkas_lama'));
            $data = [
                'no_disposisi' => $this->input->post('no_disposisi'),
                'no_surat' => $this->input->post('no_surat'),
                'tgl_surat' => $this->input->post('tgl_surat'),
                'tgl_disposisi' => $this->input->post('tgl_disposisi'),
                'tgl_dilaksanakan' => $this->input->post('tgl_dilaksanakan'),
                'perihal' => $this->input->post('perihal'),
                'asal' => $this->input->post('asal'),
                'jenis_surat' => $this->input->post('jenis_surat'),
                'berkas' => $this->$berkas,
                'status' => $this->input->post('status')
            ];
            $this->Surat_Model->update_surat($id, $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Surat berhasil diperbarui.</div>');
            redirect('admin/surat');
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

        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('users', ['email' => $email])->row_array();

        $data['title'] = 'Users';
        $data['users_list'] = $this->User_Model->get_users();

        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/users', $data);
        $this->load->view('template_admin/footer');
    }

    public function admin()
    {
        if (!$this->session->userdata('email')) {
			redirect('login'); 
		}

        $data['title'] = 'Daftar Admin';
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $data['admins'] = $this->User_Model->get_users_by_role(0); // Get users with role 0 (Admin)

        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/admin', $data);
        $this->load->view('template_admin/footer');
    }

    public function struktural()
    {
        if (!$this->session->userdata('email')) {
			redirect('login'); 
		}

        $data['title'] = 'Daftar Admin';
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $data['admins'] = $this->User_Model->get_users_by_role(1); // Get users with role 0 (Admin)

        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/struktural', $data);
        $this->load->view('template_admin/footer');
    }

    public function fungsional()
    {
        if (!$this->session->userdata('email')) {
			redirect('login'); 
		}

        $data['title'] = 'Daftar Admin';
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $data['admins'] = $this->User_Model->get_users_by_role(2); // Get users with role 0 (Admin)

        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/fungsional', $data);
        $this->load->view('template_admin/footer');
    }



    public function berkas()
	{
		if (!$this->session->userdata('email')) {
			redirect('login'); 
		}

		$email = $this->session->userdata('email');
		$data['user'] = $this->db->get_where('users', ['email' => $email])->row_array();
        $data['users'] = $this->Berkas_Model->get_all_berkas();

        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/berkas', $data);
        $this->load->view('template_admin/footer');
	}

public function insert_berkas()
{
    // Pastikan hanya pengguna yang sudah login yang bisa mengakses halaman ini
    if (!$this->session->userdata('email')) {
        redirect('login');
    }

    $data['title'] = 'Tambah berkas';
    $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

    $this->form_validation->set_rules('id_surat', 'Id Surat', 'required|trim');
    $this->form_validation->set_rules('author', 'Autor', 'required|trim');
    $this->form_validation->set_rules('berkas', 'Berkas', 'required|trim');

    if ($this->form_validation->run() == false) {
        // Validasi form gagal, tampilkan kembali halaman ulasan dengan pesan error
        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/berkas', $data);
        $this->load->view('template_admin/footer');
    } else {
        // Validasi form berhasil, lanjutkan ke proses aksi ulasan
        $this->save_berkas();
    }
}

	
	public function save_berkas()
	{
		$username = $this->session->userdata('username');
	
		$ulasan = array(
			'username' => $username,
			'pesan' => htmlspecialchars($this->input->post('pesan', true)),
			'rating' => htmlspecialchars($this->input->post('rating', true)),
		);
	
		$this->Pelanggan_Model->insert_ulasan($ulasan);
	
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Ulasan Berhasil Dikirim.</div>');
		redirect('pelanggan/ulasan');
	}
    
    public function operator() {
        // Pastikan hanya pengguna yang sudah login yang bisa mengakses halaman ini
        if (!$this->session->userdata('email')) {
            redirect('login');
        }

        $data['title'] = 'Daftar Users';
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $data['users'] = $this->User_Model->get_all_user();

        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/operator', $data);
        $this->load->view('template_admin/footer');
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
        $this->form_validation->set_rules('status', 'Status', 'required|trim');
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
            'status' => htmlspecialchars($this->input->post('status', true)),
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
        // Pastikan hanya pengguna yang sudah login yang bisa mengakses halaman ini
        if (!$this->session->userdata('email')) {
            redirect('login');
        }

        $data['title'] = 'Edit User';
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
        $data['user_edit'] = $this->User_Model->get_users($id);

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('role', 'Role', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');
        $this->form_validation->set_rules('usr', 'Username', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('whatsApp', 'WhatsApp', 'required|trim');
        // Password tidak wajib diubah, hanya jika diisi
        $this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]');

        if ($this->form_validation->run() == false) {
            // Validasi form gagal, tampilkan kembali halaman edit user dengan pesan error
            $this->load->view('template_admin/navbar', $data);
            $this->load->view('template_admin/sidebar', $data);
            $this->load->view('admin/update_op', $data);
            $this->load->view('template_admin/footer');
        } else {
            // Validasi form berhasil, lanjutkan ke proses update user
            $this->update_user($id);
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
}
?>