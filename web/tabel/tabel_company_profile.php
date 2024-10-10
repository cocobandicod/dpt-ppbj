<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

$sql = $proses->tampil_data_select('*', 'company_profile', 'id_profil ="' . $_SESSION['kode_profil'] . '"');

$data = array();
$no = 1;
foreach ($sql as $row) {
    $act = pathinfo($row['file'], PATHINFO_EXTENSION);
    $subdata = array();
    $subdata[] = $no;
    $subdata[] = $row['judul'];
    $subdata[] = '
                <div class="dropdown d-inline-block">
                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-more-fill align-middle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="' . $act . '" data-id="' . $row['file'] . '" class="dropdown-item edit-item-btn"><i class="ri-search-eye-line align-bottom me-2 text-muted"></i> File</a></li>
                        <li><a href="' . $url . 'company/profile/edit/' . $row['id'] . '" data-id="' . $row['id'] . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                        <li>
                            <a href="#" id="del" data-id="' . $row['id'] . '" data-nama="' . $row['judul'] . '" data-act="del" class="dropdown-item remove-item-btn">
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