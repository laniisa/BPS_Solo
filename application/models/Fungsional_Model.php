<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fungsional_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_surat_by_user_id($user_id) {
        $this->db->select('id_surat');
        $this->db->from('pegawai');
        $this->db->where('id_user', $user_id);
        $query = $this->db->get();
        $result = $query->result_array(); 
        
        $surat_list = [];
    
        log_message('debug', 'ID Surat Result: ' . print_r($result, true));
    
        foreach ($result as $row) {
            $id_surat = $row['id_surat'];
            $this->db->select('*');
            $this->db->from('surat');
            $this->db->where('id_ds_surat', $id_surat);
            $surat_query = $this->db->get();
            
            if ($surat_query->num_rows() > 0) {
                $surat_list = array_merge($surat_list, $surat_query->result_array());
            }
        }
    
        log_message('debug', 'Surat Query Result: ' . print_r($surat_list, true));
    
        return $surat_list;
    }
    public function update_surat($no_surat, $data) {
        $this->db->where('no_surat', $no_surat);
        $this->db->update('surat', $data);
    }

    public function get_id_surat_by_no($no_surat) {
        $this->db->select('id_ds_surat');
        $this->db->from('surat');
        $this->db->where('no_surat', $no_surat);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result['id_ds_surat'];
    }

    public function update_pegawai($user_id, $id_surat, $data) {
        $this->db->where('id_user', $user_id);
        $this->db->where('id_surat', $id_surat);
        $this->db->update('pegawai', $data);
    }
    

    
}
?>
