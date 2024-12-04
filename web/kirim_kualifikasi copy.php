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
                                                            <ul class="nav nav-pills nav-success mb-3" role="tablist">
                                                                <li class="nav-item waves-effect waves-light">
                                                                    <a class="nav-link active" data-bs-toggle="tab" href="#menu-1" role="tab">Izin Usaha</a>
                                                                </li>
                                                                <li class="nav-item waves-effect waves-light">
                                                                    <a class="nav-link" data-bs-toggle="tab" href="#menu-2" role="tab">TDP</a>
                                                                </li>
                                                                <li class="nav-item waves-effect waves-light">
                                                                    <a class="nav-link" data-bs-toggle="tab" href="#menu-3" role="tab">Akta</a>
                                                                </li>
                                                                <li class="nav-item waves-effect waves-light">
                                                                    <a class="nav-link" data-bs-toggle="tab" href="#menu-4" role="tab">SDM</a>
                                                                </li>
                                                                <li class="nav-item waves-effect waves-light">
                                                                    <a class="nav-link" data-bs-toggle="tab" href="#menu-5" role="tab">Pengalaman</a>
                                                                </li>
                                                                <li class="nav-item waves-effect waves-light">
                                                                    <a class="nav-link" data-bs-toggle="tab" href="#menu-6" role="tab">Peralatan</a>
                                                                </li>
                                                                <li class="nav-item waves-effect waves-light">
                                                                    <a class="nav-link" data-bs-toggle="tab" href="#menu-7" role="tab">Pajak</a>
                                                                </li>
                                                                <li class="nav-item waves-effect waves-light">
                                                                    <a class="nav-link" data-bs-toggle="tab" href="#menu-8" role="tab">KSWP</a>
                                                                </li>
                                                            </ul>
                                                            <!-- Tab panes -->
                                                            <form id="form">
                                                                <input type="hidden" name="id_paket" value="<?= @$cek['id_paket']; ?>">
                                                                <input type="hidden" name="id_profil" value="<?= @$_SESSION['kode_user']; ?>">
                                                                <div class="tab-content text-muted">
                                                                    <div class="tab-pane active" id="menu-1" role="tabpanel">
                                                                        <input type="hidden" name="act1" value="izin">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-bordered small tabel1">
                                                                                <thead class="table-light">
                                                                                    <tr>
                                                                                        <th class="text-center">#</th>
                                                                                        <th>Jenis Izin</th>
                                                                                        <th>Nomor</th>
                                                                                        <th>Tanggal</th>
                                                                                        <th>Berlaku</th>
                                                                                        <th>Kualifikasi</td>
                                                                                        <th class="text-center">Status</th>
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
                                                                                                <div class="form-check text-center">
                                                                                                    <input class="form-check-input" type="checkbox" name="izin[]" value="<?= $a['id']; ?>">
                                                                                                </div>
                                                                                            </td>
                                                                                            <td><?= str_replace('-', ' ', $a['jenis_izin']); ?></td>
                                                                                            <td><?= $a['nomor']; ?></td>
                                                                                            <td><?= tgl_indo($a['tanggal']); ?></td>
                                                                                            <td>
                                                                                                <?= sisa_waktu($a['masa_berlaku']); ?>
                                                                                            </td>
                                                                                            <td><?= str_replace('-', ' ', $a['grade']); ?></td>
                                                                                            <td align="center"><?= $status; ?></td>
                                                                                        </tr>
                                                                                    <?php } ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane" id="menu-2" role="tabpanel">
                                                                        <input type="hidden" name="act2" value="tdp">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-bordered small tabel2">
                                                                                <thead class="table-light">
                                                                                    <tr>
                                                                                        <th class="text-center">#</th>
                                                                                        <th>Nomor</th>
                                                                                        <th>Tanggal</th>
                                                                                        <th>Berlaku</th>
                                                                                        <th class="text-center">Status</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    $sql3 = $proses->tampil_data_join2('a.*,b.nama', 'tdp', 'operator', 'id_operator', 'a.id_profil = ' . @$_SESSION['kode_user'] . '');
                                                                                    foreach ($sql3 as $c) {
                                                                                        if ($c['status'] == 'Pending') {
                                                                                            $status = '<span class="badge text-bg-danger">Pending</span>';
                                                                                        } else if ($c['status'] == 'Waiting') {
                                                                                            $status = '<span class="badge text-bg-warning">Waiting</span>';
                                                                                        } else {
                                                                                            $status = '<span class="badge text-bg-success">Verified</span>';
                                                                                        }
                                                                                    ?>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <div class="form-check text-center">
                                                                                                    <input class="form-check-input" type="checkbox" name="tdp[]" value="<?= $c['id']; ?>">
                                                                                                </div>
                                                                                            </td>
                                                                                            <td><?= $c['nomor']; ?></td>
                                                                                            <td><?= tgl_indo($c['tanggal']); ?></td>
                                                                                            <td><?= sisa_waktu($c['masa_berlaku']); ?></td>
                                                                                            <td align="center"><?= $status; ?></td>
                                                                                        </tr>
                                                                                    <?php } ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane" id="menu-3" role="tabpanel">
                                                                        <input type="hidden" name="act3" value="akta">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-bordered small tabel3">
                                                                                <thead class="table-light">
                                                                                    <tr>
                                                                                        <th class="text-center">#</th>
                                                                                        <th>Jenis</th>
                                                                                        <th>Nomor</th>
                                                                                        <th>Tanggal</th>
                                                                                        <th>Nama Notaris</th>
                                                                                        <th class="text-center">Status</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    $sql4 = $proses->tampil_data_join2('a.*,b.nama', 'akta', 'operator', 'id_operator', 'a.id_profil = ' . @$_SESSION['kode_user'] . '');
                                                                                    foreach ($sql4 as $d) {
                                                                                        if ($d['status'] == 'Pending') {
                                                                                            $status = '<span class="badge text-bg-danger">Pending</span>';
                                                                                        } else if ($d['status'] == 'Waiting') {
                                                                                            $status = '<span class="badge text-bg-warning">Waiting</span>';
                                                                                        } else {
                                                                                            $status = '<span class="badge text-bg-success">Verified</span>';
                                                                                        }
                                                                                    ?>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <div class="form-check text-center">
                                                                                                    <input class="form-check-input" type="checkbox" name="akta[]" value="<?= $d['id']; ?>">
                                                                                                </div>
                                                                                            </td>
                                                                                            <td><?= str_replace('-', ' ', $d['jenis']); ?></td>
                                                                                            <td><?= $d['nomor']; ?></td>
                                                                                            <td><?= tgl_indo($d['tanggal']); ?></td>
                                                                                            <td><?= $d['nama_notaris']; ?></td>
                                                                                            <td align="center"><?= $status; ?></td>
                                                                                        </tr>
                                                                                    <?php } ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane" id="menu-4" role="tabpanel">
                                                                        <input type="hidden" name="act4" value="tenaga_ahli">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-bordered small tabel4">
                                                                                <thead class="table-light">
                                                                                    <tr>
                                                                                        <th class="text-center">#</th>
                                                                                        <th>Nama</th>
                                                                                        <th>Tanggal Lahir</th>
                                                                                        <th>Pendidikan</th>
                                                                                        <th>Jabatan</th>
                                                                                        <th>Pengalaman</th>
                                                                                        <th>Keahlian</th>
                                                                                        <th>Tahun Ijazah</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    $sql8 = $proses->tampil_data_select('*', 'tenaga_ahli', 'id_profil = ' . @$_SESSION['kode_user'] . '');
                                                                                    foreach ($sql8 as $h) {
                                                                                    ?>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <div class="form-check text-center">
                                                                                                    <input class="form-check-input" type="checkbox" name="sdm[]" value="<?= $h['id']; ?>">
                                                                                                </div>
                                                                                            </td>
                                                                                            <td><?= $h['nama']; ?></td>
                                                                                            <td><?= tgl_indo($h['tgl_lahir']); ?></td>
                                                                                            <td><?= $h['pendidikan']; ?></td>
                                                                                            <td><?= $h['jabatan']; ?></td>
                                                                                            <td><?= $h['pengalaman']; ?></td>
                                                                                            <td><?= $h['keahlian']; ?></td>
                                                                                            <td><?= $h['tahun_ijazah']; ?></td>
                                                                                        </tr>
                                                                                    <?php } ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane" id="menu-5" role="tabpanel">
                                                                        <input type="hidden" name="act5" value="pengalaman">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-bordered small tabel5">
                                                                                <thead class="table-light">
                                                                                    <tr>
                                                                                        <th class="text-center">#</th>
                                                                                        <th>Nama Pekerjaan</th>
                                                                                        <th>Bidang</th>
                                                                                        <th>Lokasi</th>
                                                                                        <th>Nama Pemberi</th>
                                                                                        <th>Alamat</th>
                                                                                        <th>Telepon</th>
                                                                                        <th>No. Kontrak</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    $sql10 = $proses->tampil_data_select('*', 'pengalaman', 'id_profil = ' .  @$_SESSION['kode_user'] . '');
                                                                                    foreach ($sql10 as $j) {
                                                                                    ?>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <div class="form-check text-center">
                                                                                                    <input class="form-check-input" type="checkbox" name="pengalaman[]" value="<?= $j['id']; ?>">
                                                                                                </div>
                                                                                            </td>
                                                                                            <td><?= $j['nama_pekerjaan']; ?></td>
                                                                                            <td><?= $j['bidang_pekerjaan']; ?></td>
                                                                                            <td><?= $j['lokasi']; ?></td>
                                                                                            <td><?= $j['nama_pemberi']; ?></td>
                                                                                            <td><?= $j['alamat_pemberi']; ?></td>
                                                                                            <td><?= $j['telepon_pemberi']; ?></td>
                                                                                            <td><?= $j['no_kontrak']; ?></td>
                                                                                        </tr>
                                                                                    <?php } ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane" id="menu-6" role="tabpanel">
                                                                        <input type="hidden" name="act6" value="peralatan">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-bordered small tabel6">
                                                                                <thead class="table-light">
                                                                                    <tr>
                                                                                        <th class="text-center">#</th>
                                                                                        <th>Jenis Peralatan</th>
                                                                                        <th>Jumlah</th>
                                                                                        <th>Kapasitas</th>
                                                                                        <th>Merek</th>
                                                                                        <th>Tahun</th>
                                                                                        <th>Kondisi</th>
                                                                                        <th>Lokasi</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    $sql9 = $proses->tampil_data_select('*', 'peralatan', 'id_profil = ' . @$_SESSION['kode_user'] . '');
                                                                                    foreach ($sql9 as $i) {
                                                                                    ?>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <div class="form-check text-center">
                                                                                                    <input class="form-check-input" type="checkbox" name="peralatan[]" value="<?= $i['id']; ?>">
                                                                                                </div>
                                                                                            </td>
                                                                                            <td><?= $i['jenis_peralatan']; ?></td>
                                                                                            <td><?= $i['jumlah']; ?></td>
                                                                                            <td><?= $i['kapasitas']; ?></td>
                                                                                            <td><?= $i['merek']; ?></td>
                                                                                            <td><?= $i['tahun']; ?></td>
                                                                                            <td><?= $i['kondisi']; ?></td>
                                                                                            <td><?= $i['lokasi']; ?></td>
                                                                                        </tr>
                                                                                    <?php } ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane" id="menu-7" role="tabpanel">
                                                                        <input type="hidden" name="act7" value="pajak">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-bordered small tabel7">
                                                                                <thead class="table-light">
                                                                                    <tr>
                                                                                        <th class="text-center">#</th>
                                                                                        <th>Jenis Laporan</th>
                                                                                        <th>Nomor</th>
                                                                                        <th>Tanggal</th>
                                                                                        <th class="text-center">Status</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    $sql7 = $proses->tampil_data_join2('a.*,b.nama', 'pajak', 'operator', 'id_operator', 'a.id_profil = ' . @$_SESSION['kode_user'] . '');
                                                                                    foreach ($sql7 as $g) {
                                                                                        if ($g['status'] == 'Pending') {
                                                                                            $status = '<span class="badge text-bg-danger">Pending</span>';
                                                                                        } else if ($g['status'] == 'Waiting') {
                                                                                            $status = '<span class="badge text-bg-warning">Waiting</span>';
                                                                                        } else {
                                                                                            $status = '<span class="badge text-bg-success">Verified</span>';
                                                                                        }
                                                                                    ?>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <div class="form-check text-center">
                                                                                                    <input class="form-check-input" type="checkbox" name="pajak[]" value="<?= $g['id']; ?>">
                                                                                                </div>
                                                                                            </td>
                                                                                            <td><?= str_replace('-', ' ', $g['jenis_laporan']); ?></td>
                                                                                            <td><?= $g['nomor']; ?></td>
                                                                                            <td><?= tgl_indo($g['tanggal']); ?></td>
                                                                                            <td align="center"><?= $status; ?></td>
                                                                                        </tr>
                                                                                    <?php } ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane" id="menu-8" role="tabpanel">
                                                                        <input type="hidden" name="act8" value="kswp">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-bordered small tabel8">
                                                                                <thead class="table-light">
                                                                                    <tr>
                                                                                        <th class="text-center" style="width: 5%;">#</th>
                                                                                        <th>Nomor NPWP</th>
                                                                                        <th class="text-center">Status</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    $sql11 = $proses->tampil_data_join2('a.*,b.nama', 'kswp', 'operator', 'id_operator', 'a.id_profil = ' . @$_SESSION['kode_user'] . '');
                                                                                    foreach ($sql11 as $k) {
                                                                                        if ($k['status'] == 'Pending') {
                                                                                            $status = '<span class="badge text-bg-danger">Pending</span>';
                                                                                        } else if ($k['status'] == 'Waiting') {
                                                                                            $status = '<span class="badge text-bg-warning">Waiting</span>';
                                                                                        } else {
                                                                                            $status = '<span class="badge text-bg-success">Verified</span>';
                                                                                        }
                                                                                    ?>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <div class="form-check text-center">
                                                                                                    <input class="form-check-input" type="checkbox" name="pajak[]" value="<?= $k['id']; ?>">
                                                                                                </div>
                                                                                            </td>
                                                                                            <td><?= $k['npwp']; ?></td>
                                                                                            <td align="center"><?= $status; ?></td>
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