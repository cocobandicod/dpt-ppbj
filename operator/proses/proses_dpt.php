<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
require_once('../../config/fungsi_indotgl.php');
require_once('../../config/email.php');

if (@$_POST['act'] == 'add') {

    $cek = $proses->cek_row(
        'daftar_penyedia_terpilih',
        '1=1 AND id_paket = "' . $_POST['id_paket'] . '"
        AND id_profil = "' . $_POST['id_profil'] . '"'
    );

    if ($cek != 1) {
        $data[] = array(
            'id_paket'          => $_POST['id_paket'],
            'id_profil'         => $_POST['id_profil']
        );
        $result = $proses->tambah_data('daftar_penyedia_terpilih', $data);
    } else {
        echo 'error';
        exit();
    }
}

if (@$_POST['act'] == 'kirim') {
    if (!empty($_FILES['fupload']['tmp_name'])) {
        $path1 = $_FILES['fupload']['name'];
        $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
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
                'id_paket'          => $_POST['id_paket'],
                'id_profil'         => $_POST['id_profil'],
                'judul'             => $_POST['judul'],
                'isi_undangan'      => $_POST['isi_undangan'],
                'file'              => $name1
            );
            $result = $proses->tambah_data('undangan', $data);
            $file = $name1;
        }
    } else {
        $data[] = array(
            'id_paket'          => $_POST['id_paket'],
            'id_profil'         => $_POST['id_profil'],
            'judul'             => $_POST['judul'],
            'isi_undangan'      => $_POST['isi_undangan']
        );
        $result = $proses->tambah_data('undangan', $data);
        $file = '';
    }

    //----------------------------------------------------------------------
    //$link = $url . 'aktivasi/kode/' . $tokenAkses;
    $template = template_undangan($_POST['judul'], $_POST['isi_undangan'], $_POST['email'], $file, $url);
    undangan_email($_POST['email'], $_POST['judul'], $template); // KIRIM EMAIL
    //----------------------------------------------------------------------
}

if (@$_POST['act'] == 'del') {
    $id = $_POST['del'];
    $result = $proses->hapus_data('daftar_penyedia_terpilih', 'id_daftar', $id);
}
