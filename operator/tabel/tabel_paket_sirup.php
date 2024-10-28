<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
require_once('../../config/fungsi_indotgl.php');

// URL API
$tahun = $_POST['tahun'];
$apiUrl = "https://isb.lkpp.go.id/isb-2/api/satudata/TenderUmumPublik/" . $tahun . "/25";

// Inisialisasi cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Eksekusi cURL dan decode hasilnya
$response = curl_exec($ch);
curl_close($ch);
$apiData = json_decode($response, true);

$data = array();
$no = 1;

// Memeriksa apakah data berhasil diambil
if (is_array($apiData)) {
    foreach ($apiData as $row) {
        // Memeriksa apakah 'Instansi dan Satker' ada dan merupakan array
        if (isset($row['Instansi dan Satker']) && is_array($row['Instansi dan Satker'])) {
            foreach ($row['Instansi dan Satker'] as $instansi) {
                // Memeriksa apakah 'stk_nama' adalah "UNIVERSITAS NEGERI GORONTALO"
                if ($instansi['stk_nama'] === "UNIVERSITAS NEGERI GORONTALO") {
                    $subdata = array();
                    $cek = $proses->cek_count('paket_pekerjaan', 'kode_paket = "' . $row['Kode Tender'] . '"');
                    if ($row['Status_Tender'] == 'Aktif' && $cek == 0) {
                        $status = '<span class="badge bg-success fs-11">Aktif</span>';
                        $link = '<a href="#" data-nama="' . $row['Nama Paket'] . '" data-kode="' . $row['Kode Tender'] . '" data-lokasi="' . $row['lokasi_paket'][0]['lokasi']['pkt_lokasi'] . '" id="buatpaket">' . $row['Kode Tender'] ?? null . '</a>';
                    } else if ($row['Status_Tender'] == 'Aktif' && $cek != 0) {
                        $status = '<span class="badge bg-success fs-11">Aktif</span>';
                        $link = '<a href="' . $url . 'operator/buat-paket/' . $row['Kode Tender'] . '/' . $tahun . '">' . $row['Kode Tender'] ?? null . '</a>';
                    } else {
                        $status = '<span class="badge bg-danger fs-11">Ditutup</span>';
                        $link = $row['Kode Tender'] ?? null;
                    }

                    $subdata[] = $no;
                    $subdata[] = @$link;
                    $subdata[] = $row['Nama Paket'] ?? null;
                    $subdata[] = $instansi['stk_nama'];
                    $subdata[] = number_format($row['Pagu']) ?? null;
                    $subdata[] = number_format($row['HPS']) ?? null;
                    $subdata[] = $row['anggaran'][0]['ang_tahun'] ?? null;
                    $subdata[] = $status;
                    $data[] = $subdata;
                    $no++;
                    break; // Keluar dari loop setelah menemukan "UNIVERSITAS NEGERI GORONTALO"
                }
            }
        }
    }
}

$json_data = array(
    "data" => $data
);

echo json_encode($json_data);
