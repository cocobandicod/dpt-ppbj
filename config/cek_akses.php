<?php

function cek_aktivasi($url, $proses, $token)
{
    $cek = $proses->cek_fetch('akun_penyedia', 'token = "' . $token . '"');
    if (@$cek['token'] != $token) {
        echo "<script>alert('Maaf URL Salah anda tidak bisa mengakses halaman ini..'); 
      document.location='" . $url . "'</script>";
        exit;
        exit;
    } else if (@$cek['token'] == $token && $cek['konfirmasi'] == 'Yes') {
        $link = $url;
        header("Location: $link");
        exit();
    }
}

function cek_url($url, $proses, $act, $tabel, $where)
{
    if ($act == 'edit') {
        $cek = $proses->cek_fetch($tabel, $where);
        if (empty($cek)) {
            header('Location: ' . $url . '404');
            exit();
        }
    }
}

function cek_akses($url, $proses, $token, $level)
{
    if (isset($token)) {
        $row = $proses->tampil_data_saja('token,nama', 'operator', 'token = "' . $token . '" AND level = "' . $level . '"');
        if (isset($row['token'])) {
        } else {
            echo "<script>
            alert('Maaf URL Salah anda tidak bisa mengakses halaman ini..'); 
            window.opener = self;
            window.close();
            </script>";
            exit;
            exit;
        }
    } else {
        echo "<script>alert('Maaf URL Salah anda tidak bisa mengakses halaman ini..'); 
      document.location='" . $url . "'</script>";
        exit;
        exit;
    }
}

function cek_nama($con, $token)
{
    if (isset($token)) {
        $result = mysqli_query($con, "SELECT token,nama FROM pengguna WHERE token = '$token'");
        $row = mysqli_fetch_array($result);
        if (isset($row['token'])) {
            $nama_pemilik = $row['nama'];
        }
        return $nama_pemilik;
    }
}

function cek_login_akses($proses, $url, $kode_user, $token)
{
    if (isset($kode_user)) {
        $result = $proses->cek_pengguna('token', 'operator', 'id_operator=' . "'$kode_user'");
        if ($result) {
            $token_user = $result['token'];
            if ($token != $token_user) {
                session_destroy();
                session_unset();
                echo "<script>alert('Maaf anda harus login...'); 
             document.location='" . $url . "operator'</script>";
                exit;
                exit;
            }
        }
    } else {
        echo "<script>alert('Maaf anda harus login');
       document.location='" . $url . "'</script>";
        exit;
        exit;
    }
}

function cek_akses_pengguna($proses, $url, $kode_user, $token)
{
    if (isset($kode_user)) {
        $result = $proses->cek_pengguna('token', 'akun_penyedia', 'id_akun=' . "'$kode_user'");
        if ($result) {
            $token_user = $result['token'];
            if ($token != $token_user) {
                echo "<script>alert('Maaf anda harus login pengguna...'); 
             document.location='" . $url . "'</script>";
                exit;
                exit;
            }
        }
    } else {
        echo "<script>alert('Maaf anda harus login pengguna...');
       document.location='" . $url . "'</script>";
        exit;
        exit;
    }
}
