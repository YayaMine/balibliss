<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
// $config = array(
//     'protocol' => 'smtp',
//     'smtp_host' => 'smtp.gmail.com', 
//     'smtp_port' => 587,
//     'smtp_user' => 'anastasyaa2004@gmail.com',
//     'smtp_pass' => 'email_testAuth123',
//     'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
//     'mailtype' => 'html', //plaintext 'text' mails or 'html'
//     'smtp_timeout' => '4', //in seconds
//     'charset' => 'iso-8859-1',
//     'wordwrap' => TRUE
// );

$config = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'sandbox.smtp.mailtrap.io',
    'smtp_port' => 2525,
    'smtp_user' => '98c2aefad7aec8',
    'smtp_pass' => 'd550690e6ec8f6',
    'smtp_crypto' => 'tls',
    'crlf' => "\r\n",
    'newline' => "\r\n"
  );