<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
if (@$_POST['act'] == 'add') {
    if (!empty($_FILES['fupload']['tmp_name'])) {
        $path1 = $_FILES['fupload']['name'];
        $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
        //$mime = $_FILES['fupload']['type'];
        $ekstensi_file  = array('jpg', 'jpeg', 'pdf');
        $ekstensi_ok1    = in_array($ext1, $ekstensi_file);
        if (!($ekstensi_ok1)) {
            echo 'gagal';
            exit();
        } else {

            // Pemeriksaan tipe MIME
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES['fupload']['tmp_name']);
            finfo_close($finfo);

            // Daftar tipe MIME yang diperbolehkan
            $allowedMimeTypes = array(
                "application/pdf",
                "image/jpeg",
            );

            // Pemeriksaan tipe MIME file
            if (!in_array($mime, $allowedMimeTypes)) {
                echo 'gagal';
                exit();
            }

            define("UPLOAD_DIR", "../../berkas/"); // LOKASI FILE
            $myFile1 = $_FILES['fupload'];
            $name1 = uniqid() . "." . $ext1;
            move_uploaded_file($myFile1['tmp_name'], UPLOAD_DIR . $name1);
            $data[] = array(
                'id_profil'         => $_SESSION['kode_profil'],
                'nomor'             => strip_tags($_POST['nomor']),
                'tanggal'           => strip_tags($_POST['tanggal']),
                'masa_berlaku'      => strip_tags($_POST['masa_berlaku']),
                'file'              => $name1,
                'status'            => 'Pending'
            );
            $result = $proses->tambah_data('tdp', $data); // SIMPAN KE DATABASE
        }
    }
} else if (@$_POST['act'] == 'edit') {
    if (!empty($_FILES['fupload']['tmp_name'])) {
        $path1 = $_FILES['fupload']['name'];
        $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
        //$mime = $_FILES['fupload']['type'];
        $ekstensi_file  = array('jpg', 'jpeg', 'pdf');
        $ekstensi_ok1    = in_array($ext1, $ekstensi_file);
        if (!($ekstensi_ok1)) {
            echo 'gagal';
            exit();
        } else {

            // Pemeriksaan tipe MIME
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES['fupload']['tmp_name']);
            finfo_close($finfo);

            // Daftar tipe MIME yang diperbolehkan
            $allowedMimeTypes = array(
                "application/pdf",
                "image/jpeg",
            );

            // Pemeriksaan tipe MIME file
            if (!in_array($mime, $allowedMimeTypes)) {
                echo 'gagal';
                exit();
            }

            $file = $proses->cek_fetch('tdp', 'id = "' . $_POST['id'] . '"');
            if (!empty($file['file'])) {
                unlink('../../berkas/' . $file['file']);
            }
            define("UPLOAD_DIR", "../../berkas/"); // LOKASI FILE
            $myFile1 = $_FILES['fupload'];
            $name1 = uniqid() . "." . $ext1;
            move_uploaded_file($myFile1['tmp_name'], UPLOAD_DIR . $name1);
            $data = array(
                'nomor'             => strip_tags($_POST['nomor']),
                'tanggal'           => strip_tags($_POST['tanggal']),
                'masa_berlaku'      => strip_tags($_POST['masa_berlaku']),
                'file'              => $name1
            );
            $result = $proses->edit_data('tdp', $data, 'id', $_POST['id']); // SIMPAN KE DATABASE
        }
    } else {
        $data = array(
            'nomor'             => strip_tags($_POST['nomor']),
            'tanggal'           => strip_tags($_POST['tanggal']),
            'masa_berlaku'      => strip_tags($_POST['masa_berlaku'])
        );
        $result = $proses->edit_data('tdp', $data, 'id', $_POST['id']); // SIMPAN KE DATABASE
    }
} else if ($_POST['act'] == 'del') {
    $id = $_POST['del'];
    $file = $proses->cek_fetch('tdp', 'id = "' . $id . '"');
    if (!empty($file['file'])) {
        unlink('../../berkas/' . $file['file']);
    }
    $result = $proses->hapus_data('tdp', 'id', $id);
    exit();
}
