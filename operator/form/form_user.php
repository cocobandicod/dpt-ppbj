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
cek_url($url, $proses, $_GET['act'], 'operator', 'id_operator ="' . @$_GET['id'] . '"');
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
                                <div>
                                    <button onclick="back()" type="button" class="btn btn-primary btn-label waves-effect waves-light btn-sm"><i class="ri-arrow-go-back-line label-icon align-middle fs-16 me-2"></i> Back</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="form" enctype="multipart/form-data">
                                    <?php
                                    if ($_GET['act'] == 'edit') {
                                        $row = $proses->tampil_data_saja('*', 'operator', 'id_operator = "' . $_GET['id'] . '"');
                                        echo '<input type="hidden" name="id" value="' . $row['id_operator'] . '">';
                                        echo '<input type="hidden" name="act" value="edit">';
                                        $text = '*Kosongkan jika tidak merubah';
                                        $required = '';
                                    } else {
                                        echo '<input type="hidden" name="act" value="add">';
                                        $text = '';
                                        $required = 'required';
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h5>Akun</h5>
                                                    <div class="row">
                                                        <div class="col-xxl-6 col-md-6 pt-2">
                                                            <label for="basiInput" class="form-label">Username</label>
                                                            <input type="text" class="form-control" name="username" value="<?= @$row['username']; ?>" required>
                                                        </div>
                                                        <div class="col-xxl-6 col-md-6 pt-2">
                                                            <label for="basiInput" class="form-label">Password</label>
                                                            <input type="password" class="form-control" name="password" <?= $required; ?>>
                                                            <div id="passwordHelpBlock" class="form-text">
                                                                <?= $text; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Email</label>
                                                        <input type="email" class="form-control" name="email" value="<?= @$row['email']; ?>" <?= $required; ?>>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xxl-6 col-md-6 pt-2">
                                                            <label for="basiInput" class="form-label">Level</label>
                                                            <?= level('level', @$row['level']); ?>
                                                        </div>
                                                        <div class="col-xxl-6 col-md-6 pt-2">
                                                            <label for="basiInput" class="form-label">Status</label>
                                                            <?= status('status_aktif', @$row['status_aktif']); ?>
                                                        </div>
                                                    </div>
                                                    <h5 class="pt-4">Profil</h5>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Nama Lengkap</label>
                                                        <input type="text" class="form-control" name="nama" value="<?= @$row['nama']; ?>" required>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xxl-6 col-md-6 pt-2">
                                                            <label for="basiInput" class="form-label">NIP</label>
                                                            <input type="number" class="form-control" name="nip" value="<?= @$row['nip']; ?>" required>
                                                        </div>
                                                        <div class="col-xxl-6 col-md-6 pt-2">
                                                            <label for="basiInput" class="form-label">Nomor SK</label>
                                                            <input type="text" class="form-control" name="no_sk" value="<?= @$row['no_sk']; ?>">
                                                        </div>
                                                        <div class="col-xxl-6 col-md-6 pt-2">
                                                            <label for="basiInput" class="form-label">Tanggal SK</label>
                                                            <input type="date" class="form-control" name="tgl_sk" value="<?= @$row['tgl_sk']; ?>">
                                                        </div>
                                                        <div class="col-xxl-6 col-md-6 pt-2">
                                                            <label for="basiInput" class="form-label">Nomor Telepon / HP</label>
                                                            <input type="number" class="form-control" name="hp" value="<?= @$row['hp']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Alamat</label>
                                                        <textarea name="alamat" class="form-control"><?= @$row['alamat']; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 pt-5">
                                            <button id="simpan" class="btn btn-primary" type="submit"><i class="ri-save-2-fill"></i> Simpan</button>
                                        </div>
                                    </div>
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

    <!-- JAVASCRIPT -->
    <script src="<?= $url; ?>assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?= $url; ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $url; ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= $url; ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= $url; ?>assets/libs/feather-icons/feather.min.js"></script>
    <script src="<?= $url; ?>assets/js/pages/plugins/lord-icon-2.1.0.js"></script>

    <!-- prismjs plugin -->
    <script src="<?= $url; ?>assets/libs/prismjs/prism.js"></script>
    <script src="<?= $url; ?>assets/js/toastify-js.js"></script>
    <script src="<?= $url; ?>assets/js/ajax.js"></script>

    <script src="<?= $url; ?>assets/js/app.js"></script>

    <script>
        function back() {
            history.go(-1);
        }

        $(document).on('submit', '#form', function(event) {
            event.preventDefault();
            var form = $('#form')[0];
            var nilai = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '<?= $url; ?>operator/proses/user',
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
                        setTimeout(function() {
                            history.go(-1);
                        }, 2000);
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
    </script>

</body>

</html>