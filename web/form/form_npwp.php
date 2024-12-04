<?php
require_once('../../config/koneksi.php');
require_once('../../config/menu.php');
require_once('../../config/fungsi_indotgl.php');
require_once('../../config/cek_akses.php');
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = md5(uniqid(rand(), TRUE));
}
cek_akses_pengguna($proses, $url, @$_SESSION['kode_user'], @$_SESSION['token']);
cek_url($url, $proses, $_GET['act'], 'npwp', 'id_profil ="' . @$_SESSION['kode_profil'] . '" AND id ="' . @$_GET['id'] . '"');
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

    <style>
        .kunci {
            display: none;
            visibility: hidden;
        }
    </style>

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
                        <?= notif($proses, $url); ?>
                        <?= profil($proses, $url); ?>
                    </div>
                </div>
            </div>
        </header>

        <!-- ========== App Menu ========== -->
        <?= menu_penyedia($url); ?>
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
                                        $row = $proses->tampil_data_saja('*', 'npwp', 'id = "' . $_GET['id'] . '"');
                                        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                                        echo '<input type="hidden" name="act" value="edit">';
                                        $text = '<br>*Kosongkan jika tidak merubah file';
                                        $required = '';
                                    } else {
                                        echo '<input type="hidden" name="act" value="add">';
                                        $text = '';
                                        $required = 'required';
                                    }
                                    ?>
                                    <div class="row pt-2">
                                        <div class="col-xl-6">
                                            <div class="col-xxl-12 col-md-12 pt-2">
                                                <label for="basiInput" class="form-label">NPWP *</label>
                                                <input type="text" id="cleave-delimiters" class="form-control" name="npwp" value="<?= @$row['npwp']; ?>" placeholder="xx.xxx.xxx.x-xxx.xxx" required>
                                            </div>
                                            <div class="col-xxl-12 col-md-12 pt-2">
                                                <label for="basiInput" class="form-label">Upload File *</label>
                                                <?php
                                                if (!empty($row['file'])) {
                                                    $act = pathinfo($row['file'], PATHINFO_EXTENSION);
                                                ?>
                                                    <div class="col-12">
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $row['file']; ?>" class="btn btn-success btn-sm mb-2"><i class="ri-search-line align-bottom me-1"></i> Lihat File</a>
                                                    </div>
                                                <?php } else {
                                                } ?>
                                                <input type="file" name="fupload" onchange="return validasiFile()" class="form-control" id="file" value="Upload" <?= $required; ?>>
                                                <div id="passwordHelpBlock" class="form-text">
                                                    *Accepted formats: pdf, jpg. Max file size 2Mb
                                                    <?= $text; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 pt-5">
                                        <div class="text-start">
                                            <span class="btn btn-light cursor-pointer" onclick="back()"><i class=" ri-arrow-go-back-line"></i> Kembali</span>
                                            <button type="submit" class="btn btn-success" id="simpan"><i class="ri-save-2-fill"></i> Simpan</button>
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

    <!-- Default Modals -->
    <div id="modalview" class="modal zoomIn" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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

    <div id="DetailModal" class="modal zoomIn" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="fetched-data"></div>
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
    <script src="<?= $url; ?>assets/js/toastify-js.js"></script>
    <script src="<?= $url; ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- App js -->
    <script src="<?= $url; ?>assets/js/app.js"></script>
    <script src="<?= $url; ?>assets/js/ajax.js"></script>
    <script>
        $(document).ready(function() {
            $('.buka1').addClass('show');
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
        });

        $('.buka1').addClass('show');

        function back() {
            history.go(-1);
        }

        $(document).on('submit', '#form', function(event) {
            event.preventDefault();
            var form = $('#form')[0];
            var nilai = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '<?= $url; ?>proses/npwp',
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

        function validasiFile() {
            var inputFile = document.getElementById('file');
            var pathFile = inputFile.value;
            var ekstensiOk = /(\.jpg|\.jpeg|\.pdf)$/i;
            var file_size = $('#file')[0].files[0].size;
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