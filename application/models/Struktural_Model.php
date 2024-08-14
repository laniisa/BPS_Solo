<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktural_Model extends CI_Model {

    public function insert_kepala($data) {
        return $this->db->insert('kepala', $data);
    }

    public function get_surat_by_no_surat_and_user($no_surat, $user_id) {
        // Join tabel surat dengan pegawai untuk memastikan user_id adalah tujuan dari surat tersebut
        $this->db->select('surat.*');
        $this->db->from('surat');
        $this->db->join('pegawai', 'pegawai.id_surat = surat.id_ds_surat', 'left');
        $this->db->where('surat.no_surat', $no_surat);
        $this->db->where('pegawai.id_user', $user_id);
        
        // Eksekusi query
        $query = $this->db->get();
        
        // Mengembalikan hasil sebagai array
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

    public function update_surat_status($no_surat, $status) {
        $this->db->set('status', $status);
        $this->db->where('no_surat', $no_surat);
        $this->db->update('surat');
    }
    
    public function update_surat_disposisi($no_surat) {
        $data = [
            'status' => 'disposisi',
            'tgl_disposisi' => date('Y-m-d H:i:s'),
            'tgl_dilaksanakan' => null
        ];

        $this->db->where('no_surat', $no_surat);
        $this->db->update('surat', $data);
    }
    public function get_surat_by_no_surat($no_surat) {
        $this->db->where('no_surat', $no_surat);
        $query = $this->db->get('surat');
        return $query->row_array();
    }
}

