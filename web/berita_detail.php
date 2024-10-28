<?php
require_once('../config/koneksi.php');
require_once('../config/menu.php');
require_once('../config/fungsi_indotgl.php');
require_once('../config/cek_akses.php');
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = md5(uniqid(rand(), TRUE));
}
cek_url($url, $proses, 'edit', 'berita', 'judul_seo = "' . @$_GET['id'] . '"');
$row = $proses->tampil_data_saja(
    'a.*,b.nama',
    'berita a LEFT JOIN operator b
    ON a.id_operator = b.id_operator',
    '1=1 AND a.judul_seo = "' . @$_GET['id'] . '"'
);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Daftar Penyedia Terpilih Universitas Negeri Gorontalo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <meta content="Daftar Penyedia Terpilih Pengelola Pengadaan Barang dan Jasa Universitas Negeri Gorontalo" name="description" />
    <meta property='og:title' content='Daftar Penyedia Terpilih Pengelola Pengadaan Barang dan Jasa Universitas Negeri Gorontalo' />
    <meta property='og:image' content='<?= $url; ?>assets/images/logo-dark.png' />
    <meta property='og:description' content='SIstem Informasi Pengelola Pengadaan Barang dan Jasa' />
    <meta property='og:url' content='https://simpan.ung.my.id/' />
    <meta property='og:image:width' content='1200' />
    <meta property='og:image:height' content='627' />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= $url; ?>assets/images/icon.png">

    <!--Swiper slider css-->
    <link href="<?= $url; ?>assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

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
    <style>
        .kunci {
            display: none;
            visibility: hidden;
        }
    </style>

</head>

<body data-bs-spy="scroll" data-bs-target="#navbar-example">

    <!-- Begin page -->
    <div class="layout-wrapper landing">
        <?= navbar($url); ?>
        <!-- end navbar -->

        <!-- start hero section -->
        <section class="section nft-hero" style="background-image: url(<?= $url; ?>assets/images/bg-home.jpg); background-color: #000; opacity:.95; padding-top:200px; padding-bottom:20px;" id="home">
            <div class="container">
                <div class="row align-items-center gy-4">
                    <div class="col-lg-12 order-2 order-lg-1">
                        <div class="text-muted mt-5 mt-lg-0">
                            <h5 class="fs-12 text-uppercase text-success">News & Updates</h5>
                            <h2 class="mb-3 ff-secondary fw-semibold text-capitalize lh-base text-white"><?= $row['judul']; ?></h2>
                        </div>
                    </div>
                </div>
            </div><!-- end container -->
        </section><!-- end hero section -->

        <section class="section" id="blog">
            <div class="container">
                <!-- end row -->
                <div class="row">
                    <div class="col-lg-12 col-md-6">
                        <div class="card mb-2">
                            <div class="card-body">
                                <ul class="list-inline fs-14 text-muted mb-3">
                                    <li class="list-inline-item">
                                        <i class="ri-calendar-line align-bottom me-1"></i> <?= tgl_indo($row['tanggal']); ?>
                                    </li>
                                    <li class="list-inline-item">
                                        <i class="ri-user-3-line align-bottom me-1"></i> <?= $row['nama']; ?>
                                    </li>
                                </ul>
                                <?= $row['isi']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end container -->
        </section>

        <!-- Start footer -->
        <footer class="custom-footer bg-dark py-5 position-relative" id="contact">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mt-12">
                        <div>
                            <div>
                                <img src="<?= $url; ?>assets/images/logo-light.png" alt="logo light" height="30">
                            </div>
                            <div class="mt-4">
                                <p>UPPBJ Badan Layanan Umum Universitas Negeri Gorontalo<br>
                                    Alamat: Jl. Jend. Sudirman No.6, Dulalowo Timur, Kec. Kota Tengah, Kota Gorontalo, Gorontalo 96128</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row text-center text-sm-start align-items-center mt-5">
                    <div class="col-sm-12">
                        <div>
                            <p class="copy-rights mb-0">
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> © Universitas Negeri Gorontalo
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end footer -->

        <!--start back-to-top-->
        <button onclick="topFunction()" class="btn btn-danger btn-icon landing-back-top" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->

    </div>
    <!-- end layout wrapper -->

    <!-- Basic modal -->
    <div id="DetailModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-xl">
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

    <!--Swiper slider js-->
    <script src="<?= $url; ?>assets/libs/swiper/swiper-bundle.min.js"></script>
    <!-- cleave.js -->
    <script src="<?= $url; ?>assets/libs/cleave.js/cleave.min.js"></script>

    <script src="<?= $url; ?>assets/js/pages/form-masks.init.js"></script>

    <script src="<?= $url; ?>assets/js/pages/nft-landing.init.js"></script>
    <script src="<?= $url; ?>assets/js/ajax.js"></script>
    <script src="<?= $url; ?>assets/js/index.js"></script>
    <script>
        $(document).ready(function() {
            dataTable = $('#example,#example2').DataTable({
                stateSave: true,
                autoWidth: false,
                processing: true,
                ordering: false,
                responsive: true
            });
        });

        $('#DetailModal').on('show.bs.modal', function(e) {
            var act = $(e.relatedTarget).data('act');
            var id = $(e.relatedTarget).data('id');
            $.ajax({
                type: 'post',
                url: '<?= $url; ?>detail/modal/pengumuman',
                data: {
                    act: act,
                    id: id
                },
                beforeSend: function(data) {
                    // Show image container
                    $("#wait").show();
                },
                success: function(data) {
                    $('.fetched-data').html(data); //menampilkan data ke dalam modal
                },
                complete: function(data) {
                    // Hide image container
                    $("#wait").hide();
                }
            });
        });
    </script>
</body>

</html>