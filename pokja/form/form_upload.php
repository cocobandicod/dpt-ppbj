<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/menu.php');
require_once('../../config/fungsi_indotgl.php');
require_once('../../config/cek_ajax.php');

if (@$_POST['judul'] == 'upload_hps') {
    $row = $proses->tampil_data_saja('nilai_hps', 'paket_pekerjaan', '1=1 AND kode_paket = "' . $_POST['id'] . '"');
    $cek = $proses->tampil_data_saja('nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "HPS"');
?>
    <li class="list-group-item ps-0">
        <div class="d-flex align-items-start">
            <div class="flex-grow-1 pt-1 ms-3">
                <b>Rp. <?= number_format(@$row['nilai_hps']); ?></b>
            </div>
            <div class="flex-shrink-0 ms-2 pe-3">
                <?php
                if (empty(@$cek['file'])) {
                    $text = '<div class="alert alert-danger mt-2 mb-0" role="alert">Harap mengupload rincian HPS</div>';
                ?>
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $_POST['id']; ?>" data-act="form_hps"><i class="ri-upload-cloud-2-line"></i> Upload Rincian HPS</button>
                <?php } else {
                    $text = '';
                ?>
                    <span class="me-2"><a href="<?= $url; ?>berkas/<?= $cek['file']; ?>" target="_blank"><?= $cek['nama_file']; ?></a> Upload Tanggal : <?= tgl_indo5(@$cek['timestamp']); ?></span>
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $_POST['id']; ?>" data-act="form_hps"><i class="ri-upload-cloud-2-line"></i> Ubah Rincian HPS</button>
                <?php } ?>
            </div>
        </div>
    </li>
    <?= @$text; ?>
<?php }
if (@$_POST['judul'] == 'berita_acara') {
    $cek9 = $proses->tampil_data_saja('nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Berita-Acara"');
    if (empty(@$cek9['file'])) {
        $ceklist9 = '<i class="ri-close-circle-fill text-danger fs-20"></i>';
    } else {
        $ceklist9 = '<i class="ri-checkbox-circle-fill text-success fs-20"></i>';
    }
?>
    <div class="d-flex align-items-start">
        <div class="flex-grow-1 pt-0 ms-3">
            <a href="#" class="text-decoration-underline" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $_POST['id']; ?>" data-act="form_berita_acara">Berita Acara Hasil Reviu</a> *
        </div>
        <div class="flex-shrink-0 ms-0 me-3">
            <?= @$ceklist9; ?>
        </div>
    </div>
<?php
}
if (@$_POST['judul'] == 'dokumen_persiapan') {
    $cek1 = $proses->tampil_data_saja('nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "KAK"');
    $cek2 = $proses->tampil_data_saja('nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Kontrak"');
    $cek3 = $proses->tampil_data_saja('nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Pekerjaan"');
    $cek4 = $proses->tampil_data_saja('nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Lainnya"');
    $cek5 = $proses->tampil_data_saja('nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Pemilihan"');
    $cek6 = $proses->tampil_data_saja('kode_paket,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Kualifikasi"');
    $cek7 = $proses->tampil_data_saja('nomor,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Berlaku"');
    $cek8 = $proses->tampil_data_saja('deskripsi,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Penawaran"');
    if (empty(@$cek1['file'])) {
        $ceklist1 = '<i class="ri-close-circle-fill text-danger fs-20"></i>';
    } else {
        $ceklist1 = '<i class="ri-checkbox-circle-fill text-success fs-20"></i>';
    }
    if (empty(@$cek2['file'])) {
        $ceklist2 = '<i class="ri-close-circle-fill text-danger fs-20"></i>';
    } else {
        $ceklist2 = '<i class="ri-checkbox-circle-fill text-success fs-20"></i>';
    }
    if (empty(@$cek3['file'])) {
        $ceklist3 = '<i class="ri-close-circle-fill text-danger fs-20"></i>';
    } else {
        $ceklist3 = '<i class="ri-checkbox-circle-fill text-success fs-20"></i>';
    }
    if (empty(@$cek4['file'])) {
        $ceklist4 = '<i class="ri-close-circle-fill text-danger fs-20"></i>';
        $btn4 = '<i class="ri-upload-cloud-2-line"></i>';
    } else {
        $ceklist4 = '<i class="ri-checkbox-circle-fill text-success fs-20"></i>';
        $btn4 = '<i class="ri-search-line"></i>';
    }
    if (empty(@$cek5['file'])) {
        $ceklist5 = '<i class="ri-close-circle-fill text-danger fs-20"></i>';
    } else {
        $ceklist5 = '<i class="ri-checkbox-circle-fill text-success fs-20"></i>';
    }
    if (empty(@$cek6['kode_paket'])) {
        $ceklist6 = '<i class="ri-close-circle-fill text-danger fs-20"></i>';
    } else {
        $ceklist6 = '<i class="ri-checkbox-circle-fill text-success fs-20"></i>';
    }
    if (empty(@$cek7['nomor'])) {
        $ceklist7 = '<i class="ri-close-circle-fill text-danger fs-20"></i>';
        $ket7 = '';
    } else {
        $ceklist7 = '<i class="ri-checkbox-circle-fill text-success fs-20"></i>';
        $ket7 = @$cek7['nomor'] . ' hari sejak batas akhir pemasukan dokumen penawaran';
    }
    if (empty(@$cek8['deskripsi'])) {
        $ceklist8 = '<i class="ri-close-circle-fill text-danger fs-20"></i>';
    } else {
        $ceklist8 = '<i class="ri-checkbox-circle-fill text-success fs-20"></i>';
    }

    if (!empty(@$cek1['file']) && !empty(@$cek2['file']) && !empty(@$cek3['file'])) {
        $text2 = '';
    } else {
        $text2 = '<div class="alert alert-danger mt-2 mb-0" role="alert">Harap melengkapi dokumen persiapan pengadaan</div>';
    }
?>
    <ul class="list-group list-group-flush border-dashed px-0 pe-0">
        <li class="list-group-item ps-0 pe-3">
            <div class="d-flex align-items-start">
                <div class="flex-grow-1 pt-0 ms-3">
                    <a href="#" class="text-decoration-underline" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $_POST['id']; ?>" data-act="form_pemilihan">Dokumen Pemilihan</a> *
                </div>
                <div class="flex-shrink-0 ms-0">
                    <?= @$ceklist5; ?>
                </div>
            </div>
        </li>
        <li class="list-group-item ps-0 pe-3">
            <div class="d-flex align-items-start">
                <div class="flex-grow-1 pt-0 ms-3">
                    <a href="<?= $url; ?>pokja/daftar-paket/<?= @$_POST['id'] . '/' . @$_POST['tahun'] . '/dokumen-kualifikasi'; ?>" class="text-decoration-underline">Persyaratan Kualifikasi</a> *
                </div>
                <div class="flex-shrink-0 ms-0">
                    <?= @$ceklist6; ?>
                </div>
            </div>
        </li>
        <li class="list-group-item ps-0 pe-3">
            <div class="d-flex align-items-start">
                <div class="flex-grow-1 pt-0 ms-3">
                    <a href="#" class="text-decoration-underline" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $_POST['id']; ?>" data-act="form_berlaku">Masa Berlaku Penawaran <?= $ket7; ?></a> *
                </div>
                <div class="flex-shrink-0 ms-0">
                    <?= @$ceklist7; ?>
                </div>
            </div>
        </li>
        <li class="list-group-item ps-0 pe-3">
            <div class="d-flex align-items-start">
                <div class="flex-grow-1 pt-0 ms-3">
                    <a href="<?= $url; ?>pokja/daftar-paket/<?= @$_POST['id'] . '/' . @$_POST['tahun'] . '/dokumen-penawaran'; ?>" class="text-decoration-underline">Dokumen Penawaran</a> *
                </div>
                <div class="flex-shrink-0 ms-0">
                    <?= @$ceklist8; ?>
                </div>
            </div>
        </li>
        <li class="list-group-item ps-0 pe-3">
            <div class="d-flex align-items-start">
                <div class="flex-grow-1 pt-0 ms-3">
                    <a href="#" class="text-decoration-underline" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $_POST['id']; ?>" data-act="form_kak">Kerangka Acuan Kerja (KAK) Spesifikasi Teknis dan Gambar</a> *
                </div>
                <div class="flex-shrink-0 ms-0">
                    <?= $ceklist1; ?>
                </div>
            </div>
        </li>
        <li class="list-group-item ps-0 pe-3">
            <div class="d-flex align-items-start">
                <div class="flex-grow-1 pt-0 ms-3">
                    <a href="#" class="text-decoration-underline" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $_POST['id']; ?>" data-act="form_kak">Rancangan Kontrak</a> *
                </div>
                <div class="flex-shrink-0 ms-2">
                    <?= @$ceklist2; ?>
                </div>
            </div>
            </div>
        </li>
        <li class="list-group-item ps-0 pe-3">
            <div class="d-flex align-items-start">
                <div class="flex-grow-1 pt-0 ms-3">
                    <a href="#" class="text-decoration-underline" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $_POST['id']; ?>" data-act="form_pekerjaan">Uraian Singkat Pekerjaan</a> *
                </div>
                <div class="flex-shrink-0 ms-2">
                    <?= @$ceklist3; ?>
                </div>
            </div>
        </li>
        <li class="list-group-item ps-0 pe-3">
            <div class="d-flex align-items-start">
                <div class="flex-grow-1 pt-0 ms-3">
                    <a href="#" class="text-decoration-underline" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $_POST['id']; ?>" data-act="form_lainnya">Informasi Lainnya (jika ada)</a> *
                </div>
                <div class="flex-shrink-0 ms-2">
                    <?= @$ceklist4; ?>
                </div>
            </div>
        </li>
    </ul>
    <?= $text2; ?>
<?php }
if (@$_POST['act'] == 'form_hps') {
    $row = $proses->tampil_data_saja('nilai_pagu,nilai_hps', 'paket_pekerjaan', '1=1 AND kode_paket = "' . $_POST['id'] . '"');
    $cek = $proses->tampil_data_saja('nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "HPS"');
?>
    <div class="modal-header">
        <h5 class="modal-title">Rincian HPS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-3">
        <table class="table table-bordered table-sm fs-13">
            <thead class="table-light">
                <tr>
                    <th class="text-center ps-2 pe-2">Total Pagu</th>
                    <th class="text-center ps-2 pe-2">Nilai HPS</th>
                    <th class="text-center ps-2 pe-2">File HPS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-end ps-2 pe-2">Rp. <?= number_format(@$row['nilai_pagu']); ?></td>
                    <td class="text-end ps-2 pe-2">Rp. <?= number_format(@$row['nilai_hps']); ?></td>
                    <td class="text-end ps-2 pe-2"><span class="me-2"><a href="<?= $url; ?>berkas/<?= $cek['file']; ?>" target="_blank"><?= $cek['nama_file']; ?></a> | Upload Tanggal : <?= tgl_indo5(@$cek['timestamp']); ?></span></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
    </div>
<?php }
if (@$_POST['act'] == 'form_kak') {
    $sql = $proses->tampil_data_select('id,nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "KAK"');
?>
    <div class="modal-header">
        <h5 class="modal-title">Daftar Kerangka Acuan Kerja (KAK) Spesifikasi Teknis dan Gambar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-3">
        <div class="col-xxl-12 col-md-12 pt-2">
            <table class="table table-bordered table-sm mt-3">
                <thead class="table-light">
                    <tr>
                        <th class="ps-2 pe-2" style="width: 3%;">No</th>
                        <th class="ps-2 pe-2">Nama File</th>
                        <th class="ps-2 pe-2">Tanggal Upload</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($sql as $row) {
                    ?>
                        <tr>
                            <td class="ps-2 pe-2 text-center"><?= $no; ?></td>
                            <td class="ps-2 pe-2"><a href="<?= $url; ?>berkas/<?= @$row['file']; ?>" target="_blank"><?= @$row['nama_file']; ?></a></td>
                            <td class="ps-2 pe-2"><?= tgl_indo5(@$row['timestamp']); ?></td>
                        </tr>
                    <?php $no++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
    </div>
<?php }
if (@$_POST['act'] == 'form_kontrak') {
    $sql = $proses->tampil_data_select('id,nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Kontrak"');
?>
    <div class="modal-header">
        <h5 class="modal-title">Daftar Rancangan Kontrak</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-3">
        <div class="col-xxl-12 col-md-12 pt-2">
            <table class="table table-bordered table-sm mt-3">
                <thead class="table-light">
                    <tr>
                        <th style="width: 3%;" class="ps-2 pe-2">No</th>
                        <th class="ps-2 pe-2">Nama File</th>
                        <th class="ps-2 pe-2">Tanggal Upload</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($sql as $row) {
                    ?>
                        <tr>
                            <td class="text-center ps-2 pe-2"><?= $no; ?></td>
                            <td class="ps-2 pe-2"><a href="<?= $url; ?>berkas/<?= @$row['file']; ?>" target="_blank"><?= @$row['nama_file']; ?></a></td>
                            <td class="ps-2 pe-2"><?= tgl_indo5(@$row['timestamp']); ?></td>
                        </tr>
                    <?php $no++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
    </div>
<?php }
if (@$_POST['act'] == 'form_pekerjaan') {
    $sql = $proses->tampil_data_select('id,nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Pekerjaan"');
    $cek = $proses->tampil_data_saja('file', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Pekerjaan"');
?>
    <div class="modal-header">
        <h5 class="modal-title">Daftar Uraian Singkat Pekerjaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-3">
        <div class="col-xxl-12 col-md-12 pt-2">
            <table class="table table-bordered table-sm mt-3">
                <thead class="table-light">
                    <tr>
                        <th class="ps-2 pe-2" style="width: 3%;">No</th>
                        <th class="ps-2 pe-2">Nama File</th>
                        <th class="ps-2 pe-2">Tanggal Upload</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($sql as $row) {
                    ?>
                        <tr>
                            <td class="text-center ps-2 pe-2"><?= $no; ?></td>
                            <td class="ps-2 pe-2"><a href="<?= $url; ?>berkas/<?= @$row['file']; ?>" target="_blank"><?= @$row['nama_file']; ?></a></td>
                            <td class="ps-2 pe-2"><?= tgl_indo5(@$row['timestamp']); ?></td>
                        </tr>
                    <?php $no++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
    </div>
    </form>
<?php }
if (@$_POST['act'] == 'form_lainnya') {
    $sql = $proses->tampil_data_select('id,nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Lainnya"');
?>
    <div class="modal-header">
        <h5 class="modal-title">Informasi Lainnya (jika ada)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="form" enctype="multipart/form-data">
        <?php
        echo '<input type="hidden" name="act" value="upload_lainnya">';
        ?>
        <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
        <div class="modal-body pt-3">
            <div class="col-xxl-12 col-md-12 pt-2">
                <label for="basiInput" class="form-label">Upload File</label>
                <input type="file" onchange="return validasiFile()" name="fupload" id="file" class="form-control" required>
                <div id="passwordHelpBlock" class="form-text">
                    *Max file size 10Mb
                </div>
                <table class="table table-bordered table-sm mt-3">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-2 pe-2" style="width: 3%;">No</th>
                            <th class="ps-2 pe-2">Nama File</th>
                            <th class="ps-2 pe-2">Tanggal Upload</th>
                            <th class="text-center ps-2 pe-2" style="width: 5%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (empty($sql)) {
                            echo '<tr><td class="p-2" colspan="4">Belum ada Data</td></tr>';
                        } else {
                            $no = 1;
                            foreach ($sql as $row) {
                        ?>
                                <tr>
                                    <td class="text-center ps-2 pe-2"><?= $no; ?>.</td>
                                    <td class="ps-2 pe-2"><a href="<?= $url; ?>berkas/<?= @$row['file']; ?>" target="_blank"><?= @$row['nama_file']; ?></a></td>
                                    <td class="ps-2 pe-2"><?= tgl_indo5(@$row['timestamp']); ?></td>
                                    <td class="text-center ps-2 pe-2"><a href="#" id="del" data-id="<?= @$row['id']; ?>" data-nama="<?= @$row['nama_file']; ?>" data-act="delfile"><i class="ri-delete-bin-fill align-bottom text-danger fs-15"></i></a></td>
                                </tr>
                        <?php $no++;
                            }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
            <button id="simpan" class="btn btn-success" type="submit"><i class="ri-save-2-fill"></i> Simpan</button>
        </div>
    </form>
    <script>
        function validasiFile() {
            var inputFile = document.getElementById('file');
            var pathFile = inputFile.value;
            var allowedExtensions = /(\.pdf)$/i;

            if (!allowedExtensions.exec(pathFile)) {
                alert('Silakan upload file dengan ekstensi *.pdf');
                inputFile.value = '';
                return false;
            }

            if (inputFile.files[0].size > 10 * 1024 * 1024) { // 10 MB in bytes
                alert('Ukuran file harus kurang dari 10MB');
                inputFile.value = '';
                return false;
            }
            return true;
        }
    </script>
<?php }
if (@$_POST['act'] == 'form_berita_acara') {
    $sql = $proses->tampil_data_select('id,nama_file,file,tgl_dokumen', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Berita-Acara"');
    $cek = $proses->tampil_data_saja('file', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Berita-Acara"');
?>
    <div class="modal-header">
        <h5 class="modal-title">Upload BA Reviu DPP</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="form" enctype="multipart/form-data">
        <?php
        echo '<input type="hidden" name="act" value="upload_berita_acara">';
        ?>
        <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
        <div class="modal-body pt-3">
            <div class="col-xxl-12 col-md-12 pt-2">
                <?php
                if (empty(@$cek['file'])) {
                ?>
                    <div class="row">
                        <div class="col-xxl-6 col-md-6 pt-2">
                            <label for="basiInput" class="form-label">Tanggal Dokumen BA Reviu DPP</label>
                            <input type="date" name="tgl_dokumen" class="form-control" required>
                        </div>
                        <div class="col-xxl-6 col-md-12 pt-2">
                            <label for="basiInput" class="form-label">BA Hasil Reviu DPP</label>
                            <input type="file" onchange="return validasiFile()" name="fupload" id="file" class="form-control" required>
                            <div id="passwordHelpBlock" class="form-text">
                                *.PDF Max file size 10Mb
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <table class="table table-bordered table-sm mt-3">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-2 pe-2">Nama File</th>
                            <th class="ps-2 pe-2">Tanggal Dokumen</th>
                            <th class="ps-2 pe-2 text-center" style="width: 5%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (empty($sql)) {
                            echo '<tr><td class="p-2" colspan="3">Belum ada Data</td></tr>';
                        } else {
                            foreach ($sql as $row) {
                        ?>
                                <tr>
                                    <td class="ps-2 pe-2"><a href="<?= $url; ?>berkas/<?= @$row['file']; ?>" target="_blank"><?= @$row['nama_file']; ?></a></td>
                                    <td class="ps-2 pe-2"><?= tgl_indo(@$row['tgl_dokumen']); ?></td>
                                    <td class="text-center ps-2 pe-2"><a href="#" id="del" data-id="<?= @$row['id']; ?>" data-nama="<?= @$row['nama_file']; ?>" data-act="delfile"><i class="ri-delete-bin-fill align-bottom text-danger fs-15"></i></a></td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
            <?php
            if (empty(@$cek['file'])) {
            ?>
                <button id="simpan" class="btn btn-success" type="submit"><i class="ri-save-2-fill"></i> Simpan</button>
            <?php } ?>
        </div>
    </form>
    <script>
        function validasiFile() {
            var inputFile = document.getElementById('file');
            var pathFile = inputFile.value;
            var allowedExtensions = /(\.pdf)$/i;

            if (!allowedExtensions.exec(pathFile)) {
                alert('Silakan upload file dengan ekstensi *.pdf');
                inputFile.value = '';
                return false;
            }

            if (inputFile.files[0].size > 10 * 1024 * 1024) { // 10 MB in bytes
                alert('Ukuran file harus kurang dari 10MB');
                inputFile.value = '';
                return false;
            }
            return true;
        }
    </script>
<?php }
if (@$_POST['act'] == 'form_pemilihan') {
    $sql = $proses->tampil_data_select('id,nomor,tgl_dokumen,nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Pemilihan"');
    $cek = $proses->tampil_data_saja('file', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Pemilihan"');
?>
    <div class="modal-header">
        <h5 class="modal-title">Dokumen Pemilihan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="form" enctype="multipart/form-data">
        <?php
        echo '<input type="hidden" name="act" value="upload_pemilihan">';
        ?>
        <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
        <div class="modal-body pt-3">
            <div class="col-xxl-12 col-md-12 pt-2">
                <!-- Primary Alert -->
                <div class="alert alert-primary mb-2" role="alert">
                    Petunjuk Pembuatan Dokumen Tender/Pemilihan:<br>
                    Perubahan kalimat dalam Standar Dokumen Pemilihan agar konsisten dengan isian:<br>
                    1. BAB Lembar Data Kualifikasi (LDK):
                    <ul class="ps-3 mb-0">
                        <li>Persyaratan Kualifikasi sesuai dengan yang tercantum dalam aplikasi</li>
                    </ul>
                    2. BAB Lembar Data Pemilihan (LDP):<br>
                    Jenis pengadaan sesuai dengan yang tercantum dalam aplikasi
                    <ul class="ps-3 mb-0">
                        <li>Metode evaluasi sesuai dengan yang tercantum dalam aplikasi</li>
                        <li>Metode penyampaian dokumen sesuai dengan yang tercantum dalam aplikasi</li>
                        <li>Masa berlaku penawaran sesuai dengan yang tercantum dalam aplikasi</li>
                        <li>Dokumen penawaran teknis sesuai dengan yang tercantum dalam aplikasi</li>
                    </ul>
                    3. BAB Daftar Kuantitas Barang/Pekerjaan:
                    <ul class="ps-3 mb-0">
                        <li>Daftar Kuantitas Barang/Pekerjaan sesuai dengan yang tercantum dalam aplikasi</li>
                    </ul>
                    4. BAB KAK/Spesifikasi Teknis dan Gambar:
                    <ul class="ps-3 mb-0">
                        <li>KAK Spesifikasi Teknis dan Cambar sesuai dengan yang tercantum dalam aplikasi</li>
                    </ul>
                    <br>
                    Dokumen yang dapat di upload hanya hile/dokumen yang memiliki ekstensi *.pdf.
                </div>
                <?php
                if (empty(@$cek['file'])) {
                ?>
                    <div class="row">
                        <div class="col-xxl-6 col-md-6 pt-2">
                            <label for="basiInput" class="form-label">Nomor Dokumen</label>
                            <input type="text" name="no_dokumen" class="form-control" required>
                        </div>
                        <div class="col-xxl-6 col-md-6 pt-2">
                            <label for="basiInput" class="form-label">Tanggal Dokumen</label>
                            <input type="date" name="tgl_dokumen" class="form-control" required>
                        </div>
                        <div class="col-xxl-12 col-md-12 pt-2">
                            <label for="basiInput" class="form-label">Dokumen Pemilihan</label>
                            <input type="file" onchange="return validasiFile()" name="fupload" id="file" class="form-control" required>
                            <div id="passwordHelpBlock" class="form-text">
                                *Max file size 10Mb
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <table class="table table-bordered table-sm mt-3">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-2 pe-2">No Dokumen</th>
                            <th class="ps-2 pe-2">Nama File</th>
                            <th class="ps-2 pe-2">Tanggal Dokumen</th>
                            <th class="ps-2 pe-2 text-center" style="width: 5%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (empty($sql)) {
                            echo '<tr><td class="p-2" colspan="4">Belum ada Data</td></tr>';
                        } else {
                            foreach ($sql as $row) {
                        ?>
                                <tr>
                                    <td class="ps-2 pe-2"><?= $row['nomor']; ?></td>
                                    <td class="ps-2 pe-2"><a href="<?= $url; ?>berkas/<?= @$row['file']; ?>" target="_blank"><?= @$row['nama_file']; ?></a></td>
                                    <td class="ps-2 pe-2"><?= tgl_indo(@$row['tgl_dokumen']); ?></td>
                                    <td class="text-center ps-2 pe-2"><a href="#" id="del" data-id="<?= @$row['id']; ?>" data-nama="<?= @$row['nama_file']; ?>" data-act="delfile"><i class="ri-delete-bin-fill align-bottom text-danger fs-15"></i></a></td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
            <?php
            if (empty(@$cek['file'])) {
            ?>
                <button id="simpan" class="btn btn-success" type="submit"><i class="ri-save-2-fill"></i> Simpan</button>
            <?php } ?>
        </div>
    </form>
    <script>
        function validasiFile() {
            var inputFile = document.getElementById('file');
            var pathFile = inputFile.value;
            var allowedExtensions = /(\.pdf)$/i;

            if (!allowedExtensions.exec(pathFile)) {
                alert('Silakan upload file dengan ekstensi *.pdf');
                inputFile.value = '';
                return false;
            }

            if (inputFile.files[0].size > 10 * 1024 * 1024) { // 10 MB in bytes
                alert('Ukuran file harus kurang dari 10MB');
                inputFile.value = '';
                return false;
            }
            return true;
        }
    </script>
<?php }
if (@$_POST['act'] == 'form_berlaku') {
    $row = $proses->tampil_data_saja('id,nomor', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Berlaku"');
    $jad =  $proses->tampil_data_saja('tgl_selesai', ' jadwal', '1=1 AND nomor = "4" AND kode_paket = "' . $_POST['id'] . '"');
    $kon =  $proses->tampil_data_saja('tgl_selesai', ' jadwal', '1=1 AND nomor = "12" AND kode_paket = "' . $_POST['id'] . '"');
    $tgl_selesai = ubah_tgl_edit2(@$jad['tgl_selesai']);
    $tgl_kontrak = ubah_tgl_edit2(@$kon['tgl_selesai']);
?>
    <div class="modal-header">
        <h5 class="modal-title">Masa Berlaku Dokumen Penawaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <?php
    if (empty($kon['tgl_selesai'])) {
        echo '<div class="alert alert-danger m-3" role="alert">Anda belum menyelesaikan pengisian jadwal tender</div>';
    } else {
    ?>
        <form id="form" enctype="multipart/form-data">
            <div class="modal-body pt-3">
                <label for="basiInput" class="form-label">Masa Berlaku Penawaran</label>
                <div class="input-group">
                    <input type="number" id="inputNumber" value="<?= @$row['nomor']; ?>" oninput="calculateNextDate()" class="form-control" name="nomor">
                    <span class="input-group-text" id="basic-addon2">Hari sejak batas akhir pemasukan dokumen penawaran</span>
                </div>
                <div id="message">
                    <div class="alert alert-success mt-2" role="alert">
                        Akhir penandatanganan Kontrak pada tanggal <b><?= @$tgl_kontrak; ?></b>.<br>
                        Masa Berlaku Penawaran akan berakhir pada tanggal <b><?= jumlah_tanggal($tgl_selesai, @$row['nomor']); ?></b>.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
                <?php
                if (empty(@$row['nomor'])) {
                    echo '<input type="hidden" name="act" value="upload_berlaku">';
                    echo '<input type="hidden" name="id" value="' . $_POST['id'] . '">';
                    echo '<button id="simpan" class="btn btn-success" type="submit"><i class="ri-save-2-fill"></i> Simpan</button>';
                } else {
                    echo '<input type="hidden" name="act" value="update_berlaku">';
                    echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                    echo '<button id="simpan" class="btn btn-success" type="submit"><i class="ri-save-2-fill"></i> Update</button>';
                } ?>
            </div>
        </form>
        <script>
            function calculateNextDate() {
                let tglkontrak = '<?= $tgl_kontrak; ?>';
                let tgl = '<?= $tgl_selesai; ?>';

                // Ambil nilai dari input jumlah hari
                const daysToAdd = parseInt(document.getElementById("inputNumber").value);

                // Pastikan input number memiliki nilai yang valid
                if (!isNaN(daysToAdd) && daysToAdd > 0) {
                    // Buat objek tanggal dari variabel tgl
                    const startDate = new Date(tgl);

                    // Tambahkan jumlah hari
                    startDate.setDate(startDate.getDate() + daysToAdd);

                    // Format hasil tanggal baru
                    const year = startDate.getFullYear();
                    const month = String(startDate.getMonth() + 1).padStart(2, '0');
                    const day = String(startDate.getDate()).padStart(2, '0');

                    // Tampilkan hasil dengan pesan dinamis
                    document.getElementById("message").innerHTML = `
                    <div class="alert alert-success mt-2" role="alert">
                        Akhir penandatanganan Kontrak pada tanggal <b>${tglkontrak}</b>.<br>
                        Masa Berlaku Penawaran akan berakhir pada tanggal <b>${year}-${month}-${day}</b>.
                    </div>
                `;
                } else {
                    // Hapus pesan jika input tidak valid
                    document.getElementById("message").innerHTML = "";
                }
            }
        </script>
    <?php } ?>
<?php }
if (@$_POST['judul'] == 'ukpbj') {
    $cek = $proses->cek_count('penugasan a LEFT JOIN paket_pekerjaan b ON a.kode_paket = b.kode_paket', 'b.kode_paket = "' . $_POST['id'] . '"');
    if ($cek == 0) {
        $link = '<a href="#" class="btn btn-warning btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="' . $_POST['id'] . '" data-act="form_ukpbj"> <i class="ri-home-3-line"></i> Pilih UKPBJ</a>';
        $display = 'style="display:none;"';
    } else {
        $link = '';
        $display = "";
    }
?>
    <?= $link; ?>
    <div <?= $display; ?>>
        <table class="table table-bordered table-sm fs-13 mb-0">
            <thead>
                <tr class="table-light">
                    <th class="ps-2 pe-2">Nama</th>
                    <th class="ps-2 pe-2">Tanggal</th>
                    <th style="width: 5%;" class="text-center ps-2 pe-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $row = $proses->tampil_data_saja(
                    'a.id,a.timestamp,b.nama',
                    'penugasan a LEFT JOIN operator b 
                    ON a.id_operator = b.id_operator',
                    '1=1 AND a.status = "UKPBJ"'
                );
                ?>
                <tr>
                    <td class="ps-2 pe-2"><?= @$row['nama']; ?></td>
                    <td class="ps-2 pe-2"><?= tgl_indo(@$row['timestamp']); ?></td>
                    <td class="text-center ps-2 pe-2"><a href="#" id="hapus_ukpbj" data-id="<?= @$row['id']; ?>"><i class="ri-delete-bin-fill text-danger fs-15"></i></a></td>
                </tr>
            </tbody>
        </table>
    </div>
<?php }
if (@$_POST['judul'] == 'kirim_ppk') {
    $cek = $proses->tampil_data_saja('*', 'undangan_ppk', '1=1 AND kode_paket = "' . $_POST['id'] . '" ORDER BY timestamp DESC');
    if (empty($cek['id'])) {
        echo '<a href="#" class="btn btn-warning btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="' . $_POST['id'] . '" data-act="email_ppk"> <i class="ri-mail-send-line"></i> Kirim Undangan PPK</a>';
    } else {
        $kirimulang = '<a href="#" class="btn btn-warning btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="' . $_POST['id'] . '" data-act="email_ppk"> <i class="ri-mail-send-line"></i> Kirim Ulang</a>';
        $file = '<a href="' . $url . 'berkas/' . $cek['file'] . '" class="btn btn-info btn-sm mb-0" target="_blank"><i class="ri-file-download-line"></i> Dokumen Lampiran</a>';
        echo '
        <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
            Sudah dikirim Undangan Tanggal ' . tgl_indo7($cek['timestamp']) . '
            ' . $kirimulang . ' ' . $file . '
        </div>';
    }
}
if (@$_POST['act'] == 'email_ppk') {
    $s = $proses->tampil_data_saja('*', 'paket_pekerjaan', '1=1 AND kode_paket = "' . $_POST['id'] . '"');
    $p = $proses->tampil_data_saja('id_operator, nama, email', 'operator', '1=1 AND level = "PPK"');
?>
    <div class="modal-header">
        <h5 class="modal-title">Kirim Undangan PPK</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="kirim_email" enctype="multipart/form-data">
        <?php
        echo '<input type="hidden" name="act" value="kirim_email_ppk">';
        echo '<input type="hidden" name="id_operator" value="' . @$p['id_operator'] . '">';
        echo '<input type="hidden" name="email" value="' . @$p['email'] . '">';
        echo '<input type="hidden" name="kode_paket" value="' . @$s['kode_paket'] . '">';
        echo '<input type="hidden" name="nama" value="' . @$p['nama'] . '">';
        echo '<input type="hidden" name="nama_pekerjaan" value="' . @$s['nama_pekerjaan'] . '">';
        ?>
        <div class="modal-body pt-5">
            <p>Kepada Yth,<br><?= $p['nama']; ?><br>di<br>Tempat</p>
            <table class="table table-bordered table-sm fs-13">
                <tbody>
                    <tr>
                        <td class="ps-2 pe-2">Kode Paket</td>
                        <td class="ps-2 pe-2"><?= @$s['kode_paket']; ?></td>
                    </tr>
                    <tr>
                        <td class="ps-2 pe-2">Nama Pekerjaan</td>
                        <td class="ps-2 pe-2"><?= @$s['nama_pekerjaan']; ?></td>
                    </tr>
                    <tr>
                        <td class="ps-2 pe-2" colspan="2">dengan informasi terkait Reviu Dokumen Persiapan Pengadaan sebagai berikut:</td>
                    </tr>
                    <tr>
                        <td class="ps-2 pe-2">waktu</td>
                        <td class="ps-2 pe-2"><input type="text" name="waktu" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td class="ps-2 pe-2">Tempat</td>
                        <td class="ps-2 pe-2"><input type="text" name="tempat" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td class="ps-2 pe-2">Yang harus dibawa</td>
                        <td class="ps-2 pe-2"><textarea type="text" name="dibawa" class="form-control" required></textarea></td>
                    </tr>
                    <tr>
                        <td class="ps-2 pe-2">Yang harus hadir</td>
                        <td class="ps-2 pe-2"><textarea type="text" name="hadir" class="form-control" required></textarea></td>
                    </tr>
                    <tr>
                        <td class="ps-2 pe-2">Dokumen Lampiran</td>
                        <td class="ps-2 pe-2">
                            <input type="file" name="fupload" id="file" onchange="return validasiFile()" class="form-control" required>
                            <div id="passwordHelpBlock" class="form-text">
                                *Accepted formats: *.pdf
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-2 pe-2" colspan="2">
                            Demikian Penjelasan Kami, atas perhatian dan kerjasama yang baik kami ucapkan terima kasih
                            <br><br><br>
                            Hormat Kami<br>
                            Pokja<br>
                            <?= $_SESSION['nama']; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
            <button id="simpan" class="btn btn-success" type="submit"><i class="ri-mail-send-line"></i> Kirim</button>
        </div>
    </form>
    <script>
        function validasiFile() {
            var inputFile = document.getElementById('file');
            var pathFile = inputFile.value;
            var allowedExtensions = /(\.pdf)$/i;

            if (!allowedExtensions.exec(pathFile)) {
                alert('Silakan upload file dengan ekstensi *.pdf');
                inputFile.value = '';
                return false;
            }

            if (inputFile.files[0].size > 10 * 1024 * 1024) { // 10 MB in bytes
                alert('Ukuran file harus kurang dari 10MB');
                inputFile.value = '';
                return false;
            }
            return true;
        }
    </script>
<?php }
if (@$_POST['judul'] == 'tabel_administrasi') {
    $sql = $proses->tampil_data_select('*', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Penawaran" AND menu = "Administrasi" ORDER BY id ASC');
?>
    <table class="table table-sm">
        <tbody>
            <?php
            foreach ($sql as $row) {
            ?>
                <tr>
                    <td class="text-center" style="width: 1%;">
                        <i class="ri-checkbox-circle-fill text-success fs-18"></i>
                    </td>
                    <td class="pt-2"><?= $row['deskripsi']; ?></td>
                    <td class="text-center" style="width: 3%;">
                        <a href="#" id="del" data-id="<?= @$row['id']; ?>" data-nama="<?= @$row['deskripsi']; ?>" data-act="delpenawaran"><i class="ri-delete-bin-fill text-danger fs-18"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php }
if (@$_POST['judul'] == 'tabel_teknis') {
    $sql = $proses->tampil_data_select('*', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Penawaran" AND menu = "Teknis" ORDER BY id ASC');
?>
    <table class="table table-sm">
        <tbody>
            <?php
            foreach ($sql as $row) {
            ?>
                <tr>
                    <td class="text-center" style="width: 1%;">
                        <i class="ri-checkbox-circle-fill text-success fs-18"></i>
                    </td>
                    <td class="pt-2"><?= $row['deskripsi']; ?></td>
                    <td class="text-center" style="width: 3%;">
                        <a href="#" id="del" data-id="<?= @$row['id']; ?>" data-nama="<?= @$row['deskripsi']; ?>" data-act="delpenawaran"><i class="ri-delete-bin-fill text-danger fs-18"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php }
if (@$_POST['judul'] == 'tabel_biaya') {
    $sql = $proses->tampil_data_select('*', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Penawaran" AND menu = "Biaya" ORDER BY id ASC');
?>
    <table class="table table-sm">
        <tbody>
            <?php
            foreach ($sql as $row) {
            ?>
                <tr>
                    <td class="text-center" style="width: 1%;">
                        <i class="ri-checkbox-circle-fill text-success fs-18"></i>
                    </td>
                    <td class="pt-2"><?= $row['deskripsi']; ?></td>
                    <td class="text-center" style="width: 3%;">
                        <a href="#" id="del" data-id="<?= @$row['id']; ?>" data-nama="<?= @$row['deskripsi']; ?>" data-act="delpenawaran"><i class="ri-delete-bin-fill text-danger fs-18"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php }
if (@$_POST['act'] == 'form_administrasi') {
?>
    <div class="modal-header">
        <h5 class="modal-title">Dokumen Penawaran Administrasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
        <input type="hidden" name="act" value="form_administrasi">
        <div class="modal-body pt-3">
            <div class="col-xxl-12 col-md-12 pt-2">
                <label for="basiInput" class="form-label">Syarat Penawaran</label>
                <input type="text" name="deskripsi" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
            <button id="simpan" class="btn btn-success" type="submit"><i class="ri-save-2-fill"></i> Simpan</button>
        </div>
    </form>
<?php }
if (@$_POST['act'] == 'form_teknis') {
?>
    <div class="modal-header">
        <h5 class="modal-title">Dokumen Penawaran Teknis</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
        <input type="hidden" name="act" value="form_teknis">
        <div class="modal-body pt-3">
            <div class="col-xxl-12 col-md-12 pt-2">
                <label for="basiInput" class="form-label">Syarat Penawaran</label>
                <input type="text" name="deskripsi" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
            <button id="simpan" class="btn btn-success" type="submit"><i class="ri-save-2-fill"></i> Simpan</button>
        </div>
    </form>
<?php }
if (@$_POST['act'] == 'form_biaya') {
?>
    <div class="modal-header">
        <h5 class="modal-title">Dokumen Penawaran Harga/Biaya</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
        <input type="hidden" name="act" value="form_biaya">
        <div class="modal-body pt-3">
            <div class="col-xxl-12 col-md-12 pt-2">
                <label for="basiInput" class="form-label">Syarat Penawaran</label>
                <input type="text" name="deskripsi" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
            <button id="simpan" class="btn btn-success" type="submit"><i class="ri-save-2-fill"></i> Simpan</button>
        </div>
    </form>
<?php }
if (@$_POST['judul'] == 'tabel_kbli') {
    $sql = $proses->tampil_data_select('*', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Kualifikasi" AND menu = "KBLI" ORDER BY id ASC');
?>
    <table class="table table-sm fs-13">
        <tbody>
            <?php if (empty($sql)) { ?>
                <tr>
                    <td class="p-2" colspan="3">Belum ada Data</td>
                </tr>
                <?php } else {
                foreach ($sql as $row) {
                ?>
                    <tr>
                        <td class="text-center" style="width:5%;"><?= $row['nomor']; ?></td>
                        <td><?= $row['deskripsi']; ?></td>
                        <td class="text-center" style="width: 3%;">
                            <a href="#" id="del" data-id="<?= @$row['id']; ?>" data-nama="<?= $row['nomor'] . ' - ' . $row['deskripsi']; ?>" data-act="delkualifikasi"><i class="ri-delete-bin-fill text-danger fs-18"></i></a>
                        </td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
<?php }
if (@$_POST['act'] == 'form_kbli') { // MODAL CARI KBLI
?>
    <div class="modal-header">
        <h5 class="modal-title">Cari KBLI</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-3">
        <form action="#" class="mb-2">
            <div class="input-group">
                <input type="text" class="form-control" name="cari" id="kbli" placeholder="Cari Kode KBLI atau Klasifikasi" required>
                <button class="btn btn-success" type="button" id="cari"><i class="ri-search-line"></i> Cari</button>
            </div>
        </form>
        <div class="text-center" id="loading"></div>
        <div class="kbli-data"></div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
    </div>
<?php }
if (@$_POST['act'] == 'cari_kbli') { // MODAL CARI KBLI

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    $url = 'https://gw.oss.go.id/v2/portal/autocomplete?kategori=kbli&search=' . urlencode($_POST['cari']) . '&localization=id';
    @$response = file_get_contents(@$url);
    echo @$response;
}

if (@$_POST['judul'] == 'tabel_izin_lainnya') {
    $sql = $proses->tampil_data_select('*', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Kualifikasi" AND menu = "Izin-lainnya" ORDER BY id ASC');
?>
    <table class="table table-sm">
        <tbody>
            <?php if (empty($sql)) { ?>
                <tr>
                    <td class="p-2" colspan="3">Belum ada Data</td>
                </tr>
                <?php } else {
                foreach ($sql as $row) {
                ?>
                    <tr>
                        <td class="text-center" style="width: 1%;">
                            <i class="ri-checkbox-circle-fill text-success fs-18"></i>
                        </td>
                        <td class="pt-2"><?= $row['deskripsi']; ?></td>
                        <td class="text-center" style="width: 3%;">
                            <a href="#" id="del" data-id="<?= @$row['id']; ?>" data-nama="<?= @$row['deskripsi']; ?>" data-act="delkualifikasi"><i class="ri-delete-bin-fill text-danger fs-18"></i></a>
                        </td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
<?php }
if (@$_POST['judul'] == 'tabel_syarat_administrasi') {
    $sql = $proses->tampil_data_select('*', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Kualifikasi" AND menu = "Syarat-Administrasi" ORDER BY id ASC');
?>
    <table class="table table-sm">
        <tbody>
            <?php if (empty($sql)) { ?>
                <tr>
                    <td class="p-2" colspan="3">Belum ada Data</td>
                </tr>
                <?php } else {
                foreach ($sql as $row) {
                ?>
                    <tr>
                        <td class="text-center" style="width: 1%;">
                            <i class="ri-checkbox-circle-fill text-success fs-18"></i>
                        </td>
                        <td class="pt-2"><?= $row['deskripsi']; ?></td>
                        <td class="text-center" style="width: 3%;">
                            <a href="#" id="del" data-id="<?= @$row['id']; ?>" data-nama="<?= @$row['deskripsi']; ?>" data-act="delkualifikasi"><i class="ri-delete-bin-fill text-danger fs-18"></i></a>
                        </td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
<?php }
if (@$_POST['judul'] == 'tabel_syarat_administrasi_teknis') {
    $sql = $proses->tampil_data_select('*', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Kualifikasi" AND menu = "Teknis" ORDER BY id ASC');
?>
    <table class="table table-sm">
        <tbody>
            <?php if (empty($sql)) { ?>
                <tr>
                    <td class="p-2" colspan="3">Belum ada Data</td>
                </tr>
                <?php } else {
                foreach ($sql as $row) {
                ?>
                    <tr>
                        <td class="text-center" style="width: 1%;">
                            <i class="ri-checkbox-circle-fill text-success fs-18"></i>
                        </td>
                        <td class="pt-2"><?= $row['deskripsi']; ?></td>
                        <td class="text-center" style="width: 3%;">
                            <a href="#" id="del" data-id="<?= @$row['id']; ?>" data-nama="<?= @$row['deskripsi']; ?>" data-act="delkualifikasi"><i class="ri-delete-bin-fill text-danger fs-18"></i></a>
                        </td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
<?php }
if (@$_POST['judul'] == 'tabel_tenaga_ahli') {
    $sql = $proses->tampil_data_select('*', 'dokumen_tenaga_ahli', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Ahli" ORDER BY id ASC');
?>
    <table class="table table-sm">
        <thead>
            <tr class="table-light">
                <th class="p-2 w-25">Jenis Keahlian</th>
                <th class="p-2 w-25">Keahlian/Spesifikasi</th>
                <th class="p-2 w-25">Pengalaman</th>
                <th class="p-2 w-25">Kemampuan Manajerial</th>
                <th class="p-2" style="width: 3%;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($sql)) { ?>
                <tr>
                    <td class="p-2" colspan="5">Belum ada Data</td>
                </tr>
                <?php } else {
                foreach ($sql as $row) {
                ?>
                    <tr>
                        <td class="p-2"><?= @$row['jenis_keahlian']; ?></td>
                        <td class="p-2"><?= @$row['spesifikasi']; ?></td>
                        <td class="p-2"><?= @$row['pengalaman']; ?></td>
                        <td class="p-2"><?= @$row['kemampuan']; ?></td>
                        <td class="text-center" style="width: 3%;">
                            <a href="#" id="del" data-id="<?= @$row['id']; ?>" data-nama="<?= @$row['jenis_keahlian']; ?>" data-act="deltenagaahli"><i class="ri-delete-bin-fill text-danger fs-18"></i></a>
                        </td>
                    </tr>
            <?php
                }
            } ?>
        </tbody>
    </table>
<?php }
if (@$_POST['judul'] == 'tabel_tenaga_teknis') {
    $sql = $proses->tampil_data_select('*', 'dokumen_tenaga_ahli', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Teknis" ORDER BY id ASC');
?>
    <table class="table table-sm">
        <thead>
            <tr class="table-light">
                <th class="p-2 w-25">Jenis Kemampuan</th>
                <th class="p-2 w-25">Kemampuan Teknis</th>
                <th class="p-2 w-25">Pengalaman</th>
                <th class="p-2 w-25">Kemampuan Manajerial</th>
                <th class="p-2" style="width: 3%;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($sql)) { ?>
                <tr>
                    <td class="p-2" colspan="5">Belum ada Data</td>
                </tr>
                <?php } else {
                foreach ($sql as $row) {
                ?>
                    <tr>
                        <td class="p-2"><?= @$row['jenis_keahlian']; ?></td>
                        <td class="p-2"><?= @$row['spesifikasi']; ?></td>
                        <td class="p-2"><?= @$row['pengalaman']; ?></td>
                        <td class="p-2"><?= @$row['kemampuan']; ?></td>
                        <td class="text-center" style="width: 3%;">
                            <a href="#" id="del" data-id="<?= @$row['id']; ?>" data-nama="<?= @$row['jenis_keahlian']; ?>" data-act="deltenagaahli"><i class="ri-delete-bin-fill text-danger fs-18"></i></a>
                        </td>
                    </tr>
            <?php
                }
            } ?>
        </tbody>
    </table>
<?php }
if (@$_POST['judul'] == 'tabel_peralatan') {
    $sql = $proses->tampil_data_select('*', 'dokumen_peralatan', '1=1 AND kode_paket = "' . $_POST['id'] . '" ORDER BY id ASC');
?>
    <table class="table table-sm">
        <thead>
            <tr class="table-light">
                <th class="p-2 w-25">Nama Peralatan</th>
                <th class="p-2">Spesifikasi</th>
                <th class="p-2" style="width: 3%;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($sql)) { ?>
                <tr>
                    <td class="p-2" colspan="3">Belum ada Data</td>
                </tr>
                <?php } else {
                foreach ($sql as $row) {
                ?>
                    <tr>
                        <td class="p-2"><?= @$row['nama_peralatan']; ?></td>
                        <td class="p-2"><?= @$row['spesifikasi']; ?></td>
                        <td class="text-center" style="width: 3%;">
                            <a href="#" id="del" data-id="<?= @$row['id']; ?>" data-nama="<?= @$row['nama_peralatan']; ?>" data-act="delperalatan"><i class="ri-delete-bin-fill text-danger fs-18"></i></a>
                        </td>
                    </tr>
            <?php
                }
            } ?>
        </tbody>
    </table>
<?php }
if (@$_POST['act'] == 'form_izin_lainnya') {
?>
    <div class="modal-header">
        <h5 class="modal-title">Izin Usaha Lainnya</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
        <input type="hidden" name="act" value="form_izin_lainnya">
        <div class="modal-body pt-3">
            <div class="col-xxl-12 col-md-12 pt-2">
                <label for="basiInput" class="form-label">Jenis Persyaratan</label>
                <input type="text" name="deskripsi" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
            <button id="simpan" class="btn btn-success" type="submit"><i class="ri-save-2-fill"></i> Simpan</button>
        </div>
    </form>
<?php }
if (@$_POST['act'] == 'form_syarat_administrasi') {
?>
    <div class="modal-header">
        <h5 class="modal-title">Syarat Administrasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
        <input type="hidden" name="act" value="form_syarat_administrasi">
        <div class="modal-body pt-3">
            <div class="col-xxl-12 col-md-12 pt-2">
                <label for="basiInput" class="form-label">Jenis Persyaratan</label>
                <input type="text" name="deskripsi" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
            <button id="simpan" class="btn btn-success" type="submit"><i class="ri-save-2-fill"></i> Simpan</button>
        </div>
    </form>
<?php }
if (@$_POST['act'] == 'form_syarat_administrasi_teknis') {
?>
    <div class="modal-header">
        <h5 class="modal-title">Syarat Kualifikasi Teknis</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
        <input type="hidden" name="act" value="form_syarat_administrasi_teknis">
        <div class="modal-body pt-3">
            <div class="col-xxl-12 col-md-12 pt-2">
                <label for="basiInput" class="form-label">Jenis Persyaratan</label>
                <textarea type="text" name="deskripsi" class="form-control" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
            <button id="simpan" class="btn btn-success" type="submit"><i class="ri-save-2-fill"></i> Simpan</button>
        </div>
    </form>
<?php }
if (@$_POST['act'] == 'form_tenaga_ahli') {
?>
    <div class="modal-header">
        <h5 class="modal-title">Memiliki SDM Tenaga Ahli (Jika Diperlukan)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
        <input type="hidden" name="act" value="form_tenaga_ahli">
        <div class="modal-body pt-3">
            <div class="row">
                <div class="col-xxl-6 col-md-6 pt-2">
                    <label for="basiInput" class="form-label">Jenis Keahlian</label>
                    <input type="text" name="jenis_keahlian" class="form-control" required>
                </div>
                <div class="col-xxl-6 col-md-6 pt-2">
                    <label for="basiInput" class="form-label">Keahlian/Spesifikasi</label>
                    <input type="text" name="spesifikasi" class="form-control" required>
                </div>
                <div class="col-xxl-6 col-md-6 pt-2">
                    <label for="basiInput" class="form-label">Pengalaman</label>
                    <input type="text" name="pengalaman" class="form-control" required>
                </div>
                <div class="col-xxl-6 col-md-6 pt-2">
                    <label for="basiInput" class="form-label">Kemampuan Manajerial</label>
                    <input type="text" name="kemampuan" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
            <button id="simpan" class="btn btn-success" type="submit"><i class="ri-save-2-fill"></i> Simpan</button>
        </div>
    </form>
<?php }
if (@$_POST['act'] == 'form_tenaga_teknis') {
?>
    <div class="modal-header">
        <h5 class="modal-title">Memiliki SDM Tenaga Teknis/Terampil (Jika Diperlukan)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
        <input type="hidden" name="act" value="form_tenaga_teknis">
        <div class="modal-body pt-3">
            <div class="row">
                <div class="col-xxl-6 col-md-6 pt-2">
                    <label for="basiInput" class="form-label">Jenis Keahlian</label>
                    <input type="text" name="jenis_keahlian" class="form-control" required>
                </div>
                <div class="col-xxl-6 col-md-6 pt-2">
                    <label for="basiInput" class="form-label">Kemampuan Teknis</label>
                    <input type="text" name="spesifikasi" class="form-control" required>
                </div>
                <div class="col-xxl-6 col-md-6 pt-2">
                    <label for="basiInput" class="form-label">Pengalaman</label>
                    <input type="text" name="pengalaman" class="form-control" required>
                </div>
                <div class="col-xxl-6 col-md-6 pt-2">
                    <label for="basiInput" class="form-label">Kemampuan Manajerial</label>
                    <input type="text" name="kemampuan" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
            <button id="simpan" class="btn btn-success" type="submit"><i class="ri-save-2-fill"></i> Simpan</button>
        </div>
    </form>
<?php }
if (@$_POST['act'] == 'form_peralatan') {
?>
    <div class="modal-header">
        <h5 class="modal-title">Memiliki Kemampuan Untuk Menyediakan Peralatan (Jika Diperlukan)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
        <input type="hidden" name="act" value="form_peralatan">
        <div class="modal-body pt-3">
            <div class="row">
                <div class="col-xxl-6 col-md-6 pt-2">
                    <label for="basiInput" class="form-label">Nama Peralatan</label>
                    <input type="text" name="nama_peralatan" class="form-control" required>
                </div>
                <div class="col-xxl-6 col-md-6 pt-2">
                    <label for="basiInput" class="form-label">Spesifikasi</label>
                    <input type="text" name="spesifikasi" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
            <button id="simpan" class="btn btn-success" type="submit"><i class="ri-save-2-fill"></i> Simpan</button>
        </div>
    </form>
<?php }
if (@$_POST['judul'] == 'tabel_jadwal') {
?>
    <table class="table table-bordered table-sm fs-13">
        <thead>
            <tr class="table-light">
                <th class="p-2 text-center" style="width:3%;">No</th>
                <th class="p-2 w-auto">Tahap</th>
                <th class="p-2 text-center w-xs" colspan="2">Tanggal Mulai</th>
                <th class="p-2 text-center w-xs" colspan="2">Tanggal Selesai</th>
                <th class="p-2 text-center">#</th>
            </tr>
        </thead>
        <tbody>
            <form id="jadwalForm">
                <?php
                $sql = $proses->tampil_data_select('*', 'jadwal_paket', '1=1 ORDER BY id ASC');
                foreach ($sql as $row) {
                    $cek = $proses->tampil_data_saja('*', 'jadwal', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND nomor = "' . $row['id'] . '"');
                ?>
                    <tr>
                        <td class="p-2 text-center"><?= $row['id']; ?></td>
                        <td class="p-2"><?= $row['tahap'] . ' <span class="badge text-bg-success fs-12">' . hitungDurasi(@$cek['tgl_mulai'], @$cek['tgl_selesai']) . '</span>'; ?>
                            <p class="m-0 text-success fs-12"><?= @$row['keterangan']; ?></p>
                        </td>
                        <td class="p-2"><input type="date" value="<?= ubah_tgl_edit2(@$cek['tgl_mulai']); ?>" name="tgl_mulai_<?= @$row['id']; ?>" class="form-control" required></td>
                        <td class="p-2" style="width: 10%;"><input type="text" value="<?= ubah_jam_edit(@$cek['tgl_mulai']); ?>" name="jam_mulai_<?= $row['id']; ?>" class="form-control cleave-time-format" placeholder="hh:mm"></td>
                        <td class="p-2"><input type="date" value="<?= ubah_tgl_edit2(@$cek['tgl_selesai']); ?>" name="tgl_selesai_<?= @$row['id']; ?>" class="form-control" required></td>
                        <td class="p-2" style="width: 10%;"><input type="text" value="<?= ubah_jam_edit(@$cek['tgl_selesai']); ?>" name="jam_selesai_<?= $row['id']; ?>" class="form-control cleave-time-format" placeholder="hh:mm"></td>
                        <td class="p-2 text-center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="simpanBaris(<?= $row['id']; ?>, '<?= $row['tahap']; ?>','<?= $_POST['id']; ?>')">
                                <i class="ri-save-line fs-14"></i>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </form>
        </tbody>
    </table>
    <script>
        var cleaveTimeFormat;
        document.querySelectorAll(".cleave-time-format").forEach((element) => {
            cleaveTimeFormat = new Cleave(element, {
                time: true,
                timePattern: ["h", "m"]
            });
        });
    </script>
<?php } ?>