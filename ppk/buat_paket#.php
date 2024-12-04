<?php
require_once('../config/koneksi.php');
require_once('../config/menu.php');
require_once('../config/fungsi_indotgl.php');
require_once('../config/cek_akses.php');
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = md5(uniqid(rand(), TRUE));
}
cek_login_akses($proses, $url, @$_SESSION['kode_user'], @$_SESSION['token']);
cek_url($url, $proses, 'edit', 'paket_pekerjaan', 'kode_paket = "' . @$_GET['rup'] . '"');
cek_akses($url, $proses, @$_SESSION['token'], 'PPK');
?>
<!doctype html>
<html lang="en" data-layout="horizontal" data-layout-style="" data-layout-position="fixed" data-topbar="light">

<head>
    <meta charset="utf-8" />
    <title>Daftar Penyedia Terpilih Universitas Negeri Gorontalo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <meta content="Sistem Informasi Penyedia Barang dan Jasa Universitas Negeri Gorontalo" name="description" />
    <meta property="og:image" content="<?= $url; ?>assets/images/logo-dark.png" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= $url; ?>assets/images/icon.png">

    <!--datatable css-->
    <link rel="stylesheet" href="<?= $url; ?>assets/css/datatables/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="<?= $url; ?>assets/css/datatables/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="<?= $url; ?>assets/css/datatables/buttons/2.2.2/css/buttons.dataTables.min.css">

    <!-- Layout config Js -->
    <script src="<?= $url; ?>assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="<?= $url; ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= $url; ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= $url; ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="<?= $url; ?>assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert css-->
    <link href="<?= $url; ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <!-- LOGO -->
                    <?= logo($url); ?>
                    <div class="d-flex align-items-center">
                        <?= profil_operator('ppk', $url); ?>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== App Menu ========== -->
        <?php
        menu_ppk($url);
        ?>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="col-xl-12">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1"><?= str_replace('-', ' ', $_GET['judul']); ?></h4>
                            </div><!-- end card header -->
                            <!-- card body -->
                            <div class="card-body">
                                <form id="form">
                                    <?php
                                    // Mendapatkan parameter tahun dan kode_tender
                                    $tahun = $_GET['tahun'];
                                    $kode_tender = $_GET['rup'];

                                    // URL API
                                    $apiUrl = "https://sirup.lkpp.go.id/sirup/caripaketctr/search?tahunAnggaran=" . $tahun . "&jenisPengadaan=&metodePengadaan=&minPagu=&maxPagu=&bulan=&lokasi=&kldi=453&pdn=&ukm=&draw=43&columns%5B0%5D%5Bdata%5D=&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=false&columns%5B0%5D%5Borderable%5D=false&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=paket&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B2%5D%5Bdata%5D=pagu&columns%5B2%5D%5Bname%5D=&columns%5B2%5D%5Bsearchable%5D=true&columns%5B2%5D%5Borderable%5D=true&columns%5B2%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B2%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B3%5D%5Bdata%5D=jenisPengadaan&columns%5B3%5D%5Bname%5D=&columns%5B3%5D%5Bsearchable%5D=true&columns%5B3%5D%5Borderable%5D=true&columns%5B3%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B3%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B4%5D%5Bdata%5D=isPDN&columns%5B4%5D%5Bname%5D=&columns%5B4%5D%5Bsearchable%5D=true&columns%5B4%5D%5Borderable%5D=true&columns%5B4%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B4%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B5%5D%5Bdata%5D=isUMK&columns%5B5%5D%5Bname%5D=&columns%5B5%5D%5Bsearchable%5D=true&columns%5B5%5D%5Borderable%5D=true&columns%5B5%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B5%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B6%5D%5Bdata%5D=metode&columns%5B6%5D%5Bname%5D=&columns%5B6%5D%5Bsearchable%5D=true&columns%5B6%5D%5Borderable%5D=true&columns%5B6%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B6%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B7%5D%5Bdata%5D=pemilihan&columns%5B7%5D%5Bname%5D=&columns%5B7%5D%5Bsearchable%5D=true&columns%5B7%5D%5Borderable%5D=true&columns%5B7%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B7%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B8%5D%5Bdata%5D=kldi&columns%5B8%5D%5Bname%5D=&columns%5B8%5D%5Bsearchable%5D=true&columns%5B8%5D%5Borderable%5D=true&columns%5B8%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B8%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B9%5D%5Bdata%5D=satuanKerja&columns%5B9%5D%5Bname%5D=&columns%5B9%5D%5Bsearchable%5D=true&columns%5B9%5D%5Borderable%5D=true&columns%5B9%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B9%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B10%5D%5Bdata%5D=lokasi&columns%5B10%5D%5Bname%5D=&columns%5B10%5D%5Bsearchable%5D=true&columns%5B10%5D%5Borderable%5D=true&columns%5B10%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B10%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B11%5D%5Bdata%5D=id&columns%5B11%5D%5Bname%5D=&columns%5B11%5D%5Bsearchable%5D=true&columns%5B11%5D%5Borderable%5D=true&columns%5B11%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B11%5D%5Bsearch%5D%5Bregex%5D=false&order%5B0%5D%5Bcolumn%5D=5&order%5B0%5D%5Bdir%5D=DESC&start=0&length=10&search%5Bvalue%5D=Universitas+Negeri+Gorontalo&search%5Bregex%5D=false&_=173285431108";
                                    //$apiUrl = "https://isb.lkpp.go.id/isb-2/api/satudata/TenderUmumPublik/" . $tahun . "/25";

                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, $apiUrl);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                                        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36",
                                        "Accept: application/json, text/plain, */*",
                                        "Referer: https://sirup.lkpp.go.id/"
                                    ]);
                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Tambahan untuk menghindari error SSL
                                    $response = curl_exec($ch);
                                    curl_close($ch);

                                    $apiData = json_decode($response, true);

                                    // Cari data berdasarkan kode_tender
                                    $selectedData = null;
                                    foreach ($apiData['data'] as $row) {
                                        if (isset($row['id']) == $kode_tender) {
                                            $selectedData = $row;
                                            break;
                                        }
                                    }

                                    $row = $proses->tampil_data_saja('nama_pekerjaan,lokasi_pekerjaan', 'paket_pekerjaan', '1=1 AND kode_paket = "' . $kode_tender . '"');
                                    ?>
                                    <input type="hidden" name="act" value="buat_update">
                                    <input type="hidden" name="kode_paket" value="<?= @$kode_tender; ?>">
                                    <input type="hidden" name="tahun_anggaran" value="<?= $tahun; ?>">
                                    <input type="hidden" name="nilai_pagu" value="<?= $selectedData['pagu']; ?>">
                                    <input type="hidden" name="sumber_dana" value="<?= $selectedData['sumberDana']; ?>">
                                    <input type="hidden" name="kode_anggaran" value="0">
                                    <input type="hidden" name="jenis_pengadaan" value="<?= $selectedData['jenisPengadaan']; ?>">
                                    <input type="hidden" name="metode_pengadaan" value="<?= $selectedData['metode']; ?>">
                                    <input type="hidden" name="metode_evaluasi" value="<?= $selectedData['metode']; ?>">
                                    <table class="table table-bordered fs-13">
                                        <tr>
                                            <td class="w-25">Rencana Umum Pengadaan</td>
                                            <td>
                                                <table class="table table-sm mb-0 fs-13">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="p-2">Kode RUP</th>
                                                            <th class="p-2">Nama Paket</th>
                                                            <th class="p-2">Sumber Dana</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="p-2"><?= $selectedData['id'] ?? 'Data tidak ditemukan'; ?></td>
                                                            <td class="p-2"><?= $selectedData['paket'] ?? 'Data tidak ditemukan'; ?></td>
                                                            <td class="p-2"><?= $selectedData['sumberDana'] ?? 'Data tidak ditemukan'; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nama Instansi</td>
                                            <td><?= $selectedData['kldi'] ?? 'Data tidak ditemukan'; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Satuan Kerja</td>
                                            <td>
                                                <input type="text" class="form-control" name="satuan_kerja" value="<?= $selectedData['satuanKerja'] ?? 'Data tidak ditemukan'; ?>" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Pengadaan</td>
                                            <td><?= $selectedData['jenisPengadaan'] ?? 'Data tidak ditemukan'; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Metode Pengadaan</td>
                                            <td><?= $selectedData['metode'] ?? 'Data tidak ditemukan'; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Metode Evaluasi</td>
                                            <td><?= $selectedData['metode']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Anggaran</td>
                                            <td>
                                                <table class="table table-sm mb-0 fs-13s">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="p-2">Tahun</th>
                                                            <th class="p-2">Sumber Dana</th>
                                                            <th class="p-2">Kode Anggaran</th>
                                                            <th class="p-2">Nilai</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="p-2"><?= $tahun ?? 'Data tidak ditemukan'; ?></td>
                                                            <td class="p-2"><?= $selectedData['sumberDana'] ?? 'Data tidak ditemukan'; ?></td>
                                                            <td class="p-2"><?= $selectedData['anggaran'][0]['ang_koderekening'] ?? 'Data tidak ditemukan'; ?></td>
                                                            <td class="p-2">Rp. <?= number_format(@$selectedData['pagu'], 0, ',', '.') ?? 'Data tidak ditemukan'; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nama Paket</td>
                                            <td><textarea name="nama_pekerjaan" class="form-control"><?= $row['nama_pekerjaan'] ?? 'Data tidak ditemukan'; ?></textarea></td>
                                        </tr>
                                        <tr>
                                            <td>Nilai Pagu Paket</td>
                                            <td><b>Rp. <?= number_format(@$selectedData['pagu'], 0, ',', '.') ?? 'Data tidak ditemukan'; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Lokasi Pekerjaan</td>
                                            <td><input type="text" class="form-control" name="lokasi_pekerjaan" value="<?= $row['lokasi_pekerjaan'] ?? 'Data tidak ditemukan'; ?>" required></td>
                                        </tr>
                                    </table>
                                    <button id="simpan" class="btn btn-success" type="submit">Selanjutnya <i class="ri-arrow-right-line"></i></button>
                                </form>
                            </div>
                            <!-- end card body -->
                        </div><!-- end card -->
                    </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?= footer($url); ?>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Basic modal -->
    <div id="DetailModal" class="modal zoomIn" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="fetched-data"></div>
            </div>
        </div>
    </div>
    <!-- /basic modal -->

    <!-- JAVASCRIPT -->
    <script src="<?= $url; ?>assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?= $url; ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $url; ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= $url; ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= $url; ?>assets/libs/feather-icons/feather.min.js"></script>
    <script src="<?= $url; ?>assets/js/pages/plugins/lord-icon-2.1.0.js"></script>

    <!--datatable js-->
    <script src="<?= $url; ?>assets/css/datatables/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="<?= $url; ?>assets/css/datatables/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?= $url; ?>assets/css/datatables/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="<?= $url; ?>assets/css/datatables/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="<?= $url; ?>assets/js/toastify-js.js"></script>
    <script src="<?= $url; ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Dashboard init -->
    <script src="<?= $url; ?>assets/js/pages/dashboard-analytics.init.js"></script>

    <!-- App js -->
    <script src="<?= $url; ?>assets/js/app.js"></script>

    <!-- App js -->
    <script src="<?= $url; ?>assets/js/ajax.js"></script>
    <script>
        $(document).on('submit', '#form', function(event) {
            event.preventDefault();
            var form = $('#form')[0];
            var nilai = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '<?= $url; ?>ppk/proses/paket/pekerjaan',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                data: nilai,
                beforeSend: function() {
                    document.querySelector('#simpan').innerHTML = '<i class="mdi mdi-spin mdi-loading align-middle ms-1"></i> Loading...';
                },
                success: function(data) {
                    Toastify({
                        text: "Berhasil!",
                        gravity: "top",
                        position: "center",
                        duration: 3000
                    }).showToast();
                    setTimeout(() => {
                        window.location.href = '<?= $url; ?>ppk/daftar-paket/<?= $kode_tender; ?>/<?= $tahun; ?>/dokumen-persiapan';
                    }, 3000);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    Toastify({
                        text: "Data Gagal",
                        gravity: "top",
                        position: "center",
                        duration: 3000
                    }).showToast();
                },
                complete: function(data) {
                    document.querySelector('#simpan').innerHTML = 'Selanjutnya <i class="ri-arrow-right-line"></i>';
                }
            });
        });
    </script>
</body>

</html>