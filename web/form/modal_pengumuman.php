<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/menu.php');
require_once('../../config/fungsi_indotgl.php');
require_once('../../config/cek_ajax.php');
?>
<?php
if ($_POST['act'] == 'pengumuman') {
    $today = date('Y-m-d');
    $s = $proses->tampil_data_saja('*', 'paket_pekerjaan', '1=1 AND id_paket = "' . $_POST['id'] . '"');
    $p = $proses->tampil_data_saja('GROUP_CONCAT(CONCAT("<span class=\"badge bg-success mb-1\">", tahap, "</span>") SEPARATOR " ") as pengumuman', 'jadwal_paket', '1=1 AND id_paket = "' . $s['id_paket'] . '" AND "' . $today . '" BETWEEN DATE(tgl_mulai) AND DATE(tgl_selesai)');
    $judul = 'Detail Pengumuman DPT';
?>
    <div class="modal-header">
        <h5 class="modal-title"><?= $judul; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-3">
        <center id="wait"><i class="icon-spinner2 spinner mr-1"></i> Loading..</center>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td style="width: 20%;">Nama Pekerjaan</td>
                        <td><?= @$s['nama_pekerjaan']; ?></td>
                    </tr>
                    <tr>
                        <td>Lokasi Pekerjaan</td>
                        <td><?= @$s['lokasi_pekerjaan']; ?></td>
                    </tr>
                    <tr>
                        <td>Uraian Singkat</td>
                        <td><?= @$s['uraian_singkat']; ?></td>
                    </tr>
                    <tr>
                        <td>Sumber Dana</td>
                        <td><?= @$s['nama_pekerjaan']; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Pembuatan</td>
                        <td><?= @$s['tanggal']; ?></td>
                    </tr>
                    <tr>
                        <td>Tahapan Saat Ini</td>
                        <td><?= $p['pengumuman']; ?></td>
                    </tr>
                    <tr>
                        <td>Tahun Anggaran</td>
                        <td><?= @$s['tahun_anggaran']; ?></td>
                    </tr>
                    <tr>
                        <td>Nilai Pagu</td>
                        <td>Rp. <?= number_format(@$s['nilai_pagu']); ?></td>
                    </tr>
                    <tr>
                        <td>Nilai HPS</td>
                        <td>Rp. <?= number_format(@$s['nilai_hps']); ?></td>
                    </tr>
                    <tr>
                        <td>Kualifikasi Usaha</td>
                        <td><?= @$s['kualifikasi_usaha']; ?></td>
                    </tr>
                    <tr>
                        <td>Syarat Kualifikasi</td>
                        <td>
                            <?= @$s['syarat_kualifikasi']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0);" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
    </div>
<?php }
if ($_POST['act'] == 'jadwal') {
    $today = date('Y-m-d');
    $judul = 'Detail Tahapan Saat Ini';
?>
    <div class="modal-header">
        <h5 class="modal-title"><?= $judul; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-3">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <th style="width: 3%;">No</th>
                    <th>Tahap</th>
                    <th>Mulai</th>
                    <th>Sampai</th>
                </thead>
                <tbody>
                    <?php
                    $sql = $proses->tampil_data_select(
                        'id_jadwal, 
                        CASE WHEN CURDATE() BETWEEN DATE(tgl_mulai) AND DATE(tgl_selesai) 
                        THEN CONCAT("<b>", tahap, "</b>") 
                        ELSE tahap 
                        END AS tahap,
                        tgl_mulai, 
                        tgl_selesai',
                        'jadwal_paket',
                        '1=1 
                        AND id_paket = "' . $_POST['id'] . '" 
                        ORDER BY id_jadwal ASC'
                    );
                    $no = 1;
                    foreach ($sql as $row) {
                    ?>
                        <tr>
                            <td class="text-center"><?= $no; ?>.</td>
                            <td><?= str_replace('-', ' ', $row['tahap']); ?></td>
                            <td><?= tgl_indo5($row['tgl_mulai']); ?></td>
                            <td><?= tgl_indo5($row['tgl_selesai']); ?></td>
                        </tr>
                    <?php $no++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0);" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
    </div>
<?php }
if ($_POST['act'] == 'penyedia') {
    $today = date('Y-m-d');
    $judul = 'Daftar Penyedia Terpilih';
    $s = $proses->tampil_data_saja('*', 'paket_pekerjaan', '1=1 AND id_paket = "' . $_POST['id'] . '"');
?>
    <div class="modal-header">
        <h5 class="modal-title"><?= $judul; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-3">
        <div class="table-responsive">
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
            <table id="tabel" class="table table-bordered dt-responsive table-striped align-middle fs-14">
                <thead>
                    <th style="width: 3%;">No</th>
                    <th>Penyedia</th>
                    <th>Alamat</th>
                </thead>
                <tbody>
                    <?php
                    $sql = $proses->tampil_data_select(
                        'b.nama_perusahaan, b.alamat',
                        'daftar_penyedia_terpilih a
                        LEFT JOIN profil_badan_usaha b
                        ON a.id_profil = b.id_profil',
                        '1=1 AND a.id_paket = "' . $_POST['id'] . '"'
                    );
                    $no = 1;
                    foreach ($sql as $row) {
                    ?>
                        <tr>
                            <td class="text-center"><?= $no; ?>.</td>
                            <td><?= $row['nama_perusahaan']; ?></td>
                            <td><?= $row['alamat']; ?></td>
                        </tr>
                    <?php $no++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0);" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
    </div>
    <script>
        $(document).ready(function() {
            dataTable = $('#tabel').DataTable({
                stateSave: true,
                autoWidth: false,
                processing: true,
                ordering: false,
                responsive: true
            });
        });
    </script>
<?php }
if ($_POST['act'] == 'evaluasi') {
    $today = date('Y-m-d');
    $judul = 'Hasil Pengadaan';
    $s = $proses->tampil_data_saja('*', 'paket_pekerjaan', '1=1 AND id_paket = "' . $_POST['id'] . '"');
    $p = $proses->tampil_data_saja('GROUP_CONCAT(CONCAT("<span class=\"badge bg-success mb-1\">", tahap, "</span>") SEPARATOR " ") as pengumuman', 'jadwal_paket', '1=1 AND id_paket = "' . $s['id_paket'] . '" AND "' . $today . '" BETWEEN DATE(tgl_mulai) AND DATE(tgl_selesai)');
?>
    <div class="modal-header">
        <h5 class="modal-title"><?= $judul; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-3">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#menu1" role="tab" aria-selected="false">
                    Pengumuman
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#menu2" role="tab" aria-selected="false">
                    Peserta
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#menu3" role="tab" aria-selected="false">
                    Hasil Evaluasi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#menu4" role="tab" aria-selected="true">
                    Pemenang Berkontrak
                </a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content  text-muted">
            <div class="tab-pane active" id="menu1" role="tabpanel">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td style="width: 20%;">Nama Pekerjaan</td>
                            <td><?= @$s['nama_pekerjaan']; ?></td>
                        </tr>
                        <tr>
                            <td>Lokasi Pekerjaan</td>
                            <td><?= @$s['lokasi_pekerjaan']; ?></td>
                        </tr>
                        <tr>
                            <td>Uraian Singkat</td>
                            <td><?= @$s['uraian_singkat']; ?></td>
                        </tr>
                        <tr>
                            <td>Sumber Dana</td>
                            <td><?= @$s['nama_pekerjaan']; ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Pembuatan</td>
                            <td><?= @$s['tanggal']; ?></td>
                        </tr>
                        <tr>
                            <td>Tahapan Saat Ini</td>
                            <td><?= $p['pengumuman']; ?></td>
                        </tr>
                        <tr>
                            <td>Tahun Anggaran</td>
                            <td><?= @$s['tahun_anggaran']; ?></td>
                        </tr>
                        <tr>
                            <td>Nilai Pagu</td>
                            <td>Rp. <?= number_format(@$s['nilai_pagu']); ?></td>
                        </tr>
                        <tr>
                            <td>Nilai HPS</td>
                            <td>Rp. <?= number_format(@$s['nilai_hps']); ?></td>
                        </tr>
                        <tr>
                            <td>Kualifikasi Usaha</td>
                            <td><?= @$s['kualifikasi_usaha']; ?></td>
                        </tr>
                        <tr>
                            <td>Syarat Kualifikasi</td>
                            <td>
                                <?= @$s['syarat_kualifikasi']; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane " id="menu2" role="tabpanel">
                <table id="tabel" class="table table-bordered dt-responsive table-striped align-middle fs-14">
                    <thead>
                        <th style="width: 3%;">No</th>
                        <th>Penyedia</th>
                        <th>Harga Penawaran</th>
                        <th>Harga Terkoreksi</th>
                        <th>Keterangan</th>
                    </thead>
                    <tbody>
                        <?php
                        $sql = $proses->tampil_data_select(
                            'b.nama_perusahaan, b.alamat',
                            'daftar_penyedia_terpilih a
                            LEFT JOIN profil_badan_usaha b
                            ON a.id_profil = b.id_profil',
                            '1=1 AND a.id_paket = "' . $_POST['id'] . '"'
                        );
                        $no = 1;
                        foreach ($sql as $row) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $no; ?>.</td>
                                <td><?= $row['nama_perusahaan']; ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php $no++;
                        } ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="menu3" role="tabpanel">
                <div class="table-responsive">
                    <table id="tabel2" class="table table-bordered dt-responsive table-striped align-middle fs-14">
                        <thead>
                            <th style="width: 3%;">No</th>
                            <th>Penyedia</th>
                            <th>K</th>
                            <th>B</th>
                            <th>A</th>
                            <th>T</th>
                            <th>P</th>
                            <th>PT</th>
                            <th>Hasil Negosiasi</th>
                            <th>H</th>
                            <th>P</th>
                            <th>PK</th>
                            <th>Keterangan</th>
                        </thead>
                        <tbody>
                            <?php
                            $sql = $proses->tampil_data_select(
                                'b.nama_perusahaan, b.alamat',
                                'daftar_penyedia_terpilih a
                            LEFT JOIN profil_badan_usaha b
                            ON a.id_profil = b.id_profil',
                                '1=1 AND a.id_paket = "' . $_POST['id'] . '"'
                            );
                            $no = 1;
                            foreach ($sql as $row) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no; ?>.</td>
                                    <td><?= $row['nama_perusahaan']; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php $no++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="menu4" role="tabpanel">
                <table class="table table-bordered">
                    <thead>
                        <th style="width: 3%;">No.</th>
                        <th>Nama Penyedia</th>
                        <th>Alamat</th>
                        <th>Harga Kontrak</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0);" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
    </div>
    <script>
        $(document).ready(function() {
            dataTable = $('#tabel').DataTable({
                stateSave: true,
                autoWidth: false,
                processing: true,
                ordering: false,
                responsive: true
            });
        });
    </script>
<?php } else if ($_POST['act'] == 'ikut') {
    $today = date('Y-m-d');
    $s = $proses->tampil_data_saja('*', 'paket_pekerjaan', '1=1 AND id_paket = "' . $_POST['id'] . '"');
    $p = $proses->tampil_data_saja('GROUP_CONCAT(CONCAT("<span class=\"badge bg-success mb-1\">", tahap, "</span>") SEPARATOR " ") as pengumuman', 'jadwal_paket', '1=1 AND id_paket = "' . $s['id_paket'] . '" AND "' . $today . '" BETWEEN DATE(tgl_mulai) AND DATE(tgl_selesai)');
    $judul = 'Pendaftaran Paket Pekerjaan';
?>
    <div class="modal-header">
        <h5 class="modal-title"><?= $judul; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-3">
        <center id="wait"><i class="icon-spinner2 spinner mr-1"></i> Loading..</center>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td style="width: 20%;">Nama Pekerjaan</td>
                        <td><?= @$s['nama_pekerjaan']; ?></td>
                    </tr>
                    <tr>
                        <td>Lokasi Pekerjaan</td>
                        <td><?= @$s['lokasi_pekerjaan']; ?></td>
                    </tr>
                    <tr>
                        <td>Uraian Singkat</td>
                        <td><?= @$s['uraian_singkat']; ?></td>
                    </tr>
                    <tr>
                        <td>Sumber Dana</td>
                        <td><?= @$s['nama_pekerjaan']; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Pembuatan</td>
                        <td><?= tgl_indo(@$s['tanggal']); ?></td>
                    </tr>
                    <tr>
                        <td>Tahapan Saat Ini</td>
                        <td><?= $p['pengumuman']; ?></td>
                    </tr>
                    <tr>
                        <td>Tahun Anggaran</td>
                        <td><?= @$s['tahun_anggaran']; ?></td>
                    </tr>
                    <tr>
                        <td>Nilai Pagu</td>
                        <td>Rp. <?= number_format(@$s['nilai_pagu']); ?></td>
                    </tr>
                    <tr>
                        <td>Nilai HPS</td>
                        <td>Rp. <?= number_format(@$s['nilai_hps']); ?></td>
                    </tr>
                    <tr>
                        <td>Kualifikasi Usaha</td>
                        <td><?= @$s['kualifikasi_usaha']; ?></td>
                    </tr>
                    <tr>
                        <td>Syarat Kualifikasi</td>
                        <td>
                            <?= @$s['syarat_kualifikasi']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <center>
                                <h5>PAKTA INTEGRITAS</h5>
                            </center>
                            <p class="mb-0">Untuk mengikuti pengadaan, Anda harus membaca dan menyetujui Pakta Integritas dibawah ini</p>
                            Saya menyetuji bahwa
                            <ol type="1">
                                <li>Tidak akan melakukan praktek Korupsi, Kolusi, dan/atau Nepotisme;</li>
                                <li>Akan melaporkan kepada PA/KPA/APIP jika mengetahui terjadinya praktik Korupsi, Kolusi, dan/atau Nepotisme dalam proses pengadaan ini</li>
                                <li>Akan mengikuti proses pengadaan secara bersih transparan, dan profesional untuk memberikan hasil kerja terbaik sesuai ketentuan</li>
                                <li>Apabila melanggar hal-hal yang dinyatakan dalam angka 1),2) dan 3) maka bersedia menerima sanksi sesuai dengan peraturan perundang-undangan</li>
                            </ol>
                            <button id="ikuttender" data-paket="<?= $_POST['id']; ?>" data-profil="<?= $_POST['profil']; ?>" data-act="daftar" class="btn btn-success simpan"><i class="ri-save-3-line align-middle ms-1"></i> Setuju & Ikut</button>
                            <button class="btn btn-light" data-bs-dismiss="modal">Tidak Setuju</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0);" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
    </div>
    <script>
        $('#ikuttender').on('click', function(e) {
            var profil = $(e.currentTarget).data('profil');
            var paket = $(e.currentTarget).data('paket');
            var act = $(e.currentTarget).data('act');
            Swal.fire({
                title: "Perhatian!",
                text: 'Apakah anda yakin untuk mengikuti tender ini?',
                icon: "info",
                showCancelButton: !0,
                confirmButtonClass: "btn btn-danger w-xs me-2 mt-2",
                cancelButtonClass: "btn btn-primary w-xs mt-2",
                confirmButtonText: "Ya!",
                cancelButtonText: "Tidak!",
                buttonsStyling: !1,
                showCloseButton: !0
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'post',
                        url: '<?= $url; ?>proses/paket/pekerjaan',
                        data: {
                            act: act,
                            paket: paket,
                            profil: profil
                        },
                        beforeSend: function() {
                            document.querySelector('.simpan').innerHTML = '<i class="mdi mdi-spin mdi-loading align-middle ms-1"></i> Loading...';
                        },
                        success: function(data) {
                            $('#DetailModal').modal('toggle');
                            dataTable.ajax.reload(null, false);
                        },
                        complete: function(data) {
                            document.querySelector('.simpan').innerHTML = '<i class="ri-save-3-line align-middle ms-1"></i> Setuju & Ikut';
                        }
                    });
                }
            });
        });
    </script>
<?php } else if ($_POST['act'] == 'pernyataan') {
    $judul = 'Surat Pernyataan';
?>
    <div class="modal-header">
        <h5 class="modal-title"><?= $judul; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-3">
        <center id="wait"><i class="icon-spinner2 spinner mr-1"></i> Loading..</center>
        <ol type="1">
            <li>Yang bersangkutan dan manajemennya tidak dalam pengawasan pengadilan, tidak pallit, dan kegiatan usahanya tidak sedang dihentikan;</li>
            <li>Badan usaha tidak sedang dikenakan sanksi daftar hitam;</li>
            <li>Yang bertindak untuk dan atas nama badan usaha tidak sedang dalam menjalani sanksi daftar hitam lain;</li>
            <li>Keikutsertaan yang bersangkutan tidak menimbulkan pertentangan kepentingan;</li>
            <li>Yang bertindak untuk dan atas nama badan usaha tidak sedang dalam menjalani sanksi pidana;</li>
            <li>Pimpinan dan pengurus badan usaha bukan sebagai pegawai Kementerian/Lembaga/Perangkat Daerah atau pimpinan dan pengurus badan usaha sebagai pegawai Kementerian/Lembaga/Perangkat Daerah yang sedang mengambil cuti diluar tanggungan Negara;</li>
            <li>Pernyataan lain yang menjadi syarat kualifikasi yang tercantum dalam Dokumen Pemilihan;</li>
            <li>Data kualifikasi yang diisikan dan dokumen penawaran yang disampaikan benar, dan jika dikemudian hari ditemukan bahwa data/dokumen yang disampaikan tidak benar dan ada pemalsuan maka peserta bersedia dikenakan sanksi administratif, sanksi pencantuman dalam daftar hitam, gugatan secara perdata, dan/atau pelaporan secara pidana kepada pihak berwenang sesuai dengan ketentuan peraturan perundang undangan.</li>
        </ol>
    </div>
    <div class="modal-footer">
        <div class="form-check mb-2 float-end">
            <input class="form-check-input" type="checkbox" id="formCheck1" required>
            <label class="form-check-label" for="formCheck1">
                Saya menyetujui surat pernyataan diatas
            </label>
        </div>
        <button type="submit" id="tblizin" class="btn btn-success simpan"><i class="ri-send-plane-line align-middle ms-1"></i> Kirim Kualifikasi</button>
        <a href="javascript:void(0);" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
    </div>
<?php } else if ($_POST['act'] == 'lihat_data') {
    $judul = 'Lihat Data Kualifikasi';
?>
    <div class="modal-header">
        <h5 class="modal-title"><?= $judul; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-3">
        <center id="wait"><i class="icon-spinner2 spinner mr-1"></i> Loading..</center>
        <h5>Izin Usaha</h5>
        <table class="table table-bordered small tabel1">
            <thead class="table-light">
                <tr>
                    <th>Jenis Izin</th>
                    <th>Nomor</th>
                    <th>Tanggal</th>
                    <th>Berlaku</th>
                    <th>Kualifikasi</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql1 = $proses->tampil_data_select(
                    'b.*',
                    'kirim_kualifikasi a LEFT JOIN izin_usaha b 
                    ON a.id_kirim = b.id',
                    '1=1 AND a.id_profil = "' . $_SESSION['kode_profil'] . '"
                    AND a.id_paket = "' . $_POST['id'] . '"
                    AND a.act = "Izin"'
                );
                foreach ($sql1 as $a) {
                ?>
                    <tr>
                        <td><?= str_replace('-', ' ', $a['jenis_izin']); ?></td>
                        <td><?= $a['nomor']; ?></td>
                        <td><?= tgl_indo($a['tanggal']); ?></td>
                        <td>
                            <?= sisa_waktu($a['masa_berlaku']); ?>
                        </td>
                        <td><?= str_replace('-', ' ', $a['grade']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h5>TDP</h5>
        <table class="table table-bordered small tabel4">
            <thead class="table-light">
                <tr>
                    <th>Nomor</th>
                    <th>Tanggal</th>
                    <th>Berlaku</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql3 = $proses->tampil_data_join2('a.*,b.nama', 'tdp', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                $sql3 = $proses->tampil_data_select(
                    'b.*',
                    'kirim_kualifikasi a LEFT JOIN tdp b 
                    ON a.id_kirim = b.id',
                    '1=1 AND a.id_profil = "' . $_SESSION['kode_profil'] . '"
                    AND a.id_paket = "' . $_POST['id'] . '"
                    AND a.act = "tdp"'
                );
                foreach ($sql3 as $c) {
                ?>
                    <tr>
                        <td><?= $c['nomor']; ?></td>
                        <td><?= tgl_indo($c['tanggal']); ?></td>
                        <td><?= sisa_waktu($c['masa_berlaku']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h5>Akta</h5>
        <table class="table table-bordered small tabel5">
            <thead class="table-light">
                <tr>
                    <th>Jenis</th>
                    <th>Nomor</th>
                    <th>Tanggal</th>
                    <th>Nama Notaris</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql4 = $proses->tampil_data_select(
                    'b.*',
                    'kirim_kualifikasi a LEFT JOIN akta b 
                    ON a.id_kirim = b.id',
                    '1=1 AND a.id_profil = "' . $_SESSION['kode_profil'] . '"
                    AND a.id_paket = "' . $_POST['id'] . '"
                    AND a.act = "akta"'
                );
                foreach ($sql4 as $d) {
                ?>
                    <tr>
                        <td><?= str_replace('-', ' ', $d['jenis']); ?></td>
                        <td><?= $d['nomor']; ?></td>
                        <td><?= tgl_indo($d['tanggal']); ?></td>
                        <td><?= $d['nama_notaris']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h5>Tenaga Ahli</h5>
        <table class="table table-bordered small tabel9">
            <thead class="table-light">
                <tr>
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
                $sql8 = $proses->tampil_data_select(
                    'b.*',
                    'kirim_kualifikasi a LEFT JOIN tenaga_ahli b 
                    ON a.id_kirim = b.id',
                    '1=1 AND a.id_profil = "' . $_SESSION['kode_profil'] . '"
                    AND a.id_paket = "' . $_POST['id'] . '"
                    AND a.act = "tenaga_ahli"'
                );
                foreach ($sql8 as $h) {
                ?>
                    <tr>
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
        <h5>Pengalaman</h5>
        <table class="table table-bordered small tabel11">
            <thead class="table-light">
                <tr>
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
                $sql10 = $proses->tampil_data_select(
                    'b.*',
                    'kirim_kualifikasi a LEFT JOIN pengalaman b 
                    ON a.id_kirim = b.id',
                    '1=1 AND a.id_profil = "' . $_SESSION['kode_profil'] . '"
                    AND a.id_paket = "' . $_POST['id'] . '"
                    AND a.act = "pengalaman"'
                );
                foreach ($sql10 as $j) {
                ?>
                    <tr>
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
        <h5>Peralatan</h5>
        <table class="table table-bordered small tabel10">
            <thead class="table-light">
                <tr>
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
                $sql9 = $proses->tampil_data_select(
                    'b.*',
                    'kirim_kualifikasi a LEFT JOIN peralatan b 
                    ON a.id_kirim = b.id',
                    '1=1 AND a.id_profil = "' . $_SESSION['kode_profil'] . '"
                    AND a.id_paket = "' . $_POST['id'] . '"
                    AND a.act = "peralatan"'
                );
                foreach ($sql9 as $i) {
                ?>
                    <tr>
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
        <h5>Pajak</h5>
        <table class="table table-bordered small tabel8">
            <thead class="table-light">
                <tr>
                    <th>Jenis Laporan</th>
                    <th>Nomor</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql7 = $proses->tampil_data_select(
                    'b.*',
                    'kirim_kualifikasi a LEFT JOIN pajak b 
                    ON a.id_kirim = b.id',
                    '1=1 AND a.id_profil = "' . $_SESSION['kode_profil'] . '"
                    AND a.id_paket = "' . $_POST['id'] . '"
                    AND a.act = "pajak"'
                );
                foreach ($sql7 as $g) {
                ?>
                    <tr>
                        <td><?= str_replace('-', ' ', $g['jenis_laporan']); ?></td>
                        <td><?= $g['nomor']; ?></td>
                        <td><?= tgl_indo($g['tanggal']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h5>KSWP</h5>
        <table class="table table-bordered small tabel12">
            <thead class="table-light">
                <tr>
                    <th>Nomor NPWP</th>
                    <th class="text-center">File</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql11 = $proses->tampil_data_select(
                    'b.*',
                    'kirim_kualifikasi a LEFT JOIN kswp b 
                    ON a.id_kirim = b.id',
                    '1=1 AND a.id_profil = "' . $_SESSION['kode_profil'] . '"
                    AND a.id_paket = "' . $_POST['id'] . '"
                    AND a.act = "kswp"'
                );
                foreach ($sql11 as $k) {
                ?>
                    <tr>
                        <td><?= $k['npwp']; ?></td>
                        <td align="center"><a href="<?= $url . 'berkas/' . $k['file']; ?>" target="_blank"><i class="ri-file-line"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0);" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
    </div>
<?php } ?>