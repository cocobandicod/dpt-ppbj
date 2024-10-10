<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

$sql = $proses->tampil_data_select('*', 'pengumuman', '1=1 ORDER BY tanggal DESC');

$data = array();
$no = 1;
foreach ($sql as $row) {
    $subdata = array();
    $subdata[] = $no;
    $subdata[] = $row['pekerjaan'];
    $subdata[] = $row['nama_perusahaan'];
    $subdata[] = number_format($row['nilai']);
    $subdata[] = $row['tahun_anggaran'];
    $data[] = $subdata;
    $no++;
}

$json_data = array(
    "data" =>  $data
);

echo json_encode($json_data);
