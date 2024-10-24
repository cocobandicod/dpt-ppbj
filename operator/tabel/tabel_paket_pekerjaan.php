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
    $subdata[] = $row['nama_pekerjaan'];
    $subdata[] = $row['lokasi_pekerjaan'];
    $subdata[] = number_format($row['nilai_hps']);
    $subdata[] = $row['tahun_anggaran'];
    $subdata[] = $jadwal;
    $subdata[] = $syarat;
    $subdata[] = $file;
    $subdata[] = '
                <div class="dropdown d-inline-block">
                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-more-fill align-middle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a href="' . $url . 'operator/paket-pekerjaan/edit/' . $row['id_paket'] . '" data-id="' . $row['id_paket'] . '" class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit Pekerjaan</a></li>
                        <li>
                            <a href="#" id="del" data-id="' . $row['id_paket'] . '" data-nama="' . $row['nama_pekerjaan'] . '" data-act="del" class="dropdown-item remove-item-btn">
                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Hapus Pekerjaan
                            </a>
                        </li>
                        <li><a href="' . $url . 'operator/jadwal-pekerjaan/' . $row['id_paket'] . '" data-id="' . $row['id_paket'] . '" class="dropdown-item edit-item-btn"><i class="ri-file-add-line align-bottom me-2 text-muted"></i> Jadwal</a></li>
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
