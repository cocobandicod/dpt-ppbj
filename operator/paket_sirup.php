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
                            </div>
                            <div class="card-body">
                                <div class="col-lg-3 col-md-3 col-xl-2 mb-3">
                                    <?= pilih_tahun('pilih_tahun', date('Y')); ?>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="DTable" class="table table-bordered dt-responsive table-striped align-middle fs-13" style="width:100%">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode RUP</th>
                                                    <th>Nama Paket</th>
                                                    <th>Satuan Kerja</th>
                                                    <th>Pagu</th>
                                                    <th>HPS</th>
                                                    <th>TA</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                        </table>
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

    <!-- Basic modal -->
    <div id="DetailModal" class="modal fade" tabindex="-1">
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
    <script src="<?= $url; ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!--datatable js-->
    <script src="<?= $url; ?>assets/css/datatables/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="<?= $url; ?>assets/css/datatables/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?= $url; ?>assets/css/datatables/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="<?= $url; ?>assets/css/datatables/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="<?= $url; ?>assets/js/toastify-js.js"></script>
    <script src="<?= $url; ?>assets/js/ajax.js"></script>

    <script src="<?= $url; ?>assets/js/app.js"></script>

    <script>
        var dataTable;
        $(document).ready(function() {
            // Mengambil nilai awal tahun
            var tahun = $('#pilih_tahun').val();

            // Inisialisasi DataTable dengan parameter tahun
            dataTable = $('#DTable').DataTable({
                stateSave: true,
                autoWidth: false,
                processing: true,
                ordering: false,
                responsive: true,
                columnDefs: [{
                        className: 'text-center p-2',
                        width: '3%',
                        targets: [0]
                    },
                    {
                        className: 'text-end p-2',
                        width: '5%',
                        targets: [4, 5]
                    },
                    {
                        className: 'text-center p-2',
                        width: '5%',
                        targets: [6, 7]
                    },
                    {
                        className: 'p-2',
                        targets: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                ],
                "ajax": {
                    url: "tabel/paket/sirup",
                    type: "post",
                    data: function(d) {
                        d.tahun = $('#pilih_tahun').val(); // Mengirim data tahun terbaru
                    }
                }
            });

            // Event listener untuk mengganti tahun
            $(document).on('change', '#pilih_tahun', function(e) {
                dataTable.ajax.reload(null, false); // Memuat ulang data dengan tahun baru
            });

            $(document).on('click', '#buatpaket', function(e) {
                var nama = $(e.currentTarget).data('nama');
                var kode = $(e.currentTarget).data('kode');
                var lokasi = $(e.currentTarget).data('lokasi');
                Swal.fire({
                    title: "Anda akan membuat paket ini?",
                    text: nama,
                    icon: "info",
                    showCancelButton: !0,
                    confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                    cancelButtonClass: "btn btn-danger w-xs mt-2",
                    confirmButtonText: "Ya!",
                    cancelButtonText: "Tidak!",
                    buttonsStyling: !1,
                    showCloseButton: !0
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'post',
                            url: '<?= $url; ?>operator/proses/paket/pekerjaan',
                            data: {
                                kode: kode,
                                nama: nama,
                                lokasi: lokasi,
                                act: 'buat'
                            },
                            success: function(data) {
                                Toastify({
                                    text: "Paket Berhasil Dibuat!",
                                    gravity: "top",
                                    position: "center",
                                    duration: 3000
                                }).showToast();
                                setTimeout(() => {
                                    window.location.href = '<?= $url; ?>operator/buat-paket/' + kode + '/' + tahun;
                                }, 3000);
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                Toastify({
                                    text: "Paket Gagal Dibuat!",
                                    gravity: "top",
                                    position: "center",
                                    duration: 3000
                                }).showToast();
                            },
                        });
                    }
                });
            });


        });
    </script>

</body>

</html>