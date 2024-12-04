<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/email.php');
require_once('../../config/cek_ajax.php');
require_once('../../config/fungsi_indotgl.php');

if (@$_POST['act'] == 'status_paket') {
    $data = array(
        'status_paket'    => strip_tags($_POST['sts'])
    );
    $result = $proses->edit_data('paket_pekerjaan', $data, 'kode_paket', $_POST['id']);
}

if (@$_POST['act'] == 'upload_lainnya') { // INSERT
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
                "application/pdf",                                         // .pdf
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

            $data1[] = array(
                'kode_paket' => $_POST['id'],
                'nama_file'  => $path1,
                'file'       => $name1,
                'jenis'      => 'Lainnya'
            );
            $result = $proses->tambah_data('dokumen_persiapan', $data1); // SIMPAN KE DATABASE
        }
    }
}

if ($_POST['act'] == 'pilih_pokja') {
    $data[] = array(
        'kode_paket'        => strip_tags($_POST['id']),
        'id_operator'       => strip_tags($_POST['operator']),
        'status'            => 'POKJA'
    );
    $result = $proses->tambah_data('penugasan', $data);
}

if (@$_POST['act'] == 'hapus_pokja') {
    $id = $_POST['id'];
    $result = $proses->hapus_data('penugasan', 'id', $id);
}

if (@$_POST['act'] == 'kirim_email_pokja') {
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

            $sql = $proses->tampil_data_select(
                'a.id_operator, b.email',
                'penugasan a LEFT JOIN operator b 
                ON a.id_operator = b.id_operator',
                '1=1 AND a.kode_paket = "' . $_POST['kode_paket'] . '" AND a.status = "POKJA"'
            );
            $data = [];
            foreach ($sql as $row) {
                $data[] = array(
                    'kode_paket'        => $_POST['kode_paket'],
                    'id_operator'       => $row['id_operator'],
                    'judul'             => 'Nota Dinas Kepala UKPBJ',
                    'isi_undangan'      => $_POST['isi_undangan'],
                    'file'              => $name1
                );
                //----------------------------------------------------------------------
                //$link = $url . 'aktivasi/kode/' . $tokenAkses;
                $template = template_pokja($_POST['isi_undangan'], $row['email'], $name1, $url);
                undangan_email($row['email'], 'Nota Dinas Kepala UKPBJ', $template); // KIRIM EMAIL
                //----------------------------------------------------------------------
            }

            $result = $proses->tambah_data('undangan_pokja', $data);
        }
    } else {
        exit();
    }
}
