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
            <table class="table table-bordered table-sm">
                <thead>
                    <th style="width: 3%;" class="p-2">No</th>
                    <th class="p-2">Tahap asd</th>
                    <th class="p-2">Mulai</th>
                    <th class="p-2">Sampai</th>
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
                        'jadwal',
                        '1=1 
                        AND kode_paket = "' . $_POST['id'] . '" 
                        ORDER BY id_jadwal ASC'
                    );
                    $no = 1;
                    foreach ($sql as $row) {
                    ?>
                        <tr>
                            <td class="text-center p-2"><?= $no; ?>.</td>
                            <td class="p-2"><?= str_replace('-', ' ', $row['tahap']); ?></td>
                            <td class="p-2"><?= tgl_indo5($row['tgl_mulai']); ?></td>
                            <td class="p-2"><?= tgl_indo5($row['tgl_selesai']); ?></td>
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
    $s = $proses->tampil_data_saja(
        'a.*, b.nama_file, b.file',
        'paket_pekerjaan a 
        LEFT JOIN dokumen_persiapan b ON a.kode_paket = b.kode_paket',
        '1=1 AND a.id_paket = "' . $_POST['id'] . '"
        AND b.jenis = "Pekerjaan"'
    );
    $p = $proses->tampil_data_saja('GROUP_CONCAT(CONCAT("<span class=\"badge bg-success fs-12 mb-1\">", tahap, "</span>") SEPARATOR " ") as pengumuman', 'jadwal', '1=1 AND kode_paket = "' . $s['kode_paket'] . '" AND "' . $today . '" BETWEEN DATE(tgl_mulai) AND DATE(tgl_selesai)');

    $judul = 'Detail Paket Pekerjaan';

?>
    <div class="modal-header">
        <h5 class="modal-title"><?= $judul; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-3">
        <center id="wait"><i class="icon-spinner2 spinner mr-1"></i> Loading..</center>
        <ul class="nav nav-pills nav-success mb-3" role="tablist">
            <li class="nav-item waves-effect waves-light">
                <a class="nav-link active" data-bs-toggle="tab" href="#menu-1" role="tab">Pengumuman</a>
            </li>
            <li class="nav-item waves-effect waves-light">
                <a class="nav-link" data-bs-toggle="tab" href="#menu-2" role="tab">Peserta</a>
            </li>
            <li class="nav-item waves-effect waves-light">
                <a class="nav-link" data-bs-toggle="tab" href="#menu-3" role="tab">Hasil Evaluasi</a>
            </li>
            <li class="nav-item waves-effect waves-light">
                <a class="nav-link" data-bs-toggle="tab" href="#menu-4" role="tab">Pemenang</a>
            </li>
            <li class="nav-item waves-effect waves-light">
                <a class="nav-link" data-bs-toggle="tab" href="#menu-5" role="tab">Pemenang Berkontrak</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="menu-1" role="tabpanel"> <!-- PENGUMUMAN -->
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <tbody>
                            <tr>
                                <td class="p-2 w-25">Kode Paket</td>
                                <td class="p-2"><?= @$s['kode_paket']; ?></td>
                            </tr>
                            <tr>
                                <td class="p-2">Nama Pekerjaan</td>
                                <td class="p-2"><?= @$s['nama_pekerjaan']; ?></td>
                            </tr>
                            <tr>
                                <td class="p-2">Lokasi Pekerjaan</td>
                                <td class="p-2"><?= @$s['lokasi_pekerjaan']; ?></td>
                            </tr>
                            <tr>
                                <td class="p-2">Uraian Singkat Pekerjaan</td>
                                <td class="p-2"><a href="<?= $url; ?>berkas/<?= $s['file']; ?>" target="_blank"><i class="ri-folder-download-line"></i> <?= $s['nama_file']; ?></a></td>
                            </tr>
                            <tr>
                                <td class="p-2">Sumber Dana</td>
                                <td class="p-2"><?= @$s['nama_pekerjaan']; ?></td>
                            </tr>
                            <tr>
                                <td class="p-2">Tanggal Pembuatan</td>
                                <td class="p-2"><?= tgl_indo(@$s['tanggal']); ?></td>
                            </tr>
                            <tr>
                                <td class="p-2">Tahapan Saat Ini</td>
                                <td class="p-2"><a href="#" data-bs-toggle="modal" data-bs-target="#DetailJadwal" data-id="<?= @$s['kode_paket']; ?>" data-act="jadwal"><?= $p['pengumuman']; ?></a></td>
                            </tr>
                            <tr>
                                <td class="p-2">Satuan Kerja</td>
                                <td class="p-2"><?= @$s['satuan_kerja']; ?></td>
                            </tr>
                            <tr>
                                <td class="p-2">Jenis Pengadaan</td>
                                <td class="p-2"><?= @$s['jenis_pengadaan']; ?></td>
                            </tr>
                            <tr>
                                <td class="p-2">Metode Pengadaan</td>
                                <td class="p-2"><?= @$s['metode_pengadaan'] . ' - ' . @$s['metode_evaluasi']; ?></td>
                            </tr>
                            <tr>
                                <td class="p-2">Tahun Anggaran</td>
                                <td class="p-2"><?= @$s['sumber_dana'] . ' ' . @$s['tahun_anggaran']; ?></td>
                            </tr>
                            <tr>
                                <td class="p-2">Nilai Pagu</td>
                                <td class="p-2">Rp. <?= number_format(@$s['nilai_pagu'], 2, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <td class="p-2">Nilai HPS</td>
                                <td class="p-2">Rp. <?= number_format(@$s['nilai_hps'], 2, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <td class="p-2">Kualifikasi Usaha</td>
                                <td class="p-2"><?= @$s['kualifikasi_usaha']; ?></td>
                            </tr>
                            <tr>
                                <td class="p-2">Syarat Kualifikasi</td>
                                <td class="p-2">
                                    <h5>Persyaratan Kualifikasi Administrasi/Legalitas</h5>
                                    <p>Memenuhi ketentuan peraturan perundang-undangan untuk menjalankan kegiatan/usaha</p>
                                    <table class="table table-sm mb-2">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="p-2">Jenis Izin</th>
                                                <th class="p-2">Bidang Usaha/Sub Bidang Usaha/Klasifikasi/Sub Klasifikasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = $proses->tampil_data_select(
                                                '*',
                                                'dokumen_persiapan',
                                                '1=1 AND kode_paket = "' . $s['kode_paket'] . '"
                                        AND jenis = "Kualifikasi" AND menu = "KBLI" OR menu = "Izin-Lainnya"'
                                            );
                                            foreach ($sql as $row) {
                                                if ($row['menu'] == 'KBLI') {
                                                    $jenis = 'NIB';
                                                    $deskripsi = $row['deskripsi'] . ' - ' . $row['nomor'];
                                                } else {
                                                    $jenis = '';
                                                    $deskripsi = $row['deskripsi'];
                                                }
                                            ?>
                                                <tr>
                                                    <td class="p-2"><?= $jenis; ?></td>
                                                    <td class="p-2"><?= $deskripsi; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php
                                    $sql = $proses->tampil_data_select(
                                        '*',
                                        'dokumen_persiapan',
                                        '1=1 AND kode_paket = "' . $s['kode_paket'] . '"
                                AND jenis = "Kualifikasi" AND menu = "Syarat-Administrasi"'
                                    );
                                    if (empty($sql)) {
                                        echo '<div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="ri-close-circle-fill text-danger"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    Yidak ada data
                                </div>
                            </div>';
                                    } else {
                                        foreach ($sql as $row) {
                                            $deskripsi = $row['deskripsi'];
                                    ?>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <?= $deskripsi; ?>
                                                </div>
                                            </div>
                                    <?php }
                                    } ?>
                                    <h5 class="mt-3 mb-2">Persyaratan Kualifikasi Teknis</h5>
                                    <?php
                                    $sql = $proses->tampil_data_select(
                                        '*',
                                        'dokumen_persiapan',
                                        '1=1 AND kode_paket = "' . $s['kode_paket'] . '"
                                AND jenis = "Kualifikasi" AND menu = "Teknis"'
                                    );
                                    if (empty($sql)) {
                                        echo '<div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="ri-close-circle-fill text-danger"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    Yidak ada data
                                </div>
                            </div>';
                                    } else {
                                        foreach ($sql as $row) {
                                            $deskripsi = $row['deskripsi'];
                                    ?>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <?= $deskripsi; ?>
                                                </div>
                                            </div>
                                    <?php }
                                    } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="menu-2" role="tabpanel"> <!-- PESERTA -->
            </div>
            <div class="tab-pane" id="menu-3" role="tabpanel"> <!-- HASIL EVALUASI -->
            </div>
            <div class="tab-pane" id="menu-4" role="tabpanel"> <!-- PEMENANG -->
            </div>
            <div class="tab-pane" id="menu-5" role="tabpanel"> <!-- BERKONTRAK -->
            </div>
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
        <table class="table table-bordered small tabel1 table-sm">
            <thead class="table-light">
                <tr>
                    <th class="p-2">Jenis Izin</th>
                    <th class="p-2">Nomor</th>
                    <th class="p-2">Tanggal</th>
                    <th class="p-2">Berlaku</th>
                    <th class="p-2">Kualifikasi</td>
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
        <h5>Akta</h5>
        <table class="table table-bordered small tabel5 table-sm">
            <thead class="table-light">
                <tr>
                    <th class="p-2">Jenis</th>
                    <th class="p-2">Nomor</th>
                    <th class="p-2">Tanggal</th>
                    <th class="p-2">Nama Notaris</th>
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
                        <td class="p-2"><?= str_replace('-', ' ', $d['jenis']); ?></td>
                        <td class="p-2"><?= $d['nomor']; ?></td>
                        <td class="p-2"><?= tgl_indo($d['tanggal']); ?></td>
                        <td class="p-2"><?= $d['nama_notaris']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h5>Manajerial</h5>
        <table class="table table-bordered small tabel9 table-sm">
            <thead class="table-light">
                <tr>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Nomor KTP</th>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Alamat</th>
                    <th class="p-2">Jabatan</th>
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
                        <td class="p-2"><?= $h['nama']; ?></td>
                        <td class="p-2"><?= tgl_indo($h['tgl_lahir']); ?></td>
                        <td class="p-2"><?= $h['pendidikan']; ?></td>
                        <td class="p-2"><?= $h['jabatan']; ?></td>
                        <td class="p-2"><?= $h['pengalaman']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h5>Pengalaman</h5>
        <table class="table table-bordered small tabel11 table-sm">
            <thead class="table-light">
                <tr>
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
        <h5>Pajak</h5>
        <table class="table table-bordered small tabel8 table-sm">
            <thead class="table-light">
                <tr>
                    <th class="p-2">Jenis Laporan</th>
                    <th class="p-2">Nomor</th>
                    <th class="p-2">Tanggal</th>
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
                        <td class="p-2"><?= str_replace('-', ' ', $g['jenis_laporan']); ?></td>
                        <td class="p-2"><?= $g['nomor']; ?></td>
                        <td class="p-2"><?= tgl_indo($g['tanggal']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h5>KSWP</h5>
        <table class="table table-bordered small tabel12 table-sm">
            <thead class="table-light">
                <tr>
                    <th class="p-2">Nomor NPWP</th>
                    <th class="text-center p-2">File</th>
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
                        <td class="p-2"><?= $k['npwp']; ?></td>
                        <td align="center" class="p-2"><a href="<?= $url . 'berkas/' . $k['file']; ?>" target="_blank"><i class="ri-file-line"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h5>Persyaratan Lainnya</h5>
        <table class="table table-bordered small tabel12 table-sm">
            <thead class="table-light">
                <tr>
                    <th class="p-2">Nomor NPWP</th>
                    <th class="text-center p-2">File</th>
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
                        <td class="p-2"><?= $k['npwp']; ?></td>
                        <td align="center" class="p-2"><a href="<?= $url . 'berkas/' . $k['file']; ?>" target="_blank"><i class="ri-file-line"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0);" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
    </div>
<?php } else if ($_POST['act'] == 'dokumen_pemilihan') {
    $judul = 'Dokumen Pemilihan';
?>
    <div class="modal-header">
        <h5 class="modal-title"><?= $judul; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-3">
        <center id="wait"><i class="icon-spinner2 spinner mr-1"></i> Loading..</center>
        <table class="table table-bordered table-sm fs-13">
            <tr>
                <td class="p-2 pb-3">
                    <h5 class="m-0 mb-3">Dokumen Pemilihan</h5>
                    <?php
                    $sql = $proses->tampil_data_select('*', 'dokumen_persiapan', 'kode_paket = "' . $_POST['id'] . '" AND jenis = "Pemilihan"');
                    foreach ($sql as $row) {
                    ?>
                        <div class="d-flex gap-2 align-items-center mb-2">
                            <div class="avatar-xs flex-shrink-0">
                                <div class="avatar-title bg-success-subtle text-success rounded-2 fs-17">
                                    <i class="ri-file-text-line fs-17"></i>
                                </div>
                            </div>
                            <h6 class="mb-0 flex-grow-1"> <?= $row['nama_file']; ?> <a href="<?= $url; ?>berkas/<?= $row['file']; ?>" class="ms-3" target="_blank">[Download]</a></h6>
                        </div>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td class="p-2 pb-3">
                    <h5 class="m-0 mb-3">Masa Berlaku Penawaran</h5>
                    <?php
                    $row = $proses->tampil_data_saja('id,nomor', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Berlaku"');
                    ?>
                    <p>Masa berlaku penawaran <?= @$row['nomor']; ?> hari kalender sejak batas akhir pemasukan dokumen penawaran</p>
                </td>
            </tr>
            <tr>
                <td class="p-2 pb-2">
                    <h5 class="m-0 mb-3">Persyaratan Kualifikasi</h5>
                    <p>Memenuhi ketentuan peraturan perundang-undangan untuk menjalankan kegiatan/usaha</p>
                    <table class="table table-sm mb-2">
                        <thead class="table-light">
                            <tr>
                                <th class="p-2">Jenis Izin</th>
                                <th class="p-2">Bidang Usaha/Sub Bidang Usaha/Klasifikasi/Sub Klasifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = $proses->tampil_data_select(
                                '*',
                                'dokumen_persiapan',
                                '1=1 AND kode_paket = "' . $_POST['id'] . '"
                                AND jenis = "Kualifikasi" AND menu = "KBLI" OR menu = "Izin-Lainnya"'
                            );
                            foreach ($sql as $row) {
                                if ($row['menu'] == 'KBLI') {
                                    $jenis = 'NIB';
                                    $deskripsi = $row['deskripsi'] . ' - ' . $row['nomor'];
                                } else {
                                    $jenis = '';
                                    $deskripsi = $row['deskripsi'];
                                }
                            ?>
                                <tr>
                                    <td class="p-2"><?= $jenis; ?></td>
                                    <td class="p-2"><?= $deskripsi; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php
                    $sql = $proses->tampil_data_select(
                        '*',
                        'dokumen_persiapan',
                        '1=1 AND kode_paket = "' . $_POST['id'] . '"
                        AND jenis = "Kualifikasi" AND menu = "Syarat-Administrasi"'
                    );
                    if (empty($sql)) {
                        echo '<div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="ri-close-circle-fill text-danger"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    Yidak ada data
                                </div>
                            </div>';
                    } else {
                        foreach ($sql as $row) {
                            $deskripsi = $row['deskripsi'];
                    ?>
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <?= $deskripsi; ?>
                                </div>
                            </div>
                    <?php }
                    } ?>
                    <h5 class="mt-3">Persyaratan Kualifikasi Teknis</h5>
                    <?php
                    $sql = $proses->tampil_data_select(
                        '*',
                        'dokumen_persiapan',
                        '1=1 AND kode_paket = "' . $_POST['id'] . '"
                        AND jenis = "Kualifikasi" AND menu = "Teknis"'
                    );
                    if (empty($sql)) {
                        echo '<div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="ri-close-circle-fill text-danger"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    Yidak ada data
                                </div>
                            </div>';
                    } else {
                        foreach ($sql as $row) {
                            $deskripsi = $row['deskripsi'];
                    ?>
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <?= $deskripsi; ?>
                                </div>
                            </div>
                    <?php }
                    } ?>
                    <h6 class="fs-14 mt-3">Memiliki SDM Tenaga Teknis/Terampil (Jika Diperlukan)</h6>
                    <table class="table table-sm">
                        <thead>
                            <tr class="table-light">
                                <th class="p-2 w-25">Jenis Keahlian</th>
                                <th class="p-2 w-25">Keahlian/Spesifikasi</th>
                                <th class="p-2 w-25">Pengalaman</th>
                                <th class="p-2 w-25">Kemampuan Manajerial</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = $proses->tampil_data_select('*', 'dokumen_tenaga_ahli', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Ahli" ORDER BY id ASC');
                            if (empty($sql)) {
                                echo '<tr>
                                    <td class="p-2" colspan="4">Belum ada Data</td>
                                </tr>';
                            } else {
                                foreach ($sql as $row) {
                            ?>
                                    <tr>
                                        <td class="p-2"><?= @$row['jenis_keahlian']; ?></td>
                                        <td class="p-2"><?= @$row['spesifikasi']; ?></td>
                                        <td class="p-2"><?= @$row['pengalaman']; ?></td>
                                        <td class="p-2"><?= @$row['kemampuan']; ?></td>
                                    </tr>
                            <?php
                                }
                            } ?>
                        </tbody>
                    </table>
                    <h6 class="fs-14">Memiliki SDM Tenaga Teknis/Terampil (Jika Diperlukan)</h6>
                    <table class="table table-sm">
                        <thead>
                            <tr class="table-light">
                                <th class="p-2 w-25">Jenis Kemampuan</th>
                                <th class="p-2 w-25">Kemampuan Teknis</th>
                                <th class="p-2 w-25">Pengalaman</th>
                                <th class="p-2 w-25">Kemampuan Manajerial</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = $proses->tampil_data_select('*', 'dokumen_tenaga_ahli', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Teknis" ORDER BY id ASC');
                            if (empty($sql)) {
                                echo '<tr>
                                    <td class="p-2" colspan="4">Belum ada Data</td>
                                </tr>';
                            } else {
                                foreach ($sql as $row) {
                            ?>
                                    <tr>
                                        <td class="p-2"><?= @$row['jenis_keahlian']; ?></td>
                                        <td class="p-2"><?= @$row['spesifikasi']; ?></td>
                                        <td class="p-2"><?= @$row['pengalaman']; ?></td>
                                        <td class="p-2"><?= @$row['kemampuan']; ?></td>
                                    </tr>
                            <?php
                                }
                            } ?>
                        </tbody>
                    </table>
                    <h6 class="fs-14">Memiliki Kemampuan Untuk Menyediakan Peralatan (Jika Diperlukan)</h6>
                    <table class="table table-sm">
                        <thead>
                            <tr class="table-light">
                                <th class="p-2 w-25">Nama Peralatan</th>
                                <th class="p-2">Spesifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = $proses->tampil_data_select('*', 'dokumen_peralatan', '1=1 AND kode_paket = "' . $_POST['id'] . '" ORDER BY id ASC');
                            if (empty($sql)) {
                                echo '<tr>
                                    <td class="p-2" colspan="2">Belum ada Data</td>
                                </tr>';
                            } else {
                                foreach ($sql as $row) {
                            ?>
                                    <tr>
                                        <td class="p-2"><?= @$row['nama_peralatan']; ?></td>
                                        <td class="p-2"><?= @$row['spesifikasi']; ?></td>
                                    </tr>
                            <?php
                                }
                            } ?>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="p-2 pb-3">
                    <h5 class="m-0">Dokumen Penawaran</h5>
                    <h6 class="fs-14 mt-3 mb-2">Administrasi</h6>
                    <?php
                    $sql = $proses->tampil_data_select(
                        '*',
                        'dokumen_persiapan',
                        '1=1 AND kode_paket = "' . $_POST['id'] . '"
                                 AND jenis = "Penawaran" AND menu = "Administrasi"'
                    );
                    if (empty($sql)) {
                        echo '<div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="ri-close-circle-fill text-danger"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    Yidak ada data
                                </div>
                            </div>';
                    } else {
                        foreach ($sql as $row) {
                            $deskripsi = $row['deskripsi'];
                    ?>
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <?= $deskripsi; ?>
                                </div>
                            </div>
                    <?php }
                    } ?>
                    <h6 class="fs-14 mt-3 mb-2">Teknis</h6>
                    <?php
                    $sql = $proses->tampil_data_select(
                        '*',
                        'dokumen_persiapan',
                        '1=1 AND kode_paket = "' . $_POST['id'] . '"
                                 AND jenis = "Penawaran" AND menu = "Teknis"'
                    );
                    if (empty($sql)) {
                        echo '<div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="ri-close-circle-fill text-danger"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    Yidak ada data
                                </div>
                            </div>';
                    } else {
                        foreach ($sql as $row) {
                            $deskripsi = $row['deskripsi'];
                    ?>
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <?= $deskripsi; ?>
                                </div>
                            </div>
                    <?php }
                    } ?>
                    <h6 class="fs-14 mt-3 mb-2">Harga/Biaya</h6>
                    <?php
                    $sql = $proses->tampil_data_select(
                        '*',
                        'dokumen_persiapan',
                        '1=1 AND kode_paket = "' . $_POST['id'] . '"
                                 AND jenis = "Penawaran" AND menu = "Biaya"'
                    );
                    if (empty($sql)) {
                        echo '<div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="ri-close-circle-fill text-danger"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    Yidak ada data
                                </div>
                            </div>';
                    } else {
                        foreach ($sql as $row) {
                            $deskripsi = $row['deskripsi'];
                    ?>
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <?= $deskripsi; ?>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </td>
            </tr>
            <tr>
                <td class="p-2 pb-3">
                    <h5 class="mb-3">Kerangka Acuan Kerja (KAK) / Spesifikasi Teknis dan Gambar</h5>
                    <?php
                    $sql = $proses->tampil_data_select('*', 'dokumen_persiapan', 'kode_paket = "' . $_POST['id'] . '" AND jenis = "KAK"');
                    foreach ($sql as $row) {
                    ?>
                        <div class="d-flex gap-2 align-items-center mb-2">
                            <div class="avatar-xs flex-shrink-0">
                                <div class="avatar-title bg-success-subtle text-success rounded-2 fs-17">
                                    <i class="ri-file-text-line fs-17"></i>
                                </div>
                            </div>
                            <h6 class="mb-0 flex-grow-1"> <?= $row['nama_file']; ?> <a href="<?= $url; ?>berkas/<?= $row['file']; ?>" class="ms-3" target="_blank">[Download]</a></h6>
                        </div>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td class="p-2 pb-3">
                    <h5 class="mb-3">Rancangan Kontrak</h5>
                    <?php
                    $sql = $proses->tampil_data_select('*', 'dokumen_persiapan', 'kode_paket = "' . $_POST['id'] . '" AND jenis = "Kontrak"');
                    foreach ($sql as $row) {
                    ?>
                        <div class="d-flex gap-2 align-items-center mb-2">
                            <div class="avatar-xs flex-shrink-0">
                                <div class="avatar-title bg-success-subtle text-success rounded-2 fs-17">
                                    <i class="ri-file-text-line fs-17"></i>
                                </div>
                            </div>
                            <h6 class="mb-0 flex-grow-1"> <?= $row['nama_file']; ?> <a href="<?= $url; ?>berkas/<?= $row['file']; ?>" class="ms-3" target="_blank">[Download]</a></h6>
                        </div>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td class="p-2 pb-3">
                    <h5 class="mb-3">Daftar Kuantitas dan Harga/Biaya</h5>
                    <?php
                    $sql = $proses->tampil_data_select('*', 'dokumen_persiapan', 'kode_paket = "' . $_POST['id'] . '" AND jenis = "HPS"');
                    foreach ($sql as $row) {
                    ?>
                        <div class="d-flex gap-2 align-items-center mb-2">
                            <div class="avatar-xs flex-shrink-0">
                                <div class="avatar-title bg-success-subtle text-success rounded-2 fs-17">
                                    <i class="ri-file-text-line fs-17"></i>
                                </div>
                            </div>
                            <h6 class="mb-0 flex-grow-1"> <?= $row['nama_file']; ?> <a href="<?= $url; ?>berkas/<?= $row['file']; ?>" class="ms-3" target="_blank">[Download]</a></h6>
                        </div>
                    <?php } ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0);" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
    </div>
<?php } ?>