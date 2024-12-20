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
cek_url($url, $proses, 'edit', 'paket_pekerjaan', 'id_paket ="' . @$_GET['id'] . '"');
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
                        <?= profil_operator($proses, $url); ?>
                    </div>
                </div>
            </div>
        </header>

        <!-- ========== App Menu ========== -->
        <?php
        if ($_SESSION['level'] == 'PPK') {
            menu_ppk($url);
        } else if ($_SESSION['level'] == 'Pokja') {
            menu_pokja($url);
        } else {
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

                        <div class="row h-100">
                            <div class="card">
                                <div class="p-3">
                                    <?php
                                    $s = $proses->tampil_data_saja('*', 'paket_pekerjaan', '1=1 AND id_paket = "' . $_GET['id'] . '"');
                                    ?>
                                    <div class="col-sm-12">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>Nama Pekerjaan</td>
                                                    <td><?= $s['nama_pekerjaan']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Lokasi Pekerjaan</td>
                                                    <td><?= $s['lokasi_pekerjaan']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Sumber Dana</td>
                                                    <td><?= $s['sumber_dana']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tahun Anggaran</td>
                                                    <td><?= $s['tahun_anggaran']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Nilai HPS</td>
                                                    <td>Rp. <?= number_format($s['nilai_hps']); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <span class="btn btn-primary btn-label waves-effect waves-light btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $_GET['id']; ?>" data-act="add"><i class="ri-add-circle-line label-icon align-middle fs-16 me-2"></i> Penyedia</span>
                                        <table id="DTable" class="table table-bordered dt-responsive table-striped align-middle fs-13" style="width:100%">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Badan Usaha</th>
                                                    <th>Nama Penyedia</th>
                                                    <th>Alamat</th>
                                                    <th>Telepon</th>
                                                    <th>Undangan</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row-->

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
    <script src="<?= $url; ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- ckeditor -->
    <script src="<?= $url; ?>assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>

    <!--datatable js-->
    <script src="<?= $url; ?>assets/css/datatables/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="<?= $url; ?>assets/css/datatables/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?= $url; ?>assets/css/datatables/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="<?= $url; ?>assets/css/datatables/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="<?= $url; ?>assets/js/toastify-js.js"></script>
    <script src="<?= $url; ?>assets/js/ajax.js"></script>

    <script>
        $('#DetailModal').on('show.bs.modal', function(e) {
            var act = $(e.relatedTarget).data('act');
            var id = $(e.relatedTarget).data('id');
            $.ajax({
                type: 'post',
                url: '<?= $url; ?>operator/form/dpt',
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

        var dataTable
        $(document).ready(function() {
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
                        className: 'text-center p-2',
                        width: '3%',
                        targets: [5, 6]
                    },
                    {
                        className: 'p-2',
                        targets: [0, 1, 2, 3, 4, 5, 6]
                    },
                ],
                "ajax": {
                    url: "<?= $url; ?>operator/tabel/detail/dpt",
                    type: "post",
                    data: {
                        id: <?= $_GET['id']; ?>
                    }
                }
            });
        });

        $(document).on('submit', '#form', function(event) {
            event.preventDefault();
            var form = $('#form')[0];
            var data1 = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '<?= $url ?>operator/proses/dpt',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                data: data1,
                success: function(data) {
                    if (data == 'error') {
                        alert('Penyedia Sudah Tersedia');
                    } else {
                        $('#DetailModal').modal('toggle');
                        dataTable.ajax.reload(null, false);
                        Toastify({
                            text: "Data Berhasil Disimpan!",
                            gravity: "top",
                            position: "center",
                            duration: 3000
                        }).showToast();
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#DetailModal').modal('toggle');
                    Toastify({
                        text: "Data Gagal Disimpan!",
                        gravity: "top",
                        position: "center",
                        duration: 3000
                    }).showToast();
                },
            });
        });

        $(document).on('submit', '#undangan', function(event) {
            event.preventDefault();
            var form = $('#undangan')[0];
            var data1 = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '<?= $url ?>operator/proses/dpt',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                data: data1,
                beforeSend: function() {
                    document.querySelector('#kirim').innerHTML =
                        '<i class="mdi mdi-spin mdi-loading align-middle ms-1"></i> Loading...';
                },
                success: function(data) {
                    $('#DetailModal').modal('toggle');
                    dataTable.ajax.reload(null, false);
                    Toastify({
                        text: "Undangan Berhasil Dikirim!",
                        gravity: "top",
                        position: "center",
                        duration: 3000
                    }).showToast();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#DetailModal').modal('toggle');
                    Toastify({
                        text: "Undangan Gagal Dikirim!",
                        gravity: "top",
                        position: "center",
                        duration: 3000
                    }).showToast();
                },
                complete: function(data) {
                    document.querySelector('#kirim').innerHTML = 'Kirim';
                },
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
                        url: '<?= $url; ?>operator/proses/dpt',
                        data: {
                            del: del,
                            act: act
                        },
                        success: function(data) {
                            dataTable.ajax.reload(null, false);
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
    </script>
</body>

</html>