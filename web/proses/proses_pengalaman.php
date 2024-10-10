<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
if (@$_POST['act'] == 'add') {
    $data[] = array(
        'id_profil'             => $_SESSION['kode_profil'],
        'nama_pekerjaan'        => strip_tags($_POST['nama_pekerjaan']),
        'bidang_pekerjaan'      => strip_tags($_POST['bidang_pekerjaan']),
        'lokasi'                => strip_tags($_POST['lokasi']),
        'nama_pemberi'          => strip_tags($_POST['nama_pemberi']),
        'alamat_pemberi'        => strip_tags($_POST['alamat_pemberi']),
        'telepon_pemberi'       => strip_tags($_POST['telepon_pemberi']),
        'no_kontrak'            => strip_tags($_POST['no_kontrak']),
        'tgl_kontrak'           => strip_tags($_POST['tgl_kontrak']),
        'nilai_kontrak'         => strip_tags($_POST['nilai_kontrak']),
        'tgl_selesai'           => strip_tags($_POST['tgl_selesai']),
        'tgl_berita_acara'      => strip_tags($_POST['tgl_berita_acara'])
    );
    $result = $proses->tambah_data('pengalaman', $data); // SIMPAN KE DATABASE
} else if (@$_POST['act'] == 'edit') {
    $data = array(
        'nama_pekerjaan'        => strip_tags($_POST['nama_pekerjaan']),
        'bidang_pekerjaan'      => strip_tags($_POST['bidang_pekerjaan']),
        'lokasi'                => strip_tags($_POST['lokasi']),
        'nama_pemberi'          => strip_tags($_POST['nama_pemberi']),
        'alamat_pemberi'        => strip_tags($_POST['alamat_pemberi']),
        'telepon_pemberi'       => strip_tags($_POST['telepon_pemberi']),
        'no_kontrak'            => strip_tags($_POST['no_kontrak']),
        'tgl_kontrak'           => strip_tags($_POST['tgl_kontrak']),
        'nilai_kontrak'         => strip_tags($_POST['nilai_kontrak']),
        'tgl_selesai'           => strip_tags($_POST['tgl_selesai']),
        'tgl_berita_acara'      => strip_tags($_POST['tgl_berita_acara'])
    );
    $result = $proses->edit_data('pengalaman', $data, 'id', $_POST['id']); // SIMPAN KE DATABASE
} else if ($_POST['act'] == 'del') {
    $id = $_POST['del'];
    $result = $proses->hapus_data('pengalaman', 'id', $id);
    exit();
}
