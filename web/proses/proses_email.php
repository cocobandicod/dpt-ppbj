<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
require_once('../../config/email.php');

$username = $_POST['username'];
$pass = $_POST['token'];
$email = $_POST['email'];
$tokenAkses = $_POST['akses'];

//----------------------------------------------------------------------
$link = $url . 'aktivasi/kode/' . $tokenAkses;
$template = template($username, $pass, $link);
kirim_email($email, 'Aktivasi Akun Penyedia', $template); // KIRIM EMAIL
//----------------------------------------------------------------------
