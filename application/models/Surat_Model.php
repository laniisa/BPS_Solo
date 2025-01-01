<?php
class Surat_Model extends CI_Model {

    public function get_all_surat() {
        $this->db->from('surat');
        return $this->db->get()->result_array();
    }

        public function insert_surat($data) {
        return $this->db->insert('surat', $data);
    }
    
    public function get_surat_per_bulan()
{
    $query = $this->db->query("
        SELECT MONTH(tgl_input) as bulan, COUNT(*) as jumlah
        FROM surat
        GROUP BY MONTH(tgl_input)
        ORDER BY MONTH(tgl_input)
    ");
    return $query->result_array();
}

    

public function get_surat_by_id($id) {
    $this->db->select('
        surat.*, 
        disposisi.no_disposisi, 
        pegawai.tanggal AS tgl_disposisi
    ');
    $this->db->from('surat');
    $this->db->join('disposisi', 'surat.id_ds_surat = disposisi.id_ds_surat', 'left');
    $this->db->join('pegawai', 'pegawai.id_surat = surat.id_ds_surat', 'left');
    $this->db->where('surat.id_ds_surat', $id);
    return $this->db->get()->row_array();
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

    public function get_surat_dilaksanakan() {
        $this->db->where('status', 'dilaksanakan');  // Misalnya status surat 'dilaksanakan'
        return $this->db->count_all_results('surat'); // Menghitung jumlah surat yang dilaksanakan
    }

    // Fungsi untuk mendapatkan jumlah surat yang masuk
    public function get_surat_masuk() {
        $this->db->where('status', 'masuk');  // Misalnya status surat 'masuk'
        return $this->db->count_all_results('surat'); // Menghitung jumlah surat yang masuk
    }

    public function get_surat_by_user_id($user_id) {
        $this->db->select('*'); // Ensure all columns are selected
        $this->db->from('surat');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array(); 
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
                           COUNT(DISTINCT IF(pegawai.tindak_lanjut = "dilaksanakan" OR surat.status = "dilaksanakan", pegawai.id_disposisi, NULL)) AS dilaksanakan,
                           COUNT(DISTINCT IF(pegawai.tindak_lanjut = "diteruskan" OR surat.status = "diteruskan", pegawai.id_disposisi, NULL)) AS diteruskan');
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
                           COUNT(DISTINCT IF(pegawai.tindak_lanjut = "dilaksanakan" OR surat.status = "dilaksanakan", pegawai.id_disposisi, NULL)) AS dilaksanakan,
                           COUNT(DISTINCT IF(pegawai.tindak_lanjut = "diteruskan" OR surat.status = "diteruskan", pegawai.id_disposisi, NULL)) AS diteruskan');
        $this->db->from('users');
        $this->db->join('surat', 'surat.user_id = users.id_user', 'left');
        $this->db->join('pegawai', 'pegawai.id_user = users.id_user', 'left');
        $this->db->group_by('users.nama');
        
        return $this->db->get()->result_array();
    }
    
    public function get_catatan_pegawai_by_surat($id_surat) {
        if (empty($id_surat)) {
            return []; // Kembalikan array kosong jika $id_surat tidak valid
        }
        $this->db->select('
            pegawai.id_disposisi, 
            pegawai.id_surat, 
            pegawai.id_user, 
            users.nama, 
            pegawai.catatan, 
            pegawai.tindak_lanjut, 
            pegawai.tanggal
        ');
        $this->db->from('pegawai');
        $this->db->join('users', 'pegawai.id_user = users.id_user', 'left');
    
        $this->db->where_in('pegawai.id_surat', $id_surat);
    
        $this->db->order_by('pegawai.id_disposisi', 'ASC'); 
        return $this->db->get()->result_array();
    }
    public function get_tujuan_pegawai_by_surat($id_surat) {
        if (empty($id_surat)) {
            return []; // Kembalikan array kosong jika $id_surat tidak valid
        }
        $this->db->select('
            pegawai.id_disposisi, 
            disposisi.id_disposisi, 
            disposisi.user_tujuan, 
            users.nama, 
            disposisi.status,
            disposisi.id_ds_surat AS id_surat
        ');
        $this->db->from('pegawai');
        $this->db->join('disposisi', 'pegawai.id_disposisi = disposisi.id_disposisi', 'left');
        $this->db->join('users', 'disposisi.user_tujuan = users.id_user', 'left');
        $this->db->where_in('disposisi.id_ds_surat', $id_surat);
        $this->db->order_by('disposisi.no_disposisi', 'ASC'); 
        return $this->db->get()->result_array();
    }
    
    public function get_tahun_surat() {
        // Mendapatkan daftar tahun yang ada di tabel surat
        $this->db->select('YEAR(tgl_surat) as tahun');
        $this->db->group_by('tahun');
        $this->db->order_by('tahun', 'DESC');
        return $this->db->get('surat')->result_array();
    }

    public function get_status_data($tahun) {
        // Mendapatkan jumlah surat berdasarkan status dan bulan dalam tahun tertentu
        $this->db->select("
            MONTH(tgl_surat) as bulan,
            SUM(CASE WHEN status = 'masuk' THEN 1 ELSE 0 END) as masuk,
            SUM(CASE WHEN status = 'dilaksanakan' THEN 1 ELSE 0 END) as dilaksanakan,
            SUM(CASE WHEN status = 'diteruskan' THEN 1 ELSE 0 END) as diteruskan
        ");
        $this->db->where('YEAR(tgl_surat)', $tahun);
        $this->db->group_by('bulan');
        $this->db->order_by('bulan', 'ASC');
        $result = $this->db->get('surat')->result_array();

        // Pastikan data lengkap untuk 12 bulan
        $data = array_fill(1, 12, ['masuk' => 0, 'dilaksanakan' => 0, 'diteruskan' => 0]);
        foreach ($result as $row) {
            $data[$row['bulan']] = [
                'masuk' => (int) $row['masuk'],
                'dilaksanakan' => (int) $row['dilaksanakan'],
                'diteruskan' => (int) $row['diteruskan']
            ];
        }

        return $data;
    }

    public function get_bulan_surat($tahun) {
        // Mendapatkan nama bulan dalam tahun tertentu
        $this->db->select('MONTH(tgl_surat) as bulan');
        $this->db->where('YEAR(tgl_surat)', $tahun);
        $this->db->group_by('bulan');
        $this->db->order_by('bulan', 'ASC');
        $result = $this->db->get('surat')->result_array();
        $bulan = [];
        foreach ($result as $row) {
            $bulan[] = date('F', mktime(0, 0, 0, $row['bulan'], 10)); // Mengubah bulan angka menjadi nama
        }
        return $bulan;
    }
    
}
?>
