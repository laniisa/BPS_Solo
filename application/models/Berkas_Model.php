<?php
class Berkas_Model extends CI_Model {

    public function get_all_berkas() {
        $this->db->from('berkas');
        return $this->db->get()->result_array();
    }

    public function get_jumlah_berkas() {
        $this->db->from('berkas');
        return $this->db->count_all_results();
    }

}
?>