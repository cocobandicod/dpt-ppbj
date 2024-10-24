<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

$sql = $proses->tampil_data_select(
    'a.id_daftar,b.kode,b.id_paket,b.nama_pekerjaan,b.nilai_hps,c.id_tender',
    'daftar_penyedia_terpilih a
    LEFT JOIN paket_pekerjaan b
    ON a.id_paket = b.id_paket
    LEFT JOIN tender c
    ON a.id_paket = c.id_paket',
    '1=1 AND a.id_profil = "' . $_SESSION['kode_profil'] . '"
    AND b.status = "Berlangsung"
    GROUP BY a.id_paket'
);

$data = array();
$no = 1;
foreach ($sql as $row) {
    if (empty($row['id_tender'])) {
        $a = '<span span class="cursor-pointer text-primary" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="' . @$row['id_paket'] . '" data-profil="' . @$_SESSION['kode_profil'] . '" data-act="ikut">' . $row['nama_pekerjaan'] . '</span>';
    } else {
        $a = '<a href="' . $url . 'paket/pekerjaan/' . $row['kode'] . '">' . $row['nama_pekerjaan'] . '</a> <span class="badge bg-success">Paket yang anda ikuti</span>';
    }
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
