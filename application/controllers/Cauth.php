<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cauth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mauth');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        $this->load->view('auth/login');
    }

    public function login() {
        $this->load->view('auth/login');
    }

    public function register() {
        $this->load->view('auth/register');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('cauth/login');
    }    

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
    public function prosesregister() {
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        $alamat = $this->input->post('alamat');
        $no_hp = $this->input->post('no_hp');

        if (empty($nama)) {
            $this->session->set_flashdata('pesan', 'Nama tidak boleh kosong!');
            $this->session->set_flashdata('color', 'danger');
            redirect('cauth/register');
            return;
        }

        if (empty($alamat)) {
            $this->session->set_flashdata('pesan', 'Alamat tidak boleh kosong!');
            $this->session->set_flashdata('color', 'danger');
            redirect('cauth/register');
            return;
        }

        if (empty($no_hp)) {
            $this->session->set_flashdata('pesan', 'Nomor HP tidak boleh kosong!');
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
            'level' => 'user'
        ];

        $subject = 'Aktivasi Akun';
        $message = '<html>
                    <h2>Aktivasi Akun</h2>
                    <p>Mohon untuk aktivasi akun Anda dengan klik tombol berikut:</p>
                    <button>Aktivasi</button>
                    </html>';

        if (empty($subject)) {
            $subject = 'Aktivasi Akun';  // Tentukan subjek default jika kosong
        }

        $from = $this->config->item('smtp_user');
        if (empty($from)) {
            $from = 'anastasyaa2004@gmail.com';  // Tentukan alamat email default jika kosong
        }

        $result = $this->Mauth->register($data);
        if ($result) {
            $this->send_email($email, $from, $subject, $message);
            $this->session->set_flashdata('pesan', 'Registrasi berhasil! Silakan login.');
            $this->session->set_flashdata('color', 'success');
            redirect('cauth/login');
        } else {
            $this->session->set_flashdata('pesan', 'Registrasi gagal! Silakan coba lagi.');
            $this->session->set_flashdata('color', 'danger');
            redirect('cauth/register');
        }
    }

    public function send_email($to, $from, $subject, $message){
        $from = $this->config->item('smtp_user');

        $this->email->set_newline("\r\n");
        $this->email->from($from, 'Pengirim');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()){
            return 'success';
        } else {
            return show_error($this->email->print_debugger());
        }
    }

    public function proseslogin() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
    
        // Debugging: Tampilkan nilai input email dan password
        log_message('debug', 'Email: ' . $email);
        log_message('debug', 'Password: ' . $password);
    
        $user = $this->Mauth->get_pengguna_by_email($email);
    
        // Debugging: Periksa apakah pengguna ditemukan
        if (!$user) {
            log_message('debug', 'Pengguna tidak ditemukan dengan email: ' . $email);
            $this->session->set_flashdata('pesan', 'Email atau password salah!');
            $this->session->set_flashdata('color', 'danger');
            redirect('cauth/login');
            return;
        } else {
            log_message('debug', 'Pengguna ditemukan: ' . json_encode($user));
        }
    
        // Debugging: Periksa password yang di-hash
       //  if (!password_verify($password, $user->password)) {
        //     log_message('debug', 'Password salah untuk pengguna: ' . $email);
        //     $this->session->set_flashdata('pesan', 'Email atau password salah!');
        //     $this->session->set_flashdata('color', 'danger');
           // redirect('cauth/login');
          //  return; 
      //  }
    
        // Jika berhasil login
        $this->session->set_userdata('id_user', $user->id_user);
        $this->session->set_userdata('level', $user->level);
        $this->session->set_flashdata('pesan', 'Login berhasil!');
        $this->session->set_flashdata('color', 'success');
    
        // Redirect sesuai dengan level pengguna
        if ($user->level == 'admin') {
            redirect('Cadmin/dashboard');
        } elseif ($user->level == 'pengelola') {
            redirect('Cpengelola/dashboard');
        } else {
            redirect('Cpengguna/index');
        }
    }    
    
    private function check_access($required_level) {
        $user_level = $this->session->userdata('level');
        if ($user_level !== $required_level) {
            $this->session->set_flashdata('pesan', 'Anda tidak memiliki akses ke halaman ini.');
            $this->session->set_flashdata('color', 'danger');
            redirect('cauth/login');
        }
    }

}
?>
