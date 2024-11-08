<?php
class Surat_Model extends CI_Model {

    public function get_all_surat() {
        $this->db->from('surat');
        return $this->db->get()->result_array();
    }

    public function get_kepala() {
        $query = $this->db->get('kepala'); // Sesuaikan nama tabel jika perlu
        return $query->result_array();
    }

    // Fungsi untuk memasukkan data surat ke database
    public function insert_surat($data) {
        return $this->db->insert('surat', $data);
    }
    
    public function get_surat_by_id($id)
{
    return $this->db->get_where('surat', ['id_ds_surat' => $id])->row_array();
}


    public function get_surat_by_no($no_surat) {
        $query = $this->db->get_where('surat', array('no_surat' => $no_surat));
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

    public function get_surat_by_user_id($user_id) {
        $this->db->select('*'); // Ensure all columns are selected
        $this->db->from('surat');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array(); // This should include 'id_ds_kepala'
    }    

    public function get_surat_by_user($user_id) {
        $this->db->select('*');
        $this->db->from('surat');
        $this->db->where('user_id', $user_id); // Misalkan 'tujuan' adalah kolom yang menyimpan ID pengguna tujuan
        $this->db->where('status', 'dilaksanakan'); // Menampilkan surat yang belum dilaksanakan
        $query = $this->db->get();
        return $query->result_array();
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

    public function update_tindak_lanjut($no_surat, $tindak_lanjut) {
        $this->db->where('no_surat', $no_surat);
        return $this->db->update('surat', array('tindak_lanjut' => $tindak_lanjut));
    }

    public function get_filtered_surat($tanggal_awal = null, $tanggal_akhir = null) {
        $this->db->select('*');
        $this->db->from('surat');

        // Terapkan filter jika tanggal diberikan
        if ($tanggal_awal) {
            $this->db->where('tgl_surat >=', $tanggal_awal);
        }
        if ($tanggal_akhir) {
            $this->db->where('tgl_surat <=', $tanggal_akhir);
        }

        // Eksekusi query
        $query = $this->db->get();

        // Kembalikan hasil query sebagai array
        return $query->result_array();
    }


    public function get_rekapitulasi($bulan, $tahun) {
        $this->db->select('users.nama, 
                           COUNT(DISTINCT IF(surat.status = "masuk", surat.id_ds_surat, NULL)) AS masuk, 
                           COUNT(DISTINCT IF(pegawai.tindak_lanjut = "dilaksanakan", pegawai.id_disposisi, NULL)) AS dilaksanakan,
                           COUNT(DISTINCT IF(pegawai.tindak_lanjut = "diteruskan", pegawai.id_disposisi, NULL)) AS diteruskan');
        $this->db->from('users');
        $this->db->join('surat', 'surat.user_id = users.id_user', 'left');
        $this->db->join('pegawai', 'pegawai.id_user = users.id_user', 'left');
        $this->db->group_start()
                 ->where('MONTH(surat.tgl_surat)', $bulan)
                 ->where('YEAR(surat.tgl_surat)', $tahun)
                 ->group_end();
        $this->db->or_group_start()
                 ->where('MONTH(pegawai.tanggal)', $bulan)
                 ->where('YEAR(pegawai.tanggal)', $tahun)
                 ->group_end();
        $this->db->group_by('users.nama');
    
        return $this->db->get()->result_array();
    }
   
    public function get_rekapitulasi_all() {
        $this->db->select('users.nama, 
                           COUNT(DISTINCT IF(surat.status = "masuk", surat.id_ds_surat, NULL)) AS masuk, 
                           COUNT(DISTINCT IF(pegawai.tindak_lanjut = "dilaksanakan", pegawai.id_disposisi, NULL)) AS dilaksanakan,
                           COUNT(DISTINCT IF(pegawai.tindak_lanjut = "diteruskan", pegawai.id_disposisi, NULL)) AS diteruskan');
        $this->db->from('users');
        $this->db->join('surat', 'surat.user_id = users.id_user', 'left');
        $this->db->join('pegawai', 'pegawai.id_user = users.id_user', 'left');
        $this->db->group_by('users.nama');
        
        return $this->db->get()->result_array();
    }
   
    
}
?>
