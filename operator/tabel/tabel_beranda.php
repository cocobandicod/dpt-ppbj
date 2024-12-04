<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

$sql = $proses->tampil_data_select(
    'a.*,b.id_jadwal',
    'paket_pekerjaan a LEFT JOIN jadwal_paket b 
    ON a.id_paket = b.id_paket',
    '1=1 GROUP BY a.id_paket DESC'
);

$data = array();
$no = 1;
foreach ($sql as $row) {
    $subdata = array();
    $subdata[] = $no;
    $subdata[] = $row['kode_paket'];
    $subdata[] = $row['nama_pekerjaan'];
    $subdata[] = '';
    $subdata[] = '<a href="" class="btn btn-sm btn-success disabled">e-Kontrak</a>';
    $data[] = $subdata;
    $no++;
}

$json_data = array(
    "data" =>  $data
);

echo json_encode($json_data);
