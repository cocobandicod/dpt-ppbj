<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

//$data = json_decode(file_get_contents('php://input'), true);

$cek = $proses->cek_count('jadwal', '1=1 AND nomor = "' . $_POST['id'] . '" AND kode_paket = "' . $_POST['kode'] . '"');
if (empty($cek)) {
    $data2[] = array(
        'nomor'        => $_POST['id'],
        'kode_paket'   => $_POST['kode'],
        'tahap'        => $_POST['tahap'],
        'tgl_mulai'    => $_POST['tgl_mulai'],
        'tgl_selesai'  => $_POST['tgl_selesai']
    );

    $result = $proses->tambah_data('jadwal', $data2);
} else {
    $data3 = array(
        'tgl_mulai'    => $_POST['tgl_mulai'],
        'tgl_selesai'  => $_POST['tgl_selesai']
    );

    $result = $proses->edit_data_where2('jadwal', $data3, 'nomor', $_POST['id'], 'kode_paket', $_POST['kode']);
}
