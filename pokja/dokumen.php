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
cek_url($url, $proses, 'edit', 'profil_badan_usaha', 'id_profil ="' . @$_GET['id'] . '"');
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
                                $s = $proses->tampil_data_saja('*', 'profil_badan_usaha', '1=1 AND id_profil = "' . $_GET['id'] . '"');
                                ?>
                                <table class="table table-bordered table-success table-sm fs-13">
                                    <tbody>
                                        <tr>
                                            <td class="w-25 p-2">Nama Perusahaan</td>
                                            <td class="p-2"><?= $s['nama_perusahaan']; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">Badan Usaha</td>
                                            <td class="p-2"><?= $s['badan_usaha']; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">Nomor NPWP</td>
                                            <td class="p-2"><?= $s['npwp']; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">Tanggal Daftar</td>
                                            <td class="p-2"><?= tgl_indo7($s['registrasi']); ?></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="col-sm-6 pt-0 pb-2">
                                    <div class="form-check card-radio">
                                        <label class="form-check-label" for="listGroupRadioGrid1">
                                            <table class="table table-sm fs-12 mb-0">
                                                <thead>
                                                    <tr class="bg-light">
                                                        <th class="p-2">Nama Verifikator</th>
                                                        <th class="p-2 text-center">Status</th>
                                                        <th class="p-2">Tanggal Verifikasi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql = $proses->tampil_data_select(
                                                        'a.nama AS nama_verifikator, b.timestamp, CASE WHEN b.id_operator IS NOT NULL AND b.id_profil = "' . $_GET['id'] . '" THEN "Verifikasi" ELSE "Belum Verifikasi" END AS status',
                                                        'operator a LEFT JOIN verifikator b ON a.id_operator = b.id_operator AND b.id_profil = "' . $_GET['id'] . '"',
                                                        '1=1 AND a.level = "Verifikator"'
                                                    );
                                                    foreach ($sql as $row) {
                                                        if (@$row['status'] == 'Verifikasi') {
                                                            $sts = '<span class="badge bg-success fs-11">Verifikasi</span>';
                                                        } else {
                                                            $sts = '<span class="badge bg-danger fs-11">Belum Verifikasi</span>';
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td class="p-2"><?= @$row['nama_verifikator']; ?></td>
                                                            <td class="p-2 text-center"><?= @$sts; ?></td>
                                                            <td class="p-2"><?= @$row['timestamp']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </label>
                                    </div>
                                </div>

                                <h5>Izin Usaha</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped small tabel1 table-sm fs-12">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="p-2">Jenis Izin</th>
                                                <th class="p-2">Nomor</th>
                                                <th class="p-2">Tanggal</th>
                                                <th class="p-2">Berlaku</th>
                                                <th class="p-2">Instansi Pemberi</th>
                                                <th class="p-2">Grade</th>
                                                <th class="p-2 text-center" style="width:3%;">File</td>
                                                <th class="p-2 text-center" style="width:20%;">Verifikator</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //$sql1 = $proses->tampil_data_join2('a.*,b.nama', 'izin_usaha', 'operator', 'id_operator', 'a.id_profil = ' . $_GET['id'] . '');
                                            $sql1 = $proses->tampil_data_select('*', 'izin_usaha', '1=1 AND id_profil = ' . $_GET['id'] . '');
                                            if (empty($sql1)) {
                                                echo '<tr><td class="p-2" colspan="8">Belum ada Data</td></tr>';
                                            } else {
                                                foreach ($sql1 as $a) {
                                                    $act = pathinfo(@$a['file'], PATHINFO_EXTENSION);
                                                    $cek1 = $proses->tampil_data_select(
                                                        'b.id_operator, b.nama',
                                                        'catatan a INNER JOIN operator b ON a.id_operator = b.id_operator',
                                                        '1=1 AND a.id = "' . $a['id'] . '" 
                                                        AND a.menu = "izin_usaha" 
                                                        AND a.id_profil = "' . $_GET['id'] . '"'
                                                    );
                                            ?>
                                                    <tr>
                                                        <td class="p-2"><?= str_replace('-', ' ', $a['jenis_izin']); ?></td>
                                                        <td class="p-2"><?= $a['nomor']; ?></td>
                                                        <td class="p-2"><?= tgl_indo($a['tanggal']); ?></td>
                                                        <td class="p-2">
                                                            <?= sisa_waktu($a['masa_berlaku']); ?>
                                                        </td>
                                                        <td class="p-2"><?= $a['instansi_pemberi']; ?></td>
                                                        <td class="p-2"><?= str_replace('-', ' ', $a['grade']); ?></td>
                                                        <td class="p-2 text-center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $a['file']; ?>"><i class="ri-file-line fs-14"></i></a></td>
                                                        <td class="ps-2 pe-2" align="center">
                                                            <?php
                                                            foreach ($cek1 as $aa) {
                                                                if ($aa['id_operator'] == $_SESSION['kode_user']) {
                                                                    echo '<span class="badge bg-success fs-10">' . @$aa['nama'] . '</span>';
                                                                } else {
                                                                    echo '<small>' . @$aa['nama'] . ',</small> ';
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <h5>NPWP</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped small tabel12 table-sm fs-12">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="p-2">Nomor NPWP</th>
                                                <th class="text-center p-2" style="width:3%;">File</th>
                                                <th class="p-2 text-center" style="width:20%;">Verifikator</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //$sql11 = $proses->tampil_data_join2('a.*,b.nama', 'npwp', 'operator', 'id_operator', 'a.id_profil = ' . $_GET['id'] . '');
                                            $sql11 = $proses->tampil_data_select('*', 'npwp', '1=1 AND id_profil = ' . $_GET['id'] . '');
                                            if (empty($sql11)) {
                                                echo '<tr><td class="p-2" colspan="3">Belum ada Data</td></tr>';
                                            } else {
                                                foreach ($sql11 as $k) {
                                                    $act = pathinfo(@$k['file'], PATHINFO_EXTENSION);
                                                    $cek2 = $proses->tampil_data_select(
                                                        'b.id_operator, b.nama',
                                                        'catatan a INNER JOIN operator b ON a.id_operator = b.id_operator',
                                                        '1=1 AND a.id = "' . $k['id'] . '"
                                                        AND a.menu = "npwp" 
                                                        AND a.id_profil = "' . $_GET['id'] . '"'
                                                    );
                                            ?>
                                                    <tr>
                                                        <td class="p-2"><?= $k['npwp']; ?></td>
                                                        <td align="center" class="p-2"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $k['file']; ?>"><i class="ri-file-line"></i></a></td>
                                                        <td class="ps-2 pe-2" align="center">
                                                            <?php
                                                            foreach ($cek2 as $aa) {
                                                                if ($aa['id_operator'] == $_SESSION['kode_user']) {
                                                                    echo '<span class="badge bg-success fs-10">' . @$aa['nama'] . '</span>';
                                                                } else {
                                                                    echo '<small>' . @$aa['nama'] . ',</small> ';
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <h5>Sertifikat Standard</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped small tabel8 table-sm fs-12">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="p-2">Nama Sertifikat</th>
                                                <th class="p-2 text-center" style="width:3%;">File</th>
                                                <th class="p-2 text-center" style="width:20%;">Verifikator</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //$sql7 = $proses->tampil_data_join2('a.*,b.nama', 'sertifikat', 'operator', 'id_operator', 'a.id_profil = ' . $_GET['id'] . '');
                                            $sql7 = $proses->tampil_data_select('*', 'sertifikat', '1=1 AND id_profil = ' . $_GET['id'] . '');
                                            if (empty($sql7)) {
                                                echo '<tr><td class="p-2" colspan="3">Belum ada Data</td></tr>';
                                            } else {
                                                foreach ($sql7 as $g) {
                                                    $cek2 = $proses->tampil_data_select(
                                                        'b.id_operator, b.nama',
                                                        'catatan a INNER JOIN operator b ON a.id_operator = b.id_operator',
                                                        '1=1 AND a.id = "' . $g['id'] . '"
                                                        AND a.menu = "sertifikat" 
                                                        AND a.id_profil = "' . $_GET['id'] . '"'
                                                    );
                                            ?>
                                                    <tr>
                                                        <td class="p-2"><?= $g['nama_sertifikat']; ?></td>
                                                        <td align="center" class="p-2"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $k['file']; ?>"><i class="ri-file-line"></i></a></td>
                                                        <td class="ps-2 pe-2" align="center">
                                                            <?php
                                                            foreach ($cek2 as $aa) {
                                                                if ($aa['id_operator'] == $_SESSION['kode_user']) {
                                                                    echo '<span class="badge bg-success fs-10">' . @$aa['nama'] . '</span>';
                                                                } else {
                                                                    echo '<small>' . @$aa['nama'] . ',</small> ';
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <h5>Akta</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped small tabel5 table-sm fs-12">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="p-2">Jenis</th>
                                                <th class="p-2">Nomor</th>
                                                <th class="p-2">Tanggal</th>
                                                <th class="p-2">Nama Notaris</th>
                                                <th class="p-2 text-center" style="width:3%;">File</td>
                                                <th class="p-2 text-center" style="width:20%;">Verifikator</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //$sql4 = $proses->tampil_data_join2('a.*,b.nama', 'akta', 'operator', 'id_operator', 'a.id_profil = ' . $_GET['id'] . '');
                                            $sql4 = $proses->tampil_data_select('*', 'akta', '1=1 AND id_profil = ' . $_GET['id'] . '');
                                            if (empty($sql4)) {
                                                echo '<tr><td class="p-2" colspan="6">Belum ada Data</td></tr>';
                                            } else {
                                                foreach ($sql4 as $d) {
                                                    $act = pathinfo(@$d['file'], PATHINFO_EXTENSION);
                                                    $cek2 = $proses->tampil_data_select(
                                                        'b.id_operator, b.nama',
                                                        'catatan a INNER JOIN operator b ON a.id_operator = b.id_operator',
                                                        '1=1 AND a.id = "' . $d['id'] . '" 
                                                        AND a.menu = "akta" 
                                                        AND a.id_profil = "' . $_GET['id'] . '"'
                                                    );
                                            ?>
                                                    <tr>
                                                        <td class="p-2"><?= str_replace('-', ' ', $d['jenis']); ?></td>
                                                        <td class="p-2"><?= $d['nomor']; ?></td>
                                                        <td class="p-2"><?= tgl_indo($d['tanggal']); ?></td>
                                                        <td class="p-2"><?= $d['nama_notaris']; ?></td>
                                                        <td align="center" class="p-2"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $d['file']; ?>"><i class="ri-file-line"></i></a></td>
                                                        <td class="ps-2 pe-2" align="center">
                                                            <?php
                                                            foreach ($cek2 as $aa) {
                                                                if ($aa['id_operator'] == $_SESSION['kode_user']) {
                                                                    echo '<span class="badge bg-success fs-10">' . @$aa['nama'] . '</span>';
                                                                } else {
                                                                    echo '<small>' . @$aa['nama'] . ',</small> ';
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <h5>Manajerial</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped small tabel9 table-sm fs-12">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="p-2">Jabatan</th>
                                                <th class="p-2">Nomor KTP</th>
                                                <th class="p-2">Nama</th>
                                                <th class="p-2">Alamat</th>
                                                <th class="p-2 text-center" style="width:3%;">File</th>
                                                <th class="p-2 text-center" style="width:20%;">Verifikator</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //$sql8 = $proses->tampil_data_join2('a.*,b.nama AS namas', 'pengurus', 'operator', 'id_operator', 'a.id_profil = ' . $_GET['id'] . '');
                                            $sql8 = $proses->tampil_data_select('*', 'pengurus', '1=1 AND id_profil = ' . $_GET['id'] . '');
                                            if (empty($sql8)) {
                                                echo '<tr><td class="p-2" colspan="6">Belum ada Data</td></tr>';
                                            } else {
                                                foreach ($sql8 as $h) {
                                                    $act = pathinfo(@$h['file'], PATHINFO_EXTENSION);
                                                    $cek2 = $proses->tampil_data_select(
                                                        'b.id_operator, b.nama',
                                                        'catatan a INNER JOIN operator b ON a.id_operator = b.id_operator',
                                                        '1=1 AND a.id = "' . $h['id'] . '" 
                                                        AND a.menu = "pengurus" 
                                                        AND a.id_profil = "' . $_GET['id'] . '"'
                                                    );
                                            ?>
                                                    <tr>
                                                        <td class="p-2"><?= str_replace('-', ' ', $h['jabatan']); ?></td>
                                                        <td class="p-2"><?= $h['nomor_ktp']; ?></td>
                                                        <td class="p-2"><?= $h['nama']; ?></td>
                                                        <td class="p-2"><?= $h['alamat']; ?></td>
                                                        <td align="center" class="p-2"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $h['file']; ?>"><i class="ri-file-line"></i></a></td>
                                                        <td class="ps-2 pe-2" align="center">
                                                            <?php
                                                            foreach ($cek2 as $aa) {
                                                                if ($aa['id_operator'] == $_SESSION['kode_user']) {
                                                                    echo '<span class="badge bg-success fs-10">' . @$aa['nama'] . '</span>';
                                                                } else {
                                                                    echo '<small>' . @$aa['nama'] . ',</small> ';
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <h5>Pemilik Saham</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped small tabel9 table-sm fs-12">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="p-2">Nama</th>
                                                <th class="p-2">Nomor KTP</th>
                                                <th class="p-2">Alamat</th>
                                                <th class="p-2">Tipe Saham</th>
                                                <th class="p-2">Persen Saham</th>
                                                <th class="p-2 text-center" style="width:3%;">File</th>
                                                <th class="p-2 text-center" style="width:20%;">Verifikator</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //$sql8 = $proses->tampil_data_join2('a.*,b.nama AS namas', 'pemilik_saham', 'operator', 'id_operator', 'a.id_profil = ' . $_GET['id'] . '');
                                            $sql8 = $proses->tampil_data_select('*', 'pemilik_saham', '1=1 AND id_profil = ' . $_GET['id'] . '');
                                            if (empty($sql8)) {
                                                echo '<tr><td class="p-2" colspan="7">Belum ada Data</td></tr>';
                                            } else {
                                                foreach ($sql8 as $h) {
                                                    $act = pathinfo(@$h['file'], PATHINFO_EXTENSION);
                                                    $cek2 = $proses->tampil_data_select(
                                                        'b.id_operator, b.nama',
                                                        'catatan a INNER JOIN operator b ON a.id_operator = b.id_operator',
                                                        '1=1 AND a.id = "' . $h['id'] . '" 
                                                        AND a.menu = "pemilik_saham" 
                                                        AND a.id_profil = "' . $_GET['id'] . '"'
                                                    );
                                            ?>
                                                    <tr>
                                                        <td class="p-2"><?= $h['nama']; ?></td>
                                                        <td class="p-2"><?= $h['nomor_ktp']; ?></td>
                                                        <td class="p-2"><?= $h['alamat']; ?></td>
                                                        <td class="p-2"><?= str_replace('-', ' ', $h['tipe_saham']); ?></td>
                                                        <td class="p-2"><?= str_replace('%', '', $h['persen_saham']); ?>%</td>
                                                        <td align="center" class="p-2"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $h['file']; ?>"><i class="ri-file-line"></i></a></td>
                                                        <td class="ps-2 pe-2" align="center">
                                                            <?php
                                                            foreach ($cek2 as $aa) {
                                                                if ($aa['id_operator'] == $_SESSION['kode_user']) {
                                                                    echo '<span class="badge bg-success fs-10">' . @$aa['nama'] . '</span>';
                                                                } else {
                                                                    echo '<small>' . @$aa['nama'] . ',</small> ';
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <h5>KSWP</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped small tabel12 table-sm fs-12">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="p-2">Nomor NPWP</th>
                                                <th class="text-center p-2">File</th>
                                                <th class="p-2 text-center" style="width:20%;">Verifikator</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //$sql11 = $proses->tampil_data_join2('a.*,b.nama', 'kswp', 'operator', 'id_operator', 'a.id_profil = ' . $_GET['id'] . '');
                                            $sql11 = $proses->tampil_data_select('*', 'kswp', '1=1 AND id_profil = ' . $_GET['id'] . '');
                                            if (empty($sql11)) {
                                                echo '<tr><td class="p-2" colspan="3">Belum ada Data</td></tr>';
                                            } else {
                                                foreach ($sql11 as $k) {
                                                    $act = pathinfo(@$k['file'], PATHINFO_EXTENSION);
                                                    $cek2 = $proses->tampil_data_select(
                                                        'b.id_operator, b.nama',
                                                        'catatan a INNER JOIN operator b ON a.id_operator = b.id_operator',
                                                        '1=1 AND a.id = "' . $k['id'] . '" 
                                                        AND a.menu = "kswp" 
                                                        AND a.id_profil = "' . $_GET['id'] . '"'
                                                    );
                                            ?>
                                                    <tr>
                                                        <td class="p-2"><?= $k['npwp']; ?></td>
                                                        <td align="center" class="p-2"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $k['file']; ?>"><i class="ri-file-line"></i></a></td>
                                                        <td class="ps-2 pe-2" align="center">
                                                            <?php
                                                            foreach ($cek2 as $aa) {
                                                                if ($aa['id_operator'] == $_SESSION['kode_user']) {
                                                                    echo '<span class="badge bg-success fs-10">' . @$aa['nama'] . '</span>';
                                                                } else {
                                                                    echo '<small>' . @$aa['nama'] . ',</small> ';
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <h5>Pengalaman</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped small tabel11 table-sm fs-12">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="p-2">Nama Pekerjaan</th>
                                                <th class="p-2">Bidang</th>
                                                <th class="p-2">Lokasi</th>
                                                <th class="p-2">Nama Pemberi</th>
                                                <th class="p-2">Alamat</th>
                                                <th class="p-2">Telepon</th>
                                                <th class="p-2">No. Kontrak</th>
                                                <th class="p-2">Nilai Kontrak</th>
                                                <th class="p-2">Tgl Selesai</th>
                                                <th class="p-2">Tgl Berita Acara</th>
                                                <th class="p-2 text-center" style="width:3%;">File</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql10 = $proses->tampil_data_select(
                                                '*',
                                                'pengalaman',
                                                '1=1 AND id_profil = "' . $_GET['id'] . '"'
                                            );
                                            if (empty($sql10)) {
                                                echo '<tr><td class="p-2" colspan="11">Belum ada Data</td></tr>';
                                            } else {
                                                foreach ($sql10 as $j) {
                                                    $act = pathinfo(@$j['file'], PATHINFO_EXTENSION);
                                            ?>
                                                    <tr>
                                                        <td class="p-2"><?= $j['nama_pekerjaan']; ?></td>
                                                        <td class="p-2"><?= $j['bidang_pekerjaan']; ?></td>
                                                        <td class="p-2"><?= $j['lokasi']; ?></td>
                                                        <td class="p-2"><?= $j['nama_pemberi']; ?></td>
                                                        <td class="p-2"><?= $j['alamat_pemberi']; ?></td>
                                                        <td class="p-2"><?= $j['telepon_pemberi']; ?></td>
                                                        <td class="p-2"><?= $j['no_kontrak']; ?></td>
                                                        <td class="p-2 text-end"><?= number_format($j['nilai_kontrak'], 0, ',', '.'); ?></td>
                                                        <td class="p-2"><?= tgl_indo($j['tgl_selesai']); ?></td>
                                                        <td class="p-2"><?= tgl_indo($j['tgl_berita_acara']); ?></td>
                                                        <td align="center" class="p-2"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $j['file']; ?>"><i class="ri-file-line"></i></a></td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <h5>Pekerjaan Sedang Berjalan</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped small tabel12 table-sm fs-12">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="p-2">Nama Pekerjaan</th>
                                                <th class="p-2">Bidang</th>
                                                <th class="p-2">Lokasi</th>
                                                <th class="p-2">Nama Pemberi</th>
                                                <th class="p-2">Alamat</th>
                                                <th class="p-2">Telepon</th>
                                                <th class="p-2">No. Kontrak</th>
                                                <th class="p-2">Nilai Kontrak</th>
                                                <th class="p-2 text-center" style="width:3%;">File</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql11 = $proses->tampil_data_select(
                                                '*',
                                                'pekerjaan_berjalan',
                                                '1=1 AND id_profil = "' . $_GET['id'] . '"'
                                            );
                                            if (empty($sql11)) {
                                                echo '<tr><td class="p-2" colspan="9">Belum ada Data</td></tr>';
                                            } else {
                                                foreach ($sql11 as $k) {
                                            ?>
                                                    <tr>
                                                        <td class="p-2"><?= $k['nama_pekerjaan']; ?></td>
                                                        <td class="p-2"><?= $k['bidang_pekerjaan']; ?></td>
                                                        <td class="p-2"><?= $k['lokasi']; ?></td>
                                                        <td class="p-2"><?= $k['nama_pemberi']; ?></td>
                                                        <td class="p-2"><?= $k['alamat_pemberi']; ?></td>
                                                        <td class="p-2"><?= $k['telepon_pemberi']; ?></td>
                                                        <td class="p-2"><?= $k['no_kontrak']; ?></td>
                                                        <td class="p-2 text-end"><?= number_format($j['nilai_kontrak'], 0, ',', '.'); ?></td>
                                                        <td align="center" class="p-2"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $k['file']; ?>"><i class="ri-file-line"></i></a></td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
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
        });
    </script>
</body>

</html>