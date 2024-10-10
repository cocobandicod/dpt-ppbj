<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
if (@$_POST['act'] == 'add') {
    $data[] = array(
        'id_profil'        => $_SESSION['kode_profil'],
        'nama'             => strip_tags($_POST['nama']),
        'tgl_lahir'       => strip_tags($_POST['tgl_lahir']),
        'pendidikan'       => strip_tags($_POST['pendidikan']),
        'jabatan'          => strip_tags($_POST['jabatan']),
        'pengalaman'       => strip_tags($_POST['pengalaman']),
        'keahlian'         => strip_tags($_POST['keahlian']),
        'tahun_ijazah'     => strip_tags($_POST['tahun_ijazah'])
    );
    $result = $proses->tambah_data('tenaga_ahli', $data); // SIMPAN KE DATABASE
} else if (@$_POST['act'] == 'edit') {
    $data = array(
        'nama'             => strip_tags($_POST['nama']),
        'tgl_lahir'        => strip_tags($_POST['tgl_lahir']),
        'pendidikan'       => strip_tags($_POST['pendidikan']),
        'jabatan'          => strip_tags($_POST['jabatan']),
        'pengalaman'       => strip_tags($_POST['pengalaman']),
        'keahlian'         => strip_tags($_POST['keahlian']),
        'tahun_ijazah'     => strip_tags($_POST['tahun_ijazah'])
    );
    $result = $proses->edit_data('tenaga_ahli', $data, 'id', $_POST['id']); // SIMPAN KE DATABASE
} else if ($_POST['act'] == 'del') {
    $id = $_POST['del'];
    $result = $proses->hapus_data('tenaga_ahli', 'id', $id);
    exit();
}
