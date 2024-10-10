<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

$catatan = strip_tags($_POST['catatan']);
$id = strip_tags($_POST['id']);
$db = strip_tags($_POST['db']);
$status = strip_tags($_POST['status_ver']);
$id_profil = strip_tags($_POST['id_profil']);

$data = array(
    'status'      => $status,
    'catatan'     => $catatan,
    'id_operator' => $_SESSION['kode_user']
);

$result = $proses->edit_data($db, $data, 'id', $id);

if ($_POST['act'] == 'add') {
    $data2[] = array(
        'id'                => $id,
        'menu'              => $db,
        'id_profil'         => $id_profil,
        'catatan'           => $catatan,
        'status'            => $status
    );
    $result = $proses->tambah_data('catatan', $data2); // SIMPAN KE DATABASE
} else {
    $data3 = array(
        'catatan'     => $catatan,
        'status'      => $status
    );

    $result = $proses->edit_data_where('catatan', $data3, 'id', $id, 'menu', $db, 'id_profil', $id_profil);
}
