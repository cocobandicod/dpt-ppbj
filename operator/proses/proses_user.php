<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

if ($_POST['act'] == 'add') {
    $tokenAkses = token();

    $nama = strip_tags($_POST['nama']);
    $username = strip_tags($_POST['username']);
    $pass = strip_tags($_POST['password']);
    $email = strip_tags($_POST['email']);
    $nip = strip_tags($_POST['nip']);
    $no_sk = strip_tags($_POST['no_sk']);
    $tgl_sk = strip_tags($_POST['tgl_sk']);
    $alamat = strip_tags($_POST['alamat']);
    $hp = strip_tags($_POST['hp']);
    $level = strip_tags($_POST['level']);
    $status_aktif = strip_tags($_POST['status_aktif']);

    $pengacak  = "NDJS3289JSKS190JISJI";

    $password = (md5($pengacak . md5($pass) . $pengacak));

    $data[] = array(
        'nama'         => $nama,
        'username'     => $username,
        'password'     => $password,
        'email'        => $email,
        'nip'          => $nip,
        'no_sk'        => $no_sk,
        'tgl_sk'       => $tgl_sk,
        'alamat'       => $alamat,
        'hp'           => $hp,
        'level'        => $level,
        'status_aktif' => $status_aktif,
        'token'        => $tokenAkses
    );

    $result = $proses->tambah_data('operator', $data);
} else if ($_POST['act'] == 'edit') {

    $nama = strip_tags($_POST['nama']);
    $username = strip_tags($_POST['username']);
    $pass = strip_tags($_POST['password']);
    $email = strip_tags($_POST['email']);
    $nip = strip_tags($_POST['nip']);
    $no_sk = strip_tags($_POST['no_sk']);
    $tgl_sk = strip_tags($_POST['tgl_sk']);
    $alamat = strip_tags($_POST['alamat']);
    $hp = strip_tags($_POST['hp']);
    $level = strip_tags($_POST['level']);
    $status_aktif = strip_tags($_POST['status_aktif']);

    $pengacak  = "NDJS3289JSKS190JISJI";

    if (empty($pass)) {
        $data = array(
            'nama'         => $nama,
            'username'     => $username,
            'email'        => $email,
            'nip'          => $nip,
            'no_sk'        => $no_sk,
            'tgl_sk'       => $tgl_sk,
            'alamat'       => $alamat,
            'hp'           => $hp,
            'level'        => $level,
            'status_aktif' => $status_aktif
        );
    } else {
        $password = (md5($pengacak . md5($pass) . $pengacak));
        $data = array(
            'nama'         => $nama,
            'username'     => $username,
            'password'     => $password,
            'email'        => $email,
            'nip'          => $nip,
            'no_sk'        => $no_sk,
            'tgl_sk'       => $tgl_sk,
            'alamat'       => $alamat,
            'hp'           => $hp,
            'level'        => $level,
            'status_aktif' => $status_aktif
        );
    }

    $result = $proses->edit_data('operator', $data, 'id_operator', $_POST['id']);
    #--------------------------------------------------------------------------------
} else if ($_POST['act'] == 'del') {
    $id = $_POST['del'];
    $result = $proses->hapus_data('operator', 'id_operator', $id);
}
