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

if (@$_POST['act'] == 'selesai_pokja') {

    if ($_POST['status'] == 'pembatalan') {
        $data2 = array(
            'status'        => NULL,
            'tanggal'       => NULL,
            'alasan'        => NULL
        );
        $result2 = $proses->edit_data_where2('undangan_pokja', $data2, 'kode_paket', $_POST['kode_paket'], 'id_operator', $_POST['id_operator']);
    } else {
        if ($_POST['jum'] > 2) {
            $data = array(
                'kualifikasi_usaha'    => strip_tags($_POST['kualifikasi_usaha']),
                'bentuk_usaha'         => strip_tags($_POST['bentuk_usaha']),
                'status'               => 'Baru'
            );
            $result = $proses->edit_data('paket_pekerjaan', $data, 'kode_paket', $_POST['kode_paket']);
        } else {
            $data = array(
                'kualifikasi_usaha'    => strip_tags($_POST['kualifikasi_usaha']),
                'bentuk_usaha'         => strip_tags($_POST['bentuk_usaha'])
            );
            $result = $proses->edit_data('paket_pekerjaan', $data, 'kode_paket', $_POST['kode_paket']);
        }
        $data2 = array(
            'status'        => strip_tags($_POST['status']),
            'tanggal'       => $tgl_jam,
            'alasan'        => strip_tags($_POST['alasan'])
        );
        $result2 = $proses->edit_data_where2('undangan_pokja', $data2, 'kode_paket', $_POST['kode_paket'], 'id_operator', $_POST['id_operator']);
    }
}

if (@$_POST['act'] == 'kbli') {
    $data[] = array(
        'kode_paket'       => strip_tags($_POST['id']),
        'deskripsi'        => strip_tags($_POST['deskripsi']),
        'nomor'            => strip_tags($_POST['nomor']),
        'jenis'            => 'Kualifikasi',
        'menu'             => 'KBLI'
    );
    $result = $proses->tambah_data('dokumen_persiapan', $data);
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

if (@$_POST['act'] == 'delpenawaran') {
    $id = $_POST['del'];
    $result = $proses->hapus_data('dokumen_persiapan', 'id', $id);
}

if (@$_POST['act'] == 'delkualifikasi') {
    $id = $_POST['del'];
    $result = $proses->hapus_data('dokumen_persiapan', 'id', $id);
}

if (@$_POST['act'] == 'deltenagaahli') {
    $id = $_POST['del'];
    $result = $proses->hapus_data('dokumen_tenaga_ahli', 'id', $id);
}

if (@$_POST['act'] == 'delperalatan') {
    $id = $_POST['del'];
    $result = $proses->hapus_data('dokumen_peralatan', 'id', $id);
}

if (@$_POST['act'] == 'delfile') {
    $id = $_POST['del'];
    $file = $proses->cek_fetch('dokumen_persiapan', 'id = "' . $id . '"');
    if (!empty($file['file'])) {
        unlink('../../berkas/' . $file['file']);
    }
    $result = $proses->hapus_data('dokumen_persiapan', 'id', $id);
}

if (@$_POST['act'] == 'upload_berlaku') { // INSERT

    $data1[] = array(
        'kode_paket' => $_POST['id'],
        'nomor'      => $_POST['nomor'],
        'jenis'      => 'Berlaku'
    );
    $result = $proses->tambah_data('dokumen_persiapan', $data1); // SIMPAN KE DATABASE

}

if (@$_POST['act'] == 'update_berlaku') { // INSERT

    $data = array(
        'nomor'      => $_POST['nomor']
    );

    $result = $proses->edit_data('dokumen_persiapan', $data, 'id', $_POST['id']);
}

if ($_POST['act'] == 'form_administrasi') {
    $data[] = array(
        'kode_paket'     => $_POST['id'],
        'deskripsi'      => strip_tags($_POST['deskripsi']),
        'jenis'          => 'Penawaran',
        'menu'           => 'Administrasi'
    );
    $result = $proses->tambah_data('dokumen_persiapan', $data);
}

if ($_POST['act'] == 'form_teknis') {
    $data[] = array(
        'kode_paket'     => $_POST['id'],
        'deskripsi'      => strip_tags($_POST['deskripsi']),
        'jenis'          => 'Penawaran',
        'menu'           => 'Teknis'
    );
    $result = $proses->tambah_data('dokumen_persiapan', $data);
}

if ($_POST['act'] == 'form_biaya') {
    $data[] = array(
        'kode_paket'     => $_POST['id'],
        'deskripsi'      => strip_tags($_POST['deskripsi']),
        'jenis'          => 'Penawaran',
        'menu'           => 'Biaya'
    );
    $result = $proses->tambah_data('dokumen_persiapan', $data);
}

if ($_POST['act'] == 'form_izin_lainnya') {
    $data[] = array(
        'kode_paket'     => $_POST['id'],
        'deskripsi'      => strip_tags($_POST['deskripsi']),
        'jenis'          => 'Kualifikasi',
        'menu'           => 'Izin-Lainnya'
    );
    $result = $proses->tambah_data('dokumen_persiapan', $data);
}

if ($_POST['act'] == 'form_syarat_administrasi') {
    $data[] = array(
        'kode_paket'     => $_POST['id'],
        'deskripsi'      => strip_tags($_POST['deskripsi']),
        'jenis'          => 'Kualifikasi',
        'menu'           => 'Syarat-Administrasi'
    );
    $result = $proses->tambah_data('dokumen_persiapan', $data);
}

if ($_POST['act'] == 'form_syarat_administrasi_teknis') {
    $data[] = array(
        'kode_paket'     => $_POST['id'],
        'deskripsi'      => strip_tags($_POST['deskripsi']),
        'jenis'          => 'Kualifikasi',
        'menu'           => 'Teknis'
    );
    $result = $proses->tambah_data('dokumen_persiapan', $data);
}

if ($_POST['act'] == 'form_tenaga_ahli') {
    $data[] = array(
        'kode_paket'     => $_POST['id'],
        'jenis_keahlian' => strip_tags($_POST['jenis_keahlian']),
        'spesifikasi'    => strip_tags($_POST['spesifikasi']),
        'pengalaman'     => strip_tags($_POST['pengalaman']),
        'kemampuan'      => strip_tags($_POST['kemampuan']),
        'jenis'          => 'Ahli'
    );
    $result = $proses->tambah_data('dokumen_tenaga_ahli', $data);
}

if ($_POST['act'] == 'form_tenaga_teknis') {
    $data[] = array(
        'kode_paket'     => $_POST['id'],
        'jenis_keahlian' => strip_tags($_POST['jenis_keahlian']),
        'spesifikasi'    => strip_tags($_POST['spesifikasi']),
        'pengalaman'     => strip_tags($_POST['pengalaman']),
        'kemampuan'      => strip_tags($_POST['kemampuan']),
        'jenis'          => 'Teknis'
    );
    $result = $proses->tambah_data('dokumen_tenaga_ahli', $data);
}

if ($_POST['act'] == 'form_peralatan') {
    $data[] = array(
        'kode_paket'     => $_POST['id'],
        'nama_peralatan' => strip_tags($_POST['nama_peralatan']),
        'spesifikasi'    => strip_tags($_POST['spesifikasi'])
    );
    $result = $proses->tambah_data('dokumen_peralatan', $data);
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

if (@$_POST['act'] == 'upload_pemilihan') { // INSERT
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
                'nomor'      => $_POST['no_dokumen'],
                'tgl_dokumen' => $_POST['tgl_dokumen'],
                'nama_file'  => $path1,
                'file'       => $name1,
                'jenis'      => 'Pemilihan'
            );
            $result = $proses->tambah_data('dokumen_persiapan', $data1); // SIMPAN KE DATABASE
        }
    }
}

if (@$_POST['act'] == 'upload_berita_acara') { // INSERT
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
                'tgl_dokumen' => $_POST['tgl_dokumen'],
                'nama_file'  => $path1,
                'file'       => $name1,
                'jenis'      => 'Berita-Acara'
            );
            $result = $proses->tambah_data('dokumen_persiapan', $data1); // SIMPAN KE DATABASE
        }
    }
}

if (@$_POST['act'] == 'kirim_email_ppk') {
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

            $isi = '<p>Kepada Yth,<br>' . $_POST['nama'] . '<br>di- Tempat</p>
            <table>
                <tbody>
                    <tr>
                        <td>Kode Paket</td>
                        <td>' . $_POST['kode_paket'] . '</td>
                    </tr>
                    <tr>
                        <td>Nama Pekerjaan</td>
                        <td>' . $_POST['nama_pekerjaan'] . '</td>
                    </tr>
                    <tr>
                        <td colspan="2">dengan informasi terkait Reviu Dokumen Persiapan Pengadaan sebagai berikut:</td>
                    </tr>
                    <tr>
                        <td>waktu</td>
                        <td>' . $_POST['waktu'] . '</td>
                    </tr>
                    <tr>
                        <td>Tempat</td>
                        <td>' . $_POST['tempat'] . '</td>
                    </tr>
                    <tr>
                        <td>Yang harus dibawa</td>
                        <td>' . $_POST['dibawa'] . '</td>
                    </tr>
                    <tr>
                        <td>Yang harus hadir</td>
                        <td>' . $_POST['hadir'] . '</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Demikian Penjelasan Kami, atas perhatian dan kerjasama yang baik kami ucapkan terima kasih
                            <br><br><br>
                            Hormat Kami<br>
                            Pokja<br>
                            ' . $_SESSION['nama'] . '
                        </td>
                    </tr>
                </tbody>
            </table>';

            $data[] = array(
                'kode_paket'        => $_POST['kode_paket'],
                'id_operator'       => $_POST['id_operator'],
                'judul'             => 'Undangan Reviu Dokumen Persiapan Pemilihan',
                'isi_undangan'      => $isi,
                'file'              => $name1
            );
            $result = $proses->tambah_data('undangan_ppk', $data);

            //----------------------------------------------------------------------
            //$link = $url . 'aktivasi/kode/' . $tokenAkses;
            $template = template_pokja($isi, $_POST['email'], $name1, $url);
            undangan_email($_POST['email'], 'Undangan Reviu Dokumen Persiapan Pemilihan', $template); // KIRIM EMAIL
            //----------------------------------------------------------------------

        }
    } else {
        exit();
    }
}
