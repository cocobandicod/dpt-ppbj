<?php
function navbar($url)
{
?>
    <nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
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
                        <a class="nav-link fs-14 active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-14" href="#pengumuman">Pengumuman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-14" href="#infopenting">Info Penting</a>
                    </li>
                    <!--
                    <li class="nav-item">
                        <a class="nav-link fs-14" href="#regulasi">Regulasi</a>
                    </li>
                    -->
                    <li class="nav-item">
                        <a class="nav-link fs-14" href="#panduan">Panduan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-14" href="#contact">Contact</a>
                    </li>
                </ul>

                <div class="">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#loginModals" class="btn btn-success btn-sm">Login Penyedia</a>
                </div>
            </div>

        </div>
    </nav>
<?php
}
function navbar2($url)
{
?>
    <nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
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
                        <a class="nav-link fs-14 <?= @$_GET['aktif_1'] ?>" href="<?= $url; ?>beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-14 <?= @$_GET['aktif_2'] ?>" href="<?= $url; ?>pengumuman">Pengumuman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-14 <?= @$_GET['aktif_3'] ?>" href="<?= $url; ?>info/penting">Info Penting</a>
                    </li>
                    <!--
                    <li class="nav-item">
                        <a class="nav-link fs-14 <?= @$_GET['aktif_4'] ?>" href="<?= $url; ?>regulasi">Regulasi</a>
                    </li>
                    -->
                    <li class="nav-item">
                        <a class="nav-link fs-14 <?= @$_GET['aktif_5'] ?>" href="<?= $url; ?>panduan">Panduan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-14 <?= @$_GET['aktif_6'] ?>" href="<?= $url; ?>contact">Contact</a>
                    </li>
                </ul>
                <div class="">
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ri-map-pin-user-fill"></i> <?= $_SESSION['nama']; ?></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item small" href="<?= $url; ?>ganti/password"><i class="ri-lock-2-line"></i> Ganti Password</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item small" href="<?= $url; ?>logout"><i class="ri-logout-box-line"></i> Logout</a>
                        </div>
                    </div><!-- /btn-group -->
                </div>
            </div>

        </div>
    </nav>
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
<?php
}
function kiri($url, $proses)
{
    $notif1 = $proses->cek_row('catatan', 'id_profil = "' . $_SESSION['kode_profil'] . '" AND status = "Waiting"');
    $notif2 = $proses->cek_row('catatan', 'id_profil = "' . $_SESSION['kode_profil'] . '" AND status = "Verified"');
    $notif3 = $proses->cek_row('profil_badan_usaha', 'id_profil = "' . $_SESSION['kode_profil'] . '" AND status = "Terverifikasi"');
    if ($notif3) {
        $notif = '<i class="ri-checkbox-circle-fill text-success"></i>';
    } else {
        $notif = '<i class="ri-close-circle-fill text-danger"></i>';
    }
    if ($notif1 && $notif2) {
        $notif = '<span class="badge rounded-pill bg-danger">' . $notif1 . '</span>';
    }
?>
    <div class="mt-0 mx-n4 px-4 file-menu-sidebar-scroll" data-simplebar>
        <ul class="list-unstyled file-manager-menu">
            <li>
                <a href="<?= $url; ?>ubah/profil" class="<?= @$_GET['aktif1']; ?>"><i class="ri-file-list-2-line align-bottom me-2"></i> <span class="file-list-link">Ubah Profil</span></a>
            </li>
            <li>
                <a href="<?= $url; ?>dokumen/verifikasi" class="<?= @$_GET['aktif6']; ?>"><i class="ri-file-list-2-line align-bottom me-2"></i> <span class="file-list-link">Dokumen Verifikasi</span></a>
            </li>
            <li>
                <a data-bs-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample" class="<?= @$_GET['aktif2']; ?>">
                    <i class="ri-folder-2-line align-bottom me-2"></i> <span class="file-list-link">Syarat Pendaftaran</span>
                </a>
                <div class="collapse buka1" id="collapseExample1">
                    <ul class="sub-menu list-unstyled">
                        <li class="pt-2">
                            <a href="<?= $url; ?>syarat/izin/usaha" class="<?= @$_GET['aktif21']; ?>">Copy Surat Izin Usaha</a>
                        </li>
                        <li>
                            <a href="<?= $url; ?>syarat/npwp" class="<?= @$_GET['aktif22']; ?>">Copy NPWP</a>
                        </li>
                        <li>
                            <a href="<?= $url; ?>syarat/domisili" class="<?= @$_GET['aktif23']; ?>">Copy Surat Domisili</a>
                        </li>
                        <li>
                            <a href="<?= $url; ?>syarat/tdp" class="<?= @$_GET['aktif24']; ?>">Copy TDP</a>
                        </li>
                        <li>
                            <a href="<?= $url; ?>syarat/akta" class="<?= @$_GET['aktif25']; ?>">Copy Akta</a>
                        </li>
                        <li>
                            <a href="<?= $url; ?>syarat/pengurus" class="<?= @$_GET['aktif26']; ?>">Copy Pengurus</a>
                        </li>
                        <li>
                            <a href="<?= $url; ?>syarat/pemilik/saham" class="<?= @$_GET['aktif27']; ?>">Copy Pemilik Saham</a>
                        </li>
                        <li>
                            <a href="<?= $url; ?>syarat/pajak" class="<?= @$_GET['aktif28']; ?>">Copy Pajak</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample" class="<?= @$_GET['aktif3']; ?>">
                    <i class="ri-folder-2-line align-bottom me-2"></i> <span class="file-list-link">Syarat Kualifikasi Lainnya</span>
                </a>
                <div class="collapse buka2" id="collapseExample2">
                    <ul class="sub-menu list-unstyled">
                        <li class="pt-2">
                            <a href="<?= $url; ?>syarat/tenaga/ahli" class="<?= @$_GET['aktif31']; ?>">Tenaga Ahli</a>
                        </li>
                        <li>
                            <a href="<?= $url; ?>syarat/peralatan" class="<?= @$_GET['aktif32']; ?>">Peralatan</a>
                        </li>
                        <li>
                            <a href="<?= $url; ?>syarat/pengalaman" class="<?= @$_GET['aktif33']; ?>">Pengalaman</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="<?= $url; ?>company/profile" class="<?= @$_GET['aktif4']; ?>"><i class="ri-image-2-line align-bottom me-2"></i> <span class="file-list-link">Company Profile / CV</span></a>
            </li>
            <li>
                <a href="<?= $url; ?>status/verifikasi" class="<?= @$_GET['aktif5']; ?>"><i class="ri-file-unknow-line align-bottom me-2"></i><span class="file-list-link">Status Verifikasi </span>
                    <?= $notif; ?>
                </a>
            </li>
        </ul>
    </div>
<?php }
function footer($url)
{
?>
    <footer class="custom-footer bg-dark py-5 position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mt-12">
                    <div>
                        <div>
                            <img src="<?= $url; ?>assets/images/logo-light.png" alt="logo light" height="30">
                        </div>
                        <div class="mt-4">
                            <p>Daftar Penyedia Terpilih Pengelola Pengadaan Barang dan Jasa Universitas Negeri Gorontalo<br>
                                Alamat: Jl. Jend. Sudirman No.6, Dulalowo Tim., Kec. Kota Tengah, Kota Gorontalo, Gorontalo 96128</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row text-center text-sm-start align-items-center mt-0">
                <div class="col-sm-12">
                    <div>
                        <p class="copy-rights mb-0">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © Universitas Negeri Gorontalo
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<?php }
function sidebar($url)
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
                            <i class="mdi mdi-account-box-multiple"></i> <span data-key="t-widgets">Penyedia</span>
                        </a>
                    </li>
                    <!--
                    <li class="nav-item">
                        <a class="nav-link menu-link fs-14 <?= @$_GET['aktif4']; ?>" href="<?= $url; ?>operator/satker">
                            <i class="mdi mdi-account-tie"></i> <span data-key="t-widgets">Update Satker</span>
                        </a>
                    </li>
                    -->
                    <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Informasi</span></li>

                    <li class="nav-item">
                        <a class="nav-link menu-link fs-14 <?= @$_GET['aktif5']; ?>" href="<?= $url; ?>operator/pengumuman">
                            <i class="mdi mdi-information-outline"></i> <span data-key="t-widgets">Pengumuman</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link fs-14 <?= @$_GET['aktif6']; ?>" href="<?= $url; ?>operator/info/penting">
                            <i class="mdi mdi-comment-processing-outline"></i> <span data-key="t-widgets">Info Penting</span>
                        </a>
                    </li>
                    <!--
                    <li class="nav-item">
                        <a class="nav-link menu-link fs-14 <?= @$_GET['aktif7']; ?>" href="<?= $url; ?>operator/regulasi">
                            <i class="mdi mdi-newspaper-variant-outline"></i> <span data-key="t-widgets">Regulasi</span>
                        </a>
                    </li>
                    -->
                    <li class="nav-item">
                        <a class="nav-link menu-link fs-14 <?= @$_GET['aktif8']; ?>" href="<?= $url; ?>operator/panduan">
                            <i class="mdi mdi-bookmark-box-multiple-outline"></i> <span data-key="t-widgets">Panduan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link fs-14 <?= @$_GET['aktif9']; ?>" href="<?= $url; ?>operator/contact">
                            <i class="ri-contacts-book-2-line"></i> <span data-key="t-widgets">Contact</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Sidebar -->
        </div>

        <div class="sidebar-background"></div>
    </div>
<?php } ?>