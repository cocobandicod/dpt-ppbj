<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
require_once('../../config/fungsi_indotgl.php');

if ($_POST['act'] == 'add') {
    $data[] = array(
        'judul'             => strip_tags($_POST['judul']),
        'judul_seo'         => seo_title($_POST['judul']),
        'isi'               => $_POST['isi'],
        'tanggal'           => $_POST['tanggal'],
        'id_operator'       => $_SESSION['kode_user']
    );
    $result = $proses->tambah_data('berita', $data); // SIMPAN KE DATABASE
}

if ($_POST['act'] == 'edit') {
    $data = array(
        'judul'             => strip_tags($_POST['judul']),
        'judul_seo'         => seo_title($_POST['judul']),
        'isi'               => $_POST['isi'],
        'tanggal'           => $_POST['tanggal']
    );
    $result = $proses->edit_data('berita', $data, 'id', $_POST['id']);
}

if ($_POST['act'] == 'del') {
    $id = $_POST['del'];
    $result = $proses->hapus_data('berita', 'id', $id);
}
