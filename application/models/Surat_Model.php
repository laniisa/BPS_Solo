<?php
class Surat_Model extends CI_Model {

    public function get_all_surat() {
        $this->db->from('surat');
        return $this->db->get()->result_array();
    }

    public function insert_surat($data) {
        $result = $this->db->insert('surat', $data);
        
        // Debugging Log
        log_message('debug', 'Insert query: ' . $this->db->last_query());
        
        return $result;
    }

    public function get_surat_by_id($id)
    {
    $query = $this->db->get_where('surat', array('id' => $id));
    return $query->row_array();
    }

    public function update_surat($id, $data)
    {
    $this->db->where('id', $id);
    $this->db->update('surat', $data);
    }

    public function delete_surat($id) {
        return $this->db->delete('surat', array('id' => $id));
    }

    public function get_jumlah_surat() {
        $this->db->from('surat');
        return $this->db->count_all_results();
    }
}
?>
