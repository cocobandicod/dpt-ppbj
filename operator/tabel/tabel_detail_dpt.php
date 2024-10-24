<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
require_once('../../config/fungsi_indotgl.php');

$sql = $proses->tampil_data_select(
    'a.id_daftar, b.badan_usaha, b.nama_perusahaan, b.alamat, b.telepon',
    'daftar_penyedia_terpilih a LEFT JOIN profil_badan_usaha b
    ON a.id_profil = b.id_profil',
    '1=1 AND a.id_paket = "' . $_POST['id'] . '" ORDER BY a.id_daftar DESC'
);

$data = array();
$no = 1;
foreach ($sql as $row) {
    $subdata = array();
    $subdata[] = $no;
    $subdata[] = $row['badan_usaha'];
    $subdata[] = $row['nama_perusahaan'];
    $subdata[] = $row['alamat'];
    $subdata[] = $row['telepon'];
    $subdata[] = '<span class="cursor-pointer text-primary" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="' . $row['id_daftar'] . '" data-act="kirim"><i class="ri-mail-send-line fs-16"></i></span>';
    $subdata[] = '
                <div class="dropdown d-inline-block">
                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-more-fill align-middle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="#" id="del" data-id="' . $row['id_daftar'] . '" data-nama="' . $row['nama_perusahaan'] . '" data-act="del" class="dropdown-item remove-item-btn">
                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                            </a>
                        </li>
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
