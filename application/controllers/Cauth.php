<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cauth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mauth');
        $this->load->library('session');
        $this->load->helper('url');
    }

    // Halaman login
    public function index() {
        $this->load->view('auth/login');
    }

    public function login() {
        $this->load->view('auth/login');
    }

    // Halaman register
    public function register() {
        $this->load->view('auth/register');
    }

    // Fungsi logout
    public function logout() {
        $this->session->sess_destroy();
        redirect('cauth/login');
    }

    // Fungsi proses login
    public function proseslogin() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
    
        // Validasi email dan password
        if (empty($email) || empty($password)) {
            $this->session->set_flashdata('pesan', 'Email dan password wajib diisi!');
            $this->session->set_flashdata('color', 'danger');
            redirect('cauth/login');
            return;
        }
    
        // Mencari pengguna berdasarkan email
        $user = $this->Mauth->get_pengguna_by_email($email);
    
        if ($user && password_verify($password, $user->password)) {
            if ($user->status !== 'aktif') {
                $this->session->set_flashdata('pesan', 'Akun Anda belum aktif. Silakan cek email untuk aktivasi.');
                $this->session->set_flashdata('color', 'warning');
                redirect('cauth/login');
                return;
            }
    
            // Mengambil pengguna berdasarkan ID setelah login berhasil
            $user_details = $this->Mauth->get_user_by_id($user->id_user);
    
            // Menyimpan data pengguna ke session
            $session_data = [
                'id_user' => $user_details->id_user,
                'nama' => $user_details->nama,
                'email' => $user_details->email,
                'level' => $user_details->level,
                'logged_in' => true
            ];
            $this->session->set_userdata($session_data);
    
            $this->session->set_flashdata('pesan', 'Login berhasil! Selamat datang ' . $user_details->nama . '.');
            $this->session->set_flashdata('color', 'success');
            redirect('cauth/dashboard');
        } else {
            $this->session->set_flashdata('pesan', 'Email atau password salah.');
            $this->session->set_flashdata('color', 'danger');
            redirect('cauth/login');
        }
    }
    
    

    // Halaman dashboard
    public function dashboard() {
        $level = $this->session->userdata('level');

        if (!$level) {
            $this->session->set_flashdata('pesan', 'Anda harus login terlebih dahulu.');
            $this->session->set_flashdata('color', 'danger');
            redirect('cauth/login');
        }

        switch ($level) {
            case 'admin':
                $this->load->view('admin/dashboard');
                break;
            case 'pengelola':
                $this->load->view('pengelola/dashboard');
                break;
            case 'user':
                $this->load->view('pengguna/dashboard');
                break;
            default:
                $this->session->set_flashdata('pesan', 'Role tidak valid.');
                $this->session->set_flashdata('color', 'danger');
                redirect('cauth/login');
        }
    }

    // Proses registrasi
    public function prosesregister() {
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        $alamat = $this->input->post('alamat');
        $no_hp = $this->input->post('no_hp');

        if (empty($nama) || empty($alamat) || empty($no_hp)) {
            $this->session->set_flashdata('pesan', 'Semua kolom wajib diisi!');
            $this->session->set_flashdata('color', 'danger');
            redirect('cauth/register');
            return;
        }

        if ($this->Mauth->email_exists($email)) {
            $this->session->set_flashdata('pesan', 'Email sudah digunakan!');
            $this->session->set_flashdata('color', 'danger');
            redirect('cauth/register');
            return;
        }

        if ($this->Mauth->no_hp_exists($no_hp)) {
            $this->session->set_flashdata('pesan', 'Nomor HP sudah digunakan!');
            $this->session->set_flashdata('color', 'danger');
            redirect('cauth/register');
            return;
        }

        $data = [
            'nama' => $nama,
            'email' => $email,
            'password' => $password,
            'alamat' => $alamat,
            'no_hp' => $no_hp,
            'level' => 'user',
            'status' => 'belum aktif'
        ];

        $result = $this->Mauth->register($data);
        if ($result) {
            $message = '<html>
                <h2>Aktivasi Akun</h2>
                <p>Mohon untuk aktivasi akun Anda dengan klik tombol berikut:</p>
                <a href="' . base_url() . 'cauth/verify/' . $result . '">Aktivasi</a>
                </html>';
            $subject = 'Aktivasi Akun';
            $from = $this->config->item('smtp_user') ?: 'your_email@gmail.com';
            $this->send_email($email, $from, $message, $subject);

            $this->session->set_flashdata('pesan', 'Registrasi berhasil! Silakan cek email Anda untuk aktivasi.');
            $this->session->set_flashdata('color', 'success');
            redirect('cauth/login');
        } else {
            $this->session->set_flashdata('pesan', 'Registrasi gagal! Silakan coba lagi.');
            $this->session->set_flashdata('color', 'danger');
            redirect('cauth/register');
        }
    }

    // Verifikasi akun
    public function verify($user_id) {
        $user = $this->Mauth->get_user_by_id($user_id);

        if ($user && $user->status == 'belum aktif') {
            $this->Mauth->update_user($user_id, ['status' => 'aktif']);

            $this->session->set_flashdata('pesan', 'Akun berhasil diaktifkan. Silakan login.');
            $this->session->set_flashdata('color', 'success');
            redirect('cauth/login');
        } else {
            $this->session->set_flashdata('pesan', 'Akun tidak valid atau sudah diaktifkan.');
            $this->session->set_flashdata('color', 'danger');
            redirect('cauth/login');
        }
    }

    // Fungsi untuk mengirim email
    public function send_email($to, $from, $message, $subject = null) {
        if (empty($subject)) {
            $subject = 'Aktivasi Akun';
        }

        $this->load->library('email', $this->config->item('email'));
        $this->email->set_newline("\r\n");
        $this->email->from($from, 'Pengirim');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            log_message('debug', 'Email berhasil dikirim ke: ' . $to);
            return true;
        } else {
            log_message('error', 'Email gagal dikirim ke: ' . $to . '. Debugger: ' . $this->email->print_debugger());
            return false;
        }
    }
}
