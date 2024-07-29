<?php
class User_Model extends CI_Model {
    public function insert_user($data_user)
    {
        return $this->db->insert('users', $data_user);
    }

    public function get_all_user() {
        $this->db->from('users');
        return $this->db->get()->result_array();
    }

    public function get_user_by_email($email)
    {
    $this->db->where('email', $email);
    $query = $this->db->get('users');
    return $query->row_array(); // Mengembalikan hasil sebagai array
    }

    public function get_users_by_role($role) {
        $this->db->where('role', $role);
        $query = $this->db->get('users');
        return $query->result_array();
    }    

    public function get_user_by_role($role_id) {
        $this->db->where('role', $role_id);
        $query = $this->db->get('users');
        return $query->result_array();
    }


    public function get_user($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row_array(); // Menggunakan row_array() karena ingin mengembalikan data sebagai array asosiatif
      }

      public function get_users($id) {
        $this->db->where('id_user', $id);
        $query = $this->db->get('users');
        return $query->row_array();
    }

    public function update_user($id, $data) {
        $this->db->where('id_user', $id);
        return $this->db->update('users', $data);
    }

    public function delete_user($id) {
        $this->db->where('id_user', $id);
        return $this->db->delete('users');
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

    // Operator_Model.php (Model)
    public function update_status($id_user, $status) {
        $this->db->set('status', $status);
        $this->db->where('id_user', $id_user);
        $result = $this->db->update('users');
        error_log("Update result: " . ($result ? 'Success' : 'Failed')); // Logging
        return $result;
    }
    


      
}      
?>
