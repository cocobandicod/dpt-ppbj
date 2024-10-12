<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

if (!empty($_FILES['fupload1']['tmp_name'])) {
    $path1 = $_FILES['fupload1']['name'];
    $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
    $ekstensi_file  = array('pdf');
    $ekstensi_ok1    = in_array($ext1, $ekstensi_file);
    if (!($ekstensi_ok1)) {
        echo 'gagal';
        exit();
    } else {
        $file = $proses->cek_fetch('dokumen_penawaran_biaya', 'id_profil = "' . $_SESSION['kode_profil'] . '"');
        if (!empty($file['file_penawaran_biaya'])) {
            unlink('../../berkas/' . $file['file_penawaran_biaya']);
        }

        // Pemeriksaan tipe MIME
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['fupload1']['tmp_name']);
        finfo_close($finfo);

        // Daftar tipe MIME yang diperbolehkan
        $allowedMimeTypes = array(
            "application/pdf",
        );

        // Pemeriksaan tipe MIME file
        if (!in_array($mime, $allowedMimeTypes)) {
            echo 'gagal';
            exit();
        }


        define("UPLOAD_DIR1", "../../berkas/"); // LOKASI FILE
        $myFile1 = $_FILES['fupload1'];
        $name1 = uniqid() . "." . $ext1;
        move_uploaded_file($myFile1['tmp_name'], UPLOAD_DIR1 . $name1);
        $data = array(
            'file_penawaran_biaya'  => $name1
        );
        $result = $proses->edit_data('dokumen_penawaran_biaya', $data, 'id_profil', $_SESSION['kode_profil']); // SIMPAN KE DATABASE
    }
}

if (!empty($_FILES['fupload2']['tmp_name'])) {
    $path1 = $_FILES['fupload2']['name'];
    $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
    $ekstensi_file  = array('jpg', 'jpeg', 'pdf');
    $ekstensi_ok1    = in_array($ext1, $ekstensi_file);
    if (!($ekstensi_ok1)) {
        echo 'gagal';
        exit();
    } else {
        $file = $proses->cek_fetch('dokumen_penawaran_biaya', 'id_profil = "' . $_SESSION['kode_profil'] . '"');
        if (!empty($file['file_rekapitulasi'])) {
            unlink('../../berkas/' . $file['file_rekapitulasi']);
        }

        // Pemeriksaan tipe MIME
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['fupload2']['tmp_name']);
        finfo_close($finfo);

        // Daftar tipe MIME yang diperbolehkan
        $allowedMimeTypes = array(
            "application/pdf",
        );

        // Pemeriksaan tipe MIME file
        if (!in_array($mime, $allowedMimeTypes)) {
            echo 'gagal';
            exit();
        }

        define("UPLOAD_DIR2", "../../berkas/"); // LOKASI FILE
        $myFile1 = $_FILES['fupload2'];
        $name1 = uniqid() . "." . $ext1;
        move_uploaded_file($myFile1['tmp_name'], UPLOAD_DIR2 . $name1);
        $data = array(
            'file_rekapitulasi'  => $name1
        );
        $result = $proses->edit_data('dokumen_penawaran_biaya', $data, 'id_profil', $_SESSION['kode_profil']); // SIMPAN KE DATABASE
    }
}

if (!empty($_FILES['fupload3']['tmp_name'])) {
    $path1 = $_FILES['fupload3']['name'];
    $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
    $ekstensi_file  = array('jpg', 'jpeg', 'pdf');
    $ekstensi_ok1    = in_array($ext1, $ekstensi_file);
    if (!($ekstensi_ok1)) {
        echo 'gagal';
        exit();
    } else {
        $file = $proses->cek_fetch('dokumen_penawaran_biaya', 'id_profil = "' . $_SESSION['kode_profil'] . '"');
        if (!empty($file['file_rincian_komponen'])) {
            unlink('../../berkas/' . $file['file_rincian_komponen']);
        }

        // Pemeriksaan tipe MIME
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['fupload3']['tmp_name']);
        finfo_close($finfo);

        // Daftar tipe MIME yang diperbolehkan
        $allowedMimeTypes = array(
            "application/pdf",
        );

        // Pemeriksaan tipe MIME file
        if (!in_array($mime, $allowedMimeTypes)) {
            echo 'gagal';
            exit();
        }

        define("UPLOAD_DIR3", "../../berkas/"); // LOKASI FILE
        $myFile1 = $_FILES['fupload3'];
        $name1 = uniqid() . "." . $ext1;
        move_uploaded_file($myFile1['tmp_name'], UPLOAD_DIR3 . $name1);
        $data = array(
            'file_rincian_komponen'  => $name1
        );
        $result = $proses->edit_data('dokumen_penawaran_biaya', $data, 'id_profil', $_SESSION['kode_profil']); // SIMPAN KE DATABASE
    }
}


if (@$_POST['act'] == 'del') {

    $id = $_POST['id'];
    $file = $proses->cek_fetch('dokumen_penawaran_biaya', 'id_profil = "' . $_SESSION['kode_profil'] . '"');
    if (!empty($file[$id])) {
        unlink('../../berkas/' . $file[$id]);
    }

    $data = array(
        $id  => ''
    );

    $result = $proses->edit_data('dokumen_penawaran_biaya', $data, 'id_profil', $_SESSION['kode_profil']); // SIMPAN KE DATABASE
    exit();
}
