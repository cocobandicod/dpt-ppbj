<?php
require_once('../config/koneksi.php');
require_once('../config/menu.php');
require_once('../config/fungsi_indotgl.php');
require_once('../config/cek_akses.php');
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = md5(uniqid(rand(), TRUE));
}
cek_akses_pengguna($proses, $url, @$_SESSION['kode_user'], @$_SESSION['token']);
$cek = $proses->tampil_data_saja('id_paket,kode_paket', 'paket_pekerjaan', '1=1 AND kode = "' . @$_GET['id'] . '"');
cek_url(
    $url,
    $proses,
    'edit',
    'tender',
    'id_paket ="' . @$cek['id_paket'] . '" 
    AND id_profil ="' . @$_SESSION['kode_profil'] . '"'
);
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
                                <h4 class="card-title mb-0 flex-grow-1">Daftar Paket Pekerjaan Untuk Anda</h4>
                            </div><!-- end card header -->
                            <!-- card body -->
                            <div class="card-body">
                                <?php
                                $today = date('Y-m-d');
                                $s = $proses->tampil_data_saja('*', 'paket_pekerjaan', '1=1 AND id_paket = "' . $cek['id_paket'] . '"');
                                $p = $proses->tampil_data_saja('GROUP_CONCAT(CONCAT("<span class=\"badge bg-success fs-11 mb-1\">", tahap, "</span>") SEPARATOR " ") as pengumuman', 'jadwal', '1=1 AND kode_paket = "' . $s['kode_paket'] . '" AND "' . $today . '" BETWEEN DATE(tgl_mulai) AND DATE(tgl_selesai)');
                                $k = $proses->tampil_data_saja('tgl_mulai,tgl_selesai', ' jadwal', '1=1 AND nomor = "4" AND kode_paket = "' . $cek['kode_paket'] . '"');
                                $t = $proses->tampil_data_saja('status,timestamp', 'status_kirim', '1=1 AND jenis = "Kualifikasi" AND id_paket = "' . $cek['id_paket'] . '" AND id_profil = "' . $_SESSION['kode_profil'] . '"');
                                $n = $proses->cek_count('jadwal', '1=1 AND kode_paket = "' . $cek['kode_paket'] . '" AND nomor = "4" AND "' . $today . '" BETWEEN DATE(tgl_mulai) AND DATE(tgl_selesai)');

                                if ($n == 1) {
                                    $kirim = ' <a href="' . $url . 'daftar-paket/' . @$_GET['id'] . '/kirim-kualifikasi" class="badge bg-success fs-11">Kirim Data</a>';
                                } else {
                                    $kirim = '';
                                }

                                if (empty($t['status'])) {
                                    $status = '<div class="alert alert-warning mb-0" role="alert">
                                    Belum Dikirim, Jadwal Pengiriman: ' . tgl_indo5($k['tgl_mulai']) . ' s/d ' . tgl_indo5($k['tgl_selesai']) . $kirim . '
                                    </div>';
                                    $penawaran = '<div class="alert alert-warning mb-0" role="alert">
                                    Anda wajib mengirimkan Persyaratan Kualifikasi terlebih dahulu
                                    </div>';
                                } else {
                                    $lihat =  ' <a href="#" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="' . $cek['id_paket'] . '" data-act="lihat_data" class="badge bg-success fs-11">Lihat Data</a>';
                                    $status = '<div class="alert alert-warning mb-0" role="alert">
                                    Sudah Dikirim pada tanggal: ' . tgl_indo5($t['timestamp']) . $kirim . $lihat . '
                                    </div>';
                                    $penawaaran = '';
                                }
                                ?>
                                <table class="table table-bordered fs-13">
                                    <tbody>
                                        <tr>
                                            <td style="width: 20%;">Kode Paket</td>
                                            <td><?= @$s['kode_paket']; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%;">Nama Pekerjaan</td>
                                            <td><?= @$s['nama_pekerjaan']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tahapan Saat Ini</td>
                                            <td><span class="cursor-pointer text-primary" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= @$s['kode_paket']; ?>" data-act="jadwal"><?= @$p['pengumuman']; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td>Dokumen Pemilihan</td>
                                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= @$s['kode_paket']; ?>" data-act="dokumen_pemilihan" class="btn btn-sm btn-info ms-2"><i class="ri-search-2-line me-0"></i> Dokumen Pemilihan</a></td>
                                        </tr>
                                        <tr>
                                            <td>Kualifikasi</td>
                                            <td><?= $status; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Penawaran Anda</td>
                                            <td>
                                                <?= @$penawaaran; ?>
                                                <table class="table table-bordered table-sm">
                                                    <tr class="bg-light">
                                                        <td class="p-2" colspan="2">Dokumen Penawaran Administrasi dan Teknis </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 w-25">Surat Penawaran</td>
                                                        <td class="p-2"><span class="badge bg-danger fs-11">Belum Dikirim</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2">Dokumen Teknis</td>
                                                        <td class="p-2"><span class="badge bg-danger fs-11">Belum Dikirim</span></td>
                                                    </tr>
                                                </table>
                                                <table class="table table-bordered table-sm mt-3 mb-0">
                                                    <tr class="bg-light">
                                                        <td class="p-2" colspan="2">Dokumen Penawaran Harga</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 w-25">Dokumen Harga</td>
                                                        <td class="p-2"><span class="badge bg-danger fs-11">Belum Dikirim</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 w-25"><b>Total Penawaran</b></td>
                                                        <td class="p-2">
                                                            <b>Rp.</b>
                                                            <a href="<?= $url; ?>daftar-paket/<?= $_GET['id']; ?>/kirim-penawaran" class="btn btn-sm btn-info float-end"><i class="ri-send-plane-fill"></i> Kirim Penawaran</a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Undangan</td>
                                            <td>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Berita Acara</td>
                                            <td>
                                                <div class="alert alert-warning mb-0" role="alert">
                                                    Berita acara hasil pemilihan dapat di download pada saat Tahapan Pengumuman Pemenang
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Berita Acara Lainnya</td>
                                            <td>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
        <div class="modal-dialog modal-xl">
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
        $(document).ready(function() {
            dataTable = $('#example,#example2').DataTable({
                stateSave: true,
                autoWidth: false,
                processing: true,
                ordering: false,
                responsive: true
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
                        targets: [2]
                    },
                    {
                        className: 'p-2',
                        targets: [0, 1, 2]
                    },
                ],
                "ajax": {
                    url: "<?= $url; ?>tabel/paket/pekerjaan",
                    type: "post"
                }
            });
        });

        $('#DetailModal').on('show.bs.modal', function(e) {
            var act = $(e.relatedTarget).data('act');
            var id = $(e.relatedTarget).data('id');
            var profil = $(e.relatedTarget).data('profil');
            $.ajax({
                type: 'post',
                url: '<?= $url; ?>detail/modal/pengumuman',
                data: {
                    act: act,
                    id: id,
                    profil: profil
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
    </script>
</body>

</html>