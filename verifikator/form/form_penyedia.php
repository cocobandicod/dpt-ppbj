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
cek_akses($url, $proses, @$_SESSION['token'], 'Verifikator');
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
                        <?= profil_operator('verifikator', $url); ?>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== App Menu ========== -->
        <?php
        menu_verifikator($url);
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
                                        <div class="col-xxl-4 col-md-4 pt-2">
                                            <label for="basiInput" class="form-label">NPWP *</label>
                                            <input type="hidden" name="id" value="<?= $row['id_profil']; ?>">
                                            <input type="text" id="cleave-delimiters" class="form-control" name="npwp" value="<?= $row['npwp']; ?>" placeholder="xx.xxx.xxx.x-xxx.xxx" required>
                                        </div>
                                        <div class="col-xxl-4 col-md-4 pt-2">
                                            <label for="basiInput" class="form-label">Badan Usaha *</label>
                                            <?= badan_usaha('badan_usaha', $row['badan_usaha']); ?>
                                        </div>
                                        <div class="col-xxl-4 col-md-4 pt-2">
                                            <label for="basiInput" class="form-label">Nama Perusahaan *</label>
                                            <input type="text" name="nama_perusahaan" value="<?= $row['nama_perusahaan']; ?>" class="form-control" required>
                                        </div>
                                        <div class="col-xxl-4 col-md-4 pt-2">
                                            <label for="basiInput" class="form-label">Status *</label>
                                            <?= status_usaha('status_usaha', $row['status_usaha']); ?>
                                        </div>
                                        <div class="col-xxl-4 col-md-4 pt-2">
                                            <label for="basiInput" class="form-label">Provinsi *</label>
                                            <input type="text" name="provinsi" value="<?= $row['provinsi']; ?>" class="form-control" required>
                                        </div>
                                        <div class="col-xxl-4 col-md-4 pt-2">
                                            <label for="basiInput" class="form-label">Kabupaten/Kota *</label>
                                            <input type="text" name="kab_kota" value="<?= $row['kab_kota']; ?>" class="form-control" required>
                                        </div>
                                        <div class="col-xxl-12 col-md-12 pt-2">
                                            <label for="basiInput" class="form-label">Alamat *</label>
                                            <textarea name="alamat" class="form-control" required><?= $row['alamat']; ?></textarea>
                                        </div>
                                        <div class="col-xxl-4 col-md-4 pt-2">
                                            <label for="basiInput" class="form-label">Kode Pos *</label>
                                            <input type="number" name="kode_pos" value="<?= $row['kode_pos']; ?>" class="form-control" required>
                                        </div>
                                        <div class="col-xxl-4 col-md-4 pt-2">
                                            <label for="basiInput" class="form-label">Telepon / HP *</label>
                                            <input type="number" name="telepon" value="<?= $row['telepon']; ?>" class="form-control" required>
                                        </div>
                                        <div class="col-xxl-4 col-md-4 pt-2">
                                            <label for="basiInput" class="form-label">Fax</label>
                                            <input type="number" name="fax" value="<?= $row['fax']; ?>" class="form-control">
                                        </div>
                                        <div class="col-xxl-4 col-md-4 pt-2">
                                            <label for="basiInput" class="form-label">Website</label>
                                            <input type="text" name="website" value="<?= $row['website']; ?>" placeholder="https://google.com" class="form-control">
                                        </div>
                                        <div class="col-xxl-4 col-md-4 pt-2">
                                            <label for="basiInput" class="form-label">Nama Contact Person</label>
                                            <input type="text" name="contact_person" value="<?= $row['contact_person']; ?>" class="form-control">
                                        </div>
                                        <div class="col-xxl-4 col-md-4 pt-2">
                                            <label for="basiInput" class="form-label">Telepon / HP CP</label>
                                            <input type="number" name="telepon_cp" value="<?= $row['telepon_cp']; ?>" class="form-control">
                                        </div>
                                        <div class="col-12 pt-5">
                                            <span class="btn btn-light cursor-pointer" onclick="back()"><i class=" ri-arrow-go-back-line"></i> Kembali</span>
                                            <button id="simpan" class="btn btn-success" type="submit"><i class="ri-save-2-fill"></i> Simpan</button>
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
        function back() {
            history.go(-1);
        }

        $(document).on('submit', '#form', function(event) {
            event.preventDefault();
            var form = $('#form')[0];
            var nilai = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '<?= $url; ?>verifikator/proses/edit/penyedia',
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
                        className: "bg-danger",
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