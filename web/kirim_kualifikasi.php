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
$cek = $proses->tampil_data_saja('id_paket', 'paket_pekerjaan', '1=1 AND kode = "' . @$_GET['id'] . '"');
$s = $proses->tampil_data_saja('*', 'paket_pekerjaan', '1=1 AND id_paket = "' . $cek['id_paket'] . '"');
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
                                            <td>Rp. <?= number_format($s['nilai_hps'], 2, ',', '.'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <ul class="nav nav-pills nav-success mb-3" role="tablist">
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#menu-1" role="tab">Izin Usaha</a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#menu-2" role="tab">Sertifikat Standard</a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#menu-3" role="tab">Akta</a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#menu-4" role="tab">Pengurus</a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#menu-5" role="tab">Pengalaman</a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#menu-6" role="tab">Pekerjaan Sedang Berjalan</a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link" data-bs-toggle="tab" href="#menu-8" role="tab">KSWP</a>
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <form id="form">
                                    <input type="hidden" name="id_paket" value="<?= @$cek['id_paket']; ?>">
                                    <input type="hidden" name="id_profil" value="<?= @$_SESSION['kode_user']; ?>">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="menu-1" role="tabpanel">
                                            <input type="hidden" name="act1" value="izin">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm small tabel1">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="text-center p-2" style="width: 3%;">Check</th>
                                                            <th class="p-2">Jenis Izin</th>
                                                            <th class="p-2">Nomor</th>
                                                            <th class="p-2">Tanggal</th>
                                                            <th class="p-2">Berlaku</th>
                                                            <th class="p-2">Kualifikasi</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql1 = $proses->tampil_data_join2('a.*,b.nama', 'izin_usaha', 'operator', 'id_operator', 'a.id_profil = ' . @$_SESSION['kode_user'] . '');
                                                        foreach ($sql1 as $a) {
                                                            if ($a['status'] == 'Pending') {
                                                                $status = '<span class="badge text-bg-danger">Pending</span>';
                                                            } else if ($a['status'] == 'Waiting') {
                                                                $status = '<span class="badge text-bg-warning">Waiting</span>';
                                                            } else {
                                                                $status = '<span class="badge text-bg-success">Verified</span>';
                                                            }
                                                        ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check text-center p-2">
                                                                        <input class="form-check-input" type="checkbox" name="izin[]" value="<?= $a['id']; ?>">
                                                                    </div>
                                                                </td>
                                                                <td class="p-2"><?= str_replace('-', ' ', $a['jenis_izin']); ?></td>
                                                                <td class="p-2"><?= $a['nomor']; ?></td>
                                                                <td class="p-2"><?= tgl_indo($a['tanggal']); ?></td>
                                                                <td class="p-2">
                                                                    <?= sisa_waktu($a['masa_berlaku']); ?>
                                                                </td>
                                                                <td class="p-2"><?= str_replace('-', ' ', $a['grade']); ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="menu-2" role="tabpanel">
                                            <input type="hidden" name="act2" value="sertifikat">
                                            <div class="table-responsive">
                                                <table class="table table-bordered small table-sm tabel2">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="text-center p-2" style="width: 3%;">Check</th>
                                                            <th class="p-2">Nama Sertifikat</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql3 = $proses->tampil_data_join2('a.*,b.nama', 'sertifikat', 'operator', 'id_operator', 'a.id_profil = ' . @$_SESSION['kode_user'] . '');
                                                        foreach ($sql3 as $c) {
                                                        ?>
                                                            <tr>
                                                                <td class="p-2">
                                                                    <div class="form-check text-center">
                                                                        <input class="form-check-input" type="checkbox" name="sertifikat[]" value="<?= $c['id']; ?>">
                                                                    </div>
                                                                </td>
                                                                <td class="p-2"><?= $c['nama_sertifikat']; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="menu-3" role="tabpanel">
                                            <input type="hidden" name="act3" value="akta">
                                            <div class="table-responsive">
                                                <table class="table table-bordered small table-sm tabel3">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="text-center p-2" style="width: 3%;">Check</th>
                                                            <th class="p-2">Jenis</th>
                                                            <th class="p-2">Nomor</th>
                                                            <th class="p-2">Tanggal</th>
                                                            <th class="p-2">Nama Notaris</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql4 = $proses->tampil_data_join2('a.*,b.nama', 'akta', 'operator', 'id_operator', 'a.id_profil = ' . @$_SESSION['kode_user'] . '');
                                                        foreach ($sql4 as $d) {
                                                        ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check text-center p-2">
                                                                        <input class="form-check-input" type="checkbox" name="akta[]" value="<?= $d['id']; ?>">
                                                                    </div>
                                                                </td>
                                                                <td class="p-2"><?= str_replace('-', ' ', $d['jenis']); ?></td>
                                                                <td class="p-2"><?= $d['nomor']; ?></td>
                                                                <td class="p-2"><?= tgl_indo($d['tanggal']); ?></td>
                                                                <td class="p-2"><?= $d['nama_notaris']; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="menu-4" role="tabpanel">
                                            <input type="hidden" name="act4" value="pengurus">
                                            <div class="table-responsive">
                                                <table class="table table-bordered small tabel4">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="text-center p-2" style="width: 3%;">Check</th>
                                                            <th class="p-2">Nomor KTP</th>
                                                            <th class="p-2">Nama</th>
                                                            <th class="p-2">Alamat</th>
                                                            <th class="p-2">Jabatan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql8 = $proses->tampil_data_select('*', 'pengurus', 'id_profil = ' . @$_SESSION['kode_user'] . '');
                                                        foreach ($sql8 as $h) {
                                                        ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check text-center">
                                                                        <input class="form-check-input" type="checkbox" name="pengurus[]" value="<?= $h['id']; ?>">
                                                                    </div>
                                                                </td>
                                                                <td class="p-2"><?= $h['nomor_ktp']; ?></td>
                                                                <td class="p-2"><?= $h['nama']; ?></td>
                                                                <td class="p-2"><?= $h['alamat']; ?></td>
                                                                <td class="p-2"><?= $h['jabatan']; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="menu-5" role="tabpanel">
                                            <input type="hidden" name="act5" value="pengalaman">
                                            <div class="table-responsive">
                                                <table class="table table-bordered small table-sm tabel5">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="text-center p-2" style="width: 3%;">Check</th>
                                                            <th class="p-2">Nama Pekerjaan</th>
                                                            <th class="p-2">Bidang</th>
                                                            <th class="p-2">Lokasi</th>
                                                            <th class="p-2">Nama Pemberi</th>
                                                            <th class="p-2">Alamat</th>
                                                            <th class="p-2">Telepon</th>
                                                            <th class="p-2">No. Kontrak</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql10 = $proses->tampil_data_select('*', 'pengalaman', 'id_profil = ' .  @$_SESSION['kode_user'] . '');
                                                        foreach ($sql10 as $j) {
                                                        ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check text-center p-2">
                                                                        <input class="form-check-input" type="checkbox" name="pengalaman[]" value="<?= $j['id']; ?>">
                                                                    </div>
                                                                </td>
                                                                <td class="p-2"><?= $j['nama_pekerjaan']; ?></td>
                                                                <td class="p-2"><?= $j['bidang_pekerjaan']; ?></td>
                                                                <td class="p-2"><?= $j['lokasi']; ?></td>
                                                                <td class="p-2"><?= $j['nama_pemberi']; ?></td>
                                                                <td class="p-2"><?= $j['alamat_pemberi']; ?></td>
                                                                <td class="p-2"><?= $j['telepon_pemberi']; ?></td>
                                                                <td class="p-2"><?= $j['no_kontrak']; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="menu-6" role="tabpanel">
                                            <input type="hidden" name="act6" value="pekerjaan_berjalan">
                                            <div class="table-responsive">
                                                <table class="table table-bordered small tabel6">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="text-center p-2" style="width: 3%;">Check</th>
                                                            <th class="p-2">Nama Pekerjaan</th>
                                                            <th class="p-2">Bidang</th>
                                                            <th class="p-2">Lokasi</th>
                                                            <th class="p-2">Nama Pemberi</th>
                                                            <th class="p-2">Alamat</th>
                                                            <th class="p-2">Telepon</th>
                                                            <th class="p-2">No. Kontrak</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql9 = $proses->tampil_data_select('*', 'pekerjaan_berjalan', 'id_profil = ' . @$_SESSION['kode_user'] . '');
                                                        foreach ($sql9 as $i) {
                                                        ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check text-center">
                                                                        <input class="form-check-input" type="checkbox" name="pekerjaan_berjalan[]" value="<?= $i['id']; ?>">
                                                                    </div>
                                                                </td>
                                                                <td class="p-2"><?= $i['nama_pekerjaan']; ?></td>
                                                                <td class="p-2"><?= $i['bidang_pekerjaan']; ?></td>
                                                                <td class="p-2"><?= $i['lokasi']; ?></td>
                                                                <td class="p-2"><?= $i['nama_pemberi']; ?></td>
                                                                <td class="p-2"><?= $i['alamat_pemberi']; ?></td>
                                                                <td class="p-2"><?= $i['telepon_pemberi']; ?></td>
                                                                <td class="p-2"><?= $i['no_kontrak']; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="menu-8" role="tabpanel">
                                            <input type="hidden" name="act8" value="kswp">
                                            <div class="table-responsive">
                                                <table class="table table-bordered small table-sm tabel8">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="text-center" style="width: 3%;">Check</th>
                                                            <th class="p-2">Nomor NPWP</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql11 = $proses->tampil_data_join2('a.*,b.nama', 'kswp', 'operator', 'id_operator', 'a.id_profil = ' . @$_SESSION['kode_user'] . '');
                                                        foreach ($sql11 as $k) {
                                                        ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check text-center p-2">
                                                                        <input class="form-check-input" type="checkbox" name="kswp[]" value="<?= $k['id']; ?>">
                                                                    </div>
                                                                </td>
                                                                <td class="p-2"><?= $k['npwp']; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="" data-act="pernyataan" class="btn btn-success"><i class="ri-send-plane-line align-middle ms-1"></i> Kirim Kualifikasi</button>
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
            dataTable = $('.tabel1,.tabel2,.tabel3,.tabel4,.tabel5,.tabel6,.tabel7,.tabel8').DataTable({
                stateSave: true,
                autoWidth: false,
                processing: true,
                ordering: false,
                responsive: true
            });
        });

        $('#DetailModal').on('show.bs.modal', function(e) {
            var act = $(e.relatedTarget).data('act');
            var id = $(e.relatedTarget).data('id');
            $.ajax({
                type: 'post',
                url: '<?= $url; ?>detail/modal/pengumuman',
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


        $(document).on('click', '#tblizin', function(event) {
            event.preventDefault();
            var form = $('#form')[0];
            var nilai = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '<?= $url; ?>proses/kirim/kualifikasi',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                data: nilai,
                beforeSend: function() {
                    document.querySelector('#tblizin').innerHTML = '<i class="mdi mdi-spin mdi-loading align-middle ms-1"></i> Loading...';
                },
                success: function(data) {
                    $('#DetailModal').modal('toggle');
                    Toastify({
                        text: "Data Berhasil Dikirim!",
                        gravity: "top",
                        position: "center",
                        duration: 3000
                    }).showToast();
                    setTimeout(function() {
                        history.go(-1);
                    }, 2000);

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    Toastify({
                        text: "Data Gagal Dikirim!",
                        gravity: "top",
                        position: "center",
                        duration: 3000
                    }).showToast();
                },
                complete: function(data) {
                    document.querySelector('#tblizin').innerHTML = '<i class="ri-send-plane-line align-middle ms-1"></i> Kirim';
                }
            });
        });
    </script>
</body>

</html>