<?php
function navbar($url)
{
?>
    <nav class="navbar navbar-expand-lg navbar-landing fixed-top is-sticky">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="<?= $url; ?>assets/images/logo-dark.png" class="card-logo card-logo-dark" alt="logo dark" height="30">
                <img src="<?= $url; ?>assets/images/logo-light.png" class="card-logo card-logo-light" alt="logo light" height="20">
            </a>
            <button class="navbar-toggler py-2 fs-20 text-body" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="mdi mdi-menu"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="navbar-example">
                    <li class="nav-item">
                        <a class="nav-link fs-14 <?= @$_GET['aktif1']; ?>" href="<?= $url; ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-14 <?= @$_GET['aktif2']; ?>" href="<?= $url; ?>pengumuman-pengadaan">Pengumuman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-14 <?= @$_GET['aktif3']; ?>" href="<?= $url; ?>dpt-terverifikasi">DPT Terverifikasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-14 <?= @$_GET['aktif4']; ?>" href="<?= $url; ?>hasil-pengadaan">Hasil Pengadaan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-14 <?= @$_GET['aktif5']; ?>" href="<?= $url; ?>info-penting">Info Penting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-14 <?= @$_GET['aktif6']; ?>" href="<?= $url; ?>panduan-aplikasi">Panduan</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
<?php
}
function logo($url)
{
?>
    <div class="d-flex">
        <div class="navbar-brand-box horizontal-logo">
            <a href="#" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="<?= $url; ?>assets/images/logo-sm.png" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="<?= $url; ?>assets/images/logo-dark.png" alt="" height="30">
                </span>
            </a>

            <a href="#" class="logo logo-light">
                <span class="logo-sm">
                    <img src="<?= $url; ?>assets/images/logo-sm.png" alt="" height="25">
                </span>
                <span class="logo-lg">
                    <img src="<?= $url; ?>assets/images/logo-light.png" alt="" height="30">
                </span>
            </a>
        </div>
        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
            <span class="hamburger-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>
    </div>
<?php
}
function notif($proses, $url)
{
    $notif1 = $proses->cek_row('catatan', 'id_profil = "' . $_SESSION['kode_profil'] . '" AND status = "Waiting"');
    if ($notif1) {
        $notif_1 = $notif1;
    } else {
        $notif_1 = '0';
    }
?>
    <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
            <i class='bx bx-bell fs-22'></i>
            <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger"><?= $notif_1; ?><span class="visually-hidden">unread messages</span></span>
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">

            <div class="dropdown-head bg-primary bg-pattern rounded-top">
                <div class="p-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="m-0 fs-16 fw-semibold text-white"> Notifikasi </h6>
                        </div>
                        <div class="col-auto dropdown-tabs">
                            <span class="badge bg-light-subtle text-body fs-13"> <?= $notif_1; ?> New</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content position-relative" id="notificationItemsTabContent">
                <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                    <div data-simplebar style="max-height: 300px;" class="pe-2">
                        <div class="text-reset notification-item d-block dropdown-item position-relative">
                            <div class="d-flex">
                                <?php
                                $sql = $proses->tampil_data_select('*', 'catatan', 'id_profil = "' . $_SESSION['kode_profil'] . '" AND status = "Waiting" ORDER BY id_catatan LIMIT 5');
                                foreach ($sql as $row) {
                                ?>
                                    <div class="flex-grow-1">
                                        <h6 class="mt-0 mb-2 lh-base"><?= str_replace('_', ' ', $row['menu']) . ' ' . $row['catatan']; ?>
                                        </h6>
                                        <p class="mb-0 fs-10 fw-medium text-muted">
                                            <span><i class="mdi mdi-clock-outline"></i> <?= waktu_lalu($row['timestamp']); ?></span>
                                        </p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="my-3 text-center view-all">
                            <a href="<?= $url; ?>status-catatan" class="btn btn-sm btn-soft-success waves-effect waves-light">Lihat Semua <i class="ri-arrow-right-line align-middle"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
function profil($proses, $url)
{
    $notif2 = $proses->cek_row('profil_badan_usaha', 'id_profil = "' . $_SESSION['kode_profil'] . '" AND status = "Terverifikasi"');
    if ($notif2) {
        $notif_2 = '<i class="ri-checkbox-circle-fill text-success"></i>';
    } else {
        $notif_2 = '<i class="ri-close-circle-fill text-danger"></i>';
    }
?>
    <div class="dropdown ms-sm-3 header-item topbar-user">
        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center">
                <img class="rounded-circle header-profile-user" src="<?= $url; ?>assets/images/avatar-1.jpg">
                <span class="text-start ms-xl-2">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?= $_SESSION['nama']; ?><?= $notif_2; ?></span>
                    <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">Penyedia</span>
                </span>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <h6 class="dropdown-header">Selamat Datang!</h6>
            <a class="dropdown-item" href="<?= $url; ?>ganti-password"><i class="ri-lock-2-line text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Ubah Password</span></a>
            <a class="dropdown-item" href="<?= $url; ?>logout"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
        </div>
    </div>
<?php
}
function profil_operator($link, $url)
{
?>
    <div class="dropdown ms-sm-3 header-item topbar-user">
        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center">
                <img class="rounded-circle header-profile-user" src="<?= $url; ?>assets/images/avatar-1.jpg">
                <span class="text-start ms-xl-2">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?= $_SESSION['nama']; ?></span>
                    <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text"><?= $_SESSION['level']; ?></span>
                </span>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <h6 class="dropdown-header">Selamat Datang!</h6>
            <a class="dropdown-item" href="<?= $url . $link; ?>/profil"><i class="ri-account-box-line text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profil</span></a>
            <a class="dropdown-item" href="<?= $url; ?>logout"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
        </div>
    </div>
<?php
}
function menu_penyedia($url)
{
?>
    <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <!-- Dark Logo-->
            <a href="#" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="<?= $url; ?>assets/images/logo-sm.png" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="<?= $url; ?>assets/images/logo-dark.png" alt="" height="17">
                </span>
            </a>
            <!-- Light Logo-->
            <a href="#" class="logo logo-light">
                <span class="logo-sm">
                    <img src="<?= $url; ?>assets/images/logo-sm.png" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="<?= $url; ?>assets/images/logo-light.png" alt="" height="17">
                </span>
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>
        <div id="scrollbar">
            <div class="container-fluid">
                <div id="two-column-menu"></div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="menu-title"><span>Menu</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_1']; ?>" href="<?= $url; ?>beranda">
                            <i class="ri-home-3-line"></i> <span>Beranda</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_3']; ?>" href="<?= $url; ?>paket-baru">
                            <i class="ri-truck-line"></i> <span>Paket Baru</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_2']; ?>" href="<?= $url; ?>ubah-profil">
                            <i class="ri-profile-line"></i> <span>Profil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link <?= @$_GET['aktif_4']; ?>" href="#sidebarDokumen" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDokumen">
                            <i class="ri-question-line"></i> <span>Dokumen Perusahaan</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarDokumen">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="<?= $url; ?>syarat-izin-usaha" class="nav-link <?= @$_GET['aktif_41']; ?>"> Izin Usaha </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= $url; ?>syarat-npwp" class="nav-link <?= @$_GET['aktif_42']; ?>"> NPWP </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= $url; ?>syarat-sertifikat" class="nav-link <?= @$_GET['aktif_44']; ?>"> Sertifikat Standar </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= $url; ?>syarat-akta" class="nav-link <?= @$_GET['aktif_45']; ?>"> Akta </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= $url; ?>syarat-pengurus" class="nav-link <?= @$_GET['aktif_46']; ?>"> Pengurus</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= $url; ?>syarat-pemilik-saham" class="nav-link <?= @$_GET['aktif_47']; ?>">Pemilik Saham</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= $url; ?>syarat-kswp" class="nav-link <?= @$_GET['aktif_49']; ?>">KSWP</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= $url; ?>syarat-pengalaman" class="nav-link <?= @$_GET['aktif_412']; ?>">Pengalaman</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= $url; ?>syarat-pekerjaan-berjalan" class="nav-link <?= @$_GET['aktif_413']; ?>">Pekerjaan Sedang Berjalan</a>
                                </li>
                            </ul>
                        </div>
                    </li> <!-- end Dashboard Menu -->
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_6']; ?>" href="<?= $url; ?>status-verifikasi">
                            <i class="ri-checkbox-circle-line"></i> <span>Status Verifikasi</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Sidebar -->
        </div>
        <div class="sidebar-background"></div>
    </div>
<?php
}
function menu_ppk($url)
{
?>
    <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <!-- Dark Logo-->
            <a href="#" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="<?= $url; ?>assets/images/logo-sm.png" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="<?= $url; ?>assets/images/logo-dark.png" alt="" height="17">
                </span>
            </a>
            <!-- Light Logo-->
            <a href="#" class="logo logo-light">
                <span class="logo-sm">
                    <img src="<?= $url; ?>assets/images/logo-sm.png" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="<?= $url; ?>assets/images/logo-light.png" alt="" height="17">
                </span>
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>
        <div id="scrollbar">
            <div class="container-fluid">
                <div id="two-column-menu"></div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="menu-title"><span>Menu</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_1']; ?>" href="<?= $url; ?>ppk/beranda">
                            <i class="ri-home-3-line"></i> <span>Beranda</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_2']; ?>" href="<?= $url; ?>ppk/daftar-paket">
                            <i class="ri-truck-line"></i> <span>Daftar Paket</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_3']; ?>" href="<?= $url; ?>ppk/inbox">
                            <i class="ri-mail-unread-line"></i> <span>Inbox</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_4']; ?>" href="<?= $url; ?>ppk/ganti-password">
                            <i class="ri-lock-2-line"></i> <span>Ganti Password</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Sidebar -->
        </div>
        <div class="sidebar-background"></div>
    </div>
<?php
}
function menu_ukpbj($url)
{
?>
    <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <!-- Dark Logo-->
            <a href="#" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="<?= $url; ?>assets/images/logo-sm.png" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="<?= $url; ?>assets/images/logo-dark.png" alt="" height="17">
                </span>
            </a>
            <!-- Light Logo-->
            <a href="#" class="logo logo-light">
                <span class="logo-sm">
                    <img src="<?= $url; ?>assets/images/logo-sm.png" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="<?= $url; ?>assets/images/logo-light.png" alt="" height="17">
                </span>
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>
        <div id="scrollbar">
            <div class="container-fluid">
                <div id="two-column-menu"></div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="menu-title"><span>Menu</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_1']; ?>" href="<?= $url; ?>ukpbj/beranda">
                            <i class="ri-home-3-line"></i> <span>Beranda</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_2']; ?>" href="<?= $url; ?>ukpbj/daftar-paket">
                            <i class="ri-truck-line"></i> <span>Daftar Paket</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_3']; ?>" href="<?= $url; ?>ukpbj/pegawai">
                            <i class="mdi mdi-account-box-multiple"></i> <span>Pegawai</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_5']; ?>" href="<?= $url; ?>ukpbj/inbox">
                            <i class="ri-mail-unread-line"></i> <span>Inbox</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_4']; ?>" href="<?= $url; ?>ukpbj/ganti-password">
                            <i class="ri-lock-2-line"></i> <span>Ganti Password</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Sidebar -->
        </div>
        <div class="sidebar-background"></div>
    </div>
<?php
}
function menu_pokja($url)
{
?>
    <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <!-- Dark Logo-->
            <a href="#" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="<?= $url; ?>assets/images/logo-sm.png" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="<?= $url; ?>assets/images/logo-dark.png" alt="" height="17">
                </span>
            </a>
            <!-- Light Logo-->
            <a href="#" class="logo logo-light">
                <span class="logo-sm">
                    <img src="<?= $url; ?>assets/images/logo-sm.png" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="<?= $url; ?>assets/images/logo-light.png" alt="" height="17">
                </span>
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>
        <div id="scrollbar">
            <div class="container-fluid">
                <div id="two-column-menu"></div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="menu-title"><span>Menu</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_1']; ?>" href="<?= $url; ?>pokja/beranda">
                            <i class="ri-home-3-line"></i> <span>Beranda</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_2']; ?>" href="<?= $url; ?>pokja/daftar-paket">
                            <i class="ri-truck-line"></i> <span>Daftar Paket</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_5']; ?>" href="<?= $url; ?>pokja/penyedia">
                            <i class="mdi mdi-account-box-multiple"></i> <span>Penyedia</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link <?= @$_GET['aktif_6']; ?>" href="#sidebarInformasi" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarInformasi">
                            <i class="ri-information-line"></i> <span>Informasi</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarInformasi">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="<?= $url; ?>pokja/news-update" class="nav-link <?= @$_GET['aktif_61']; ?>"> News & Update </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= $url; ?>pokja/info-penting" class="nav-link <?= @$_GET['aktif_62']; ?>"> Info Penting </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= $url; ?>pokja/panduan" class="nav-link <?= @$_GET['aktif_63']; ?>"> Panduan </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= $url; ?>pokja/contact" class="nav-link <?= @$_GET['aktif_64']; ?>"> Contact </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_3']; ?>" href="<?= $url; ?>pokja/inbox">
                            <i class="ri-mail-unread-line"></i> <span>Inbox</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_4']; ?>" href="<?= $url; ?>pokja/ganti-password">
                            <i class="ri-lock-2-line"></i> <span>Ganti Password</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Sidebar -->
        </div>
        <div class="sidebar-background"></div>
    </div>
<?php
}
function menu_verifikator($url)
{
?>
    <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <!-- Dark Logo-->
            <a href="#" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="<?= $url; ?>assets/images/logo-sm.png" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="<?= $url; ?>assets/images/logo-dark.png" alt="" height="17">
                </span>
            </a>
            <!-- Light Logo-->
            <a href="#" class="logo logo-light">
                <span class="logo-sm">
                    <img src="<?= $url; ?>assets/images/logo-sm.png" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="<?= $url; ?>assets/images/logo-light.png" alt="" height="17">
                </span>
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>
        <div id="scrollbar">
            <div class="container-fluid">
                <div id="two-column-menu"></div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="menu-title"><span>Menu</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_1']; ?>" href="<?= $url; ?>verifikator/beranda">
                            <i class="ri-home-3-line"></i> <span>Beranda</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_2']; ?>" href="<?= $url; ?>verifikator/penyedia">
                            <i class="mdi mdi-account-box-multiple"></i> <span>Daftar Penyedia</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_3']; ?>" href="<?= $url; ?>verifikator/inbox">
                            <i class="ri-mail-unread-line"></i> <span>Inbox</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link pe-1 <?= @$_GET['aktif_4']; ?>" href="<?= $url; ?>verifikator/ganti-password">
                            <i class="ri-lock-2-line"></i> <span>Ganti Password</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Sidebar -->
        </div>
        <div class="sidebar-background"></div>
    </div>
<?php
}
function navbar3($url)
{
?>
    <nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="<?= $url; ?>assets/images/logo-dark.png" class="card-logo card-logo-dark" alt="logo dark" height="30">
                <img src="<?= $url; ?>assets/images/logo-light.png" class="card-logo card-logo-light" alt="logo light" height="20">
            </a>
        </div>
    </nav>
<?php }
function footer($url)
{
?>
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> UPPBJ Badan Layanan Umum
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        © Universitas Negeri Gorontalo
                    </div>
                </div>
            </div>
        </div>
    </footer>
<?php }
function sidebar_ppk($url)
{
?>
    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                        <span class="hamburger-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                </div>

                <div class="d-flex align-items-center">

                    <div class="dropdown ms-sm-3 header-item">
                        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-flex align-items-center">
                                <img class="rounded-circle header-profile-user" src="<?= $url; ?>assets/images/avatar-1.jpg" alt="Header Avatar">
                                <span class="text-start ms-xl-2">
                                    <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?= $_SESSION['nama']; ?></span>
                                    <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text"><?= $_SESSION['level']; ?></span>
                                </span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header">Welcome!</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= $url; ?>operator/profil"><i class="mdi mdi-face-agent text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profil</span></a>
                            <a class="dropdown-item" href="<?= $url; ?>operator/ganti/password"><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Ganti Password</span></a>
                            <a class="dropdown-item" href="<?= $url; ?>operator/logout"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ========== App Menu ========== -->
    <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <!-- Dark Logo-->
            <a href="index.html" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="<?= $url; ?>assets/images/logo-sm.png" alt="" height="40">
                </span>
                <span class="logo-lg">
                    <img src="<?= $url; ?>assets/images/logo-dark.png" alt="" height="35">
                </span>
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>

        <div id="scrollbar">
            <div class="container-fluid ">

                <div id="two-column-menu"></div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link fs-14 <?= @$_GET['aktif1']; ?>" href="<?= $url; ?>operator/beranda">
                            <i class="mdi mdi-home"></i> <span data-key="t-widgets">Beranda</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link fs-14 <?= @$_GET['aktif2']; ?>" href="<?= $url; ?>operator/user">
                            <i class="mdi mdi-account-lock"></i> <span data-key="t-widgets">User Management</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link fs-14 <?= @$_GET['aktif3']; ?>" href="<?= $url; ?>operator/penyedia">
                            <i class="mdi mdi-account-box-multiple"></i> <span data-key="t-widgets">Data Penyedia</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link fs-14 <?= @$_GET['aktif11']; ?>" href="<?= $url; ?>operator/evaluasi">
                            <i class="ri-checkbox-circle-line"></i> <span data-key="t-widgets">Evaluasi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link <?= @$_GET['aktif_1']; ?>" href="#pekerjaan" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="pekerjaan">
                            <i class="ri-truck-line"></i> <span data-key="t-dashboards">Pekerjaan</span>
                        </a>
                        <div class="collapse menu-dropdown <?= @$_GET['show1']; ?>" id="pekerjaan">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link menu-link fs-14 <?= @$_GET['aktif13']; ?>" href="<?= $url; ?>operator/paket-sirup">
                                        Buat Paket
                                    </a>
                                </li>
                                <?php
                                if ($_SESSION['level'] == 'Pokja') {
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link menu-link fs-14 <?= @$_GET['aktif10']; ?>" href="<?= $url; ?>operator/paket-pekerjaan">
                                            Paket Pekerjaan
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link menu-link fs-14 <?= @$_GET['aktif5']; ?>" href="<?= $url; ?>operator/dpt">
                                            Penyedia Terpilih
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link <?= @$_GET['aktif_2']; ?>" href="#informasi" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="informasi">
                            <i class="mdi mdi-information-outline"></i> <span data-key="t-dashboards">Informasi</span>
                        </a>
                        <div class="collapse menu-dropdown <?= @$_GET['show2']; ?>" id="informasi">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link menu-link fs-14 <?= @$_GET['aktif12']; ?>" href="<?= $url; ?>operator/news/update">
                                        News & Updates
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link fs-14 <?= @$_GET['aktif6']; ?>" href="<?= $url; ?>operator/info/penting">
                                        Info Penting
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link fs-14 <?= @$_GET['aktif8']; ?>" href="<?= $url; ?>operator/panduan">
                                        Panduan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link fs-14 <?= @$_GET['aktif9']; ?>" href="<?= $url; ?>operator/contact">
                                        Contact
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!--
                    <li class="nav-item">
                        <a class="nav-link menu-link fs-14 <?= @$_GET['aktif4']; ?>" href="<?= $url; ?>operator/satker">
                            <i class="mdi mdi-account-tie"></i> <span data-key="t-widgets">Update Satker</span>
                        </a>
                    </li>
                    -->
                </ul>
            </div>
            <!-- Sidebar -->
        </div>
        <div class="sidebar-background"></div>
    </div>
<?php }
function sidebar_pokja($url)
{
?>
    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                        <span class="hamburger-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                </div>

                <div class="d-flex align-items-center">

                    <div class="dropdown ms-sm-3 header-item">
                        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-flex align-items-center">
                                <img class="rounded-circle header-profile-user" src="<?= $url; ?>assets/images/avatar-1.jpg" alt="Header Avatar">
                                <span class="text-start ms-xl-2">
                                    <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?= $_SESSION['nama']; ?></span>
                                    <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text"><?= $_SESSION['level']; ?></span>
                                </span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header">Welcome!</h6>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= $url; ?>operator/profil"><i class="mdi mdi-face-agent text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profil</span></a>
                            <a class="dropdown-item" href="<?= $url; ?>operator/ganti/password"><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Ganti Password</span></a>
                            <a class="dropdown-item" href="<?= $url; ?>operator/logout"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ========== App Menu ========== -->
    <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <!-- Dark Logo-->
            <a href="index.html" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="<?= $url; ?>assets/images/logo-sm.png" alt="" height="40">
                </span>
                <span class="logo-lg">
                    <img src="<?= $url; ?>assets/images/logo-dark.png" alt="" height="35">
                </span>
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>

        <div id="scrollbar">
            <div class="container-fluid ">

                <div id="two-column-menu"></div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link fs-14 <?= @$_GET['aktif1']; ?>" href="<?= $url; ?>operator/beranda">
                            <i class="mdi mdi-home"></i> <span data-key="t-widgets">Beranda</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link fs-14 <?= @$_GET['aktif2']; ?>" href="<?= $url; ?>operator/user">
                            <i class="mdi mdi-account-lock"></i> <span data-key="t-widgets">User Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link fs-14 <?= @$_GET['aktif3']; ?>" href="<?= $url; ?>operator/penyedia">
                            <i class="mdi mdi-account-box-multiple"></i> <span data-key="t-widgets">Data Penyedia</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link fs-14 <?= @$_GET['aktif11']; ?>" href="<?= $url; ?>operator/evaluasi">
                            <i class="ri-checkbox-circle-line"></i> <span data-key="t-widgets">Evaluasi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link <?= @$_GET['aktif_1']; ?>" href="#pekerjaan" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="pekerjaan">
                            <i class="ri-truck-line"></i> <span data-key="t-dashboards">Pekerjaan</span>
                        </a>
                        <div class="collapse menu-dropdown <?= @$_GET['show1']; ?>" id="pekerjaan">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link menu-link fs-14 <?= @$_GET['aktif10']; ?>" href="<?= $url; ?>operator/paket-pekerjaan">
                                        Paket Pekerjaan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link fs-14 <?= @$_GET['aktif5']; ?>" href="<?= $url; ?>operator/dpt">
                                        Penyedia Terpilih
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link <?= @$_GET['aktif_2']; ?>" href="#informasi" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="informasi">
                            <i class="mdi mdi-information-outline"></i> <span data-key="t-dashboards">Informasi</span>
                        </a>
                        <div class="collapse menu-dropdown <?= @$_GET['show2']; ?>" id="informasi">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a class="nav-link menu-link fs-14 <?= @$_GET['aktif12']; ?>" href="<?= $url; ?>operator/news/update">
                                        News & Updates
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link fs-14 <?= @$_GET['aktif6']; ?>" href="<?= $url; ?>operator/info/penting">
                                        Info Penting
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link fs-14 <?= @$_GET['aktif8']; ?>" href="<?= $url; ?>operator/panduan">
                                        Panduan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link fs-14 <?= @$_GET['aktif9']; ?>" href="<?= $url; ?>operator/contact">
                                        Contact
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!--
                    <li class="nav-item">
                        <a class="nav-link menu-link fs-14 <?= @$_GET['aktif4']; ?>" href="<?= $url; ?>operator/satker">
                            <i class="mdi mdi-account-tie"></i> <span data-key="t-widgets">Update Satker</span>
                        </a>
                    </li>
                    -->
                </ul>
            </div>
            <!-- Sidebar -->
        </div>
        <div class="sidebar-background"></div>
    </div>
<?php } ?>