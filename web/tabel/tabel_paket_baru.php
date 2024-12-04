<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
/*
$sql = $proses->tampil_data_select(
    'a.kode,a.id_paket,a.nama_pekerjaan,a.nilai_hps',
    'paket_pekerjaan a LEFT JOIN tender b
    ON a.id_paket = b.id_paket
    AND b.id_profil = "' . $_SESSION['kode_profil'] . '"',
    '1=1 AND a.status = "Baru"
    AND b.id_paket IS NULL'
);
*/

$sql = $proses->tampil_data_select(
    'a.*',
    'paket_pekerjaan a JOIN jadwal b ON a.kode_paket = b.kode_paket
    LEFT JOIN tender c ON a.id_paket = c.id_paket',
    '1=1 AND b.nomor = "1"
    AND b.tgl_mulai <= NOW()
    AND c.id_paket IS NULL'
);

$data = array();
$no = 1;
foreach ($sql as $row) {
    $a = '<span span class="cursor-pointer text-primary" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="' . @$row['id_paket'] . '" data-profil="' . @$_SESSION['kode_profil'] . '" data-act="ikut">' . $row['nama_pekerjaan'] . '</span>';
    $subdata = array();
    $subdata[] = $no;
    $subdata[] = $a;
    $subdata[] = 'Rp. ' . number_format(@$row['nilai_hps']);
    $data[] = $subdata;
    $no++;
}

$json_data = array(
    "data" =>  $data
);

echo json_encode($json_data);
