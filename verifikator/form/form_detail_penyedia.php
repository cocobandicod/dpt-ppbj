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
cek_url($url, $proses, 'edit', 'profil_badan_usaha', 'id_profil ="' . @$_GET['id'] . '"');
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
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="tabel_penyedia"></div>
                                            <div class="accordion" id="default-accordion-example">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header bg-success-subtle" id="head1">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#open1" aria-expanded="false" aria-controls="open1">
                                                            Detail Penyedia
                                                        </button>
                                                    </h2>
                                                    <div id="open1" class="accordion-collapse collapse" aria-labelledby="head1" data-bs-parent="#default-accordion-example">
                                                        <div class="accordion-body text-black">
                                                            <div class="tampil_detail_penyedia"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header bg-success-subtle" id="head3">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#open3" aria-expanded="false" aria-controls="open3">
                                                            Syarat Pendaftaran
                                                        </button>
                                                    </h2>
                                                    <div id="open3" class="accordion-collapse collapse" aria-labelledby="head3" data-bs-parent="#default-accordion-example">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-xl-12 text-black">
                                                                    <h5>Izin Usaha</h5>
                                                                    <div class="tabel_izin_usaha"></div>
                                                                    <h5 class="mt-4">NPWP</h5>
                                                                    <div class="tabel_npwp"></div>
                                                                    <h5 class="mt-4">Sertifikat Standard</h5>
                                                                    <div class="tabel_sertifikat"></div>
                                                                    <h5 class="mt-4">Akta</h5>
                                                                    <div class="tabel_akta"></div>
                                                                    <h5 class="mt-4">Pengurus</h5>
                                                                    <div class="tabel_pengurus"></div>
                                                                    <h5 class="mt-4">Pemilik Saham</h5>
                                                                    <div class="tabel_pemilik_saham"></div>
                                                                    <h5 class="mt-4">KSWP</h5>
                                                                    <div class="tabel_kswp"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header bg-success-subtle" id="head4">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#open4" aria-expanded="false" aria-controls="open4">
                                                            Syarat Pendaftaran Lainnya
                                                        </button>
                                                    </h2>
                                                    <div id="open4" class="accordion-collapse collapse" aria-labelledby="head4" data-bs-parent="#default-accordion-example">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-xl-12 text-black">
                                                                    <h5>Pengalaman Pekerjaan</h5>
                                                                    <div class="tabel_pengalaman"></div>
                                                                    <h5 class="mt-4">Pekerjaan Sedang Dilaksanakan</h5>
                                                                    <div class="tabel_pekerjaan_dilaksanakan"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

    <!-- Default Modals -->
    <div id="modalproses" class="modal zoomIn zoomIn" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div id="modal_proses"></div>
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

            $('#modalproses').on('show.bs.modal', function(e) {
                var act = $(e.relatedTarget).data('act');
                var id = $(e.relatedTarget).data('id');
                var db = $(e.relatedTarget).data('db');
                var text = $(e.relatedTarget).data('text');
                var action = $(e.relatedTarget).data('action');
                var id_profil = $(e.relatedTarget).data('profil');
                $.ajax({
                    type: 'post',
                    url: '<?= $url; ?>verifikator/form/modal',
                    data: {
                        act: 'modal_proses',
                        db: db,
                        text: text,
                        action: action,
                        profil: id_profil,
                        id: id
                    },
                    success: function(data) {
                        $('#modal_proses').html(data);
                    },
                });
                /*
                var id = $(e.relatedTarget).data('id');
                var text = $(e.relatedTarget).data('text');
                var db = $(e.relatedTarget).data('db');
                var status = $(e.relatedTarget).data('status');
                var catatan = $(e.relatedTarget).data('catatan');
                var action = $(e.relatedTarget).data('action');
                $('#myModalproses').text(text);
                $('#status_ver').val(status);
                $('#catatan').val(catatan);
                $('#id').val(id);
                $('#db').val(db);
                $('#act').val(action);
                */
            });

            detail_tabel('koppenyedia');
            detail_tabel('izin_usaha');
            detail_tabel('sertifikat');
            detail_tabel('akta');
            detail_tabel('pengurus');
            detail_tabel('pemilik_saham');
            detail_tabel('npwp');
            detail_tabel('pengalaman');
            detail_tabel('pekerjaan_dilaksanakan');
            detail_tabel('penyedia');
            detail_tabel('kswp');

            /*
            detail_tabel('pajak');
            detail_tabel('tenaga_ahli');
            detail_tabel('peralatan');
            detail_tabel('nib');
            detail_tabel('sbu');
            detail_tabel('domisili');
            detail_tabel('teknis');
            detail_tabel('biaya');
            */
        });

        function detail_tabel(judul) {
            $.ajax({
                type: 'post',
                url: '<?= $url; ?>verifikator/tabel/detail/penyedia',
                data: {
                    judul: judul,
                    id: <?= $_GET['id']; ?>
                },
                success: function(data) {

                    if (judul == 'izin_usaha') {
                        $('.tabel_izin_usaha').html(data);
                    }
                    /*
                    if (judul == 'domisili') {
                        $('.tabel_domisili').html(data);
                    }
                    */
                    if (judul == 'sertifikat') {
                        $('.tabel_sertifikat').html(data);
                    }
                    if (judul == 'akta') {
                        $('.tabel_akta').html(data);
                    }
                    if (judul == 'pengurus') {
                        $('.tabel_pengurus').html(data);
                    }
                    if (judul == 'pemilik_saham') {
                        $('.tabel_pemilik_saham').html(data);
                    }
                    /*
                    if (judul == 'pajak') {
                        $('.tabel_pajak').html(data);
                    }
                    */
                    if (judul == 'npwp') {
                        $('.tabel_npwp').html(data);
                    }
                    /*
                    if (judul == 'tenaga_ahli') {
                        $('.tabel_tenaga_ahli').html(data);
                    }
                    if (judul == 'peralatan') {
                        $('.tabel_peralatan').html(data);
                    }
                    */
                    if (judul == 'pengalaman') {
                        $('.tabel_pengalaman').html(data);
                    }

                    if (judul == 'penyedia') {
                        $('.tampil_detail_penyedia').html(data);
                    }

                    if (judul == 'koppenyedia') {
                        $('.tabel_penyedia').html(data);
                    }

                    if (judul == 'pekerjaan_dilaksanakan') {
                        $('.tabel_pekerjaan_dilaksanakan').html(data);
                    }

                    /*     
                    if (judul == 'sbu') {
                        $('.tabel_sbu').html(data);
                    }
                    */
                    if (judul == 'kswp') {
                        $('.tabel_kswp').html(data);
                    }
                    /*
                    if (judul == 'teknis') {
                        $('.tabel_teknis').html(data);
                    }
                    if (judul == 'biaya') {
                        $('.tabel_biaya').html(data);
                    }
                    */
                },
            });
        };

        $(document).on('submit', '#form', function(event) {
            event.preventDefault();
            var judul = $('#db').val();
            var form = $('#form')[0];
            var nilai = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '<?= $url; ?>verifikator/proses/verifikasi',
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
                        $('#modalproses').modal('hide');
                        if (judul == 'izin_usaha') {
                            detail_tabel('izin_usaha');
                        } else if (judul == 'sertifikat') {
                            detail_tabel('sertifikat');
                        } else if (judul == 'akta') {
                            detail_tabel('akta');
                        } else if (judul == 'pengurus') {
                            detail_tabel('pengurus');
                        } else if (judul == 'pemilik_saham') {
                            detail_tabel('pemilik_saham');
                        } else if (judul == 'npwp') {
                            detail_tabel('npwp');
                        } else if (judul == 'kswp') {
                            detail_tabel('kswp');
                        }
                        detail_tabel('koppenyedia');
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

        $(document).on('click', '#verifikasiemail', function(e) {
            var nama = $(e.currentTarget).data('nama');
            var id = $(e.currentTarget).data('id');
            var ok = $(e.currentTarget).data('ok');
            Swal.fire({
                html: '<div class="mt-3"><div class="avatar-lg mx-auto"><div class="avatar-title bg-light text-success display-5 rounded-circle"><i class="ri-mail-send-fill"></i></div></div><div class="mt-4 pt-2 fs-15"><h4 class="fs-20 fw-semibold">Verifikasi Penyedia</h4><p class="text-muted mb-0 mt-3 fs-13">Status verifikasi akan dikirimkan ke email <span class="fw-medium text-dark">' + nama + '</span>, <br/> Penyedia ini akan resmi terverifikasi.</p></div></div>',
                showCancelButton: !0,
                confirmButtonClass: "btn btn-success w-xs me-2 mt-2",
                cancelButtonClass: "btn btn-danger w-xs mt-2",
                confirmButtonText: "Verifikasi!",
                cancelButtonText: "Batal!",
                buttonsStyling: !1,
                showCloseButton: !0
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'post',
                        url: '<?= $url; ?>verifikator/proses/terverifikasi',
                        data: {
                            id: id,
                            ok: ok,
                            act: 'ver'
                        },
                        beforeSend: function() {
                            document.querySelector('#verifikasiemail').innerHTML = '<i class="mdi mdi-spin mdi-loading label-icon align-middle fs-16 me-2"></i> Menunggu Sedang Proses Verifikasi...';
                        },
                        success: function(data) {
                            //$(".revdiv").load(location.href + " .revdiv");
                            Toastify({
                                text: "Data Berhasil Diverifikasi!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                            detail_tabel('koppenyedia');
                        },
                    });
                }
            });
        });

        $(document).on('click', '#verifikasi', function(e) {
            var nama = $(e.currentTarget).data('nama');
            var id = $(e.currentTarget).data('id');
            var ok = $(e.currentTarget).data('ok');
            Swal.fire({
                html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>Verifikasi Penyedia!</h4><p class="text-muted mx-4 mb-0">' + nama + '</p></div></div>',
                //title: "Verifikasi Penyedia?",
                //text: nama,
                //icon: "question",
                showCancelButton: !0,
                confirmButtonClass: "btn btn-success w-xs me-2 mt-2",
                cancelButtonClass: "btn btn-danger w-xs mt-2",
                confirmButtonText: "Verifikasi!",
                cancelButtonText: "Batal!",
                buttonsStyling: !1,
                showCloseButton: !0
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'post',
                        url: '<?= $url; ?>verifikator/proses/terverifikasi',
                        data: {
                            id: id,
                            ok: ok,
                            act: 'ver'
                        },
                        success: function(data) {
                            //$(".revdiv").load(location.href + " .revdiv");
                            Toastify({
                                text: "Data Berhasil Diverifikasi!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                            detail_tabel('koppenyedia');
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