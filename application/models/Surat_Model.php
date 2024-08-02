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
    $query = $this->db->get_where('surat', array('id_ds_surat' => $id));
    return $query->row_array();
    }

    public function update_surat($id, $data)
    {
    $this->db->where('id_ds_surat', $id);
    $this->db->update('surat', $data);
    }

    public function delete_surat($id) {
        return $this->db->delete('surat', array('id_ds_surat' => $id));
    }

    public function get_jumlah_surat() {
        $this->db->from('surat');
        return $this->db->count_all_results();
    }

    public function insert_or_update_tujuan($surat_id, $user_id)
{
    // Cek apakah sudah ada tujuan untuk surat ini
    $this->db->where('id_ds_surat', $surat_id);
    $query = $this->db->get('surat_tujuan');

    if ($query->num_rows() > 0) {
        // Update tujuan yang sudah ada
        $this->db->where('id_ds_surat', $surat_id);
        $this->db->update('surat_tujuan', ['id_ds_surat' => $user_id]);
    } else {
        // Insert tujuan baru
        $this->db->insert('surat_tujuan', ['id_ds_surat' => $surat_id, 'id_ds_surat' => $user_id]);
    }
}

    public function get_rekapitulasi($bulan, $tahun) {
        // Select data nama dari tabel users dan status dari tabel surat
        $this->db->select('users.nama, 
                        SUM(CASE WHEN surat.status = "belum_cek" THEN 1 ELSE 0 END) as belum_cek, 
                        SUM(CASE WHEN surat.status = "sudah_dicek" THEN 1 ELSE 0 END) as sudah_dicek, 
                        SUM(CASE WHEN surat.status = "dilaksanakan" THEN 1 ELSE 0 END) as dilaksanakan, 
                        SUM(CASE WHEN surat.status = "diteruskan" THEN 1 ELSE 0 END) as diteruskan');
        $this->db->from('surat');
        $this->db->join('users', 'surat.id_ds_surat = users.id_user');
        $this->db->where('MONTH(surat.tgl_surat)', $bulan);
        $this->db->where('YEAR(surat.tgl_surat)', $tahun);
        $this->db->group_by('users.nama');
        $query = $this->db->get();
        return $query->result_array();
    }

}
?>
