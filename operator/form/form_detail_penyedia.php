<?php
require_once('../../config/koneksi.php');
require_once('../../config/menu.php');
require_once('../../config/fungsi_indotgl.php');
require_once('../../config/cek_akses.php');
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = md5(uniqid(rand(), TRUE));
}
cek_login_akses($proses, $url, @$_SESSION['kode_user'], @$_SESSION['token']);
cek_url($url, $proses, 'edit', 'profil_badan_usaha', 'id_profil ="' . @$_GET['id'] . '"');
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Operator | Simpan Universitas Negeri Gorontalo</title>
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

        <?= sidebar($url); ?>
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
                                <div>
                                    <button onclick="back()" type="button" class="btn btn-primary btn-label waves-effect waves-light btn-sm"><i class="ri-arrow-go-back-line label-icon align-middle fs-16 me-2"></i> Back</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                if ($_GET['act'] == 'detail') {
                                    $row = $proses->tampil_data_saja('*', 'profil_badan_usaha', 'id_profil = "' . $_GET['id'] . '"');
                                    echo '<input type="hidden" name="id" value="' . $row['id_profil'] . '">';
                                    echo '<input type="hidden" name="act" value="detail">';
                                    if ($row['status'] == 'Terverifikasi') {
                                        $status = '<i class="ri-checkbox-circle-line text-success"></i>';
                                    } else {
                                        $status = '<i class="ri-close-circle-line text-danger"></i>';
                                    }
                                }
                                ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6 pt-3 pb-3">
                                                <div class="revdiv">
                                                    <h2><?= $row['nama_perusahaan'] . ' ' . $status; ?> </h2>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 pt-3 pb-3">
                                                <?php
                                                $cek = $proses->cek_row('catatan', 'id_profil = "' . $_GET['id'] . '" AND status = "Verified" GROUP BY menu');
                                                if ($cek >= 9) {
                                                    $kunci = '';
                                                    $ket = '';
                                                } else {
                                                    $kunci = 'disabled';
                                                    $ket = '
                                                    <div class="alert alert-danger" role="alert">
                                                        Tombol Verifikasi Penyedia akan aktif jika semua berkas syarat pendaftaran telah di verifikasi
                                                    </div>
                                                    ';
                                                }
                                                ?>
                                                <button id="verifikasi" data-id="<?= $row['id_profil']; ?>" data-nama="<?= $row['nama_perusahaan']; ?>" type="button" class="btn btn-success btn-label waves-effect waves-light float-end <?= $kunci; ?>"><i class="ri-checkbox-circle-line label-icon align-middle fs-16 me-2"></i> Verifikasi Penyedia</button>
                                            </div>

                                            <!-- Base Example -->
                                            <div class="col-sm-12 pt-0 pb-0">
                                                <?= $ket; ?>
                                            </div>
                                            <div class="accordion" id="default-accordion-example">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="head1">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#open1" aria-expanded="false" aria-controls="open1">
                                                            Detail Penyedia
                                                        </button>
                                                    </h2>
                                                    <div id="open1" class="accordion-collapse collapse" aria-labelledby="head1" data-bs-parent="#default-accordion-example">
                                                        <div class="accordion-body">
                                                            <div class="tampil_detail_penyedia"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="head2">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#open2" aria-expanded="false" aria-controls="open2">
                                                            Dokumen Verifikasi
                                                        </button>
                                                    </h2>
                                                    <div id="open2" class="accordion-collapse collapse" aria-labelledby="head2" data-bs-parent="#default-accordion-example">
                                                        <div class="revdiv2">
                                                            <div class="accordion-body">
                                                                <?php
                                                                $row = $proses->tampil_data_saja('*', 'dokumen_verifikasi', 'id_profil = "' . $_GET['id'] . '"');
                                                                if (!@$row['file_keikutsertaan']) {
                                                                    $iconA = 'ri-close-circle-fill text-danger';
                                                                    $downloadA = '';
                                                                } else {
                                                                    $act1 = pathinfo(@$row['file_keikutsertaan'], PATHINFO_EXTENSION);
                                                                    $iconA = 'ri-checkbox-circle-fill text-success';
                                                                    $downloadA = '<a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="' . $act1 . '" data-id="' . $row['file_keikutsertaan'] . '"><span class="badge text-bg-success">Lihat File</span></a>';
                                                                }
                                                                if (!@$row['file_surat_kuasa']) {
                                                                    $iconB = 'ri-close-circle-fill text-danger';
                                                                    $downloadB = '';
                                                                } else {
                                                                    $act2 = pathinfo(@$row['file_surat_kuasa'], PATHINFO_EXTENSION);
                                                                    $iconB = 'ri-checkbox-circle-fill text-success';
                                                                    $downloadB = '<a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="' . $act2 . '" data-id="' . $row['file_surat_kuasa'] . '"><span class="badge text-bg-success">Lihat File</span></a>';
                                                                }
                                                                if (!@$row['file_penunjukan_admin']) {
                                                                    $iconC = 'ri-close-circle-fill text-danger';
                                                                    $downloadC = '';
                                                                } else {
                                                                    $act3 = pathinfo(@$row['file_penunjukan_admin'], PATHINFO_EXTENSION);
                                                                    $iconC = 'ri-checkbox-circle-fill text-success';
                                                                    $downloadC = '<a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="' . $act3 . '" data-id="' . $row['file_penunjukan_admin'] . '"><span class="badge text-bg-success">Lihat File</span></a>';
                                                                }
                                                                if (!@$row['file_verifikasi']) {
                                                                    $iconD = 'ri-close-circle-fill text-danger';
                                                                    $downloadD = '';
                                                                } else {
                                                                    $act4 = pathinfo(@$row['file_verifikasi'], PATHINFO_EXTENSION);
                                                                    $iconD = 'ri-checkbox-circle-fill text-success';
                                                                    $downloadD = '';
                                                                }
                                                                ?>
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <div class="d-flex">
                                                                            <div class="flex-shrink-0">
                                                                                <i class="<?= $iconA; ?>"></i>
                                                                            </div>
                                                                            <div class="flex-grow-1 ms-2">
                                                                                Form Keikutsertaan <?= $downloadA; ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex">
                                                                            <div class="flex-shrink-0">
                                                                                <i class="<?= $iconC; ?>"></i>
                                                                            </div>
                                                                            <div class="flex-grow-1 ms-2">
                                                                                Surat Penunjukan Admin <?= $downloadC; ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex">
                                                                            <div class="flex-shrink-0">
                                                                                <i class="<?= $iconB; ?>"></i>
                                                                            </div>
                                                                            <div class="flex-grow-1 ms-2">
                                                                                Surat Kuasa (Jika Ada) <?= $downloadB; ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex">
                                                                            <div class="flex-shrink-0">
                                                                                <i class="<?= $iconD; ?>"></i>
                                                                            </div>
                                                                            <div class="flex-grow-1 ms-2">
                                                                                Lembar Verifikasi <?= $downloadD; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <?php
                                                                        if (!@$row['file_verifikasi']) {
                                                                        ?>
                                                                            <form id="lembar" enctype="multipart/form-data">
                                                                                <div class="row">
                                                                                    <h6>Lembar Verifikasi</h6>
                                                                                    <div class="col-xxl-6 col-md-6">
                                                                                        <label for="basiInput" class="form-label">Upload Scan Lembar Verifikasi Operator yang di telah di tandatangani, lembar verifikasi dapat di cetak di sini <a href="<?= $url; ?>operator/cetak/lembar/verifikasi/<?= $_GET['id'] ?>" target="_blank">Cetak Lembar Verifikasi</a></label>
                                                                                    </div>
                                                                                    <div class="col-xxl-6 col-md-6">
                                                                                        <input type="hidden" name="id_profil" id="id_profil" value="<?= $_GET['id']; ?>">
                                                                                        <input type="file" name="fupload" onchange="validasiFile(this)" class="form-control file" required>
                                                                                        <div id="passwordHelpBlock" class="form-text">
                                                                                            *Accepted formats: pdf, jpg. Max file size 2Mb
                                                                                        </div>
                                                                                        <button type="submit" class="btn btn-primary mt-3" id="upload"><i class="ri-save-2-fill"></i> Upload</button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        <?php } else { ?>
                                                                            <div class="row">
                                                                                <div class="col-xxl-6 col-md-6">
                                                                                    <label for="basiInput" class="form-label">Upload Scan Lembar Verifikasi Operator yang telah di tandatangani</label>
                                                                                </div>
                                                                                <div class="col-xxl-6 col-md-6">
                                                                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act4; ?>" data-id="<?= $row['file_verifikasi']; ?>"><i class="ri-search-line"></i> Lihat File</button>
                                                                                    <button type="button" id="del" data-id="file_verifikasi" data-id_profil="<?= $_GET['id']; ?>" data-nama="File Lembar Verifikasi" data-act="del" class="text-danger btn btn-sm btn-light"><i class="ri-delete-bin-line"></i> File</button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="head3">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#open3" aria-expanded="false" aria-controls="open3">
                                                            Syarat Pendaftaran
                                                        </button>
                                                    </h2>
                                                    <div id="open3" class="accordion-collapse collapse" aria-labelledby="head3" data-bs-parent="#default-accordion-example">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="nav flex-column nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                                        <!--
                                                                        <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-12" role="tab" aria-controls="v-pills-12" aria-selected="true">Nomor Induk Berusaha (NIB)</a>
                                                                        <a class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-13" role="tab" aria-controls="v-pills-13" aria-selected="true">Sertifikat Badan Usaha (SBU)</a>
                                                                        -->
                                                                        <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Izin Usaha</a>
                                                                        <a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-8" role="tab" aria-controls="v-pills-8" aria-selected="false">NPWP</a>
                                                                        <a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">Domisili</a>
                                                                        <a class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false">TDP</a>
                                                                        <a class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-4" role="tab" aria-controls="v-pills-4" aria-selected="false">Akta</a>
                                                                        <a class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-5" role="tab" aria-controls="v-pills-5" aria-selected="false">Pengurus</a>
                                                                        <a class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-6" role="tab" aria-controls="v-pills-6" aria-selected="false">Pemilik Saham</a>
                                                                        <a class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-7" role="tab" aria-controls="v-pills-7" aria-selected="false">Pajak</a>
                                                                        <a class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-14" role="tab" aria-controls="v-pills-14" aria-selected="true">KSWP</a>
                                                                    </div>
                                                                </div><!-- end col -->
                                                                <div class="col-md-10">
                                                                    <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">

                                                                        <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                                            <h5>Izin Usaha</h5>
                                                                            <div class="tabel_izin_usaha"></div>
                                                                        </div>
                                                                        <div class="tab-pane fade" id="v-pills-8" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                                                            <h5>NPWP</h5>
                                                                            <div class="tabel_npwp"></div>
                                                                        </div>
                                                                        <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                                                            <h5>Domisili</h5>
                                                                            <div class="tabel_domisili"></div>
                                                                        </div>
                                                                        <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                                                            <h5>TDP</h5>
                                                                            <div class="tabel_tdp"></div>
                                                                        </div>
                                                                        <div class="tab-pane fade" id="v-pills-4" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                                                            <h5>Akta</h5>
                                                                            <div class="tabel_akta"></div>
                                                                        </div>
                                                                        <div class="tab-pane fade" id="v-pills-5" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                                                            <h5>Pengurus</h5>
                                                                            <div class="tabel_pengurus"></div>
                                                                        </div>
                                                                        <div class="tab-pane fade" id="v-pills-6" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                                                            <h5>Pemilik Saham</h5>
                                                                            <div class="tabel_pemilik_saham"></div>
                                                                        </div>
                                                                        <div class="tab-pane fade" id="v-pills-7" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                                                            <h5>Pajak</h5>
                                                                            <div class="tabel_pajak"></div>
                                                                        </div>

                                                                        <!--
                                                                        <div class="tab-pane fade show active" id="v-pills-12" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                                                            <h5>Nomor Induk Berusaha (NIB)</h5>
                                                                            <div class="tabel_nib"></div>
                                                                        </div>

                                                                        <div class="tab-pane fade" id="v-pills-13" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                                                            <h5>Sertifikat Badan Usaha (SBU)</h5>
                                                                            <div class="tabel_sbu"></div>
                                                                        </div>
                                                                        -->
                                                                        <div class="tab-pane fade" id="v-pills-14" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                                                            <h5>KSWP</h5>
                                                                            <div class="tabel_kswp"></div>
                                                                        </div>
                                                                    </div><!--  end col -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="head4">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#open4" aria-expanded="false" aria-controls="open4">
                                                            Syarat Pendaftaran Lainnya
                                                        </button>
                                                    </h2>
                                                    <div id="open4" class="accordion-collapse collapse" aria-labelledby="head4" data-bs-parent="#default-accordion-example">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="nav flex-column nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                                        <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-9" role="tab" aria-controls="v-pills-9" aria-selected="true">Tenaga Ahli</a>
                                                                        <a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-10" role="tab" aria-controls="v-pills-10" aria-selected="false">Peralatan</a>
                                                                        <a class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" href="#v-pills-11" role="tab" aria-controls="v-pills-11" aria-selected="false">Pengalaman</a>
                                                                    </div>
                                                                </div><!-- end col -->
                                                                <div class="col-md-10">
                                                                    <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                                                                        <div class="tab-pane fade show active" id="v-pills-9" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                                            <h5>Tenaga Ahli</h5>
                                                                            <div class="tabel_tenaga_ahli"></div>
                                                                        </div>
                                                                        <div class="tab-pane fade" id="v-pills-10" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                                                            <h5>Peralatan</h5>
                                                                            <div class="tabel_peralatan"></div>
                                                                        </div>
                                                                        <div class="tab-pane fade" id="v-pills-11" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                                                            <h5>Pengalaman</h5>
                                                                            <div class="tabel_pengalaman"></div>
                                                                        </div>
                                                                    </div>
                                                                </div><!--  end col -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="head5">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#open5" aria-expanded="false" aria-controls="open5">
                                                            Dokumen Penawaran Teknis
                                                        </button>
                                                    </h2>
                                                    <div id="open5" class="accordion-collapse collapse" aria-labelledby="head5" data-bs-parent="#default-accordion-example">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="tabel_teknis"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="head6">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#open6" aria-expanded="false" aria-controls="open6">
                                                            Dokumen Penawaran Biaya
                                                        </button>
                                                    </h2>
                                                    <div class="revdiv4">
                                                        <div id="open6" class="accordion-collapse collapse" aria-labelledby="head6" data-bs-parent="#default-accordion-example">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="tabel_biaya"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                -->
                                            </div>
                                        </div>
                                    </div>
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

        <!-- Default Modals -->
        <div id="modalview" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalview"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div id="viewfile"></div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- Default Modals -->
        <div id="modalproses" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalproses"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form" method="POST">
                            <div class="row">
                                <div class="col-xxl-12 col-md-12 pt-2">
                                    <label for="basiInput" class="form-label">Status</label>
                                    <?= verifikasi('status_ver', ''); ?>
                                    <input type="hidden" name="db" id="db" value="">
                                    <input type="hidden" name="id" id="id" value="">
                                    <input type="hidden" name="act" id="act" value="">
                                    <input type="hidden" name="id_profil" value="<?= $_GET['id']; ?>">
                                </div>
                                <div class="col-xxl-12 col-md-12 pt-2">
                                    <label for="basiInput" class="form-label">Keterangan</label>
                                    <textarea name="catatan" id="catatan" class="form-control" required></textarea>
                                </div>
                                <div class="col-12 pt-3">
                                    <button id="simpan" class="btn btn-primary" type="submit"><i class="ri-save-2-fill"></i> Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

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

        <!-- prismjs plugin -->
        <script src="<?= $url; ?>assets/libs/prismjs/prism.js"></script>
        <script src="<?= $url; ?>assets/js/toastify-js.js"></script>
        <script src="<?= $url; ?>assets/js/ajax.js"></script>

        <script src="<?= $url; ?>assets/js/app.js"></script>

        <script>
            function back() {
                history.go(-1);
            }

            $(document).ready(function() {
                $('#modalview').on('show.bs.modal', function(e) {
                    var id = $(e.relatedTarget).data('id');
                    var act = $(e.relatedTarget).data('act');
                    $('#myModalview').text('View');
                    if (act === 'pdf') {
                        $('#viewfile').html('<iframe src="<?= $url; ?>berkas/' + id + '" style="width: 100%; height: 700px; border: none;"></iframe>');
                    } else {
                        $('#viewfile').html('<img src="<?= $url; ?>berkas/' + id + '" class="gallery-img img-fluid mx-auto">');
                    }
                });

                $('#modalview').on('hidden.bs.modal', function() {
                    $('#viewfile').empty();
                });

                $('#modalproses').on('show.bs.modal', function(e) {
                    var id = $(e.relatedTarget).data('id');
                    var text = $(e.relatedTarget).data('text');
                    var db = $(e.relatedTarget).data('db');
                    var status = $(e.relatedTarget).data('status');
                    var catatan = $(e.relatedTarget).data('catatan');
                    var action = $(e.relatedTarget).data('action');
                    $('#myModalproses').text(text);
                    $('#status_ver').val(status);
                    $('#catatan').val(catatan);
                    $('#id').val(id);
                    $('#db').val(db);
                    $('#act').val(action);
                });

                detail_tabel('izin_usaha');
                detail_tabel('domisili');
                detail_tabel('tdp');
                detail_tabel('akta');
                detail_tabel('pengurus');
                detail_tabel('pemilik_saham');
                detail_tabel('pajak');
                detail_tabel('npwp');

                detail_tabel('tenaga_ahli');
                detail_tabel('peralatan');
                detail_tabel('pengalaman');
                detail_tabel('penyedia');

                detail_tabel('nib');
                detail_tabel('sbu');
                detail_tabel('kswp');
                /*
                detail_tabel('teknis');
                detail_tabel('biaya');
                */
            });

            function detail_tabel(judul) {
                $.ajax({
                    type: 'post',
                    url: '<?= $url; ?>operator/tabel/detail/penyedia',
                    data: {
                        judul: judul,
                        id: <?= $_GET['id']; ?>
                    },
                    success: function(data) {

                        if (judul == 'izin_usaha') {
                            $('.tabel_izin_usaha').html(data);
                        }
                        if (judul == 'domisili') {
                            $('.tabel_domisili').html(data);
                        }
                        if (judul == 'tdp') {
                            $('.tabel_tdp').html(data);
                        }
                        if (judul == 'akta') {
                            $('.tabel_akta').html(data);
                        }
                        if (judul == 'pengurus') {
                            $('.tabel_pengurus').html(data);
                        }
                        if (judul == 'pemilik_saham') {
                            $('.tabel_pemilik_saham').html(data);
                        }
                        if (judul == 'pajak') {
                            $('.tabel_pajak').html(data);
                        }
                        if (judul == 'npwp') {
                            $('.tabel_npwp').html(data);
                        }
                        if (judul == 'tenaga_ahli') {
                            $('.tabel_tenaga_ahli').html(data);
                        }
                        if (judul == 'peralatan') {
                            $('.tabel_peralatan').html(data);
                        }
                        if (judul == 'pengalaman') {
                            $('.tabel_pengalaman').html(data);
                        }
                        if (judul == 'penyedia') {
                            $('.tampil_detail_penyedia').html(data);
                        }
                        if (judul == 'nib') {
                            $('.tabel_nib').html(data);
                        }
                        if (judul == 'sbu') {
                            $('.tabel_sbu').html(data);
                        }
                        if (judul == 'kswp') {
                            $('.tabel_kswp').html(data);
                        }
                        /*
                        if (judul == 'teknis') {
                            $('.tabel_teknis').html(data);
                        }
                        if (judul == 'biaya') {
                            $('.tabel_biaya').html(data);
                        }
                        */
                    },
                });
            };

            $(document).on('submit', '#form', function(event) {
                event.preventDefault();
                var judul = $('#db').val();
                var form = $('#form')[0];
                var nilai = new FormData(form);
                $.ajax({
                    type: 'POST',
                    url: '<?= $url; ?>operator/proses/penyedia',
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: nilai,
                    beforeSend: function() {
                        document.querySelector('#simpan').innerHTML = '<i class="mdi mdi-spin mdi-loading align-middle ms-1"></i> Loading...';
                    },
                    success: function(data) {
                        if (data === 'gagal') {
                            Toastify({
                                text: "Data Gagal Dimasukan!",
                                className: "bg-danger",
                                gravity: "top",
                                position: "center",
                                duration: 3000,
                            }).showToast();
                        } else {
                            Toastify({
                                text: "Data Berhasil Dimasukan!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                            $('#modalproses').modal('hide');
                            if (judul == 'izin_usaha') {
                                detail_tabel('izin_usaha');
                            } else if (judul == 'domisili') {
                                detail_tabel('domisili');
                            } else if (judul == 'tdp') {
                                detail_tabel('tdp');
                            } else if (judul == 'akta') {
                                detail_tabel('akta');
                            } else if (judul == 'pengurus') {
                                detail_tabel('pengurus');
                            } else if (judul == 'pemilik_saham') {
                                detail_tabel('pemilik_saham');
                            } else if (judul == 'pajak') {
                                detail_tabel('pajak');
                            } else if (judul == 'npwp') {
                                detail_tabel('npwp');
                            } else if (judul == 'sbu') {
                                detail_tabel('sbu');
                            } else if (judul == 'kswp') {
                                detail_tabel('kswp');
                            } else if (judul == 'dokumen_penawaran_teknis') {
                                detail_tabel('teknis');
                            } else if (judul == 'dokumen_penawaran_biaya') {
                                detail_tabel('biaya');
                            }
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        Toastify({
                            text: "Data Gagal Dimasukan!",
                            gravity: "top",
                            position: "center",
                            duration: 3000
                        }).showToast();
                    },
                    complete: function(data) {
                        document.querySelector('#simpan').innerHTML = '<i class="ri-save-3-line align-middle ms-1"></i> Simpan';
                    }
                });
            });

            $(document).on('click', '#verifikasi', function(e) {
                var nama = $(e.currentTarget).data('nama');
                var id = $(e.currentTarget).data('id');
                Swal.fire({
                    title: "Verifikasi Penyedia?",
                    text: nama,
                    icon: "question",
                    showCancelButton: !0,
                    confirmButtonClass: "btn btn-success w-xs me-2 mt-2",
                    cancelButtonClass: "btn btn-danger w-xs mt-2",
                    confirmButtonText: "Verifikasi!",
                    cancelButtonText: "Batal!",
                    buttonsStyling: !1,
                    showCloseButton: !0
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'post',
                            url: '<?= $url; ?>operator/proses/verifikasi',
                            data: {
                                id: id,
                                act: 'ver'
                            },
                            success: function(data) {
                                $(".revdiv").load(location.href + " .revdiv");
                                Toastify({
                                    text: "Data Berhasil Diverifikasi!",
                                    gravity: "top",
                                    position: "center",
                                    duration: 3000
                                }).showToast();
                            }
                        });
                    }
                });
            });

            $(document).on('submit', '#lembar', function(event) {
                event.preventDefault();
                var form = $('#lembar')[0];
                var nilai = new FormData(form);
                $.ajax({
                    type: 'POST',
                    url: '<?= $url; ?>operator/proses/lembar',
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: nilai,
                    beforeSend: function() {
                        document.querySelector('#upload').innerHTML = '<i class="mdi mdi-spin mdi-loading align-middle ms-1"></i> Loading...';
                    },
                    success: function(data) {
                        if (data === 'gagal') {
                            Toastify({
                                text: "Data Gagal Dimasukan!",
                                className: "bg-danger",
                                gravity: "top",
                                position: "center",
                                duration: 3000,
                            }).showToast();
                        } else {
                            Toastify({
                                text: "Data Berhasil Dimasukan!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                            $(".revdiv2").load(location.href + " .revdiv2");
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        Toastify({
                            text: "Data Gagal Dimasukan!",
                            gravity: "top",
                            position: "center",
                            duration: 3000
                        }).showToast();
                    },
                    complete: function(data) {
                        document.querySelector('#upload').innerHTML = '<i class="ri-save-3-line align-middle ms-1"></i> Upload';
                    }
                });
            });

            $(document).on('click', '#del', function(e) {
                var nama = $(e.currentTarget).data('nama');
                var id = $(e.currentTarget).data('id');
                var act = $(e.currentTarget).data('act');
                var id_profil = $(e.currentTarget).data('id_profil');
                Swal.fire({
                    title: "File ini akan dihapus?",
                    text: nama,
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonClass: "btn btn-danger w-xs me-2 mt-2",
                    cancelButtonClass: "btn btn-primary w-xs mt-2",
                    confirmButtonText: "Hapus!",
                    cancelButtonText: "Batal!",
                    buttonsStyling: !1,
                    showCloseButton: !0
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'post',
                            url: '<?= $url; ?>operator/proses/lembar',
                            data: {
                                id: id,
                                act: act,
                                id_profil: id_profil
                            },
                            success: function(data) {
                                $(".revdiv2").load(location.href + " .revdiv2");
                                Toastify({
                                    text: "Data Berhasil Dihapus!",
                                    gravity: "top",
                                    position: "center",
                                    duration: 3000
                                }).showToast();
                            }
                        });
                    }
                });
            });

            function validasiFile(inputFile) {
                var pathFile = inputFile.value;
                var ekstensiOk = /(\.jpg|\.jpeg|\.pdf)$/i;
                var file_size = inputFile.files[0].size;

                if (!ekstensiOk.exec(pathFile)) {
                    alert('Silakan upload file yang memiliki ekstensi .jpeg/.jpg/.pdf');
                    inputFile.value = '';
                    return false;
                } else {
                    if (file_size > 2000000) {
                        alert('Ukuran file harus kurang dari 2Mb');
                        inputFile.value = '';
                        return false;
                    }
                }
            }
        </script>

</body>

</html>