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
cek_akses($url, $proses, @$_SESSION['token'], 'UKPBJ');
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
                                <?php
                                // Mendapatkan parameter tahun dan kode_tender
                                $tahun = $_GET['tahun'];
                                $kode_tender = $_GET['rup'];
                                ?>
                                <input type="hidden" name="act" value="buat_update">
                                <input type="hidden" name="kode_paket" value="<?= @$kode_tender; ?>">
                                <table class="table table-bordered fs-13">
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
                                    <tr>
                                        <td>UKPBJ</td>
                                        <td>
                                            <table class="table table-sm fs-13 mb-0">
                                                <thead>
                                                    <tr class="table-light">
                                                        <th class="p-2">Nama Kepala UKPBJ</th>
                                                        <th class="p-2">Tanggal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $row = $proses->tampil_data_saja(
                                                        'a.id,a.timestamp,b.nama',
                                                        'penugasan a LEFT JOIN operator b 
                                                        ON a.id_operator = b.id_operator',
                                                        '1=1 AND a.kode_paket = "' . $kode_tender . '" AND a.status = "UKPBJ"'
                                                    );
                                                    ?>
                                                    <tr>
                                                        <td class="p-2"><?= @$row['nama']; ?></td>
                                                        <td class="p-2"><?= tgl_indo(@$row['timestamp']); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nota Dinas PPK</td>
                                        <td>
                                            <?php
                                            $cek = $proses->tampil_data_saja('*', 'undangan_ukpbj', '1=1 AND kode_paket = "' . $kode_tender . '" ORDER BY timestamp DESC');
                                            if (empty($cek['id'])) {
                                                echo 'Tidak ada Nota Dinas';
                                            } else {
                                                $file = '<a href="' . $url . 'berkas/' . $cek['file'] . '" class="btn btn-info btn-sm mb-0" target="_blank"><i class="ri-file-download-line"></i> Nota Dinas PPK</a>';
                                                echo '
                                                <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                                                    Dikirim Tanggal ' . tgl_indo7($cek['timestamp']) . '
                                                    ' . $file . '
                                                </div>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status Peket</td>
                                        <td>
                                            <div class="status_paket"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pokja Pemilihan</td>
                                        <td>
                                            <div class="pokja"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kirim Pemberitahuan ke POKJA</td>
                                        <td>
                                            <div class="kirim_pokja"></div>
                                        </td>
                                    </tr>
                                </table>
                                <a href="<?= $url; ?>ukpbj/daftar-paket/<?= $kode_tender; ?>/<?= $tahun; ?>" class="btn btn-success"><i class="ri-arrow-left-line"></i> Sebelumnya</a>
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
                url: '<?= $url; ?>ukpbj/form/upload',
                data: {
                    id: <?= $kode_tender; ?>,
                    judul: judul,
                    tahun: <?= $tahun; ?>
                },
                success: function(data) {
                    if (judul == 'upload_hps') {
                        $('.upload_hps').html(data);
                    }
                    if (judul == 'dokumen_persiapan') {
                        $('.dokumen_persiapan').html(data);
                    }
                    if (judul == 'pokja') {
                        $('.pokja').html(data);
                    }
                    if (judul == 'kirim_pokja') {
                        $('.kirim_pokja').html(data);
                    }
                    if (judul == 'status_paket') {
                        $('.status_paket').html(data);
                    }
                },
            });
        };

        $('#DetailModal').on('show.bs.modal', function(e) {
            var act = $(e.relatedTarget).data('act');
            var id = $(e.relatedTarget).data('id');
            $.ajax({
                type: 'post',
                url: '<?= $url; ?>ukpbj/form/upload',
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
                url: '<?= $url; ?>ukpbj/proses/paket/pekerjaan',
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

        $(document).on('submit', '#kirim_email', function(event) {
            event.preventDefault();
            Swal.fire({
                title: "Apakah anda yakin akan kirim pemberitahuan ini?",
                text: '',
                icon: "info",
                showCancelButton: !0,
                confirmButtonClass: "btn btn-danger w-xs me-2 mt-2",
                cancelButtonClass: "btn btn-primary w-xs mt-2",
                confirmButtonText: "Kirim!",
                cancelButtonText: "Batal!",
                buttonsStyling: !1,
                showCloseButton: !0
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#kirim_email')[0];
                    var nilai = new FormData(form);
                    $.ajax({
                        type: 'POST',
                        url: '<?= $url; ?>ukpbj/proses/paket/pekerjaan',
                        enctype: 'multipart/form-data',
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: nilai,
                        beforeSend: function() {
                            document.querySelector('#simpan').innerHTML = '<i class="mdi mdi-spin mdi-loading align-middle ms-1"></i> Sedang Mengirim Email...';
                        },
                        success: function(data) {
                            Toastify({
                                text: "Email Berhasil Dikirim!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                            $('#DetailModal').modal('toggle');
                            detail_upload('kirim_pokja');
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            Toastify({
                                text: "Email Gagal Dikirim!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                        },
                        complete: function(data) {
                            document.querySelector('#simpan').innerHTML = '<i class="ri-mail-send-line ms-1"></i> Kirim';
                        }
                    });
                }
            });
        });

        $(document).ready(function() {
            detail_upload('upload_hps');
            detail_upload('dokumen_persiapan');
            detail_upload('pokja');
            detail_upload('kirim_pokja');
            detail_upload('status_paket');
        });

        $(document).on('click', '.status', function(e) {
            var sts = $(e.currentTarget).data('sts');
            var id = $(e.currentTarget).data('id');
            var nama = $(e.currentTarget).data('nama');
            Swal.fire({
                title: "Apakah Status Paket ini!",
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
                        url: '<?= $url; ?>ukpbj/proses/paket/pekerjaan',
                        data: {
                            id: id,
                            sts: sts,
                            act: 'status_paket'
                        },
                        success: function(data) {
                            Toastify({
                                text: "Status Berhasil Dibuat!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                            detail_upload('status_paket');
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            Toastify({
                                text: "Status Gagal Dibuat!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                        },
                    });
                }
            });
        });

        $(document).on('click', '#terapkan', function(e) {
            var nama = $(e.currentTarget).data('nama');
            var id = $(e.currentTarget).data('id');
            var operator = $(e.currentTarget).data('operator');
            Swal.fire({
                title: "Anda akan memilih POKJA ini?",
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
                        url: '<?= $url; ?>ukpbj/proses/paket/pekerjaan',
                        data: {
                            id: id,
                            nama: nama,
                            operator: operator,
                            act: 'pilih_pokja'
                        },
                        success: function(data) {
                            Toastify({
                                text: "Paket Berhasil Dibuat!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                            $('#DetailModal').modal('toggle');
                            detail_upload('pokja');
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

        $(document).on('click', '#hapus_pokja', function(e) {
            var id = $(e.currentTarget).data('id');
            var nama = $(e.currentTarget).data('nama');
            Swal.fire({
                title: "Anda akan membatalkan Pokja ini?",
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
                        url: '<?= $url; ?>ukpbj/proses/paket/pekerjaan',
                        data: {
                            id: id,
                            act: 'hapus_pokja'
                        },
                        success: function(data) {
                            Toastify({
                                text: "UKPBJ Berhasil Dibatalkan!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                            detail_upload('pokja');
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
    </script>
</body>

</html>