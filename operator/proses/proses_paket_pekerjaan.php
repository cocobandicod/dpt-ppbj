<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
require_once('../../config/fungsi_indotgl.php');

if ($_POST['act'] == 'add') {
    $t = array(',', '.');
    $nilai_pagu = str_replace($t, '', $_POST['nilai_pagu']);
    $nilai_hps = str_replace($t, '', $_POST['nilai_hps']);

    if (!empty($_FILES['fupload']['tmp_name'])) {
        $path1 = $_FILES['fupload']['name'];
        $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
        //$mime = $_FILES['fupload']['type'];
        $ekstensi_file  = array('pdf');
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
                'kode'              => random_char(10),
                'kode_paket'        => strip_tags($_POST['kode_paket']),
                'nama_pekerjaan'    => strip_tags($_POST['nama_pekerjaan']),
                'uraian_singkat'    => strip_tags($_POST['uraian_singkat']),
                'tanggal'           => $_POST['tanggal'],
                'tahun_anggaran'    => $_POST['tahun_anggaran'],
                'sumber_dana'       => $_POST['sumber_dana'],
                'nilai_pagu'        => $nilai_pagu,
                'nilai_hps'         => $nilai_hps,
                'lokasi_pekerjaan'  => $_POST['lokasi_pekerjaan'],
                'kualifikasi_usaha' => $_POST['kualifikasi_usaha'],
                'syarat_kualifikasi' => $_POST['syarat_kualifikasi'],
                'file_pemilihan'     => $name1
            );
            $result = $proses->tambah_data('paket_pekerjaan', $data); // SIMPAN KE DATABASE
        }
    }
}

if ($_POST['act'] == 'edit') {
    $t = array(',', '.');
    $nilai_pagu = str_replace($t, '', $_POST['nilai_pagu']);
    $nilai_hps = str_replace($t, '', $_POST['nilai_hps']);

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
            );

            // Pemeriksaan tipe MIME file
            if (!in_array($mime, $allowedMimeTypes)) {
                echo 'gagal';
                exit();
            }

            $file = $proses->cek_fetch('paket_pekerjaan', 'id_paket = "' . $_POST['id'] . '"');
            if (!empty($file['file_pemilihan'])) {
                unlink('../../berkas/' . $file['file_pemilihan']);
            }

            define("UPLOAD_DIR", "../../berkas/"); // LOKASI FILE
            $myFile1 = $_FILES['fupload'];
            $name1 = uniqid() . "." . $ext1;
            move_uploaded_file($myFile1['tmp_name'], UPLOAD_DIR . $name1);
            $data = array(
                'kode_paket'         => strip_tags($_POST['kode_paket']),
                'nama_pekerjaan'     => strip_tags($_POST['nama_pekerjaan']),
                'uraian_singkat'     => strip_tags($_POST['uraian_singkat']),
                'tanggal'            => $_POST['tanggal'],
                'tahun_anggaran'     => $_POST['tahun_anggaran'],
                'sumber_dana'        => $_POST['sumber_dana'],
                'nilai_pagu'         => $nilai_pagu,
                'nilai_hps'          => $nilai_hps,
                'lokasi_pekerjaan'   => $_POST['lokasi_pekerjaan'],
                'kualifikasi_usaha'  => $_POST['kualifikasi_usaha'],
                'syarat_kualifikasi' => $_POST['syarat_kualifikasi'],
                'file_pemilihan'     => $name1
            );
            $result = $proses->edit_data('paket_pekerjaan', $data, 'id_paket', $_POST['id']);
        }
    } else {
        $data = array(
            'kode_paket'        => strip_tags($_POST['kode_paket']),
            'nama_pekerjaan'    => strip_tags($_POST['nama_pekerjaan']),
            'uraian_singkat'    => strip_tags($_POST['uraian_singkat']),
            'tanggal'           => $_POST['tanggal'],
            'tahun_anggaran'    => $_POST['tahun_anggaran'],
            'sumber_dana'       => $_POST['sumber_dana'],
            'nilai_pagu'        => $nilai_pagu,
            'nilai_hps'         => $nilai_hps,
            'lokasi_pekerjaan'  => $_POST['lokasi_pekerjaan'],
            'kualifikasi_usaha' => $_POST['kualifikasi_usaha'],
            'syarat_kualifikasi' => $_POST['syarat_kualifikasi']
        );
        $result = $proses->edit_data('paket_pekerjaan', $data, 'id_paket', $_POST['id']);
    }
}

if ($_POST['act'] == 'del') {
    $id = $_POST['del'];
    $file = $proses->cek_fetch('paket_pekerjaan', 'id_paket = "' . $id . '"');
    if (!empty($file['file_pemilihan'])) {
        unlink('../../berkas/' . $file['file_pemilihan']);
    }
    $result = $proses->hapus_data('paket_pekerjaan', 'id_paket', $id);
}
