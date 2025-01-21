<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mauth extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_pengguna($email, $password) {
        $this->db->where('email', $email);
        $query = $this->db->get('tb_pengguna');
        $user = $query->row();
        
        // Debugging: Log hasil query dan user data
        log_message('debug', 'Hasil query get_pengguna: ' . json_encode($user));
        
        if ($user) {
            if (password_verify($password, $user->password)) {
                log_message('debug', 'Password berhasil diverifikasi untuk pengguna: ' . $email);
                return $user;
            } else {
                log_message('error', 'Password salah untuk pengguna dengan email: ' . $email);
            }
        } else {
            log_message('error', 'Pengguna dengan email: ' . $email . ' tidak ditemukan');
        }
        
        return false;
    }

    public function email_exists($email) {
        $query = $this->db->get_where('tb_pengguna', ['email' => $email]);
        return $query->num_rows() > 0;
    }

    public function no_hp_exists($no_hp) {
        $query = $this->db->get_where('tb_pengguna', ['no_hp' => $no_hp]);
        return $query->num_rows() > 0;
    }

    public function register($data) {
        return $this->db->insert('tb_pengguna', $data);
    }

    public function get_pengguna_by_email($email) {
        $query = $this->db->get_where('tb_pengguna', ['email' => $email]);
        $result = $query->row();
        
        // Debugging: Log hasil query
        log_message('debug', 'Hasil query get_pengguna_by_email: ' . json_encode($result));

        return $result;
    }
    
    public function get_user_by_id($id_user) {
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('tb_pengguna');
        return $query->row();
    }

    public function get_all_users() {
        $query = $this->db->get('tb_pengguna');
        return $query->result();
    }

    public function insert_user($data) {
        return $this->db->insert('tb_pengguna', $data);
    }

    public function update_user($id_user, $data) {
        $this->db->where('id_user', $id_user);
        return $this->db->update('tb_pengguna', $data);
    }

    public function delete_user($id_user) {
        $this->db->where('id_user', $id_user);
        return $this->db->delete('tb_pengguna');
    }

    public function get_role($email) {
        $this->db->select('level');
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row()->level ?? null;
    }
    
}
?>
