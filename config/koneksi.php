<?php
// panggil file
require 'db.php';
require 'crud.php';
// cara panggil class di koneksi php
$db = new Koneksi();
// cara panggil koneksi di fungsi DBConnect()
$koneksi =  $db->DBConnect();
// panggil class prosesCrud di file prosescrud.php
$proses = new prosesCrud($koneksi);
// menghilangkan pesan error
// panggil session ID
//$id = $_SESSION['USER']['id_pengguna'];
//$sesi = $proses->tampil_data_id('pengguna', 'id_pengguna', @$id);
$url = 'https://dpt.ppbj.ung.ac.id/';

function token()
{
    $batas = 30;
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    $max = strlen($codeAlphabet);

    for ($i = 0; $i < $batas; $i++) {
        $token .= $codeAlphabet[rand(0, $max - 1)];
    }

    return $token;
}
