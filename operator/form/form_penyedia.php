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
cek_url($url, $proses, $_GET['act'], 'profil_badan_usaha', 'id_profil ="' . @$_GET['id'] . '"');
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
                                <form id="form" enctype="multipart/form-data">
                                    <?php
                                    if ($_GET['act'] == 'edit') {
                                        $row = $proses->tampil_data_saja_join2('a.*,b.username,b.email', 'profil_badan_usaha', 'akun_penyedia', 'id_akun', 'a.id_profil = "' . $_GET['id'] . '"');
                                        echo '<input type="hidden" name="id" value="' . $row['id_profil'] . '">';
                                        echo '<input type="hidden" name="id_akun" value="' . $row['id_akun'] . '">';
                                        echo '<input type="hidden" name="act" value="edit">';
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h5>Akun</h5>
                                                    <div class="col-xxl-6 col-md-6 pt-2">
                                                        <label for="basiInput" class="form-label">Username</label>
                                                        <input type="text" class="form-control" name="username" value="<?= @$row['username']; ?>" disabled>
                                                    </div>
                                                    <div class="col-xxl-6 col-md-6 pt-2">
                                                        <label for="basiInput" class="form-label">Email</label>
                                                        <input type="email" class="form-control" name="email" value="<?= @$row['email']; ?>">
                                                    </div>
                                                    <h5 class="pt-4">Profil</h5>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">NPWP *</label>
                                                        <input type="hidden" name="id" value="<?= $row['id_profil']; ?>">
                                                        <input type="text" id="cleave-delimiters" class="form-control" name="npwp" value="<?= $row['npwp']; ?>" placeholder="xx.xxx.xxx.x-xxx.xxx" required>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Badan Usaha *</label>
                                                        <?= badan_usaha('badan_usaha', $row['badan_usaha']); ?>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Nama Perusahaan *</label>
                                                        <input type="text" name="nama_perusahaan" value="<?= $row['nama_perusahaan']; ?>" class="form-control" required>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Status *</label>
                                                        <?= status_usaha('status_usaha', $row['status_usaha']); ?>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Alamat *</label>
                                                        <textarea name="alamat" class="form-control" required><?= $row['alamat']; ?></textarea>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Provinsi *</label>
                                                        <input type="text" name="provinsi" value="<?= $row['provinsi']; ?>" class="form-control" required>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Kabupaten/Kota *</label>
                                                        <input type="text" name="kab_kota" value="<?= $row['kab_kota']; ?>" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Kode Pos *</label>
                                                        <input type="number" name="kode_pos" value="<?= $row['kode_pos']; ?>" class="form-control" required>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Telepon / HP *</label>
                                                        <input type="number" name="telepon" value="<?= $row['telepon']; ?>" class="form-control" required>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Fax</label>
                                                        <input type="number" name="fax" value="<?= $row['fax']; ?>" class="form-control">
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Website</label>
                                                        <input type="text" name="website" value="<?= $row['website']; ?>" placeholder="https://google.com" class="form-control">
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Nama Contact Person</label>
                                                        <input type="text" name="contact_person" value="<?= $row['contact_person']; ?>" class="form-control">
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Telepon / HP CP</label>
                                                        <input type="number" name="telepon_cp" value="<?= $row['telepon_cp']; ?>" class="form-control">
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
                url: '<?= $url; ?>operator/proses/edit/penyedia',
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