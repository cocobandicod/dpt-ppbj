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
cek_akses($url, $proses, @$_SESSION['token'], 'UKPBJ');
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
                        <?= profil_operator('ukpbj', $url); ?>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== App Menu ========== -->
        <?php
        menu_ukpbj($url);
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

                                    $row = $proses->tampil_data_saja('*', 'paket_pekerjaan', '1=1 AND kode_paket = "' . $kode_tender . '"');
                                    ?>
                                    <table class="table table-bordered fs-13">
                                        <tr>
                                            <td class="w-25">Rencana Umum Pengadaan</td>
                                            <td>
                                                <table class="table mb-0 table-sm fs-13">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="p-2">Kode RUP</th>
                                                            <th class="p-2">Nama Paket</th>
                                                            <th class="p-2">Sumber Dana</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="p-2"><?= $row['kode_paket'] ?? 'Data tidak ditemukan'; ?></td>
                                                            <td class="p-2"><?= $row['nama_pekerjaan'] ?? 'Data tidak ditemukan'; ?></td>
                                                            <td class="p-2"><?= $row['sumber_dana'] ?? 'Data tidak ditemukan'; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nama Instansi</td>
                                            <td>Kementerian Pendidikan dan Kebudayaan</td>
                                        </tr>
                                        <tr>
                                            <td>Satuan Kerja</td>
                                            <td>
                                                <?= $row['satuan_kerja'] ?? 'Data tidak ditemukan'; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Pengadaan</td>
                                            <td>
                                                <?= $row['jenis_pengadaan'] ?? 'Data tidak ditemukan'; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Metode Pengadaan</td>
                                            <td>
                                                <?= $row['metode_pengadaan'] ?? 'Data tidak ditemukan'; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Metode Evaluasi</td>
                                            <td>
                                                <?= $row['metode_evaluasi'] ?? 'Data tidak ditemukan'; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Anggaran</td>
                                            <td>
                                                <table class="table mb-0 table-sm fs-13s">
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
                                                            <td class="p-2"><?= $row['tahun_anggaran'] ?? 'Data tidak ditemukan'; ?></td>
                                                            <td class="p-2"><?= $row['sumber_dana'] ?? 'Data tidak ditemukan'; ?></td>
                                                            <td class="p-2"><?= $row['kode_anggaran'] ?? 'Data tidak ditemukan'; ?></td>
                                                            <td class="p-2">Rp. <?= number_format(@$row['nilai_pagu'], 0, ',', '.') ?? 'Data tidak ditemukan'; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nama Paket</td>
                                            <td><?= $row['nama_pekerjaan'] ?? 'Data tidak ditemukan'; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Nilai Pagu Paket</td>
                                            <td><b>Rp. <?= number_format(@$row['nilai_pagu'], 0, ',', '.') ?? 'Data tidak ditemukan'; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Lokasi Pekerjaan</td>
                                            <td><?= $row['lokasi_pekerjaan'] ?? 'Data tidak ditemukan'; ?></td>
                                        </tr>
                                    </table>
                                    <a href="<?= $url; ?>ukpbj/daftar-paket/<?= $kode_tender; ?>/<?= $tahun; ?>/dokumen-persiapan" class="btn btn-success" type="submit">Selanjutnya <i class="ri-arrow-right-line"></i></a>
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
</body>

</html>