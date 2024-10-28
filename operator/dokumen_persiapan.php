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
                                <?php
                                // Mendapatkan parameter tahun dan kode_tender
                                $tahun = $_GET['tahun'];
                                $kode_tender = $_GET['rup'];
                                ?>
                                <input type="hidden" name="act" value="buat_update">
                                <input type="hidden" name="kode_paket" value="<?= @$kode_tender; ?>">
                                <table class="table table-bordered">
                                    <tr>
                                        <td class="w-25">Nilai HPS</td>
                                        <td>
                                            <div class="upload_hps"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dokumen Persiapan Pengadaan</td>
                                        <td>
                                            <div class="dokumen_persiapan"></div>
                                        </td>
                                    </tr>
                                </table>
                                <a href="<?= $url; ?>operator/buat-paket/<?= $kode_tender; ?>/<?= $tahun; ?>" class="btn btn-primary"><i class="ri-arrow-left-line"></i> Sebelumnya</a>
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
        function detail_upload(judul) {
            $.ajax({
                type: 'post',
                url: '<?= $url; ?>operator/form/upload',
                data: {
                    id: <?= $kode_tender; ?>,
                    judul: judul,
                },
                success: function(data) {
                    if (judul == 'upload_hps') {
                        $('.upload_hps').html(data);
                    }
                    if (judul == 'dokumen_persiapan') {
                        $('.dokumen_persiapan').html(data);
                    }
                },
            });
        };

        $('#DetailModal').on('show.bs.modal', function(e) {
            var act = $(e.relatedTarget).data('act');
            var id = $(e.relatedTarget).data('id');
            $.ajax({
                type: 'post',
                url: '<?= $url; ?>operator/form/upload',
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
                url: '<?= $url; ?>operator/proses/paket/pekerjaan',
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
                    detail_upload('upload_hps');
                    detail_upload('dokumen_persiapan');
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

        $(document).on('click', '#del', function(e) {
            var nama = $(e.currentTarget).data('nama');
            var del = $(e.currentTarget).data('id');
            var act = $(e.currentTarget).data('act');
            Swal.fire({
                title: "Data ini akan dihapus?",
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
                        url: '<?= $url; ?>operator/proses/paket/pekerjaan',
                        data: {
                            del: del,
                            act: act
                        },
                        success: function(data) {
                            $('#DetailModal').modal('toggle');
                            detail_upload('upload_hps');
                            detail_upload('dokumen_persiapan');
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


        $(document).ready(function() {
            detail_upload('upload_hps');
            detail_upload('dokumen_persiapan');
        });

        function formatRupiah(angka, prefix = '') {
            var number_string = angka.replace(/[^,\d]/g, '').toString(), // Hanya biarkan angka dan koma
                split = number_string.split(','), // Pisahkan angka dengan koma sebagai pemisah desimal
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // Tambahkan titik jika input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            // Gabungkan dengan bagian desimal (jika ada)
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix + rupiah;
        }
    </script>

</body>

</html>