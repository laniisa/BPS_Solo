<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Kepala_Model extends CI_Model {

        // Method to retrieve a record by id_user
        public function get_kepala_by_user_id($id_user) {
            $this->db->where('id_user', $id_user);
            $query = $this->db->get('kepala');
            return $query->row_array(); // Return a single row
        }

        // Method to update a record by id_ds_kepala
        public function update_tindak_lanjut($id_ds_kepala, $data) {
            $this->db->where('id_ds_kepala', $id_ds_kepala);
            return $this->db->update('kepala', $data);
        }

        // Method to insert a new record
        public function insert_kepala($data) {
            return $this->db->insert('kepala', $data);
        }
    
}
