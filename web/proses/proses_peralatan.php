<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
if (@$_POST['act'] == 'add') {
    $data[] = array(
        'id_profil'         => $_SESSION['kode_profil'],
        'jenis_peralatan'   => strip_tags($_POST['jenis_peralatan']),
        'jumlah'            => strip_tags($_POST['jumlah']),
        'kapasitas'         => strip_tags($_POST['kapasitas']),
        'merek'             => strip_tags($_POST['merek']),
        'tahun'             => strip_tags($_POST['tahun']),
        'kondisi'           => strip_tags($_POST['kondisi']),
        'lokasi'            => strip_tags($_POST['lokasi'])
    );
    $result = $proses->tambah_data('peralatan', $data); // SIMPAN KE DATABASE
} else if (@$_POST['act'] == 'edit') {
    $data = array(
        'jenis_peralatan'   => strip_tags($_POST['jenis_peralatan']),
        'jumlah'            => strip_tags($_POST['jumlah']),
        'kapasitas'         => strip_tags($_POST['kapasitas']),
        'merek'             => strip_tags($_POST['merek']),
        'tahun'             => strip_tags($_POST['tahun']),
        'kondisi'           => strip_tags($_POST['kondisi']),
        'lokasi'            => strip_tags($_POST['lokasi'])
    );
    $result = $proses->edit_data('peralatan', $data, 'id', $_POST['id']); // SIMPAN KE DATABASE
} else if ($_POST['act'] == 'del') {
    $id = $_POST['del'];
    $result = $proses->hapus_data('peralatan', 'id', $id);
    exit();
}
