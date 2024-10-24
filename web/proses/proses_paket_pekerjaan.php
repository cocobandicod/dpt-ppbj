<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

if (@$_POST['act'] == 'daftar') {
    $data[] = array(
        'id_paket'   => strip_tags($_POST['paket']),
        'id_profil'  => $_SESSION['kode_profil']
    );
    $result = $proses->tambah_data('tender', $data); // SIMPAN KE DATABASE
}
