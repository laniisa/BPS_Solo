<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fungsional_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Function to get surat data based on the logged-in user's ID
    public function get_surat_by_user_id($user_id) {
        // Step 1: Get the id_surat from the pegawai table based on the user_id
        $this->db->select('id_surat');
        $this->db->from('pegawai');
        $this->db->where('id_user', $user_id);
        $query = $this->db->get();
        $result = $query->row_array();
    
        // Log the id_surat result
        log_message('debug', 'ID Surat Result: ' . print_r($result, true));
    
        if ($result) {
            // Step 2: If id_surat exists, use it to get surat data from the surat table
            $id_surat = $result['id_surat'];
            $this->db->select('*');
            $this->db->from('surat');
            $this->db->where('id_ds_surat', $id_surat); // Matching id_ds_surat in surat table
            $surat_query = $this->db->get();
    
            // Log the surat data
            log_message('debug', 'Surat Query Result: ' . print_r($surat_query->result_array(), true));
    
            return $surat_query->result_array(); // Return the surat data
        }
    
        return []; // Return empty array if no surat found
    }

    
}
?>
