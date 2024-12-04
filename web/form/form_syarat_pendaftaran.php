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

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0"><?= str_replace('-', ' ', $_GET['judul']); ?></h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex flex-column h-100">
                                <div class="row h-100">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body p-0">
                                                <div class="row align-items-end">
                                                    <div class="col-sm-12">
                                                        <div class="p-3">
                                                            <form id="form" enctype="multipart/form-data">
                                                                <?php
                                                                $row = $proses->tampil_data_saja('*', 'dokumen_verifikasi', 'id_profil = "' . $_SESSION['kode_profil'] . '"');
                                                                ?>
                                                                <div class="row">
                                                                    <div class="col-xl-12">
                                                                        <?php
                                                                        if (!@$row['file_keikutsertaan']) {
                                                                            $a = 0;
                                                                        ?>
                                                                            <div class="row pt-3">
                                                                                <h6>Formulir Keikutsertaan</h6>
                                                                                <div class="col-xxl-6 col-md-6">
                                                                                    <label for="basiInput" class="form-label">Upload Formulir Keikutsertaan (File Scan ditandatangani diatas materai 10.000 dan dibubuhi cap perusahaan)*</label>
                                                                                </div>
                                                                                <div class="col-xxl-6 col-md-6">
                                                                                    <input type="file" name="fupload1" onchange="validasiFile(this)" class="form-control file" required>
                                                                                    <div id="passwordHelpBlock" class="form-text">
                                                                                        *Accepted formats: pdf, jpg. Max file size 2Mb
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php } else {
                                                                            $a = 1;
                                                                            $act1 = pathinfo(@$row['file_keikutsertaan'], PATHINFO_EXTENSION);
                                                                        ?>
                                                                            <div class="row pt-3">
                                                                                <h6>Formulir Keikutsertaan</h6>
                                                                                <div class="col-xxl-6 col-md-6">
                                                                                    <label for="basiInput" class="form-label">Upload Formulir Keikutsertaan (File Scan ditandatangani diatas materai 10.000 dan dibubuhi cap perusahaan)*</label>
                                                                                </div>
                                                                                <div class="col-xxl-6 col-md-6">
                                                                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act1; ?>" data-id="<?= $row['file_keikutsertaan']; ?>"><i class="ri-search-line"></i> Lihat File</button>
                                                                                    <button type="button" id="del" data-id="file_keikutsertaan" data-nama="File Formulir Keikutsertaan" data-act="del" class="text-danger btn btn-sm btn-light"><i class="ri-delete-bin-line"></i> File</button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php
                                                                        if (!@$row['file_surat_kuasa']) {
                                                                            $b = 0;
                                                                        ?>
                                                                            <div class="row pt-3">
                                                                                <h6>Surat Kuasa</h6>
                                                                                <div class="col-xxl-6 col-md-6">
                                                                                    <label for="basiInput" class="form-label">Upload Surat Kuasa, jika ada! (File Scan ditandatangani diatas materai 10.000 dan dibubuhi cap perusahaan)*</label>
                                                                                </div>
                                                                                <div class="col-xxl-6 col-md-6">
                                                                                    <input type="file" name="fupload2" onchange="validasiFile(this)" class="form-control file">
                                                                                    <div id="passwordHelpBlock" class="form-text">
                                                                                        *Accepted formats: pdf, jpg. Max file size 2Mb
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php } else {
                                                                            $b = 1;
                                                                            $act2 = pathinfo(@$row['file_surat_kuasa'], PATHINFO_EXTENSION);
                                                                        ?>
                                                                            <div class="row pt-3">
                                                                                <h6>Surat Kuasa (jika ada!)</h6>
                                                                                <div class="col-xxl-6 col-md-6">
                                                                                    Upload Surat Kuasa (File Scan ditandatangani diatas materai 10.000 dan dibubuhi cap perusahaan)*
                                                                                </div>
                                                                                <div class="col-xxl-6 col-md-6">
                                                                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act2; ?>" data-id="<?= $row['file_surat_kuasa']; ?>"><i class="ri-search-line"></i> Lihat File</button>
                                                                                    <button type="button" id="del" data-id="file_surat_kuasa" data-nama="File Surat Kuasa" data-act="del" class="text-danger btn btn-sm btn-light"><i class="ri-delete-bin-line"></i> File</button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                        <?php
                                                                        if (!@$row['file_penunjukan_admin']) {
                                                                            $c = 0;
                                                                        ?>
                                                                            <div class="row pt-3">
                                                                                <h6>Surat Penunjukan Admin</h6>
                                                                                <div class="col-xxl-6 col-md-6">
                                                                                    <label for="basiInput" class="form-label">Upload Surat Penunjukan Admin (File Scan ditandatangani dan dibubuhi cap perusahaan)*</label>
                                                                                </div>
                                                                                <div class="col-xxl-6 col-md-6">
                                                                                    <input type="file" name="fupload3" onchange="validasiFile(this)" class="form-control file" required>
                                                                                    <div id="passwordHelpBlock" class="form-text">
                                                                                        *Accepted formats: pdf, jpg. Max file size 2Mb
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php } else {
                                                                            $c = 1;
                                                                            $act3 = pathinfo(@$row['file_penunjukan_admin'], PATHINFO_EXTENSION);
                                                                        ?>
                                                                            <div class="row pt-3">
                                                                                <h6>Surat Penunjukan Admin</h6>
                                                                                <div class="col-xxl-6 col-md-6">
                                                                                    <label for="basiInput" class="form-label">Upload Surat Penunjukan Admin (File Scan ditandatangani dan dibubuhi cap perusahaan)*</label>
                                                                                </div>
                                                                                <div class="col-xxl-6 col-md-6">
                                                                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act3; ?>" data-id="<?= $row['file_penunjukan_admin']; ?>"><i class="ri-search-line"></i> Lihat File</button>
                                                                                    <button type="button" id="del" data-id="file_penunjukan_admin" data-nama="File Surat Penunjukan Admin" data-act="del" class="text-danger btn btn-sm btn-light"><i class="ri-delete-bin-line"></i> File</button>
                                                                                </div>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 pt-5">
                                                                    <div class="text-start">
                                                                        <span class="btn btn-light cursor-pointer" onclick="back()"><i class=" ri-arrow-go-back-line"></i> Kembali</span>
                                                                        <?php if ($a + $b + $c == 3) {
                                                                        } else { ?>
                                                                            <button type="submit" class="btn btn-success" id="simpan"><i class="ri-save-2-fill"></i> Simpan</button>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- end card-body-->
                                        </div>
                                    </div> <!-- end col-->
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end col-->
                    </div> <!-- end row-->
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

    <!-- JAVASCRIPT -->
    <script src="<?= $url; ?>assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?= $url; ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $url; ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= $url; ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= $url; ?>assets/libs/feather-icons/feather.min.js"></script>
    <script src="<?= $url; ?>assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="<?= $url; ?>assets/js/toastify-js.js"></script>

    <!-- App js -->
    <script src="<?= $url; ?>assets/js/app.js"></script>
    <script src="<?= $url; ?>assets/js/ajax.js"></script>
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
        });

        $(document).on('submit', '#form', function(event) {
            event.preventDefault();
            var form = $('#form')[0];
            var nilai = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '<?= $url; ?>proses/dokumen/verifikasi',
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
                        $("#revdiv").load(location.href + " #revdiv");
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

        $(document).on('click', '#del', function(e) {
            var nama = $(e.currentTarget).data('nama');
            var id = $(e.currentTarget).data('id');
            var act = $(e.currentTarget).data('act');
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
                        url: '<?= $url; ?>proses/dokumen/verifikasi',
                        data: {
                            id: id,
                            act: act
                        },
                        success: function(data) {
                            $("#revdiv").load(location.href + " #revdiv");
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