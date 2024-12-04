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
cek_akses($url, $proses, @$_SESSION['token'], 'Pokja');
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
                        <?= profil_operator('pokja', $url); ?>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== App Menu ========== -->
        <?php
        menu_pokja($url);
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
                                <?php
                                // Mendapatkan parameter tahun dan kode_tender
                                $tahun = $_GET['tahun'];
                                $kode_tender = $_GET['rup'];
                                $row = $proses->tampil_data_saja('*', 'paket_pekerjaan', '1=1 AND kode_paket = "' . $kode_tender . '"');
                                ?>
                                <input type="hidden" name="act" value="buat_update">
                                <input type="hidden" name="kode_paket" value="<?= @$kode_tender; ?>">
                                <div class="alert alert-success" role="alert">
                                    <strong>Petunjuk</strong>
                                    <ol type="1" class="ps-3 mb-0">
                                        <li>Silahkan tambah daftar dokumen penawaran yang dipersyaratkan untuk melengkapi penawaran peserta tender</li>
                                        <li>Untuk menambahkan dokumen penawaran klik tombol Tambah Data Administrasi, Teknis, Harga/Biaya</li>
                                    </ol>
                                </div>
                                <div class="align-items-center d-flex mb-3">
                                    <h4 class="card-title mb-0 flex-grow-1">Administrasi</h4>
                                    <div class="flex-shrink-0">
                                        <div class="form-check form-switch form-switch-right form-switch-md">
                                            <button class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $kode_tender; ?>" data-act="form_administrasi"><i class="ri-add-circle-line fs-14"></i> Administrasi</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabel_administrasi"></div>
                                <div class="align-items-center d-flex mb-3">
                                    <h4 class="card-title mb-0 flex-grow-1">Teknis</h4>
                                    <div class="flex-shrink-0">
                                        <div class="form-check form-switch form-switch-right form-switch-md">
                                            <button class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $kode_tender; ?>" data-act="form_teknis"><i class="ri-add-circle-line fs-14"></i> Teknis</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabel_teknis"></div>
                                <div class="align-items-center d-flex mb-3">
                                    <h4 class="card-title mb-0 flex-grow-1">Harga/Biaya</h4>
                                    <div class="flex-shrink-0">
                                        <div class="form-check form-switch form-switch-right form-switch-md">
                                            <button class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $kode_tender; ?>" data-act="form_biaya"><i class="ri-add-circle-line fs-14"></i> Harga/Biaya</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabel_biaya"></div>
                                <div class="mt-5">
                                    <a href="<?= $url; ?>pokja/daftar-paket/<?= $kode_tender; ?>/<?= $tahun; ?>/dokumen-persiapan" class="btn btn-success"><i class="ri-arrow-left-line"></i> Sebelumnya</a>
                                </div>
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
        function detail_upload(judul) {
            $.ajax({
                type: 'post',
                url: '<?= $url; ?>pokja/form/upload',
                data: {
                    id: <?= $kode_tender; ?>,
                    tahun: <?= $tahun; ?>,
                    judul: judul,
                },
                success: function(data) {
                    if (judul == 'tabel_administrasi') {
                        $('.tabel_administrasi').html(data);
                    }
                    if (judul == 'tabel_teknis') {
                        $('.tabel_teknis').html(data);
                    }
                    if (judul == 'tabel_biaya') {
                        $('.tabel_biaya').html(data);
                    }
                },
            });
        };

        $(document).ready(function() {
            detail_upload('tabel_administrasi');
            detail_upload('tabel_teknis');
            detail_upload('tabel_biaya');
        });

        $('#DetailModal').on('show.bs.modal', function(e) {
            var act = $(e.relatedTarget).data('act');
            var id = $(e.relatedTarget).data('id');
            $.ajax({
                type: 'post',
                url: '<?= $url; ?>pokja/form/upload',
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

        $(document).on('submit', '#form', function(event) {
            event.preventDefault();
            var form = $('#form')[0];
            var nilai = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '<?= $url; ?>pokja/proses/paket/pekerjaan',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                data: nilai,
                beforeSend: function() {
                    document.querySelector('#simpan').innerHTML = '<i class="mdi mdi-spin mdi-loading align-middle ms-1"></i> Loading...';
                },
                success: function(data) {
                    Toastify({
                        text: "Data Berhasil Dimasukan!",
                        gravity: "top",
                        position: "center",
                        duration: 3000
                    }).showToast();
                    $('#DetailModal').modal('toggle');
                    detail_upload('tabel_administrasi');
                    detail_upload('tabel_teknis');
                    detail_upload('tabel_biaya');
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
            var del = $(e.currentTarget).data('id');
            var act = $(e.currentTarget).data('act');
            Swal.fire({
                //title: "Data ini akan dihapus?",
                //text: nama,
                //icon: "warning",
                html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon><div class="mt-4 pt-2 fs-15 mx-5"><h4>Data ini akan dihapus?</h4><p class="text-muted mx-4 mb-0">' + nama + '</p></div></div>',
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
                        url: '<?= $url; ?>pokja/proses/paket/pekerjaan',
                        data: {
                            del: del,
                            act: act
                        },
                        success: function(data) {
                            detail_upload('tabel_administrasi');
                            detail_upload('tabel_teknis');
                            detail_upload('tabel_biaya');
                            Toastify({
                                text: "Data Berhasil Dihapus!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            Toastify({
                                text: "Data Gagal Dihapus!",
                                className: "bg-danger",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                        },
                    });
                }
            });
        });
    </script>
</body>

</html>