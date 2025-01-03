<?php
class User_Model extends CI_Model {

    public function insert_user($data_user) {
        return $this->db->insert('users', $data_user);
    }

    public function get_all_user() {
        return $this->db->get('users')->result_array();
    }

    public function get_user_by_email($email) {
        $this->db->where('email', $email);
        return $this->db->get('users')->row_array();
    }

    public function get_users_by_role($role) {
        $this->db->where('role', $role); // Pastikan kolom ini benar
        return $this->db->get('users')->result_array();
    }

    public function get_user_roles_count()
{
    $roles = ['0', '3', '1', '2'];
    $counts = [];
    foreach ($roles as $role) {
        $this->db->where('role', $role);
        $counts[] = $this->db->count_all_results('users');
    }
    return $counts;
}



    public function get_user($email) {
        $this->db->where('email', $email);
        return $this->db->get('users')->row_array();
    }

    public function get_users($id) {
        $this->db->where('id_user', $id); // Pastikan 'id_user' adalah kolom yang benar
        return $this->db->get('users')->row_array();
    }

    public function get_roles() {
        $query = $this->db->get('user_role');
        return $query->result_array(); // Mengembalikan hasil dalam bentuk array
    }

    public function get_user_by_id($id_user) {
        $query = $this->db->get_where('users', ['id_user' => $id_user]);
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

    public function get_jumlah_user($role_id = null) {
        $this->db->select('COUNT(*) AS total_users');
        $this->db->from('users');
        
        if ($role_id !== null) {
            $this->db->where('id_role', $role_id); // Pastikan 'id_role' adalah kolom yang benar
        }

        $this->db->where('status', 'active'); // Ganti dengan nilai yang sesuai jika perlu
        
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->row()->total_users : 0;
    }

    
    public function update_status($id_user, $status) {
        // Validasi status yang diterima
        $status = $status === 'active' ? 'active' : 'inactive';

        // Update status di database
        $this->db->where('id_user', $id_user);
        return $this->db->update('users', ['status' => $status]);
    }
    
    

    
}
?>
