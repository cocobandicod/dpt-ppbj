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
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Operator | Daftar Penyedia Terpilih Universitas Negeri Gorontalo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <meta content="Sistem Informasi Penyedia Barang dan Jasa Universitas Negeri Gorontalo" name="description" />
    <meta content="Themesbrand" name="cocobandicod" />
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
        <?php
        if ($_SESSION['level'] == 'PPK') {
            echo sidebar_ppk($url);
        } else if ($_SESSION['level'] == 'Pokja') {
            echo sidebar_pokja($url);
        }
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
                    <div class="col-lg-12 mt-3">
                        <div class="card">
                            <div class="card-header d-flex align-items-center pt-3 pb-3">
                                <h4 class="card-title mb-0 flex-grow-1"><?= str_replace('-', ' ', $_GET['judul']); ?></h4>
                            </div>
                            <div class="card-body">
                                <form id="form">
                                    <?php
                                    // Mendapatkan parameter tahun dan kode_tender
                                    $tahun = $_GET['tahun'];
                                    $kode_tender = $_GET['rup'];

                                    // URL API
                                    $apiUrl = "https://isb.lkpp.go.id/isb-2/api/satudata/TenderUmumPublik/" . $tahun . "/25";

                                    // Inisialisasi cURL
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, $apiUrl);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                                    // Eksekusi cURL dan decode hasilnya
                                    $response = curl_exec($ch);
                                    curl_close($ch);
                                    $apiData = json_decode($response, true);

                                    // Cari data berdasarkan kode_tender
                                    $selectedData = null;
                                    if (is_array($apiData)) {
                                        foreach ($apiData as $item) {
                                            if (isset($item['Kode Tender']) && $item['Kode Tender'] == $kode_tender) {
                                                $selectedData = $item;
                                                break;
                                            }
                                        }
                                    }

                                    $row = $proses->tampil_data_saja('nama_pekerjaan,lokasi_pekerjaan', 'paket_pekerjaan', '1=1 AND kode_paket = "' . $kode_tender . '"');
                                    ?>
                                    <input type="hidden" name="act" value="buat_update">
                                    <input type="hidden" name="kode_paket" value="<?= @$kode_tender; ?>">
                                    <input type="hidden" name="tahun_anggaran" value="<?= $selectedData['anggaran'][0]['ang_tahun']; ?>">
                                    <input type="hidden" name="nilai_pagu" value="<?= $selectedData['Pagu']; ?>">
                                    <input type="hidden" name="sumber_dana" value="<?= $selectedData['anggaran'][0]['sbd_id'] ?>">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td class="w-25">Rencana Umum Pengadaan</td>
                                            <td>
                                                <table class="table table-bordered mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Kode RUP</th>
                                                            <th>Nama Paket</th>
                                                            <th>Sumber Dana</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?= $selectedData['Kode Tender'] ?? 'Data tidak ditemukan'; ?></td>
                                                            <td><?= $selectedData['Nama Paket'] ?? 'Data tidak ditemukan'; ?></td>
                                                            <td><?= $selectedData['anggaran'][0]['sbd_id'] ?? 'Data tidak ditemukan'; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nama Instansi</td>
                                            <td><?= $selectedData['Instansi dan Satker'][0]['nama_instansi'] ?? 'Data tidak ditemukan'; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Satuan Kerja</td>
                                            <td><?= $selectedData['Instansi dan Satker'][0]['stk_nama'] ?? 'Data tidak ditemukan'; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Anggaran</td>
                                            <td>
                                                <table class="table table-bordered mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Tahun</th>
                                                            <th>Sumber Dana</th>
                                                            <th>Kode Anggaran</th>
                                                            <th>Nilai</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?= $selectedData['anggaran'][0]['ang_tahun'] ?? 'Data tidak ditemukan'; ?></td>
                                                            <td><?= $selectedData['anggaran'][0]['sbd_id'] ?? 'Data tidak ditemukan'; ?></td>
                                                            <td><?= $selectedData['anggaran'][0]['ang_koderekening'] ?? 'Data tidak ditemukan'; ?></td>
                                                            <td>Rp. <?= number_format(@$selectedData['anggaran'][0]['ang_nilai']) ?? 'Data tidak ditemukan'; ?></td>
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
                                            <td>Rp. <?= number_format(@$selectedData['Pagu']) ?? 'Data tidak ditemukan'; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Lokasi Pekerjaan</td>
                                            <td><input type="text" class="form-control" name="lokasi_pekerjaan" value="<?= $row['lokasi_pekerjaan'] ?? 'Data tidak ditemukan'; ?>" required></td>
                                        </tr>
                                    </table>
                                    <button id="simpan" class="btn btn-primary" type="submit">Selanjutnya <i class="ri-arrow-right-line"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div><!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © Universitas Negeri Gorontalo.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Develop by Bengkel IT Gorontalo
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Basic modal -->
    <div id="DetailModal" class="modal fade" tabindex="-1">
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
    <script src="<?= $url; ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!--datatable js-->
    <script src="<?= $url; ?>assets/css/datatables/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="<?= $url; ?>assets/css/datatables/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?= $url; ?>assets/css/datatables/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="<?= $url; ?>assets/css/datatables/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="<?= $url; ?>assets/js/toastify-js.js"></script>
    <script src="<?= $url; ?>assets/js/ajax.js"></script>

    <script src="<?= $url; ?>assets/js/app.js"></script>

    <script>
        $(document).on('submit', '#form', function(event) {
            event.preventDefault();
            var form = $('#form')[0];
            var nilai = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '<?= $url; ?>operator/proses/paket/pekerjaan',
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
                        text: "Data Berhasil!",
                        gravity: "top",
                        position: "center",
                        duration: 3000
                    }).showToast();
                    setTimeout(() => {
                        window.location.href = '<?= $url; ?>operator/buat-paket/<?= $kode_tender; ?>/<?= $tahun; ?>/dokumen-persiapan';
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