<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
require_once('../../config/fungsi_indotgl.php');

$sql = $proses->tampil_data_select('*', 'jadwal_paket', '1=1 AND id_paket = "' . $_POST['id'] . '" ORDER BY id_jadwal ASC');

$data = array();
$no = 1;
foreach ($sql as $row) {
    $subdata = array();
    $subdata[] = $no;
    $subdata[] = str_replace('-', ' ', $row['tahap']);
    $subdata[] = tgl_indo7($row['tgl_mulai']);
    $subdata[] = tgl_indo7($row['tgl_selesai']);
    $subdata[] = '
                <div class="dropdown d-inline-block">
                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-more-fill align-middle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                        <span class="dropdown-item edit-item-btn" data-id="' . $row['id_jadwal'] . '" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="" data-act="edit">
                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</span></li>
                        <li>
                            <a href="#" id="del" data-id="' . $row['id_jadwal'] . '" data-nama="' . $row['tahap'] . '" data-act="del" class="dropdown-item remove-item-btn">
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
