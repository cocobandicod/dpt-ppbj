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

if ($_POST['act'] == 'delfile') {
    $id = $_POST['del'];
    $file = $proses->cek_fetch('dokumen_persiapan', 'id = "' . $id . '"');
    if (!empty($file['file'])) {
        unlink('../../berkas/' . $file['file']);
    }
    $result = $proses->hapus_data('dokumen_persiapan', 'id', $id);
}

if ($_POST['act'] == 'buat') {
    $data[] = array(
        'kode'              => random_char(10),
        'kode_paket'        => strip_tags($_POST['kode']),
        'nama_pekerjaan'    => strip_tags($_POST['nama']),
        'lokasi_pekerjaan'  => strip_tags($_POST['lokasi']),
        'status'            => 'Draf'
    );
    $result = $proses->tambah_data('paket_pekerjaan', $data);
}

if ($_POST['act'] == 'pilih_ukpbj') {
    $data[] = array(
        'id_paket'          => strip_tags($_POST['id']),
        'id_operator'       => strip_tags($_POST['operator']),
        'status'            => 'UKPBJ'
    );
    $result = $proses->tambah_data('penugasan', $data);
}

if ($_POST['act'] == 'buat_update') {
    $t = array(',', '.');
    $nilai_pagu = str_replace($t, '', $_POST['nilai_pagu']);
    $data = array(
        'nama_pekerjaan'    => strip_tags($_POST['nama_pekerjaan']),
        'tahun_anggaran'    => $_POST['tahun_anggaran'],
        'sumber_dana'       => $_POST['sumber_dana'],
        'nilai_pagu'        => $nilai_pagu,
        'lokasi_pekerjaan'  => $_POST['lokasi_pekerjaan']
    );
    $result = $proses->edit_data('paket_pekerjaan', $data, 'kode_paket', $_POST['kode_paket']);
}

if ($_POST['act'] == 'upload_hps') { // INSERT
    $t = array(',', '.');
    $nilai_hps = str_replace($t, '', $_POST['nilai_hps']);

    if (!empty($_FILES['fupload']['tmp_name'])) {
        $path1 = $_FILES['fupload']['name'];
        $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
        //$mime = $_FILES['fupload']['type'];
        $ekstensi_file  = array('xls', 'xlsx');
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
                "application/vnd.ms-excel",
                "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            );

            // Pemeriksaan tipe MIME file
            if (!in_array($mime, $allowedMimeTypes)) {
                echo 'gagal';
                exit();
            }

            $file = $proses->cek_fetch('dokumen_persiapan', 'kode_paket = "' . $_POST['id'] . '"');
            if (!empty($file['file'])) {
                unlink('../../berkas/' . $file['file']);
            }

            define("UPLOAD_DIR", "../../berkas/"); // LOKASI FILE
            $myFile1 = $_FILES['fupload'];
            $name1 = uniqid() . "." . $ext1;
            move_uploaded_file($myFile1['tmp_name'], UPLOAD_DIR . $name1);

            $data1[] = array(
                'kode_paket' => $_POST['id'],
                'nama_file'  => $path1,
                'file'       => $name1,
                'jenis'      => 'HPS'
            );
            $result = $proses->tambah_data('dokumen_persiapan', $data1); // SIMPAN KE DATABASE

            $data = array(
                'nilai_hps' => $nilai_hps
            );
            $result = $proses->edit_data('paket_pekerjaan', $data, 'kode_paket', $_POST['id']);
        }
    }
}

if ($_POST['act'] == 'update_hps') { // UPDATE
    $t = array(',', '.');
    $nilai_hps = str_replace($t, '', $_POST['nilai_hps']);

    if (!empty($_FILES['fupload']['tmp_name'])) {
        $path1 = $_FILES['fupload']['name'];
        $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
        //$mime = $_FILES['fupload']['type'];
        $ekstensi_file  = array('xls', 'xlsx');
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
                "application/vnd.ms-excel",
                "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
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

            $data1 = array(
                'nama_file'  => $path1,
                'file'       => $name1,
            );
            $result = $proses->edit_data('dokumen_persiapan', $data1, 'kode_paket', $_POST['id']);

            $data = array(
                'nilai_hps' => $nilai_hps
            );
            $result = $proses->edit_data('paket_pekerjaan', $data, 'kode_paket', $_POST['id']);
        }
    } else {
        $data = array(
            'nilai_hps' => $nilai_hps
        );
        $result = $proses->edit_data('paket_pekerjaan', $data, 'kode_paket', $_POST['id']);
    }
}

if ($_POST['act'] == 'upload_kak') { // INSERT
    if (!empty($_FILES['fupload']['tmp_name'])) {
        $path1 = $_FILES['fupload']['name'];
        $ext1 = pathinfo($path1, PATHINFO_EXTENSION);
        //$mime = $_FILES['fupload']['type'];
        $ekstensi_file  = array('doc', 'docx', 'xls', 'xlsx', 'pdf', 'jpg', 'jpeg', 'png', 'zip', 'rar');
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
                'jenis'      => 'KAK'
            );
            $result = $proses->tambah_data('dokumen_persiapan', $data1); // SIMPAN KE DATABASE
        }
    }
}

if ($_POST['act'] == 'upload_kontrak') { // INSERT
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
                'jenis'      => 'Kontrak'
            );
            $result = $proses->tambah_data('dokumen_persiapan', $data1); // SIMPAN KE DATABASE
        }
    }
}

if ($_POST['act'] == 'upload_pekerjaan') { // INSERT
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
                'jenis'      => 'Pekerjaan'
            );
            $result = $proses->tambah_data('dokumen_persiapan', $data1); // SIMPAN KE DATABASE
        }
    }
}

if ($_POST['act'] == 'upload_lainnya') { // INSERT
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

if ($_POST['act'] == 'hapus_ukpbj') {
    $id = $_POST['id'];
    $result = $proses->hapus_data('penugasan', 'id', $id);
}
