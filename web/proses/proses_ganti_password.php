<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

if ($_POST['act'] == 'cek') {
    $pass = $_POST['pass_lama'];
    $pengacak  = "NDJS3289JSKS190JISJI";
    $password = (md5($pengacak . md5($pass) . $pengacak));
    $cek = $proses->cek_row('akun_penyedia', 'id_akun = "' . $_SESSION['kode_user'] . '" AND password = "' . $password . '"');
    echo $cek;
}

if ($_POST['act'] == 'edit') {
    $pengacak  = "NDJS3289JSKS190JISJI";
    $pass = md5($pengacak . md5($_POST['pass_baru']) . $pengacak);
    $data = array(
        'password'  => $pass
    );
    $result = $proses->edit_data('akun_penyedia', $data, 'id_akun', $_SESSION['kode_user']);
}
