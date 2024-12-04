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

    if (empty($row['id_jadwal'])) {
        $jadwal = '<span class="badge bg-danger">Belum Dibuat</span>';
    } else {
        $jadwal = '<span class="cursor-pointer text-primary" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="' . @$row['id_paket'] . '" data-act="jadwal"><i class="ri-search-2-line fs-14"></i></span>';
    }
    if (empty($row['syarat_kualifikasi'])) {
        $syarat = '<span class="badge bg-danger">Belum Dibuat</span>';
    } else {
        $syarat = '<span class="cursor-pointer text-primary" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="' . @$row['id_paket'] . '" data-act="pengumuman"><i class="ri-search-2-line fs-14"></i></span>';
    }
    if (empty($row['file_pemilihan'])) {
        $file = '<span class="badge bg-danger">Belum Ada</span>';
    } else {
        $file = '<a href="' . $url . 'berkas/' . $row['file_pemilihan'] . '" target="_blank"><i class="ri-file-line fs-14"></i></a>';
    }
    $subdata[] = $no;
    $subdata[] = $row['kode_paket'];
    $subdata[] = $row['nama_pekerjaan'];
    $subdata[] = '';
    $subdata[] = '';
    $data[] = $subdata;
    $no++;
}

$json_data = array(
    "data" =>  $data
);

echo json_encode($json_data);
