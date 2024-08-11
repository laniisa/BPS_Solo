<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Kepala_Model extends CI_Model {

        public function get_users_by_role($role) {
            $this->db->where('role', $role); 
            return $this->db->get('users')->result_array();
        }
        public function get_all_kepala() {
            $this->db->from('kepala');
            return $this->db->get()->result_array();
        }
        public function insert_kepala($data) {
            return $this->db->insert('kepala', $data);
        }

        public function get_catatan_kepala_by_surat_id($id) {
            $this->db->select('kepala.*, users.nama');
            $this->db->from('kepala');
            $this->db->join('users', 'users.id_user = kepala.user_id');
            $this->db->join('disposisi', 'disposisi.id_ds_kepala = kepala.id_ds_kepala');
            $this->db->where('disposisi.id_ds_surat', $id);
            return $this->db->get()->row_array();
        }
    }
?>
