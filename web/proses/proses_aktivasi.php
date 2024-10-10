<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

$data = array(
    'konfirmasi'   => 'Yes'
);
$result = $proses->edit_data('akun_penyedia', $data, 'token', $_POST['token']);
