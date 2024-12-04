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
                                        <li>Silahkan tambah Persyaratan Kualifikasi untuk melengkapi penawaran peserta tender</li>
                                        <li>Untuk menambahkan Persyaratan Kualifikasi klik tombol Tambah Data</li>
                                    </ol>
                                </div>
                                <div class="align-items-center d-flex mb-3">
                                    <h4 class="card-title mb-0 flex-grow-1">Izin Usaha NIB *</h4>
                                    <div class="flex-shrink-0">
                                        <div class="form-check form-switch form-switch-right form-switch-md">
                                            <button class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $kode_tender; ?>" data-act="form_kbli"><i class="ri-add-circle-line fs-14"></i> Data</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabel_kbli"></div>
                                <div class="align-items-center d-flex mb-3">
                                    <h4 class="card-title mb-0 flex-grow-1">Izin Usaha Lainnya</h4>
                                    <div class="flex-shrink-0">
                                        <div class="form-check form-switch form-switch-right form-switch-md">
                                            <button class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $kode_tender; ?>" data-act="form_izin_lainnya"><i class="ri-add-circle-line fs-14"></i> Data</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabel_izin_lainnya"></div>
                                <div class="align-items-center d-flex mb-3">
                                    <h4 class="card-title mb-0 flex-grow-1">Syarat Administrasi</h4>
                                    <div class="flex-shrink-0">
                                        <div class="form-check form-switch form-switch-right form-switch-md">
                                            <button class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $kode_tender; ?>" data-act="form_syarat_administrasi"><i class="ri-add-circle-line fs-14"></i> Data</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabel_syarat_administrasi"></div>
                                <div class="align-items-center d-flex mb-3">
                                    <h4 class="card-title mb-0 flex-grow-1">Syarat Kualifikasi Teknis</h4>
                                    <div class="flex-shrink-0">
                                        <div class="form-check form-switch form-switch-right form-switch-md">
                                            <button class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $kode_tender; ?>" data-act="form_syarat_administrasi_teknis"><i class="ri-add-circle-line fs-14"></i> Data</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabel_syarat_administrasi_teknis"></div>
                                <div class="align-items-center d-flex mb-3">
                                    <h4 class="card-title mb-0 flex-grow-1">Memiliki SDM Tenaga Ahli (Jika Diperlukan)</h4>
                                    <div class="flex-shrink-0">
                                        <div class="form-check form-switch form-switch-right form-switch-md">
                                            <button class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $kode_tender; ?>" data-act="form_tenaga_ahli"><i class="ri-add-circle-line fs-14"></i> Data</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabel_tenaga_ahli"></div>
                                <div class="align-items-center d-flex mb-3">
                                    <h4 class="card-title mb-0 flex-grow-1">Memiliki SDM Tenaga Teknis/Terampil (Jika Diperlukan)</h4>
                                    <div class="flex-shrink-0">
                                        <div class="form-check form-switch form-switch-right form-switch-md">
                                            <button class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $kode_tender; ?>" data-act="form_tenaga_teknis"><i class="ri-add-circle-line fs-14"></i> Data</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabel_tenaga_teknis"></div>
                                <div class="align-items-center d-flex mb-3">
                                    <h4 class="card-title mb-0 flex-grow-1">Memiliki Kemampuan Untuk Menyediakan Peralatan (Jika Diperlukan)</h4>
                                    <div class="flex-shrink-0">
                                        <div class="form-check form-switch form-switch-right form-switch-md">
                                            <button class="btn btn-soft-primary btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $kode_tender; ?>" data-act="form_peralatan"><i class="ri-add-circle-line fs-14"></i> Data</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabel_peralatan"></div>
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
                    if (judul == 'tabel_kbli') {
                        $('.tabel_kbli').html(data);
                    }
                    if (judul == 'tabel_izin_lainnya') {
                        $('.tabel_izin_lainnya').html(data);
                    }
                    if (judul == 'tabel_syarat_administrasi') {
                        $('.tabel_syarat_administrasi').html(data);
                    }
                    if (judul == 'tabel_syarat_administrasi_teknis') {
                        $('.tabel_syarat_administrasi_teknis').html(data);
                    }
                    if (judul == 'tabel_tenaga_ahli') {
                        $('.tabel_tenaga_ahli').html(data);
                    }
                    if (judul == 'tabel_tenaga_teknis') {
                        $('.tabel_tenaga_teknis').html(data);
                    }
                    if (judul == 'tabel_peralatan') {
                        $('.tabel_peralatan').html(data);
                    }
                },
            });
        };

        $(document).ready(function() {
            detail_upload('tabel_kbli');
            detail_upload('tabel_izin_lainnya');
            detail_upload('tabel_syarat_administrasi');
            detail_upload('tabel_tenaga_ahli');
            detail_upload('tabel_tenaga_teknis');
            detail_upload('tabel_peralatan');
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

        $(document).on('click', '#cari', function(e) {
            var kbli = $('#kbli').val();

            $.ajax({
                type: 'post',
                url: '<?= $url; ?>pokja/form/upload',
                data: {
                    cari: kbli,
                    act: 'cari_kbli'
                },
                beforeSend: function() {
                    document.querySelector('#loading').innerHTML = '<i class="mdi mdi-spin mdi-loading align-middle ms-1"></i> Loading...';
                    $('.kbli-data').html('');
                },
                success: function(response) {
                    if (response.success && response.data) {
                        // Membuat tabel dari data respons
                        var table = '<table class="table table-bordered table-sm"><thead class="table-light"><tr><th class="p-2 text-center w-sm">Kode KBLI</th><th class="p-2">Klasifikasi</th></tr></thead><tbody>';
                        response.data.forEach(function(item) {
                            // Memisahkan kode dan klasifikasi berdasarkan tanda "-"
                            var splitData = item.split(" - ");
                            var kodeKbli = splitData[0].trim();
                            var klasifikasi = splitData[1] ? splitData[1].trim() : '';
                            table += `<tr><td class="p-2 text-center"><a href="#" id="pilih" data-id="<?= $kode_tender; ?>" data-nomor="${kodeKbli}" data-deskripsi="${klasifikasi}">${kodeKbli}</a></td><td class="p-2">${klasifikasi}</td></tr>`;
                        });
                        table += '</tbody></table>';

                        // Menampilkan tabel di dalam elemen .kbli-data
                        $('.kbli-data').html(table);
                    } else {
                        $('.kbli-data').html('<p>Data tidak ditemukan.</p>');
                    }
                },
                error: function() {
                    $('.kbli-data').html('<p>Terjadi kesalahan saat mengambil data.</p>');
                },
                complete: function(data) {
                    document.querySelector('#loading').innerHTML = '';
                }
            });
        });

        $(document).on('click', '#pilih', function(e) {
            var id = $(e.currentTarget).data('id');
            var deskripsi = $(e.currentTarget).data('deskripsi');
            var nomor = $(e.currentTarget).data('nomor');
            $.ajax({
                type: 'post',
                url: '<?= $url; ?>pokja/proses/paket/pekerjaan',
                data: {
                    act: 'kbli',
                    id: id,
                    deskripsi: deskripsi,
                    nomor: nomor
                },
                success: function(data) {
                    detail_upload('tabel_kbli');
                    Toastify({
                        text: "KBLI Berhasil Ditambahkan!",
                        gravity: "top",
                        position: "center",
                        duration: 3000
                    }).showToast();
                },
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
                    detail_upload('tabel_kbli');
                    detail_upload('tabel_izin_lainnya');
                    detail_upload('tabel_syarat_administrasi');
                    detail_upload('tabel_syarat_administrasi_teknis');
                    detail_upload('tabel_tenaga_ahli');
                    detail_upload('tabel_tenaga_teknis');
                    detail_upload('tabel_peralatan');
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
                            detail_upload('tabel_kbli');
                            detail_upload('tabel_izin_lainnya');
                            detail_upload('tabel_syarat_administrasi');
                            detail_upload('tabel_syarat_administrasi_teknis');
                            detail_upload('tabel_tenaga_ahli');
                            detail_upload('tabel_tenaga_teknis');
                            detail_upload('tabel_peralatan');
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