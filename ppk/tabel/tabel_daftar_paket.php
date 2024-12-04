<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/fungsi_indotgl.php');
require_once('../../config/cek_ajax.php');

$sql = $proses->tampil_data_select(
    'a.*,b.id_jadwal',
    'paket_pekerjaan a LEFT JOIN jadwal b 
    ON a.kode_paket = b.kode_paket',
    '1=1 AND a.status = "Draf"
    GROUP BY a.id_paket DESC'
);

$data = array();
$no = 1;
foreach ($sql as $row) {
    $subdata = array();
    $subdata[] = $no;
    $subdata[] = '<a href="' . $url . 'ppk/daftar-paket/' . $row['kode_paket'] . '/' . $row['tahun_anggaran'] . '">' . $row['nama_pekerjaan'] . '</a>';
    $subdata[] = $row['status'];
    $subdata[] = tgl_indo($row['tanggal']);
    $subdata[] = $row['satuan_kerja'];
    $data[] = $subdata;
    $no++;
}

$json_data = array(
    "data" =>  $data
);

echo json_encode($json_data);
