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
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>Simpan Universitas Negeri Gorontalo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <meta content="Sistem Informasi Penyedia Barang dan Jasa Universitas Negeri Gorontalo" name="description" />
    <meta property="og:image" content="<?= $url; ?>assets/images/logo-dark.png" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= $url; ?>assets/images/icon.png">

    <!--Swiper slider css-->
    <link href="<?= $url; ?>assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

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
    <style>
        .kunci {
            display: none;
            visibility: hidden;
        }
    </style>

</head>

<body data-bs-spy="scroll" data-bs-target="#navbar-example">

    <!-- Begin page -->
    <div class="layout-wrapper landing">
        <?= navbar2($url); ?>
        <!-- end navbar -->

        <!-- start hero section -->
        <section class="section pb-0 hero-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mt-12">
                        <div class="row">
                            <div class="col-lg-3 mt-3">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Menu</h4>
                                    </div><!-- end card header -->
                                    <div class="card-body small">
                                        <?= kiri($url, $proses); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9 mt-3">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1"><?= str_replace('-', ' ', $_GET['judul']); ?></h4>
                                    </div><!-- end card header -->
                                    <div class="card-body small">
                                        <form id="form">
                                            <?php
                                            $row = $proses->tampil_data_saja('*', 'profil_badan_usaha', 'id_profil = "' . $_SESSION['kode_profil'] . '"');
                                            $p = $proses->tampil_data_saja('email', 'akun_penyedia', 'id_akun = "' . $_SESSION['kode_profil'] . '"');
                                            ?>
                                            <div class="row pt-2">
                                                <div class="col-xl-6">
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">NPWP *</label>
                                                        <input type="hidden" name="id" value="<?= $row['id_profil']; ?>">
                                                        <input type="text" id="cleave-delimiters" class="form-control" name="npwp" value="<?= $row['npwp']; ?>" placeholder="xx.xxx.xxx.x-xxx.xxx" required>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Badan Usaha *</label>
                                                        <?= badan_usaha('badan_usaha', $row['badan_usaha']); ?>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Nama Perusahaan *</label>
                                                        <input type="text" name="nama_perusahaan" value="<?= $row['nama_perusahaan']; ?>" class="form-control" required>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Status *</label>
                                                        <?= status_usaha('status_usaha', $row['status_usaha']); ?>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Alamat *</label>
                                                        <textarea name="alamat" class="form-control" required><?= $row['alamat']; ?></textarea>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Provinsi *</label>
                                                        <input type="text" name="provinsi" value="<?= $row['provinsi']; ?>" class="form-control" required>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Kabupaten/Kota *</label>
                                                        <input type="text" name="kab_kota" value="<?= $row['kab_kota']; ?>" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Email</label>
                                                        <input type="email" name="kode_pos" value="<?= $p['email']; ?>" class="form-control" disabled>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Kode Pos *</label>
                                                        <input type="number" name="kode_pos" value="<?= $row['kode_pos']; ?>" class="form-control" required>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Telepon / HP / Whatsapp *</label>
                                                        <input type="number" name="telepon" value="<?= $row['telepon']; ?>" class="form-control" required>
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Fax</label>
                                                        <input type="number" name="fax" value="<?= $row['fax']; ?>" class="form-control">
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Website</label>
                                                        <input type="text" name="website" value="<?= $row['website']; ?>" class="form-control">
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Nama Contact Person</label>
                                                        <input type="text" name="contact_person" value="<?= $row['contact_person']; ?>" class="form-control">
                                                    </div>
                                                    <div class="col-xxl-12 col-md-12 pt-2">
                                                        <label for="basiInput" class="form-label">Telepon / HP CP / Whatsapp</label>
                                                        <input type="number" name="telepon_cp" value="<?= $row['telepon_cp']; ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 pt-5">
                                                <div class="text-start">
                                                    <a href="#" class="btn btn-light" onclick="back()"><i class=" ri-arrow-go-back-line"></i> Kembali</a>
                                                    <button type="submit" class="btn btn-primary" id="simpan"><i class="ri-save-2-fill"></i> Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end container -->
        </section><!-- end hero section -->

        <!-- Start footer -->
        <?= footer($url); ?>
        <!-- end footer -->

        <!--start back-to-top-->
        <button onclick="topFunction()" class="btn btn-danger btn-icon landing-back-top" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->

    </div>
    <!-- end layout wrapper -->


    <!-- JAVASCRIPT -->
    <script src="<?= $url; ?>assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?= $url; ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $url; ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= $url; ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= $url; ?>assets/libs/feather-icons/feather.min.js"></script>
    <script src="<?= $url; ?>assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="<?= $url; ?>assets/js/toastify-js.js"></script>

    <!--Swiper slider js-->
    <script src="<?= $url; ?>assets/libs/swiper/swiper-bundle.min.js"></script>
    <!-- cleave.js -->
    <script src="<?= $url; ?>assets/libs/cleave.js/cleave.min.js"></script>

    <script src="<?= $url; ?>assets/js/pages/form-masks.init.js"></script>

    <script src="<?= $url; ?>assets/js/pages/nft-landing.init.js"></script>
    <script src="<?= $url; ?>assets/js/ajax.js"></script>
    <script>
        function back() {
            history.go(-1);
        }

        $(document).on('submit', '#form', function(event) {
            event.preventDefault();
            var form = $('#form')[0];
            var nilai = new FormData(form);
            $.ajax({
                type: 'POST',
                url: '<?= $url; ?>proses/profil',
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
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    Toastify({
                        text: "Data Gagal Dimasukan!",
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
    </script>
</body>

</html>