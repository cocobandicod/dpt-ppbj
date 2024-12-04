<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/email.php');
require_once('../../config/cek_ajax.php');
require_once('../../config/fungsi_indotgl.php');
require_once('../../vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

if (@$_POST['act'] == 'buat') {
    $data[] = array(
        'kode'              => random_char(10),
        'kode_paket'        => strip_tags($_POST['kode']),
        'nama_pekerjaan'    => strip_tags($_POST['nama']),
        'tanggal'           => $tgl_sekarang,
        'tahun_anggaran'    => strip_tags($_POST['tahun']),
        'lokasi_pekerjaan'  => strip_tags($_POST['lokasi']),
        'status'            => 'Draf'
    );
    $result = $proses->tambah_data('paket_pekerjaan', $data);
}

if (@$_POST['act'] == 'buat_update') {
    $t = array(',', '.');
    $nilai_pagu = str_replace($t, '', $_POST['nilai_pagu']);
    $data = array(
        'nama_pekerjaan'    => strip_tags($_POST['nama_pekerjaan']),
        'tahun_anggaran'    => $_POST['tahun_anggaran'],
        'satuan_kerja'      => $_POST['satuan_kerja'],
        'sumber_dana'       => $_POST['sumber_dana'],
        'kode_anggaran'     => $_POST['kode_anggaran'],
        'nilai_pagu'        => $nilai_pagu,
        'lokasi_pekerjaan'  => $_POST['lokasi_pekerjaan'],
        'jenis_pengadaan'   => $_POST['jenis_pengadaan'],
        'metode_pengadaan'  => $_POST['metode_pengadaan'],
        'metode_evaluasi'   => $_POST['metode_evaluasi'],
    );
    $result = $proses->edit_data('paket_pekerjaan', $data, 'kode_paket', $_POST['kode_paket']);
}

if (@$_POST['act'] == 'delfile') {
    $id = $_POST['del'];
    $file = $proses->cek_fetch('dokumen_persiapan', 'id = "' . $id . '"');
    if (!empty($file['file'])) {
        unlink('../../berkas/' . $file['file']);
    }
    $result = $proses->hapus_data('dokumen_persiapan', 'id', $id);
}

if ($_POST['act'] == 'pilih_ukpbj') {
    $data[] = array(
        'kode_paket'        => strip_tags($_POST['id']),
        'id_operator'       => strip_tags($_POST['operator']),
        'status'            => 'UKPBJ'
    );
    $result = $proses->tambah_data('penugasan', $data);
}


if (@$_POST['act'] == 'upload_hps') { // INSERT

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

            $file = $proses->cek_fetch('dokumen_persiapan', 'kode_paket = "' . $_POST['id'] . '" AND jenis = "HPS"');
            if (!empty($file['file'])) {
                unlink('../../berkas/hps/' . $file['file']);
            }

            define("UPLOAD_DIR", "../../berkas/hps/"); // LOKASI FILE
            //$myFile1 = $_FILES['fupload'];
            $name1 = uniqid() . "." . $ext1;
            $destinationPath = UPLOAD_DIR . $name1;

            if (move_uploaded_file($_FILES['fupload']['tmp_name'], $destinationPath)) {

                $result = $proses->hapus_data2('hps', 'kode_paket = "' . $_POST['id'] . '" AND oleh = "PPK"');
                $result = $proses->hapus_data2('dokumen_persiapan', 'kode_paket = "' . $_POST['id'] . '" AND jenis = "HPS"');

                // Baca file Excel
                try {
                    $spreadsheet = IOFactory::load($destinationPath);
                    $sheet = $spreadsheet->getActiveSheet();
                    $rows = $sheet->toArray();

                    // Hapus header (baris pertama)
                    array_shift($rows);

                    $data1 = [];
                    foreach ($rows as $row) {
                        $data1[] = [
                            'id_profil'  => NULL,
                            'kode_paket' => $_POST['id'],
                            'oleh'       => 'PPK',
                            'jenis_barang' => $row[0] ?? null,
                            'satuan'       => $row[1] ?? null,
                            'volume'       => $row[2] ?? null,
                            'harga'        => formatNumber($row[3]),
                            'pajak'        => $row[4] ?? null,
                            'total'        => formatNumber($row[5]),
                            'keterangan'   => $row[6] ?? null,
                            'kunci_baris'  => $row[7] ?? null
                        ];
                    }

                    // Simpan ke database
                    if (!empty($data1) && is_array($data1)) {
                        $proses->tambah_data('hps', $data1);

                        $data2[] = array(
                            'kode_paket' => $_POST['id'],
                            'nama_file'  => $path1,
                            'file'       => $name1,
                            'jenis'      => 'HPS'
                        );
                        $result = $proses->tambah_data('dokumen_persiapan', $data2);
                    } else {
                        echo 'gagal';
                        exit();
                    }
                } catch (Exception $e) {
                    echo 'Error membaca file Excel: ' . $e->getMessage();
                    exit();
                }
            }
        }
    }
}

if (@$_POST['act'] == 'simpan_hps') { // INSERT
    //$t = array(',', '.');
    //$nilai_hps = str_replace($t, '', $_POST['nilai_hps']);
    $data = array(
        'nilai_hps' => $_POST['hps']
    );
    $result = $proses->edit_data('paket_pekerjaan', $data, 'kode_paket', $_POST['id']);
}

if (@$_POST['act'] == 'update_hps') { // UPDATE
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

if (@$_POST['act'] == 'upload_kak') { // INSERT
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

if (@$_POST['act'] == 'upload_kontrak') { // INSERT
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

if (@$_POST['act'] == 'upload_pekerjaan') { // INSERT
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

if (@$_POST['act'] == 'hapus_ukpbj') {
    $id = $_POST['id'];
    $result = $proses->hapus_data('penugasan', 'id', $id);
}

if (@$_POST['act'] == 'kirim_email_ukpbj') {
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
                'kode_paket'        => $_POST['kode_paket'],
                'id_operator'       => $_POST['id_operator'],
                'judul'             => 'Nota Dinas PPK',
                'isi_undangan'      => $_POST['isi_undangan'],
                'file'              => $name1
            );
            $result = $proses->tambah_data('undangan_ukpbj', $data);
            $file = $name1;
        }
    } else {
        $data[] = array(
            'kode_paket'        => $_POST['kode_paket'],
            'id_operator'       => $_POST['id_operator'],
            'judul'             => 'Nota Dinas PPK',
            'isi_undangan'      => $_POST['isi_undangan']
        );
        $result = $proses->tambah_data('undangan_ukpbj', $data);
        $file = '';
    }

    //----------------------------------------------------------------------
    //$link = $url . 'aktivasi/kode/' . $tokenAkses;
    $template = template_ukpbj($_POST['isi_undangan'], $_POST['email'], $file, $url);
    undangan_email($_POST['email'], 'Nota Dinas PPK', $template); // KIRIM EMAIL
    //----------------------------------------------------------------------
}
