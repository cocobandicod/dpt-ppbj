<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
require_once('../../config/fungsi_indotgl.php');
require_once('../../config/email.php');

if (@$_POST['act'] == 'kirim_email') {
    $email = strip_tags($_POST['email']);
    $cek = $proses->tampil_data_saja('id_akun,username,email', 'akun_penyedia', '1=1 AND email LIKE "%' . $email . '"');

    $username = $cek['username'];
    $email = $cek['email'];
    $pass = random_char(8);

    $pengacak  = "NDJS3289JSKS190JISJI";
    $password = (md5($pengacak . md5($pass) . $pengacak));

    $data = array(
        'password' => $password
    );
    $result = $proses->edit_data('akun_penyedia', $data, 'id_akun', $cek['id_akun']);

    //----------------------------------------------------------------------
    $template = template_reset($username, $pass, $email);
    reset_email($email, 'Reset Password Penyedia', $template); // KIRIM EMAIL
    //----------------------------------------------------------------------
} else {
    $email = strip_tags($_POST['email']);
    $pass = random_char(8);
    $cek_email = $proses->cek_count('akun_penyedia', 'email LIKE "%' . $email . '"');
    $cek = $proses->tampil_data_saja('id_akun,username', 'akun_penyedia', '1=1 AND email LIKE "%' . $email . '"');
    $username = @$cek['username'];
    $subdata = array();

    if ($cek_email == 0) {
        $subdata['status'] = 'alert_email';
    } else {
        $subdata['email'] = $email;
        $subdata['status'] = 'sukses';
    }

    echo json_encode($subdata);
}
