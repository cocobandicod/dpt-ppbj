<?php
require_once('../config/koneksi.php');
require_once('../config/menu.php');
require_once('../config/fungsi_indotgl.php');
require_once('../config/cek_akses.php');
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = md5(uniqid(rand(), TRUE));
}
cek_aktivasi($url, $proses, $_GET['token']);
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Aktivasi Akun Pengelola Pengadaan Barang dan Jasa Universitas Negeri Gorontalo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <meta content="Aktivasi Akun Pengelola Pengadaan Barang dan Jasa Universitas Negeri Gorontalo" name="description" />
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
        <?= navbar3($url); ?>
        <!-- end navbar -->

        <!-- start hero section -->
        <section class="section pb-0 hero-section" id="home">
            <div class="bg-overlay bg-overlay-pattern"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-sm-10 mb-5 pb-lg-5">
                        <div class="text-center mt-lg-5 pt-5 pb-5 mb-lg-5">
                            <h1 class="display-6 fw-semibold mb-3 lh-base pt-5">Daftar Penyedia Terpilih<br><span class="text-success"> Pengelola Pengadaan Barang dan Jasa</span></h1>
                            <h2 class="pb-5">Universitas Negeri Gorontalo</h2>
                            <div class="hstack gap-2 justify-content-center">
                                <a href="#" onclick="aktivasi('<?= $_GET['token'] ?>')" class="btn btn-danger">Aktifkan Akun Saya</a>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!-- end row -->
            </div><!-- end container -->
        </section><!-- end hero section -->



        <!--start back-to-top-->
        <button onclick="topFunction()" class="btn btn-danger btn-icon landing-back-top" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->

    </div>
    <!-- end layout wrapper -->

    <div id="loginModals" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 overflow-hidden">
                <div class="modal-body p-5">
                    <h5 class="mb-3">Login Penyedia</h5>
                    <div class="alert alert-success login-success" role="alert" style="display:none;"></div>
                    <div class="alert alert-danger login-danger" role="alert" style="display:none;"></div>
                    <form id="login">
                        <div class="mb-2">
                            <input type="text" class="form-control" name="username" id="username" placeholder="Masukan username" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Masukan password" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100" id="tblmasuk">Masuk</button>
                    </form>
                </div>
                <div class="modal-footer bg-light p-3 justify-content-center">
                    <p class="mb-0 text-muted">Universitas Negeri Gorontalo</p>
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

    <!--Swiper slider js-->
    <script src="<?= $url; ?>assets/libs/swiper/swiper-bundle.min.js"></script>
    <!-- cleave.js -->
    <script src="<?= $url; ?>assets/libs/cleave.js/cleave.min.js"></script>

    <script src="<?= $url; ?>assets/js/pages/form-masks.init.js"></script>

    <script src="<?= $url; ?>assets/js/pages/nft-landing.init.js"></script>
    <script src="<?= $url; ?>assets/js/ajax.js"></script>
    <script src="<?= $url; ?>assets/js/index.js"></script>
    <script>
        function aktivasi(token) {
            $.ajax({
                type: 'post',
                url: '<?= $url; ?>proses/aktivasi',
                data: {
                    token: token
                },
                success: function(data) {
                    alert('Aktivasi Sukses');
                    location.reload();
                }
            });
        }
    </script>
</body>

</html>