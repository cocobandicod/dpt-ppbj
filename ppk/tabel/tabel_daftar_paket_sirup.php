<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');
require_once('../../config/fungsi_indotgl.php');

// URL API
$tahun = $_POST['tahun'];
//$apiUrl = "https://sirup.lkpp.go.id/sirup/caripaketctr/search?tahunAnggaran=" . $tahun . "&jenisPengadaan=&metodePengadaan=&minPagu=&maxPagu=&bulan=&lokasi=&kldi=453&pdn=&ukm=&draw=43&columns%5B0%5D%5Bdata%5D=&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=false&columns%5B0%5D%5Borderable%5D=false&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=paket&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B2%5D%5Bdata%5D=pagu&columns%5B2%5D%5Bname%5D=&columns%5B2%5D%5Bsearchable%5D=true&columns%5B2%5D%5Borderable%5D=true&columns%5B2%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B2%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B3%5D%5Bdata%5D=jenisPengadaan&columns%5B3%5D%5Bname%5D=&columns%5B3%5D%5Bsearchable%5D=true&columns%5B3%5D%5Borderable%5D=true&columns%5B3%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B3%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B4%5D%5Bdata%5D=isPDN&columns%5B4%5D%5Bname%5D=&columns%5B4%5D%5Bsearchable%5D=true&columns%5B4%5D%5Borderable%5D=true&columns%5B4%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B4%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B5%5D%5Bdata%5D=isUMK&columns%5B5%5D%5Bname%5D=&columns%5B5%5D%5Bsearchable%5D=true&columns%5B5%5D%5Borderable%5D=true&columns%5B5%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B5%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B6%5D%5Bdata%5D=metode&columns%5B6%5D%5Bname%5D=&columns%5B6%5D%5Bsearchable%5D=true&columns%5B6%5D%5Borderable%5D=true&columns%5B6%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B6%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B7%5D%5Bdata%5D=pemilihan&columns%5B7%5D%5Bname%5D=&columns%5B7%5D%5Bsearchable%5D=true&columns%5B7%5D%5Borderable%5D=true&columns%5B7%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B7%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B8%5D%5Bdata%5D=kldi&columns%5B8%5D%5Bname%5D=&columns%5B8%5D%5Bsearchable%5D=true&columns%5B8%5D%5Borderable%5D=true&columns%5B8%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B8%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B9%5D%5Bdata%5D=satuanKerja&columns%5B9%5D%5Bname%5D=&columns%5B9%5D%5Bsearchable%5D=true&columns%5B9%5D%5Borderable%5D=true&columns%5B9%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B9%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B10%5D%5Bdata%5D=lokasi&columns%5B10%5D%5Bname%5D=&columns%5B10%5D%5Bsearchable%5D=true&columns%5B10%5D%5Borderable%5D=true&columns%5B10%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B10%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B11%5D%5Bdata%5D=id&columns%5B11%5D%5Bname%5D=&columns%5B11%5D%5Bsearchable%5D=true&columns%5B11%5D%5Borderable%5D=true&columns%5B11%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B11%5D%5Bsearch%5D%5Bregex%5D=false&order%5B0%5D%5Bcolumn%5D=5&order%5B0%5D%5Bdir%5D=DESC&start=0&length=10&search%5Bvalue%5D=Universitas+Negeri+Gorontalo&search%5Bregex%5D=false&_=173285431108";
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
                        $link = '<a href="' . $url . 'ppk/daftar-paket/' . $row['Kode Tender'] . '/' . $tahun . '">' . $row['Kode Tender'] ?? null . '</a>';
                    } else {
                        $status = '<span class="badge bg-danger fs-11">Ditutup</span>';
                        $link = $row['Kode Tender'] ?? null;
                    }

                    $subdata[] = $no;
                    $subdata[] = @$link;
                    $subdata[] = $row['Nama Paket'] ?? null;
                    $subdata[] = $instansi['stk_nama'];
                    $subdata[] = $instansi['nama_instansi'];
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
