<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/email.php');
require_once('../../config/cek_ajax.php');
require_once('../../config/fungsi_indotgl.php');

if ($_POST['act'] == 'ver') {
    /*
    if (@$_POST['ok'] == 3) {
        $data = array(
            'status'            => 'Terverifikasi',
            'verifikasi_oleh'   => $_SESSION['kode_user'],
            'verifikasi_tgl'    => $tgl_jam
        );
        $result = $proses->edit_data('profil_badan_usaha', $data, 'id_profil', $_POST['id']);

        $row = $proses->tampil_data_saja_join2(
            'b.email,a.nama_perusahaan',
            'profil_badan_usaha',
            'akun_penyedia',
            'id_akun',
            '1=1 AND a.id_profil = "' . $_POST['id'] . '"'
        );

        //----------------------------------------------------------------------
        //$link = $url . 'aktivasi/kode/' . $tokenAkses;
        $template = template_verifikasi($row['email'], $row['nama_perusahaan']);
        kirim_email($row['email'], 'Status Verifikasi', $template); // KIRIM EMAIL
        //----------------------------------------------------------------------
    }

    $data2[] = array(
        'id_operator'  => $_SESSION['kode_user'],
        'id_profil'    => $_POST['id'],
        'verifikasi'   => 'Kualifikasi',
        'timestamp'    => $tgl_jam
    );
    $result = $proses->tambah_data('verifikator', $data2); // SIMPAN KE DATABASE
    */
}
