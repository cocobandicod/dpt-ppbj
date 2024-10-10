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
        } else {
            define("UPLOAD_DIR", "../../berkas/"); // LOKASI FILE
            $myFile1 = $_FILES['fupload'];
            $name1 = uniqid() . "." . $ext1;
            move_uploaded_file($myFile1['tmp_name'], UPLOAD_DIR . $name1);
            $data[] = array(
                'id_profil'         => $_SESSION['kode_profil'],
                'jenis_izin'        => strip_tags($_POST['jenis_izin']),
                'nomor'             => strip_tags($_POST['nomor']),
                'tanggal'           => strip_tags($_POST['tanggal']),
                'masa_berlaku'      => strip_tags($_POST['masa_berlaku']),
                'instansi_pemberi'  => strip_tags($_POST['instansi_pemberi']),
                'grade'             => strip_tags($_POST['grade']),
                'file'              => $name1,
                'status'            => 'Pending'
            );
            $result = $proses->tambah_data('izin_usaha', $data); // SIMPAN KE DATABASE
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
        } else {
            $file = $proses->cek_fetch('izin_usaha', 'id = "' . $_POST['id'] . '"');
            if (!empty($file['file'])) {
                unlink('../../berkas/' . $file['file']);
            }
            define("UPLOAD_DIR", "../../berkas/"); // LOKASI FILE
            $myFile1 = $_FILES['fupload'];
            $name1 = uniqid() . "." . $ext1;
            move_uploaded_file($myFile1['tmp_name'], UPLOAD_DIR . $name1);
            $data = array(
                'jenis_izin'        => strip_tags($_POST['jenis_izin']),
                'nomor'             => strip_tags($_POST['nomor']),
                'tanggal'           => strip_tags($_POST['tanggal']),
                'masa_berlaku'      => strip_tags($_POST['masa_berlaku']),
                'instansi_pemberi'  => strip_tags($_POST['instansi_pemberi']),
                'grade'             => strip_tags($_POST['grade']),
                'file'              => $name1
            );
            $result = $proses->edit_data('izin_usaha', $data, 'id', $_POST['id']); // SIMPAN KE DATABASE
        }
    } else {
        $data = array(
            'jenis_izin'        => strip_tags($_POST['jenis_izin']),
            'nomor'             => strip_tags($_POST['nomor']),
            'tanggal'           => strip_tags($_POST['tanggal']),
            'masa_berlaku'      => strip_tags($_POST['masa_berlaku']),
            'instansi_pemberi'  => strip_tags($_POST['instansi_pemberi']),
            'grade'             => strip_tags($_POST['grade'])
        );
        $result = $proses->edit_data('izin_usaha', $data, 'id', $_POST['id']); // SIMPAN KE DATABASE
    }
} else if ($_POST['act'] == 'del') {
    $id = $_POST['del'];
    $file = $proses->cek_fetch('izin_usaha', 'id = "' . $id . '"');
    if (!empty($file['file'])) {
        unlink('../../berkas/' . $file['file']);
    }
    $result = $proses->hapus_data('izin_usaha', 'id', $id);
    exit();
}
