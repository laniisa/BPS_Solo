<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Surat_Model');
        $this->load->model('User_Model');

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
        $data['title'] = 'Daftar Surat';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['surat'] = $this->Surat_Model->get_all_surat();

        $this->load->view('template_admin/navbar', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/surat', $data);
        $this->load->view('template_admin/footer');
    }

    public function insert_surat()
    {
        $this->form_validation->set_rules('no_surat', 'No Surat', 'required');
        $this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'required');
        $this->form_validation->set_rules('perihal', 'Perihal', 'required');
        $this->form_validation->set_rules('asal', 'Asal', 'required');
        $this->form_validation->set_rules('jenis_surat', 'Jenis Surat', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Tambah Surat';
            $this->load->view('template_admin/navbar', $data);
            $this->load->view('template_admin/sidebar', $data);
            $this->load->view('admin/insert_surat', $data);
            $this->load->view('template_admin/footer');
        } else {
            $file_data = $this->upload->data();
            $data = [
                'no_disposisi' => $this->input->post('no_disposisi'),
                'no_surat' => $this->input->post('no_surat'),
                'tgl_surat' => $this->input->post('tgl_surat'),
                'tgl_input' => date('Y-m-d H:i:s'),
                'tgl_disposisi' => $this->input->post('tgl_disposisi'),
                'tgl_dilaksanakan' => $this->input->post('tgl_dilaksanakan'),
                'perihal' => $this->input->post('perihal'),
                'asal' => $this->input->post('asal'),
                'jenis_surat' => $this->input->post('jenis_surat'),
               'berkas' => $file_data['file_name'],
                'status' => $this->input->post('status')
            ];
            // Debugging Log
            log_message('debug', 'Data to insert: ' . json_encode($data));

            if ($this->Surat_Model->insert_surat($data)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success">Surat berhasil ditambahkan.</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Surat gagal ditambahkan.</div>');
            }
            redirect('admin/surat');
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

    public function delete_surat($id)
    {
        $this->Surat_Model->delete_surat($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Surat berhasil dihapus.</div>');
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

    

}
?>