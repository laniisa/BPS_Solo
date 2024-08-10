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
    
}
