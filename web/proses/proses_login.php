<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

$tokenAkses = token();

$user = strip_tags($_POST['username']);
$pass = strip_tags($_POST['password']);

$pengacak  = "NDJS3289JSKS190JISJI";

$password = (md5($pengacak . md5($pass) . $pengacak));

$result = $proses->proses_login($user, $password);

$subdata = array();

if ($result == 'gagal') {
    $subdata['status'] = 'gagal';
} else if (@$result['konfirmasi'] == 'No') {
    $subdata['status'] = 'konfirmasi';
} else {
    $data = array(
        'token'        => $tokenAkses
    );
    $proses->edit_data('akun_penyedia', $data, 'id_akun', $result['id_akun']);
    $cek = $proses->tampil_data_saja('id_profil,nama_perusahaan', 'profil_badan_usaha', 'id_akun = "' . $result['id_akun'] . '"');
    $_SESSION['token'] = $tokenAkses;
    $_SESSION['kode_user'] = $result['id_akun'];
    $_SESSION['kode_profil'] = $cek['id_profil'];
    $_SESSION['nama'] = $cek['nama_perusahaan'];
    $subdata['status'] = 'beranda';
}

echo json_encode($subdata);
