<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai_Model extends CI_Model {
    
    public function get_catatan_pegawai_by_surat_id($id) {
        $this->db->select('pegawai.*, users.nama');
        $this->db->from('pegawai');
        $this->db->join('users', 'users.id_user = pegawai.id_user');
        $this->db->join('disposisi', 'disposisi.id_ds_pegawai = pegawai.id_ds_pegawai');
        $this->db->where('disposisi.id_ds_surat', $id);
        return $this->db->get()->result_array();
    }

    // Tambahkan metode lainnya sesuai kebutuhan
}