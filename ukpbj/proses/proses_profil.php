<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

if ($_POST['act'] == 'edit') {

    $nama = strip_tags($_POST['nama']);
    $username = strip_tags(str_replace(' ', '', $_POST['username']));
    $email = strip_tags($_POST['email']);
    $nip = strip_tags($_POST['nip']);
    $no_sk = strip_tags($_POST['no_sk']);
    $tgl_sk = strip_tags($_POST['tgl_sk']);
    $alamat = strip_tags($_POST['alamat']);
    $hp = strip_tags($_POST['hp']);

    $data = array(
        'nama'         => $nama,
        'username'     => $username,
        'email'        => $email,
        'nip'          => $nip,
        'no_sk'        => $no_sk,
        'tgl_sk'       => $tgl_sk,
        'alamat'       => $alamat,
        'hp'           => $hp
    );

    $result = $proses->edit_data('operator', $data, 'id_operator', $_SESSION['kode_user']);
    #--------------------------------------------------------------------------------
}
