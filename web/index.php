<?php
require_once('../config/koneksi.php');
require_once('../config/menu.php');
require_once('../config/fungsi_indotgl.php');
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = md5(uniqid(rand(), TRUE));
}
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Simpan Universitas Negeri Gorontalo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <meta content="Daftar Penyedia Terpilih Pengelola Pengadaan Barang dan Jasa Universitas Negeri Gorontalo" name="description" />
    <meta property='og:title' content='Daftar Penyedia Terpilih Pengelola Pengadaan Barang dan Jasa Universitas Negeri Gorontalo' />
    <meta property='og:image' content='<?= $url; ?>assets/images/logo-dark.png' />
    <meta property='og:description' content='SIstem Informasi Pengelola Pengadaan Barang dan Jasa' />
    <meta property='og:url' content='https://simpan.ung.my.id/' />
    <meta property='og:image:width' content='1200' />
    <meta property='og:image:height' content='627' />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= $url; ?>assets/images/icon.png">

    <!--Swiper slider css-->
    <link href="<?= $url; ?>assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

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
        <?= navbar($url); ?>
        <!-- end navbar -->

        <!-- start hero section -->
        <section class="section pb-0 hero-section" id="home">
            <div class="bg-overlay bg-overlay-pattern"></div>
            <div class="container">
                <div class="row justify-content-center pb-5">
                    <div class="col-lg-10 col-sm-10 mb-5 pb-lg-5">
                        <div class="text-center mt-lg-5 pt-5 pb-5 mb-lg-5">
                            <h1 class="display-6 fw-semibold mb-3 lh-base pt-5">Daftar Penyedia Terpilih<br><span class="text-success"> Pengelola Pengadaan Barang dan Jasa</span></h1>
                            <h2 class="pb-5">Universitas Negeri Gorontalo</h2>
                            <div class="hstack gap-2 justify-content-center">
                                <a href="#" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl" class="btn btn-success">Daftar Penyedia Badan Usaha</a>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!-- end row -->
            </div><!-- end container -->
        </section><!-- end hero section -->

        <!-- start wallet -->
        <section class="section" id="pengumuman">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="mb-5">
                            <h2 class="mb-3 fw-bold lh-base text-center">Pengumuman</h2>
                            <p class="text-muted text-center">Penyedia Pengadaan Langsung</p>
                            <table id="example" class="table table-bordered dt-responsive table-striped align-middle fs-12" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama Pekerjaan</th>
                                        <th>Nama Perusahaan</th>
                                        <th class="text-center">Nilai (Rp)</th>
                                        <th class="text-center">Tahun Anggaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = $proses->tampil_data_select('*', 'pengumuman', '1=1');
                                    $no = 1;
                                    foreach ($sql as $row) {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no; ?></td>
                                            <td><?= $row['pekerjaan']; ?></td>
                                            <td><?= $row['nama_perusahaan']; ?></td>
                                            <td class="text-end"><?= number_format($row['nilai']); ?></td>
                                            <td class="text-center"><?= $row['tahun_anggaran']; ?></td>
                                        </tr>
                                    <?php $no++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->

                <div class="row g-4">

                </div><!-- end row -->
            </div><!-- end container -->
        </section><!-- end wallet -->

        <section class="section bg-light" id="infopenting">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="text-center mb-5">
                            <h2 class="mb-3 fw-bold lh-base">Info Penting</h2>
                        </div>
                        <!-- Base Example -->
                        <div class="accordion" id="default-accordion-example">
                            <?php
                            $sql = $proses->tampil_data_select('*', 'info_penting', '1=1');
                            $no = 1;
                            foreach ($sql as $row) {
                            ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading<?= $no; ?>">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $no; ?>" aria-expanded="false" aria-controls="collapse<?= $no; ?>">
                                            <?= $row['judul']; ?>
                                        </button>
                                    </h2>
                                    <div id="collapse<?= $no; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $no; ?>" data-bs-parent="#default-accordion-example">
                                        <div class="accordion-body">
                                            <?= $row['isi']; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php $no++;
                            } ?>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
                <div class="row">

                </div>
            </div><!-- end container -->
        </section>

        <!-- start plan -->
        <section class="section" id="panduan">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="mb-5">
                            <h2 class="mb-3 fw-bold lh-base text-center">Panduan</h2>
                            <p class="text-muted text-center">Petunjuk penggunaan aplikasi dapat di download dibawah ini</p>
                            <?php
                            $sql = $proses->tampil_data_select('*', 'panduan', '1=1');
                            $no = 1;
                            foreach ($sql as $row) {
                            ?>
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="ri-checkbox-circle-fill text-success"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <?= $row['judul']; ?> <a href="<?= $url; ?>download/<?= $row['file']; ?>" target="_blank"><span class="badge text-bg-success">Download</span></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
                <div class="row">
                    <div class="col-lg-12">

                    </div>
                </div>
            </div><!-- end container -->
        </section>
        <!-- end plan -->

        <!-- Start footer -->
        <footer class="custom-footer bg-dark py-5 position-relative" id="contact">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mt-12">
                        <div>
                            <div>
                                <img src="<?= $url; ?>assets/images/logo-light.png" alt="logo light" height="30">
                            </div>
                            <div class="mt-4">
                                <p>UPPBJ Badan Layanan Umum Universitas Negeri Gorontalo<br>
                                    Alamat: Jl. Jend. Sudirman No.6, Dulalowo Timur, Kec. Kota Tengah, Kota Gorontalo, Gorontalo 96128</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row text-center text-sm-start align-items-center mt-5">
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
        <!-- end footer -->

        <!--start back-to-top-->
        <button onclick="topFunction()" class="btn btn-danger btn-icon landing-back-top" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
        <!--end back-to-top-->

    </div>
    <!-- end layout wrapper -->

    <div class="modal fade bs-example-modal-xl" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myExtraLargeModalLabel">Pendaftaran Penyedia Badan Usaha</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="pesan" class="kunci">
                    <div class="modal-body text-center pb-5">
                        <lord-icon src="https://cdn.lordicon.com/tqywkdcz.json" trigger="hover" style="width:150px;height:150px">
                        </lord-icon>
                        <h4 class="mb-3 mt-1">Pendaftaran Sukses!</h4>
                        <p>Terima kasih telah melakukan pendaftaran di Sistem Informasi Pengelola Pengadaan Barang dan Jasa<br>Universitas Negeri Gorontalo<br>
                            Aktivasi pendaftaran telah kami kirimkan ke alamat email
                        <h5 class="mail"></h5> silahkan periksa email anda untuk melakukan aktivasi, terima kasih</p>
                    </div>
                </div>
                <form id="daftar" method="POST" class="">
                    <div class="modal-body p-4">
                        <div class="tab-content text-muted row">
                            <div class="col-xxl-3 col-md-3 pb-5">
                                <div class="row">
                                    <h5>Akun Login Penyedia</h5>
                                    <p>Masukan username, email aktif anda</p>
                                    <div class="col-xxl-12 col-md-12">
                                        <div class="alert alert-danger alert-user small" role="alert" style="display:none;"></div>
                                        <div class="alert alert-danger alert-email small" role="alert" style="display:none;"></div>
                                        <div class="alert alert-danger alert-kode small" role="alert" style="display:none;"></div>
                                    </div>
                                    <div class="col-xxl-12 col-md-12 pt-2">
                                        <label for="basiInput" class="form-label">Username <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="username" required>
                                    </div>
                                    <div class="col-xxl-12 col-md-12 pt-2">
                                        <label for="basiInput" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" placeholder="example@gmail.com" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-9 col-md-9">
                                <div class="row">
                                    <h5>Profil Penyedia Badan Usaha</h5>
                                    <p>Masukan data profil badan usaha dengan lengkap dan benar</p>
                                    <div class="col-xl-6">
                                        <div class="col-xxl-12 col-md-12 pt-2">
                                            <label for="basiInput" class="form-label">NPWP <span class="text-danger">*</span></label>
                                            <input type="text" id="cleave-delimiters" class="form-control" name="npwp" placeholder="xx.xxx.xxx.x-xxx.xxx" required>
                                        </div>
                                        <div class="col-xxl-12 col-md-12 pt-2">
                                            <label for="basiInput" class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                                            <input type="text" name="nama_perusahaan" class="form-control" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-xxl-6 col-md-6 pt-2">
                                                <label for="basiInput" class="form-label">Badan Usaha <span class="text-danger">*</span></label>
                                                <?= badan_usaha('badan_usaha', ''); ?>
                                            </div>
                                            <div class="col-xxl-6 col-md-6 pt-2">
                                                <label for="basiInput" class="form-label">Status <span class="text-danger">*</span></label>
                                                <?= status_usaha('status_usaha', ''); ?>
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-md-12 pt-2">
                                            <label for="basiInput" class="form-label">Alamat <span class="text-danger">*</span></label>
                                            <textarea name="alamat" class="form-control" required></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-xxl-6 col-md-6 pt-2">
                                                <label for="basiInput" class="form-label">Provinsi <span class="text-danger">*</span></label>
                                                <input type="text" name="provinsi" class="form-control" required>
                                            </div>
                                            <div class="col-xxl-6 col-md-6 pt-2">
                                                <label for="basiInput" class="form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                                                <input type="text" name="kab_kota" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="row">
                                            <div class="col-xxl-6 col-md-6 pt-2">
                                                <label for="basiInput" class="form-label">Kode Pos <span class="text-danger">*</span></label>
                                                <input type="number" name="kode_pos" class="form-control" required>
                                            </div>
                                            <div class="col-xxl-6 col-md-6 pt-2">
                                                <label for="basiInput" class="form-label">Telepon / HP <span class="text-danger">*</span></label>
                                                <input type="number" name="telepon" class="form-control" required>
                                            </div>
                                            <div class="col-xxl-6 col-md-6 pt-2">
                                                <label for="basiInput" class="form-label">Fax</label>
                                                <input type="number" name="fax" class="form-control">
                                            </div>
                                            <div class="col-xxl-6 col-md-6 pt-2">
                                                <label for="basiInput" class="form-label">Website</label>
                                                <input type="text" name="website" class="form-control">
                                            </div>
                                            <div class="col-xxl-6 col-md-6 pt-2">
                                                <label for="basiInput" class="form-label">Nama Contact Person</label>
                                                <input type="text" name="contact_person" class="form-control">
                                            </div>
                                            <div class="col-xxl-6 col-md-6 pt-2">
                                                <label for="basiInput" class="form-label">Telepon / HP CP</label>
                                                <input type="number" name="telepon_cp" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xxl-6 col-md-6 pt-2">
                                                <label for="basiInput" class="form-label">Captcha</label>
                                                <img src="config/captcha.php" class="form-label" alt="PHP Captcha">
                                            </div>
                                            <div class="col-xxl-6 col-md-6 pt-2">
                                                <label for="basiInput" class="form-label">type code <span class="text-danger">*</span></label>
                                                <input type="number" name="captcha" class="form-control" placeholder="Jawaban" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal">Batal</a>
                        <button type="submit" id="tbldaftar" class="btn btn-success"><i class="ri-save-2-fill me-1 align-middle"></i> Ajukan Pendaftaran</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div id="loginModals" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 overflow-hidden">
                <div class="modal-body p-5">
                    <h5 class="mb-3">Login Penyedia</h5>
                    <div class="alert alert-success login-success" role="alert" style="display:none;"></div>
                    <div class="alert alert-danger login-danger" role="alert" style="display:none;"></div>
                    <form id="login">
                        <div class="mb-2">
                            <input type="text" class="form-control" name="username" id="username" placeholder="Masukan username" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Masukan password" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100" id="tblmasuk">Masuk</button>
                    </form>
                </div>
                <div class="modal-footer bg-light p-3 justify-content-center">
                    <p class="mb-0 text-muted">Universitas Negeri Gorontalo</p>
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

    <!--Swiper slider js-->
    <script src="<?= $url; ?>assets/libs/swiper/swiper-bundle.min.js"></script>
    <!-- cleave.js -->
    <script src="<?= $url; ?>assets/libs/cleave.js/cleave.min.js"></script>

    <script src="<?= $url; ?>assets/js/pages/form-masks.init.js"></script>

    <script src="<?= $url; ?>assets/js/pages/nft-landing.init.js"></script>
    <script src="<?= $url; ?>assets/js/ajax.js"></script>
    <script src="<?= $url; ?>assets/js/index.js"></script>
    <script>
        $(document).ready(function() {
            dataTable = $('#example').DataTable({
                stateSave: true,
                autoWidth: false,
                processing: true,
                ordering: false,
                responsive: true
            });
        });
    </script>
</body>

</html>