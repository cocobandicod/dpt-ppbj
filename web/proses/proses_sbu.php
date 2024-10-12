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
                'jenis_izin'        => strip_tags($_POST['jenis_izin']),
                'no_registrasi'     => strip_tags($_POST['no_registrasi']),
                'nama_badan_usaha'  => strip_tags($_POST['nama_badan_usaha']),
                'nama_pimpinan'     => strip_tags($_POST['nama_pimpinan']),
                'alamat_badan'      => strip_tags($_POST['alamat_badan']),
                'kab_kota'          => strip_tags($_POST['kab_kota']),
                'provinsi'          => strip_tags($_POST['provinsi']),
                'kode_pos'          => strip_tags($_POST['kode_pos']),
                'email'             => strip_tags($_POST['email']),
                'no_telepon'        => strip_tags($_POST['no_telepon']),
                'no_fax'            => strip_tags($_POST['no_fax']),
                'npwp'              => strip_tags($_POST['npwp']),
                'jenis_usaha'       => strip_tags($_POST['jenis_usaha']),
                'sifat_usaha'       => strip_tags($_POST['sifat_usaha']),
                'kekayaan_bersih'   => strip_tags($_POST['kekayaan_bersih']),
                'masa_berlaku'      => strip_tags($_POST['masa_berlaku']),
                'file'              => $name1,
                'status'            => 'Pending'
            );
            $result = $proses->tambah_data('sbu', $data); // SIMPAN KE DATABASE
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

            $file = $proses->cek_fetch('sbu', 'id = "' . $_POST['id'] . '"');
            if (!empty($file['file'])) {
                unlink('../../berkas/' . $file['file']);
            }
            define("UPLOAD_DIR", "../../berkas/"); // LOKASI FILE
            $myFile1 = $_FILES['fupload'];
            $name1 = uniqid() . "." . $ext1;
            move_uploaded_file($myFile1['tmp_name'], UPLOAD_DIR . $name1);
            $data = array(
                'jenis_izin'        => strip_tags($_POST['jenis_izin']),
                'no_registrasi'     => strip_tags($_POST['no_registrasi']),
                'nama_badan_usaha'  => strip_tags($_POST['nama_badan_usaha']),
                'nama_pimpinan'     => strip_tags($_POST['nama_pimpinan']),
                'alamat_badan'      => strip_tags($_POST['alamat_badan']),
                'kab_kota'          => strip_tags($_POST['kab_kota']),
                'provinsi'          => strip_tags($_POST['provinsi']),
                'kode_pos'          => strip_tags($_POST['kode_pos']),
                'email'             => strip_tags($_POST['email']),
                'no_telepon'        => strip_tags($_POST['no_telepon']),
                'no_fax'            => strip_tags($_POST['no_fax']),
                'npwp'              => strip_tags($_POST['npwp']),
                'jenis_usaha'       => strip_tags($_POST['jenis_usaha']),
                'sifat_usaha'       => strip_tags($_POST['sifat_usaha']),
                'kekayaan_bersih'   => strip_tags($_POST['kekayaan_bersih']),
                'masa_berlaku'      => strip_tags($_POST['masa_berlaku']),
                'file'              => $name1
            );
            $result = $proses->edit_data('sbu', $data, 'id', $_POST['id']); // SIMPAN KE DATABASE
        }
    } else {
        $data = array(
            'jenis_izin'        => strip_tags($_POST['jenis_izin']),
            'no_registrasi'     => strip_tags($_POST['no_registrasi']),
            'nama_badan_usaha'  => strip_tags($_POST['nama_badan_usaha']),
            'nama_pimpinan'     => strip_tags($_POST['nama_pimpinan']),
            'alamat_badan'      => strip_tags($_POST['alamat_badan']),
            'kab_kota'          => strip_tags($_POST['kab_kota']),
            'provinsi'          => strip_tags($_POST['provinsi']),
            'kode_pos'          => strip_tags($_POST['kode_pos']),
            'email'             => strip_tags($_POST['email']),
            'no_telepon'        => strip_tags($_POST['no_telepon']),
            'no_fax'            => strip_tags($_POST['no_fax']),
            'npwp'              => strip_tags($_POST['npwp']),
            'jenis_usaha'       => strip_tags($_POST['jenis_usaha']),
            'sifat_usaha'       => strip_tags($_POST['sifat_usaha']),
            'kekayaan_bersih'   => strip_tags($_POST['kekayaan_bersih']),
            'masa_berlaku'      => strip_tags($_POST['masa_berlaku'])
        );
        $result = $proses->edit_data('sbu', $data, 'id', $_POST['id']); // SIMPAN KE DATABASE
    }
} else if ($_POST['act'] == 'del') {
    $id = $_POST['del'];
    $file = $proses->cek_fetch('sbu', 'id = "' . $id . '"');
    if (!empty($file['file'])) {
        unlink('../../berkas/' . $file['file']);
    }
    $result = $proses->hapus_data('sbu', 'id', $id);
    exit();
}
