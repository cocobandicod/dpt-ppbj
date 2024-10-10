<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

$sql = $proses->tampil_data_select('a.*,b.email,c.nama', 'profil_badan_usaha a LEFT JOIN akun_penyedia b ON a.id_akun = b.id_akun LEFT JOIN operator c ON a.verifikasi_oleh = c.id_operator', '1=1');

$data = array();
$no = 1;
foreach ($sql as $row) {
    if ($row['status'] == 'Belum-Verifikasi') {
        $status = '<span class="badge badge-pill bg-danger">' . str_replace('-', ' ', $row['status']) . '</span>';
    } else {
        $status = '<span class="badge badge-pill bg-success">' . str_replace('-', ' ', $row['status']) . '</span>';
    }
    $subdata = array();
    $subdata[] = $no;
    $subdata[] = $row['nama_perusahaan'];
    $subdata[] = $row['badan_usaha'];
    $subdata[] = $row['email'];
    $subdata[] = $row['provinsi'];
    $subdata[] = $row['kab_kota'];
    $subdata[] = $status;
    $subdata[] = $row['nama'];
    $subdata[] = '
                <div class="dropdown d-inline-block">
                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-more-fill align-middle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a href="' . $url . 'operator/penyedia/edit/' . $row['id_profil'] . '" data-id="' . $row['id_profil'] . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                        <li><a href="' . $url . 'operator/penyedia/detail/' . $row['id_profil'] . '" data-id="' . $row['id_profil'] . '" class="dropdown-item edit-item-btn"><i class="ri-send-plane-fill align-bottom me-2 text-muted"></i> Proses</a></li>
                    </ul>
                 </div>
    ';
    $data[] = $subdata;
    $no++;
}

$json_data = array(
    "data" =>  $data
);

echo json_encode($json_data);
