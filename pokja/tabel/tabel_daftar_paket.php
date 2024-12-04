<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/fungsi_indotgl.php');
require_once('../../config/cek_ajax.php');

$sql = $proses->tampil_data_select(
    'a.*,b.*',
    'penugasan a LEFT JOIN paket_pekerjaan b 
    ON a.kode_paket = b.kode_paket',
    '1=1 AND a.status = "POKJA"
    AND a.id_operator = "' . $_SESSION['kode_user'] . '"'
);

$data = array();
$no = 1;
foreach ($sql as $row) {
    if ($row['status'] == 'Draf') {
        $status = '<span class="badge bg-warning fs-11">Draf</span>';
    } else {
        $status = '<span class="badge bg-success fs-11">Baru</span>';
    }
    $subdata = array();
    $subdata[] = $no;
    $subdata[] = '<a href="' . $url . 'pokja/daftar-paket/' . $row['kode_paket'] . '/' . $row['tahun_anggaran'] . '/dokumen-persiapan">' . $row['nama_pekerjaan'] . '</a>';
    $subdata[] = $status;
    $subdata[] = tgl_indo($row['tanggal']);
    $subdata[] = $row['satuan_kerja'];
    $data[] = $subdata;
    $no++;
}

$json_data = array(
    "data" =>  $data
);

echo json_encode($json_data);
