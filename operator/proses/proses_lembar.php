<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

if (!empty($_FILES['fupload']['tmp_name'])) {
    $path1 = $_FILES['fupload']['name'];
    $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
    $ekstensi_file  = array('jpg', 'jpeg', 'pdf');
    $ekstensi_ok1    = in_array($ext1, $ekstensi_file);
    if (!($ekstensi_ok1)) {
        echo 'gagal';
    } else {
        $file = $proses->cek_fetch('dokumen_verifikasi', 'id_profil = "' . $_POST['id_profil'] . '"');
        if (!empty($file['file_verifikasi'])) {
            unlink('../../berkas/' . $file['file_verifikasi']);
        }
        define("UPLOAD_DIR1", "../../berkas/"); // LOKASI FILE
        $myFile1 = $_FILES['fupload'];
        $name1 = uniqid() . "." . $ext1;
        move_uploaded_file($myFile1['tmp_name'], UPLOAD_DIR1 . $name1);
        $data = array(
            'file_verifikasi'  => $name1
        );
        $result = $proses->edit_data('dokumen_verifikasi', $data, 'id_profil', $_POST['id_profil']); // SIMPAN KE DATABASE
    }
}

if (@$_POST['act'] == 'del') {

    $id = $_POST['id'];
    $file = $proses->cek_fetch('dokumen_verifikasi', 'id_profil = "' . $_POST['id_profil'] . '"');
    if (!empty($file[$id])) {
        unlink('../../berkas/' . $file[$id]);
    }

    $data = array(
        $id  => ''
    );

    $result = $proses->edit_data('dokumen_verifikasi', $data, 'id_profil', $_POST['id_profil']); // SIMPAN KE DATABASE
    exit();
}
