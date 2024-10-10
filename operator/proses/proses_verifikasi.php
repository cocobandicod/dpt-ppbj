<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
require_once('../../config/fungsi_indotgl.php');

if ($_POST['act'] == 'ver') {
    $data = array(
        'status'            => 'Terverifikasi',
        'verifikasi_oleh'   => $_SESSION['kode_user'],
        'verifikasi_tgl'    => $tgl_jam
    );
    $result = $proses->edit_data('profil_badan_usaha', $data, 'id_profil', $_POST['id']);
}
