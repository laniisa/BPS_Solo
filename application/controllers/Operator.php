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

    public function index()
    {
    if (!$this->session->userdata('email')) {
        redirect('login'); 
    }
    
    $email = $this->session->userdata('email');
    
    // Get user information (add more as needed)
    $data['user'] = $this->db->get_where('users', ['usr' => $email])->row_array();
    
    // Get list of surat (letters) from the Surat_Model
    $data['surat'] = $this->Surat_Model->get_all_surat(); // Fetch all surat
    $data['struktural_users'] = $this->User_Model->get_user_by_role(1);
    
    // Load view with the collected data
    $this->load->view('template/navbar', $data);
    $this->load->view('template/sidebar', $data);
    $this->load->view('operator/index', $data); // Ensure this view is created to display surat
    $this->load->view('template/footer');
    }


    public function dashboard() {
        $data['title'] = 'Daftar Surat';
        $data['surat'] = $this->Surat_Model->get_all_surat();

        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('operator/index', $data);
        $this->load->view('template/footer');
    }

    public function update_tujuan()
{
    $id = $this->input->post('id_ds_surat');
    $tujuan = $this->input->post('tujuan');
    $this->Surat_Model->update_tujuan($id, $tujuan);
    echo json_encode(['status' => 'success']);
}


    public function insert_surat() {
        if (!$this->session->userdata('email')) {
            redirect('login');
        }

            $data['title'] = 'Tambah Surat';
            $data['surat'] = $this->Surat_Model->get_all_surat();
            $this->load->model('Surat_Model');
        
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('operator/insert_surat', $data);
        $this->load->view('template/footer');
    }

    public function save_surat() {
        $this->form_validation->set_rules('no_surat', 'No Surat', 'required');
        $this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'required');
        $this->form_validation->set_rules('perihal', 'Perihal', 'required');
        $this->form_validation->set_rules('asal', 'Asal', 'required');
        $this->form_validation->set_rules('jenis_surat', 'Jenis Surat', 'required');
        $this->form_validation->set_rules('tujuan_id', 'Tujuan', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            $this->insert_surat();
        } else {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 2048; // 2MB
    
            $this->load->library('upload', $config);
    
            if (!$this->upload->do_upload('berkas')) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">File upload failed: ' . $this->upload->display_errors() . '</div>');
                redirect('operator/index');
            } else {
                $file_data = $this->upload->data();
                $data = [
                    'no_surat' => $this->input->post('no_surat'),
                    'tgl_surat' => $this->input->post('tgl_surat'),
                    'tgl_input' => $this->input->post('tgl_input'),
                    'perihal' => $this->input->post('perihal'),
                    'asal' => $this->input->post('asal'),
                    'jenis_surat' => $this->input->post('jenis_surat'),
                    'berkas' => $file_data['file_name'],
                    'tujuan_id' => $this->input->post('tujuan_id') // Pastikan ini tidak null
                ];
    
                // Debugging Log
                log_message('debug', 'Save Surat Data: ' . print_r($data, true));
                
                $this->Surat_Model->insert_surat($data);
                $this->session->set_flashdata('message', '<div class="alert alert-success">Surat berhasil ditambahkan</div>');
                redirect('operator/index');
            }
        }
    }
    
    public function Update_surat($id) {
        if (!$this->session->userdata('email')) {
            redirect('login');
        }

        $data['title'] = "Edit Surat";
        $data['surat'] = $this->Surat_Model->get_surat_by_id($id);
        $data['users'] = $this->User_Model->get_users_by_role(2);

        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('operator/update_surat', $data);
        $this->load->view('template/footer');
        
    }

    public function update_surat_action()
    {
        $this->form_validation->set_rules('no_surat', 'No Surat', 'required');
        $this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'required');
        $this->form_validation->set_rules('tgl_input', 'Tanggal Input', 'required');
        $this->form_validation->set_rules('perihal', 'Perihal', 'required');
        $this->form_validation->set_rules('asal', 'Asal', 'required');
        $this->form_validation->set_rules('jenis_surat', 'Jenis Surat', 'required');
        $this->form_validation->set_rules('tujuan', 'Tujuan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $id = $this->input->post('id_ds_surat');
            $data['title'] = 'Update Surat';
            $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();
            $data['surat'] = $this->Surat_Model->get_surat_by_id($id);

            $this->load->view('template/navbar', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('operator/update_surat', $data);
            $this->load->view('template/footer');
        } else {
            $id = $this->input->post('id_ds_surat');

            $this->load->library('upload');
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 2048; // 2MB
            $this->upload->initialize($config);

            $data = [
                'no_surat' => $this->input->post('no_surat'),
                'tgl_surat' => $this->input->post('tgl_surat'),
                'tgl_input' => $this->input->post('tgl_input'),
                'perihal' => $this->input->post('perihal'),
                'asal' => $this->input->post('asal'),
                'jenis_surat' => $this->input->post('jenis_surat'),
                'tujuan' => $this->input->post('tujuan_id')
            ];

            if (!empty($_FILES['berkas']['name'])) {
                if ($this->upload->do_upload('berkas')) {
                    $file_data = $this->upload->data();
                    $data['berkas'] = $file_data['file_name'];
                }
            }

            $this->Surat_Model->update_surat($id, $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Surat berhasil diperbarui</div>');
            redirect('operator/index');
        }
    }

    public function delete_surat($id) {
        $this->Surat_Model->delete_surat($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success">Surat berhasil dihapus</div>');
        redirect('operator/index');
    }
}

    
?>