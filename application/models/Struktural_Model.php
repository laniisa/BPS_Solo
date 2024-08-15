<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktural_Model extends CI_Model {

    public function insert_kepala($data) {
        $this->db->insert('kepala', $data);
        return $this->db->insert_id();
    }

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
            'tgl_dilaksanakan' => date('Y-m-d H:i:s'),
            'tgl_disposisi' => null
        ];

        $this->db->where('no_surat', $no_surat);
        $this->db->update('surat', $data);
    }

    public function update_surat_disposisi($no_surat, $no_disposisi) {
        $data = [
            'status' => 'disposisi',
            'no_disposisi' => $no_disposisi,
            'tgl_disposisi' => date('Y-m-d H:i:s'),
            'tgl_dilaksanakan' => null
        ];

        $this->db->where('no_surat', $no_surat);
        $this->db->update('surat', $data);
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

