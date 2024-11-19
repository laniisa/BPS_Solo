<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai_Model extends CI_Model {
    
    public function get_all_pegawai() {
        $this->db->from('pegawai');
        return $this->db->get()->result_array();
    }
    public function get_catatan_pegawai_by_surat_id($id) {
        $this->db->select('pegawai.*, users.nama');
        $this->db->from('pegawai');
        $this->db->join('users', 'users.id_user = pegawai.id_user');
        $this->db->join('disposisi', 'disposisi.id_ds_pegawai = pegawai.id_ds_pegawai');
        $this->db->where('disposisi.id_ds_surat', $id);
        return $this->db->get()->result_array();
    }

    public function get_pegawai_by_disposisi($no_disposisi) {
        $this->db->select('pegawai.catatan, pegawai.tindak_lanjut, pegawai.tanggal, users.nama');
        $this->db->from('disposisi');
        $this->db->join('pegawai', 'disposisi.id_disposisi = pegawai.id_disposisi');
        $this->db->join('users', 'pegawai.id_user = users.id_user');
        $this->db->where('disposisi.no_disposisi', $no_disposisi);
        $query = $this->db->get();
        return $query->result_array();
    }

    // Tambahkan metode lainnya sesuai kebutuhan
}