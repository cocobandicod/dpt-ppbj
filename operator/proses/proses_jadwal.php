<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
require_once('../../config/fungsi_indotgl.php');

if ($_POST['act'] == 'add') {
    $data[] = array(
        'id_paket'          => $_POST['id_paket'],
        'tahap'             => $_POST['tahap'],
        'tgl_mulai'         => $_POST['tgl_mulai1'] . ' ' . $_POST['tgl_mulai2'],
        'tgl_selesai'       => $_POST['tgl_selesai1'] . ' ' . $_POST['tgl_selesai2']
    );
    $result = $proses->tambah_data('jadwal_paket', $data);
}
if ($_POST['act'] == 'edit') {
    $data = array(
        'tahap'             => $_POST['tahap'],
        'tgl_mulai'         => $_POST['tgl_mulai1'] . ' ' . $_POST['tgl_mulai2'],
        'tgl_selesai'       => $_POST['tgl_selesai1'] . ' ' . $_POST['tgl_selesai2']
    );
    $result = $proses->edit_data('jadwal_paket', $data, 'id_jadwal', $_POST['id']);
}
if ($_POST['act'] == 'del') {
    $id = $_POST['del'];
    $result = $proses->hapus_data('jadwal_paket', 'id_jadwal', $id);
}
