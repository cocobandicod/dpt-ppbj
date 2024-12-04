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
                                <form id="form_selesai">
                                    <?php
                                    // Mendapatkan parameter tahun dan kode_tender
                                    $tahun = $_GET['tahun'];
                                    $kode_tender = $_GET['rup'];
                                    $row = $proses->tampil_data_saja('*', 'paket_pekerjaan', '1=1 AND kode_paket = "' . $kode_tender . '"');
                                    $cek_setuju = $proses->tampil_data_saja('*', 'undangan_pokja', '1=1 AND kode_paket = "' . $kode_tender . '" AND id_operator = "' . $_SESSION['kode_user'] . '"');
                                    $jum = $proses->cek_count('undangan_pokja', '1=1 AND kode_paket = "' . $kode_tender . '" AND status = "Setuju"');
                                    ?>
                                    <input type="hidden" name="act" value="selesai_pokja">
                                    <input type="hidden" name="kode_paket" value="<?= @$kode_tender; ?>">
                                    <input type="hidden" name="id_operator" value="<?= @$_SESSION['kode_user']; ?>">
                                    <input type="hidden" name="jum" value="<?= @$jum; ?>">

                                    <div class="alert alert-success" role="alert">
                                        <strong>Penting</strong>
                                        <ol type="1" class="ps-3 mb-0">
                                            <li>Paket Tender belum bisa diumumkan jika isian belum dilengkapi</li>
                                            <li>Tender Harus dilakukan secera menyeluruh, jika ada tahap yang tidak dilalui (misalnya dilakukan secara manual akan menyebabkan status Tender menggantung dan berpotensi sebagai temuan Auditor</li>
                                        </ol>
                                    </div>
                                    <table class="table table-bordered fs-13">
                                        <tr>
                                            <td class="w-25">Kode Tender</td>
                                            <td class="w-25"><b><?= $row['kode_paket']; ?></b></td>
                                            <td class="w-25">
                                                Nilai HPS
                                            </td>
                                            <td class="w-25"><b>Rp. <?= number_format($row['nilai_hps'], 2, ',', '.'); ?></b> <a href="<?= $url; ?>pokja/daftar-paket/<?= $kode_tender; ?>/<?= $tahun; ?>/rincian-hps" class="btn btn-success btn-sm"><i class="ri-search-2-line"></i> Rincian HPS</a></td>
                                        </tr>
                                        <tr>
                                            <td class="w-25">Nama Paket</td>
                                            <td colspan="3"><b><?= $row['nama_pekerjaan']; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td class="w-25">Metode Pengadaan</td>
                                            <td colspan="3">
                                                <h5><span class="badge text-bg-secondary"><?= $row['jenis_pengadaan'], '-' . $row['metode_pengadaan'] . '-' . $row['metode_evaluasi']; ?></span></h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w-25">Kualifikasi Usaha</td>
                                            <td colspan="3">
                                                <div class="col-xl-4">
                                                    <?= grade('kualifikasi_usaha', @$row['kualifikasi_usaha']); ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w-25">Bentuk Usaha</td>
                                            <td colspan="3">
                                                <div class="col-xl-4">
                                                    <?= bentuk_usaha('bentuk_usaha', @$row['bentuk_usaha']); ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="w-25">Jadwal Tender</td>
                                            <td colspan="3">
                                                <?php
                                                $cek_jadwal = $proses->cek_count('jadwal', '1=1 AND kode_paket = "' . $kode_tender . '"');
                                                if (empty($cek_jadwal)) {
                                                    $jadwal = '<a href="' . $url . 'pokja/daftar-paket/' . $kode_tender . '/' . $tahun . '/jadwal"><span class="badge text-bg-danger fs-12">Belum Dibuat</span></a>';
                                                } else {
                                                    $jadwal = '<a href="' . $url . 'pokja/daftar-paket/' . $kode_tender . '/' . $tahun . '/jadwal"><span class="badge text-bg-success fs-12">Lihat Jadwal</span></a>';
                                                }
                                                echo $jadwal;
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Dokumen Pemilihan</td>
                                            <td colspan="3">
                                                <div class="dokumen_persiapan"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nota Dinas Kepala UKPBJ</td>
                                            <td colspan="3">
                                                <?php
                                                $cek = $proses->tampil_data_saja('*', 'undangan_pokja', '1=1 AND kode_paket = "' . $kode_tender . '" ORDER BY timestamp DESC');
                                                if (empty($cek['id'])) {
                                                    echo 'Tidak ada Nota Dinas';
                                                } else {
                                                    $file = '<a href="' . $url . 'berkas/' . $cek['file'] . '" class="btn btn-info btn-sm mb-0" target="_blank"><i class="ri-file-download-line"></i> Nota Dinas UKPBJ</a>';
                                                    echo '
                                                <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                                                    Dikirim Tanggal ' . tgl_indo7($cek['timestamp']) . '
                                                    ' . $file . '
                                                </div>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Undangan Review Dokumen Persiapan Pemilihan</td>
                                            <td colspan="3">
                                                <div class="kirim_ppk"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Berita Acara Hasil Review</td>
                                            <td colspan="3">
                                                <div class="berita_acara"></div>
                                            </td>
                                        </tr>
                                    </table>
                                    <h5>Status Persetujuan</h5>
                                    <div class="col-sm-12 pt-0 pb-2">
                                        <div class="card-radio">
                                            <label class="form-check-label">
                                                <table class="table table-sm fs-12 mb-0">
                                                    <thead>
                                                        <tr class="bg-light">
                                                            <th class="p-2">Anggota Pokja Pemilihan</th>
                                                            <th class="p-2 text-center" style="width:10%;">Status</th>
                                                            <th class="p-2">Tanggal Persetujuan</th>
                                                            <th class="p-2">Alasan Tidak Setuju</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                        $sql = $proses->tampil_data_select(
                                                            'a.status, a.tanggal, a.alasan, b.nama',
                                                            'undangan_pokja a LEFT JOIN operator b ON a.id_operator = b.id_operator',
                                                            '1=1 AND a.kode_paket = "' . $kode_tender . '"'
                                                        );
                                                        if (empty($sql)) {
                                                            echo '<tr><td class="p-2" colspan="4">Belum ada Data</td></tr>';
                                                        } else {
                                                            foreach ($sql as $row) {
                                                                if ($row['status'] == 'Tidak-Setuju') {
                                                                    $status = '<i class="ri-close-circle-fill text-danger fs-20"></i>';
                                                                } else if ($row['status'] == 'Setuju') {
                                                                    $status = '<i class="ri-checkbox-circle-fill text-success fs-20"></i>';
                                                                } else {
                                                                    $status = '<span class="badge bg-danger fs-11">Belum Memeriksa</span>';
                                                                }
                                                        ?>
                                                                <tr>
                                                                    <td class="p-2"><?= $row['nama']; ?></td>
                                                                    <td class="p-2 text-center"><?= $status; ?></td>
                                                                    <td class="p-2"><?= tgl_indo8($row['tanggal']); ?></td>
                                                                    <td class="p-2"><?= $row['alasan']; ?></td>
                                                                </tr>
                                                        <?php }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </label>
                                        </div>
                                    </div>

                                    <h5>Persetujuan</h5>
                                    <div class="col-sm-12 pt-0 pb-2">
                                        <div class="card-radio">
                                            <label class="form-check-label fs-12 p-3">
                                                <?php
                                                if (empty($cek_setuju['status'])) {
                                                ?>
                                                    <h5 class="text-center">FAKTA INTEGRITAS</h5>
                                                    Saya menyetujui bahwa
                                                    <ol type="1">
                                                        <li>Tidak akan melakukan praktik korupsi, kolusi dan/atau nepotisme</li>
                                                        <li>Akan melaporkan kepada PA/KPA/APIP jika mengetahui terjadinya praktik Korupsi, Kolusi dan Nepotisme dalam proses pengadaan ini</li>
                                                        <li>Akan mengikuti proses pengadaan secara bersih, transparan, dan profesional untuk memberikan hasil kerja terbaik sesuai ketentuan peraturan perundang-undangan; dan</li>
                                                        <li>Apabila melanggar hal yang dinyatakan dalam angka 1), 2), dan 3) maka bersedia menerima sanksi sesuai dengan peraturan perundang-undangan</li>
                                                    </ol>
                                                    <p>Pakta Integritas merupakan bagian yang tidak terpisahkan dari Paket ini. Dengan mengumumkan Paket ini. Anda telah dianggap menyetujui. Pakta Integritas.</p>
                                                    <p class="mb-0">Alasan Tidak Setuju</p>
                                                    <textarea name="alasan" class="form-control mb-3" placeholder="Berikan tanda - jika anda setuju" required></textarea>
                                                    <button class="btn btn-success" data-nama="Setuju" data-status="Setuju" type="submit"><i class="ri-checkbox-circle-line"></i> Setuju</button>
                                                    <button class="btn btn-danger" data-nama="Tidak Setuju" data-status="Tidak-Setuju" type="submit"><i class="ri-close-circle-line"></i> Tidak Setuju</button>
                                                <?php } else {
                                                    echo '<button class="btn btn-danger" data-nama="Pembatalan Persetujuan" data-status="pembatalan" type="submit"><i class="ri-close-circle-line"></i> Pembatalan Persetujuan</button>';
                                                } ?>
                                            </label>
                                        </div>
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
    <div id="DetailModal" class="modal zoomIn" data-bs-backdrop="static" tabindex="-1">
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
                    if (judul == 'dokumen_persiapan') {
                        $('.dokumen_persiapan').html(data);
                    }
                    if (judul == 'berita_acara') {
                        $('.berita_acara').html(data);
                    }
                    if (judul == 'pokja') {
                        $('.pokja').html(data);
                    }
                    if (judul == 'kirim_ppk') {
                        $('.kirim_ppk').html(data);
                    }
                },
            });
        };

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
                    detail_upload('dokumen_persiapan');
                    detail_upload('berita_acara');
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

        $(document).on('submit', '#form_selesai', function(event) {
            event.preventDefault(); // Hentikan submit form default

            // Ambil tombol yang diklik
            var button = $(document.activeElement);
            var nama = button.data('nama'); // Ambil data-nama dari tombol
            var status = button.data('status'); // Ambil data-status dari tombol

            Swal.fire({
                html: `
                <div class="mt-3">
                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" 
                        colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px">
                    </lord-icon>
                    <div class="mt-4 pt-2 fs-15">
                        <h4>${nama}!</h4>
                        <p class="text-muted mx-4 mb-0">Apakah anda yakin ${nama} tender ini?</p>
                    </div>
                </div>`,
                showCancelButton: true,
                confirmButtonClass: "btn btn-danger w-xs me-2 mt-2",
                cancelButtonClass: "btn btn-primary w-xs mt-2",
                confirmButtonText: "Ya!",
                cancelButtonText: "Batal!",
                buttonsStyling: false,
                showCloseButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Ambil data dari form
                    var form = $('#form_selesai')[0];
                    var formData = new FormData(form);

                    // Tambahkan status ke form data
                    formData.append('status', status);

                    $.ajax({
                        type: 'POST',
                        url: '<?= $url; ?>pokja/proses/paket/pekerjaan',
                        processData: false,
                        contentType: false,
                        cache: false,
                        data: formData,
                        beforeSend: function() {
                            button.html('<i class="mdi mdi-spin mdi-loading align-middle ms-1"></i> Loading...');
                        },
                        success: function(response) {
                            Toastify({
                                text: "Proses Berhasil!",
                                className: "bg-success",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            Toastify({
                                text: "Proses Gagal!",
                                className: "bg-danger",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                        },
                        complete: function() {
                            button.html(`<i class="${button.find('i').attr('class')}"></i> ${nama}`);
                        }
                    });
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
                            $('#DetailModal').modal('toggle');
                            detail_upload('dokumen_persiapan');
                            detail_upload('berita_acara');
                            Toastify({
                                text: "Data Berhasil Dihapus!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                        }
                    });
                }
            });
        });

        $(document).on('submit', '#kirim_email', function(event) {
            event.preventDefault();
            Swal.fire({
                html: '<div class="mt-3"><div class="avatar-lg mx-auto"><div class="avatar-title bg-light text-success display-5 rounded-circle"><i class="ri-mail-send-fill"></i></div></div><div class="mt-4 pt-2 fs-15"><h4 class="fs-20 fw-semibold">Kirim Undangan</h4><p class="text-muted mb-0 mt-3 fs-13">Undangan akan di kirimkan ke email penerima</p></div></div>',
                //title: "Apakah anda yakin akan kirim pemberitahuan ini?",
                //text: '',
                //icon: "info",
                showCancelButton: !0,
                confirmButtonClass: "btn btn-danger w-xs me-2 mt-2",
                cancelButtonClass: "btn btn-primary w-xs mt-2",
                confirmButtonText: "Kirim!",
                cancelButtonText: "Batal!",
                buttonsStyling: !1,
                showCloseButton: !0
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#kirim_email')[0];
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
                                text: "Email Berhasil Dikirim!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                            $('#DetailModal').modal('toggle');
                            detail_upload('kirim_ppk');
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            Toastify({
                                text: "Email Gagal Dikirim!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                        },
                        complete: function(data) {
                            document.querySelector('#simpan').innerHTML = '<i class="ri-mail-send-line ms-1"></i> Kirim';
                        }
                    });
                }
            });
        });

        $(document).ready(function() {
            detail_upload('dokumen_persiapan');
            detail_upload('berita_acara');
            detail_upload('pokja');
            detail_upload('kirim_ppk');
        });

        $(document).on('click', '.status', function(e) {
            var sts = $(e.currentTarget).data('sts');
            var id = $(e.currentTarget).data('id');
            var nama = $(e.currentTarget).data('nama');
            Swal.fire({
                title: "Apakah Status Paket ini!",
                text: nama,
                icon: "info",
                showCancelButton: !0,
                confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                cancelButtonClass: "btn btn-danger w-xs mt-2",
                confirmButtonText: "Ya!",
                cancelButtonText: "Tidak!",
                buttonsStyling: !1,
                showCloseButton: !0
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'post',
                        url: '<?= $url; ?>pokja/proses/paket/pekerjaan',
                        data: {
                            id: id,
                            sts: sts,
                            act: 'status_paket'
                        },
                        success: function(data) {
                            Toastify({
                                text: "Status Berhasil Dibuat!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                            detail_upload('status_paket');
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            Toastify({
                                text: "Status Gagal Dibuat!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                        },
                    });
                }
            });
        });

        $(document).on('click', '#terapkan', function(e) {
            var nama = $(e.currentTarget).data('nama');
            var id = $(e.currentTarget).data('id');
            var operator = $(e.currentTarget).data('operator');
            Swal.fire({
                title: "Anda akan memilih POKJA ini?",
                text: nama,
                icon: "info",
                showCancelButton: !0,
                confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                cancelButtonClass: "btn btn-danger w-xs mt-2",
                confirmButtonText: "Ya!",
                cancelButtonText: "Tidak!",
                buttonsStyling: !1,
                showCloseButton: !0
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'post',
                        url: '<?= $url; ?>pokja/proses/paket/pekerjaan',
                        data: {
                            id: id,
                            nama: nama,
                            operator: operator,
                            act: 'pilih_pokja'
                        },
                        success: function(data) {
                            Toastify({
                                text: "Paket Berhasil Dibuat!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                            $('#DetailModal').modal('toggle');
                            detail_upload('pokja');
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            Toastify({
                                text: "Paket Gagal Dibuat!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                        },
                    });
                }
            });
        });

        $(document).on('click', '#hapus_pokja', function(e) {
            var id = $(e.currentTarget).data('id');
            Swal.fire({
                title: "Anda akan membatalkan Pokja ini?",
                text: '',
                icon: "info",
                showCancelButton: !0,
                confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                cancelButtonClass: "btn btn-danger w-xs mt-2",
                confirmButtonText: "Ya!",
                cancelButtonText: "Tidak!",
                buttonsStyling: !1,
                showCloseButton: !0
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'post',
                        url: '<?= $url; ?>pokja/proses/paket/pekerjaan',
                        data: {
                            id: id,
                            act: 'hapus_pokja'
                        },
                        success: function(data) {
                            Toastify({
                                text: "UKPBJ Berhasil Dibatalkan!",
                                gravity: "top",
                                position: "center",
                                duration: 3000
                            }).showToast();
                            detail_upload('pokja');
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            Toastify({
                                text: "Paket Gagal Dibuat!",
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