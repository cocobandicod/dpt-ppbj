<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
require_once('../../config/fungsi_indotgl.php');

if ($_POST['act'] == 'add') {
    $t = array(',', '.');
    $nilai = str_replace($t, '', $_POST['nilai']);
    $data[] = array(
        'pekerjaan'         => strip_tags($_POST['pekerjaan']),
        'nama_perusahaan'   => strip_tags($_POST['nama_perusahaan']),
        'nilai'             => $nilai,
        'tahun_anggaran'    => $_POST['tahun_anggaran'],
        'tanggal'           => $tgl_sekarang
    );
    $result = $proses->tambah_data('pengumuman', $data); // SIMPAN KE DATABASE
}

if ($_POST['act'] == 'edit') {
    $data = array(
        'pekerjaan'         => strip_tags($_POST['pekerjaan']),
        'nama_perusahaan'   => strip_tags($_POST['nama_perusahaan']),
        'nilai'             => $nilai,
        'tahun_anggaran'    => $_POST['tahun_anggaran']
    );
    $result = $proses->edit_data('pengumuman', $data, 'id', $_POST['id']);
}

if ($_POST['act'] == 'del') {
    $id = $_POST['del'];
    $result = $proses->hapus_data('pengumuman', 'id', $id);
}
