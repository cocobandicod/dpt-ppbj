<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
require_once('../../config/fungsi_indotgl.php');

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
            define("UPLOAD_DIR", "../../download/"); // LOKASI FILE
            $myFile1 = $_FILES['fupload'];
            $name1 = uniqid() . "." . $ext1;
            move_uploaded_file($myFile1['tmp_name'], UPLOAD_DIR . $name1);
            $data[] = array(
                'judul'             => strip_tags($_POST['judul']),
                'file'              => $name1,
                'tanggal'           => $tgl_sekarang
            );
            $result = $proses->tambah_data('panduan', $data); // SIMPAN KE DATABASE
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
            $file = $proses->cek_fetch('panduan', 'id = "' . $_POST['id'] . '"');
            if (!empty($file['file'])) {
                unlink('../../download/' . $file['file']);
            }
            define("UPLOAD_DIR", "../../download/"); // LOKASI FILE
            $myFile1 = $_FILES['fupload'];
            $name1 = uniqid() . "." . $ext1;
            move_uploaded_file($myFile1['tmp_name'], UPLOAD_DIR . $name1);
            $data = array(
                'judul'             => strip_tags($_POST['judul']),
                'file'              => $name1
            );
            $result = $proses->edit_data('panduan', $data, 'id', $_POST['id']); // SIMPAN KE DATABASE
        }
    } else {
        $data = array(
            'judul'             => strip_tags($_POST['judul'])
        );
        $result = $proses->edit_data('panduan', $data, 'id', $_POST['id']); // SIMPAN KE DATABASE
    }
} else if ($_POST['act'] == 'del') {
    $id = $_POST['del'];
    $file = $proses->cek_fetch('panduan', 'id = "' . $id . '"');
    if (!empty($file['file'])) {
        unlink('../../download/' . $file['file']);
    }
    $result = $proses->hapus_data('panduan', 'id', $id);
    exit();
}
