<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
require_once('../../config/fungsi_indotgl.php');

if ($_POST['act'] == 'add') {
    $data[] = array(
        'judul'             => strip_tags($_POST['judul']),
        'isi'               => $_POST['isi'],
        'tanggal'           => $tgl_sekarang
    );
    $result = $proses->tambah_data('info_penting', $data); // SIMPAN KE DATABASE
}

if ($_POST['act'] == 'edit') {
    $data = array(
        'judul'             => strip_tags($_POST['judul']),
        'isi'               => $_POST['isi']
    );
    $result = $proses->edit_data('info_penting', $data, 'id', $_POST['id']);
}

if ($_POST['act'] == 'del') {
    $id = $_POST['del'];
    $result = $proses->hapus_data('info_penting', 'id', $id);
}
