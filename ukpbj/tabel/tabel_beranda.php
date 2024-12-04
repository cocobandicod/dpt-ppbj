<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

$sql = $proses->tampil_data_select(
    'a.*,b.id_jadwal',
    'paket_pekerjaan a LEFT JOIN jadwal b 
    ON a.kode_paket = b.kode_paket',
    '1=1 GROUP BY a.id_paket DESC'
);

$sql = $proses->tampil_data_select(
    'a.*',
    'paket_pekerjaan a JOIN jadwal b ON a.kode_paket = b.kode_paket',
    '1=1 AND b.nomor = "1"
    AND a.status = "BARU"
    AND b.tgl_mulai <= NOW()'
);

$data = array();
$no = 1;
foreach ($sql as $row) {
    $a = '<span span class="cursor-pointer text-primary" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="' . @$row['id_paket'] . '" data-profil="' . @$_SESSION['kode_profil'] . '" data-act="ikut">' . $row['nama_pekerjaan'] . '</span>';
    $subdata = array();
    $subdata[] = $no;
    $subdata[] = $row['kode_paket'];
    $subdata[] = $a;
    $subdata[] = 'Rp. ' . number_format(@$row['nilai_hps'], 0, ',', '.');
    $data[] = $subdata;
    $no++;
}

$json_data = array(
    "data" =>  $data
);

echo json_encode($json_data);
