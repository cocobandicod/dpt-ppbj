<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

$sql = $proses->tampil_data_select(
    'a.*,COUNT(b.id_profil) AS jum',
    'paket_pekerjaan a LEFT JOIN daftar_penyedia_terpilih b 
    ON a.id_paket = b.id_paket',
    '1=1 GROUP BY a.id_paket DESC'
);

$data = array();
$no = 1;
foreach ($sql as $row) {
    $subdata = array();
    $subdata[] = $no;
    $subdata[] = '<a href="' . $url . 'operator/dpt/' . $row['id_paket'] . '">' . $row['nama_pekerjaan'] . '</a>';
    $subdata[] = $row['lokasi_pekerjaan'];
    $subdata[] = $row['tahun_anggaran'];
    $subdata[] = $row['jum'];
    $data[] = $subdata;
    $no++;
}

$json_data = array(
    "data" =>  $data
);

echo json_encode($json_data);
