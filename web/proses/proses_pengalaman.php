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

            $t = array(',', '.');
            $nilai_kontrak = str_replace($t, '', $_POST['nilai_kontrak']);

            $data[] = array(
                'id_profil'             => $_SESSION['kode_profil'],
                'nama_pekerjaan'        => anti_injection($_POST['nama_pekerjaan']),
                'bidang_pekerjaan'      => anti_injection($_POST['bidang_pekerjaan']),
                'lokasi'                => anti_injection($_POST['lokasi']),
                'nama_pemberi'          => anti_injection($_POST['nama_pemberi']),
                'alamat_pemberi'        => anti_injection($_POST['alamat_pemberi']),
                'telepon_pemberi'       => strip_tags($_POST['telepon_pemberi']),
                'no_kontrak'            => strip_tags($_POST['no_kontrak']),
                'tgl_kontrak'           => strip_tags($_POST['tgl_kontrak']),
                'nilai_kontrak'         => $nilai_kontrak,
                'tgl_selesai'           => strip_tags($_POST['tgl_selesai']),
                'tgl_berita_acara'      => strip_tags($_POST['tgl_berita_acara']),
                'file'                  => $name1,
                'status'                => 'Pending'
            );
            $result = $proses->tambah_data('pengalaman', $data); // SIMPAN KE DATABASE
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

            $file = $proses->cek_fetch('pengalaman', 'id = "' . $_POST['id'] . '"');
            if (!empty($file['file'])) {
                unlink('../../berkas/' . $file['file']);
            }
            define("UPLOAD_DIR", "../../berkas/"); // LOKASI FILE
            $myFile1 = $_FILES['fupload'];
            $name1 = uniqid() . "." . $ext1;
            move_uploaded_file($myFile1['tmp_name'], UPLOAD_DIR . $name1);

            $t = array(',', '.');
            $nilai_kontrak = str_replace($t, '', $_POST['nilai_kontrak']);
            $data = array(
                'nama_pekerjaan'        => anti_injection($_POST['nama_pekerjaan']),
                'bidang_pekerjaan'      => anti_injection($_POST['bidang_pekerjaan']),
                'lokasi'                => anti_injection($_POST['lokasi']),
                'nama_pemberi'          => anti_injection($_POST['nama_pemberi']),
                'alamat_pemberi'        => anti_injection($_POST['alamat_pemberi']),
                'telepon_pemberi'       => strip_tags($_POST['telepon_pemberi']),
                'no_kontrak'            => strip_tags($_POST['no_kontrak']),
                'tgl_kontrak'           => strip_tags($_POST['tgl_kontrak']),
                'nilai_kontrak'         => $nilai_kontrak,
                'tgl_selesai'           => strip_tags($_POST['tgl_selesai']),
                'tgl_berita_acara'      => strip_tags($_POST['tgl_berita_acara']),
                'file'                  => $name1,
            );
            $result = $proses->edit_data('pengalaman', $data, 'id', $_POST['id']); // SIMPAN KE DATABASE
        }
    } else {

        $t = array(',', '.');
        $nilai_kontrak = str_replace($t, '', $_POST['nilai_kontrak']);
        $data = array(
            'nama_pekerjaan'        => anti_injection($_POST['nama_pekerjaan']),
            'bidang_pekerjaan'      => anti_injection($_POST['bidang_pekerjaan']),
            'lokasi'                => anti_injection($_POST['lokasi']),
            'nama_pemberi'          => anti_injection($_POST['nama_pemberi']),
            'alamat_pemberi'        => anti_injection($_POST['alamat_pemberi']),
            'telepon_pemberi'       => strip_tags($_POST['telepon_pemberi']),
            'no_kontrak'            => strip_tags($_POST['no_kontrak']),
            'tgl_kontrak'           => strip_tags($_POST['tgl_kontrak']),
            'nilai_kontrak'         => $nilai_kontrak,
            'tgl_selesai'           => strip_tags($_POST['tgl_selesai']),
            'tgl_berita_acara'      => strip_tags($_POST['tgl_berita_acara'])
        );
        $result = $proses->edit_data('pengalaman', $data, 'id', $_POST['id']); // SIMPAN KE DATABASE
    }
} else if ($_POST['act'] == 'del') {
    $id = $_POST['del'];
    $result = $proses->hapus_data('pengalaman', 'id', $id);
    exit();
}
