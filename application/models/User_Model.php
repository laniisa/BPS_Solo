<?php
class User_Model extends CI_Model {
    public function insert_user($data_user)
    {
        return $this->db->insert('users', $data_user);
    }

    public function get_user_by_email($email)
    {
    $this->db->where('email', $email);
    $query = $this->db->get('users');
    return $query->row_array(); // Mengembalikan hasil sebagai array
    }


    public function get_user($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row_array(); // Menggunakan row_array() karena ingin mengembalikan data sebagai array asosiatif
      }

      public function get_jumlah_user($role_id = null)
      {
          $this->db->select('COUNT(*) AS total_users');
          $this->db->from('users');
          
          // Jika ada ID role yang ditentukan, gunakan filter
          if ($role_id !== null) {
              $this->db->where('id_role', $role_id);
          }
          
          // Pastikan 'active' adalah string atau definisikan konstanta jika diperlukan
          $this->db->where('status', 'active'); // Ganti dengan nilai yang sesuai jika perlu
          
          $query = $this->db->get();
      
          if ($query->num_rows() > 0) {
              return $query->row()->total_users;
          } else {
              return 0;
          }
      }

      public function get_users_by_role($role) {
        return $this->db->get_where('users', ['role' => $role])->result_array();
    }
}      
?>
