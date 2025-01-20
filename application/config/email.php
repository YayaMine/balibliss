<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
// $config = array(
//     'protocol' => 'smtp',
//     'smtp_host' => 'smtp.gmail.com', 
//     'smtp_port' => 587,
//     'smtp_user' => 'kadeklinda83@gmail.com',
//     'smtp_pass' => '',
//     'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
//     'mailtype' => 'html', //plaintext 'text' mails or 'html'
//     'smtp_timeout' => '4', //in seconds
//     'charset' => 'iso-8859-1',
//     'wordwrap' => TRUE
// );

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.gmail.com';
$config['smtp_port'] = 465;
$config['smtp_user'] = 'kadeklinda83@gmail.com'; // Ganti dengan alamat email Gmail Anda
$config['smtp_pass'] = 'lemb xiuf ghvl jbhm'; // Ganti dengan password Gmail Anda (atau gunakan app password jika 2FA diaktifkan)
$config['smtp_crypto'] = 'ssl';
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['crlf'] = "\r\n";
$config['newline'] = "\r\n";