<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

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

$data = array(
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
    'telepon_cp'        => $telepon_cp
);

$result = $proses->edit_data('profil_badan_usaha', $data, 'id_profil', $_POST['id']);

$data2 = array(
    'email'             => strip_tags($_POST['email'])
);

$result = $proses->edit_data('akun_penyedia', $data2, 'id_akun', $_POST['id_akun']);
