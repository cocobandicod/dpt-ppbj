<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/fungsi_indotgl.php');
require_once('../../config/cek_ajax.php');

if (@$_POST['act'] == 'daftar') {
    $data[] = array(
        'id_paket'   => strip_tags($_POST['paket']),
        'id_profil'  => $_SESSION['kode_profil']
    );
    $result = $proses->tambah_data('tender', $data); // SIMPAN KE DATABASE
}

if (@$_POST['aksi'] == 'dokumen_penawaran') {
    if (!empty($_FILES['fupload']['tmp_name'])) {
        $path1 = $_FILES['fupload']['name'];
        $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
        $ukuran_file = round($_FILES['fupload']['size'] / 1024, 2); // Ukuran file dalam KB
        $ekstensi_file = array('doc', 'docx', 'xls', 'xlsx', 'pdf', 'jpg', 'jpeg', 'png', 'zip', 'rar');
        $ekstensi_ok1 = in_array($ext1, $ekstensi_file);

        if (!$ekstensi_ok1) {
            echo 'gagal';
            exit();
        } else {
            // Pemeriksaan tipe MIME
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES['fupload']['tmp_name']);
            finfo_close($finfo);

            // Daftar tipe MIME yang diperbolehkan
            $allowedMimeTypes = array(
                "application/msword",                                      // .doc
                "application/vnd.openxmlformats-officedocument.wordprocessingml.document", // .docx
                "application/vnd.ms-excel",                                // .xls
                "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", // .xlsx
                "application/pdf",                                         // .pdf
                "image/jpeg",                                              // .jpg, .jpeg
                "image/png",                                               // .png
                "application/zip",                                         // .zip
                "application/x-rar-compressed",                            // .rar
                "application/octet-stream",                                // alternatif untuk .zip dan .rar
            );

            if (!in_array($mime, $allowedMimeTypes)) {
                echo 'gagal';
                exit();
            }

            define("UPLOAD_DIR", "../../berkas/penawaran/"); // LOKASI FILE
            $nama_file_bersih = preg_replace('/\s+/', '_', pathinfo($path1, PATHINFO_FILENAME));
            $file_perbaiki = uniqid(5) . "_" . $nama_file_bersih . "." . $ext1; // Nama file unik dengan format bersih

            if (move_uploaded_file($_FILES['fupload']['tmp_name'], UPLOAD_DIR . $file_perbaiki)) {
                $data1[] = array(
                    'id_kirim'   => $_POST['id_kirim'],
                    'id_profil'  => $_SESSION['kode_user'],
                    'kode_paket' => $_POST['kode_paket'],
                    'nama_file'  => $path1,        // Nama file asli
                    'ukuran_file' => $ukuran_file, // Ukuran file dalam KB
                    'file'       => $file_perbaiki, // Nama file yang diperbaiki
                    'act'        => $_POST['act'],
                    'timestamp'  => $tgl_jam
                );
                $result = $proses->tambah_data('kirim_penawaran', $data1); // SIMPAN KE DATABASE

                if ($result) {
                } else {
                    echo 'gagal';
                    exit();
                }
            } else {
                echo 'gagal';
                exit();
            }
        }
    }
}

if (@$_POST['act'] == 'hapus') {
    $id = $_POST['del'];
    $file = $proses->cek_fetch('kirim_penawaran', 'id = "' . $id . '"');
    if (!empty($file['file'])) {
        unlink('../../berkas/penawaran/' . $file['file']);
    }
    $result = $proses->hapus_data('kirim_penawaran', 'id', $id);
}
