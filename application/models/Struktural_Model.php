<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktural_Model extends CI_Model {

    public function get_surat_by_no_surat_and_user($no_surat, $user_id) {
        $this->db->select('surat.*');
        $this->db->from('surat');
        $this->db->join('pegawai', 'pegawai.id_surat = surat.id_ds_surat', 'left');
        $this->db->where('surat.no_surat', $no_surat);
        $this->db->where('pegawai.id_user', $user_id);
        
        $query = $this->db->get();
        
        return $query->row_array();
    }

    public function update_surat_tgl_dilaksanakan($no_surat) {
        $data = [
            'tgl_dilaksanakan' => date('Y-m-d H:i:s')
        ];

        $this->db->where('no_surat', $no_surat);
        $this->db->update('surat', $data);
    }
    
    public function update_surat_status($no_surat, $status, $user_id) {
        $this->db->set('status', $status);
        $this->db->set('user_id', $user_id);
        $this->db->where('no_surat', $no_surat);
        $this->db->update('surat');
    }
    public function get_surat_by_no_surat($no_surat) {
        $this->db->where('no_surat', $no_surat);
        return $this->db->get('surat')->row_array();
    }
    public function insert_disposisi($data) {
        return $this->db->insert('disposisi', $data);
    }
    
    public function insert_pegawai($data) {
        return $this->db->insert('pegawai', $data);
    }
    public function delete_surat($no_surat) {
        $this->db->where('no_surat', $no_surat);
        $this->db->delete('surat');
    }

}













