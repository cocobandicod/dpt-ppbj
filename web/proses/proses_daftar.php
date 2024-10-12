<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
require_once('../../config/fungsi_indotgl.php');
require_once('../../config/email.php');

$tokenAkses = token();

$captchaUser = strip_tags($_POST["captcha"]);

$username = strip_tags(str_replace(' ', '', $_POST['username']));
$email = strip_tags($_POST['email']);
$pass = random_char(8);

$cek_user = $proses->cek_count('akun_penyedia', 'username LIKE "%' . $username . '"');
$cek_email = $proses->cek_count('akun_penyedia', 'email LIKE "%' . $email . '"');

$subdata = array();

if ($_SESSION['CAPTCHA_CODE'] != $captchaUser) {
    $subdata['status'] = 'alert_captcha';
} else if ($cek_user == 1) {
    $subdata['status'] = 'alert_user';
    $subdata['user'] = $username;
} else if ($cek_email == 1) {
    $subdata['status'] = 'alert_email';
    $subdata['email'] = $email;
} else {
    //----------------------------------------------------------------------
    //$link = $url . 'aktivasi/kode/' . $tokenAkses;
    //$template = template($username, $pass, $link);
    //kirim_email($email, 'Aktivasi Akun Penyedia', $template); // KIRIM EMAIL
    //----------------------------------------------------------------------
    $npwp = strip_tags($_POST['npwp']);
    $badan_usaha = strip_tags($_POST['badan_usaha']);
    $nama_perusahaan = strip_tags($_POST['nama_perusahaan']);
    $status_usaha = strip_tags($_POST['status_usaha']);
    $alamat = strip_tags($_POST['alamat']);
    $provinsi = strip_tags($_POST['provinsi']);
    $kab_kota = strip_tags($_POST['kab_kota']);
    $kode_pos = strip_tags($_POST['kode_pos']);
    $telepon = strip_tags($_POST['telepon']);
    $fax = strip_tags($_POST['fax']);
    $website = strip_tags($_POST['website']);
    $contact_person = strip_tags($_POST['contact_person']);
    $telepon_cp = strip_tags($_POST['telepon_cp']);

    $pengacak  = "NDJS3289JSKS190JISJI";

    $password = (md5($pengacak . md5($pass) . $pengacak));

    $data1[] = array(
        'username'          => $username,
        'email'             => $email,
        'password'          => $password,
        'token'             => $tokenAkses,
        'konfirmasi'        => 'No'
    );

    $result = $proses->tambah_data('akun_penyedia', $data1);
    $lastid = $result;

    $data2[] = array(
        'id_akun'           => $lastid,
        'npwp'              => $npwp,
        'badan_usaha'       => $badan_usaha,
        'nama_perusahaan'   => $nama_perusahaan,
        'status_usaha'      => $status_usaha,
        'alamat'            => $alamat,
        'provinsi'          => $provinsi,
        'kab_kota'          => $kab_kota,
        'kode_pos'          => $kode_pos,
        'telepon'           => $telepon,
        'fax'               => $fax,
        'website'           => $website,
        'contact_person'    => $contact_person,
        'telepon_cp'        => $telepon_cp,
        'status'            => 'Belum-Verifikasi',
        'verifikasi_oleh'   => '0',
        'registrasi'        => $tgl_jam
    );

    $result = $proses->tambah_data('profil_badan_usaha', $data2);

    $data3[] = array(
        'id_profil'         => $lastid
    );

    $result = $proses->tambah_data('dokumen_verifikasi', $data3);

    $data4[] = array(
        'id_profil'         => $lastid
    );

    $result = $proses->tambah_data('dokumen_penawaran_biaya', $data3);

    $subdata['username'] = $username;
    $subdata['email'] = $email;
    $subdata['token'] = $pass;
    $subdata['akses'] = $tokenAkses;
    $subdata['status'] = 'sukses';
}

echo json_encode($subdata);
