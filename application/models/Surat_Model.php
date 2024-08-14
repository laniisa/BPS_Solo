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
    
    public function get_surat_by_id($id) {
        $query = $this->db->get_where('surat', ['id_ds_surat' => $id]);
        $result = $query->row_array();
        
        // Debugging: Lihat hasil query
        if (!$result) {
            log_message('error', 'Surat dengan ID ' . $id . ' tidak ditemukan.');
        }
    
        return $result;
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
                            SUM(CASE WHEN surat.status = "masuk" THEN 1 ELSE 0 END) as masuk, 
                            SUM(CASE WHEN surat.status = "dilaksanakan" THEN 1 ELSE 0 END) as dilaksanakan, 
                            SUM(CASE WHEN surat.status = "diteruskan" THEN 1 ELSE 0 END) as diteruskan');
        $this->db->from('users');
        $this->db->join('surat', 'users.id_user = surat.user_id', 'left');
        $this->db->join('pegawai', 'surat.id_ds_surat = pegawai.id_surat', 'left');
        $this->db->join('kepala', 'pegawai.id_ds_kepala = kepala.id_ds_kepala', 'left');
        $this->db->where('MONTH(surat.tgl_surat)', $bulan);
        $this->db->where('YEAR(surat.tgl_surat)', $tahun);
        $this->db->group_by('users.nama');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_rekapitulasi_all() {
        $this->db->select('users.nama,  
                            SUM(CASE WHEN surat.status = "masuk" THEN 1 ELSE 0 END) as masuk, 
                            SUM(CASE WHEN surat.status = "dilaksanakan" THEN 1 ELSE 0 END) as dilaksanakan, 
                            SUM(CASE WHEN surat.status = "diteruskan" THEN 1 ELSE 0 END) as diteruskan');
        $this->db->from('users');
        $this->db->join('surat', 'users.id_user = surat.user_id', 'left');
        $this->db->join('pegawai', 'surat.id_ds_surat = pegawai.id_surat', 'left');
        $this->db->join('kepala', 'pegawai.id_ds_kepala = kepala.id_ds_kepala', 'left');
        
        // Tidak ada filter bulan dan tahun
        $this->db->group_by('users.nama');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_surat_by_user_id_kepala($user_id) {
        $this->db->select('surat.*, kepala.tindak_lanjut');
        $this->db->from('surat');
        $this->db->join('kepala', 'kepala.id_surat = surat.id_ds_surat', 'left');
        $this->db->where('surat.user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
}
?>
