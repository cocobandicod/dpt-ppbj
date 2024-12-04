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
                                    <div class="row pt-2">
                                        <div class="col-xl-3">
                                            <div class="col-xxl-12 col-md-12 pt-2">
                                                <input type="hidden" name="act" value="edit">
                                                <div class="alert alert-danger" id="pesan1" style="display:none;"></div>
                                                <div class="alert alert-danger" id="pesan2" style="display:none;"></div>
                                                <label for="basiInput" class="form-label">Password Lama</label>
                                                <input type="password" onchange="cek_pass()" class="form-control" id="pass_lama" required>
                                            </div>
                                            <div class="col-xxl-12 col-md-12 pt-2">
                                                <label for="basiInput" class="form-label">Password Baru *</label>
                                                <input type="password" name="pass_baru" id="pass_baru" class="form-control" required>
                                            </div>
                                            <div class="col-xxl-12 col-md-12 pt-2">
                                                <label for="basiInput" class="form-label">Konfirmasi Password Baru</label>
                                                <input type="password" class="form-control" id="konf_pass" name="konf_pass" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 pt-5">
                                        <div class="text-start">
                                            <span class="btn btn-light cursor-pointer" onclick="back()"><i class=" ri-arrow-go-back-line"></i> Kembali</span>
                                            <button type="submit" class="btn btn-success" id="simpan"><i class="ri-save-2-fill"></i> Update</button>
                                        </div>
                                    </div>
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
        function back() {
            history.go(-1);
        }

        function cek_pass() {
            var pass_lama = $('#pass_lama').val();
            $.ajax({
                type: 'post',
                url: '<?= $url; ?>ukpbj/proses/ganti/password',
                data: {
                    pass_lama: pass_lama,
                    act: 'cek'
                },
                success: function(data) {
                    if (data == 0) {
                        $("#pesan1").fadeIn();
                        $("#pesan1").html('Password Lama Salah');
                        setTimeout(function() {
                            $("#pesan1").fadeOut();
                            $('#pass_lama').val('');
                        }, 2000); //will call the function after 2 secs.
                    }
                },
            });
        }

        $(document).on('submit', '#form', function(event) {
            event.preventDefault();
            var pass_baru = $('#pass_baru').val();
            var konf_pass = $('#konf_pass').val();
            var form = $('#form')[0];
            var nilai = new FormData(form);
            if (konf_pass != pass_baru) {
                $("#pesan2").fadeIn();
                $("#pesan2").html('Password baru dan konfirmasi password tidak sama');
                setTimeout(function() {
                    $("#pesan2").fadeOut();
                    $('#konf_pass').val('');
                }, 2000); //will call the function after 2 secs.
            } else {

                $.ajax({
                    type: 'POST',
                    url: '<?= $url; ?>ukpbj/proses/ganti/password',
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
                                text: "Password Gagal diubah",
                                className: "bg-danger",
                                gravity: "top",
                                position: "center",
                                duration: 3000,
                            }).showToast();
                        } else {
                            Toastify({
                                text: "Password berhasil dirubah!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                            $('#pass_baru').val('');
                            $('#konf_pass').val('');
                            $('#pass_lama').val('');
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        Toastify({
                            text: "Password Gagal diubah",
                            gravity: "top",
                            position: "center",
                            duration: 3000
                        }).showToast();
                    },
                    complete: function(data) {
                        document.querySelector('#simpan').innerHTML = '<i class="ri-save-3-line align-middle ms-1"></i> Simpan';
                    }
                });

            };
        });
    </script>
</body>

</html>