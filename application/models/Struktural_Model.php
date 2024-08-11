<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktural_model extends CI_Model {

    public function insert_kepala($data) {
        return $this->db->insert('kepala', $data);
    }

    public function update_status($id_ds_kepala, $tindak_lanjut) {
        $this->db->set('tindak_lanjut', $tindak_lanjut);
        $this->db->where('id_ds_kepala', $id_ds_kepala);
        $result = $this->db->update('kepala');
        error_log("Update result: " . ($result ? 'Success' : 'Failed')); // Logging
        return $result;
    }

    public function get_entry_by_user_id_and_no_surat($user_id, $no_surat) {
        $this->db->where('user_id', $user_id);
        $this->db->where('id_ds_surat', $no_surat);
        $query = $this->db->get('kepala');
        return $query->row_array();
    }
}

    
