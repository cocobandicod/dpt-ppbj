<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/menu.php');
require_once('../../config/fungsi_indotgl.php');
require_once('../../config/cek_ajax.php');

if (@$_POST['act'] == 'lihat_data') {
    $judul = 'Lihat Dokumen Kualifikasi';
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
                    <th class="p-2">Instansi Pemberi</th>
                    <th class="p-2">Grade</th>
                    <th class="p-2 text-center" style="width:3%;">File</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql1 = $proses->tampil_data_select(
                    '*',
                    'izin_usaha',
                    '1=1 AND id_profil = "' . $_POST['id'] . '"
                    ORDER BY id ASC'
                );
                foreach ($sql1 as $a) {
                    $act = pathinfo(@$a['file'], PATHINFO_EXTENSION);
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
                    '1=1 AND a.id_profil = "' . $_POST['id'] . '"
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
                    '1=1 AND a.id_profil = "' . $_POST['id'] . '"
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
                    '1=1 AND a.id_profil = "' . $_POST['id'] . '"
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
        <h5>Sertifikat Standard</h5>
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
                    '1=1 AND a.id_profil = "' . $_POST['id'] . '"
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
                    '1=1 AND a.id_profil = "' . $_POST['id'] . '"
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
                    '1=1 AND a.id_profil = "' . $_POST['id'] . '"
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
<?php }
if (@$_POST['act'] == 'modal_proses') {
    $row = $proses->tampil_data_saja(
        '*',
        'catatan',
        '1=1 AND id = "' . $_POST['id'] . '" 
        AND menu = "' . $_POST['db'] . '"
        AND id_profil = "' . $_POST['profil'] . '"
        AND id_operator = "' . $_SESSION['kode_user'] . '"'
    );

    if (empty($row['status'])) {
        $action = 'add';
    } else {
        $action = 'edit';
    }
?>
    <div class="modal-header">
        <h5 class="modal-title"><?= @$_POST['text']; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="form" method="POST">
            <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
            <input type="hidden" name="db" id="db" value="<?= $_POST['db']; ?>">
            <input type="hidden" name="id_profil" value="<?= $_POST['profil']; ?>">
            <input type="hidden" name="id_operator" value="<?= $_SESSION['kode_user']; ?>">
            <input type="hidden" name="act" value="<?= $action; ?>">
            <div class="row">
                <div class="col-xxl-12 col-md-12 pt-2">
                    <label for="basiInput" class="form-label">Status</label>
                    <?= verifikasi('status_ver', @$row['status']); ?>
                </div>
                <div class="col-xxl-12 col-md-12 pt-2">
                    <label for="basiInput" class="form-label">Keterangan</label>
                    <textarea name="catatan" id="catatan" class="form-control" required><?= @$row['catatan']; ?></textarea>
                </div>
                <div class="col-12 pt-3">
                    <button id="simpan" class="btn btn-success" type="submit"><i class="ri-save-2-fill"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>
<?php } ?>