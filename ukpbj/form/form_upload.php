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
                    <a href="<?= $url; ?>ukpbj/daftar-paket/<?= $_POST['id']; ?>/<?= $_POST['tahun']; ?>/rincian-hps" class="btn btn-success btn-sm"><i class="ri-upload-cloud-2-line"></i> Rincian HPS</a>
                <?php } else {
                    $text = '';
                ?>
                    <span class="me-2"><a href="<?= $url; ?>berkas/hps/<?= $cek['file']; ?>" target="_blank"><?= $cek['nama_file']; ?></a> Upload Tanggal : <?= tgl_indo5(@$cek['timestamp']); ?></span>
                    <a href="<?= $url; ?>ukpbj/daftar-paket/<?= $_POST['id']; ?>/<?= $_POST['tahun']; ?>/rincian-hps" class="btn btn-success btn-sm"><i class="ri-upload-cloud-2-line"></i> Rincian HPS</a>
                <?php } ?>
            </div>
        </div>
    </li>
    <?= @$text; ?>
<?php }
if (@$_POST['judul'] == 'tabel_hps') {
    $s = $proses->tampil_data_saja('nilai_pagu', 'paket_pekerjaan', '1=1 AND kode_paket = "' . $_POST['id'] . '"');
?>
    <h5>Total Pagu : Rp. <?= number_format($s['nilai_pagu'], 0, ',', '.'); ?></h5>
    <table class="table table-sm table-bordered fs-12">
        <thead>
            <tr class="table-light">
                <th class="p-2 text-center" style="width:3%;">No.</th>
                <th class="p-2">Jenis Barang Jasa/Keluaran</th>
                <th class="p-2 text-center">Satuan</th>
                <th class="p-2 text-center" style="width:5%;">Volume</th>
                <th class="p-2 text-center">Harga/Biaya</th>
                <th class="p-2 text-center" style="width:5%;">Pajak(%)</th>
                <th class="p-2 text-center">Total</th>
                <th class="p-2">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = $proses->tampil_data_select(
                '*',
                'hps',
                '1=1 AND kode_paket = "' . $_POST['id'] . '" AND oleh = "PPK"'
            );
            $no = 1;
            $totalharga = 0;

            if (empty($sql)) {
                echo '<tr><td class="p-2" colspan="8">Belum ada Data</td></tr>';
            } else {
                foreach ($sql as $row) {
                    $totalharga += $row['total'];
                    if ($row['kunci_baris'] == 'KUNCI') {
                        $no_display = '';
                        $jenis_barang = '<b>' . $row['jenis_barang'] . '</b>';
                        $satuan = '';
                        $volume = '';
                        $harga = '';
                        $pajak = '';
                        $total = '';
                    } else {
                        $no_display = $no;
                        $jenis_barang = $row['jenis_barang'];
                        $satuan = $row['satuan'];
                        $volume = $row['volume'];
                        $harga = number_format($row['harga'], 2, ',', '.');
                        $pajak = $row['pajak'];
                        $total = number_format($row['total'], 2, ',', '.');
                    }
            ?>
                    <tr>
                        <td class="p-2 text-center"><?= $no_display; ?></td>
                        <td class="p-2"><?= $jenis_barang; ?></td>
                        <td class="p-2 text-center"><?= $satuan; ?></td>
                        <td class="p-2 text-center"><?= $volume; ?></td>
                        <td class="p-2 text-end"><?= $harga; ?></td>
                        <td class="p-2 text-center"><?= $pajak; ?></td>
                        <td class="p-2 text-end"><?= $total; ?></td>
                        <td class="p-2"><?= $row['keterangan']; ?></td>
                    </tr>
            <?php
                    if ($row['kunci_baris'] != 'KUNCI') {
                        $no++;  // Melanjutkan nomor urut setiap iterasi, kecuali untuk baris dengan kunci_baris = 'KUNCI'
                    }
                }
            } ?>
        </tbody>
    </table>
    <div class="col-xl-12">
        <div class="float-end">
            <table class="fs-14 mb-3">
                <tr>
                    <td><b>Total Nilai</b> <small class="fs-10">(Sebelum)</small></td>
                    <td><b>Rp. <?= number_format($totalharga, 2, ',', '.'); ?></b></td>
                </tr>
                <tr>
                    <td><b>Total Nilai</b> <small class="me-3 fs-10">(Pembulatan)</small></td>
                    <td><b>Rp. <?= number_format($totalharga, 2, ',', '.'); ?></b></td>
                </tr>
            </table>
        </div>
    </div>
<?php }
if (@$_POST['judul'] == 'dokumen_persiapan') {
    $cek1 = $proses->tampil_data_saja('nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "KAK"');
    $cek2 = $proses->tampil_data_saja('nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Kontrak"');
    $cek3 = $proses->tampil_data_saja('nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Pekerjaan"');
    $cek4 = $proses->tampil_data_saja('nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Lainnya"');
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
                    <th class="text-center P-2">Total Pagu</th>
                    <th class="text-center P-2">Nilai HPS</th>
                    <th class="text-center P-2">File HPS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-end P-2">Rp. <?= number_format(@$row['nilai_pagu']); ?></td>
                    <td class="text-end P-2">Rp. <?= number_format(@$row['nilai_hps']); ?></td>
                    <td class="text-end P-2"><span class="me-2"><a href="<?= $url; ?>berkas/<?= $cek['file']; ?>" target="_blank"><?= $cek['nama_file']; ?></a> | Upload Tanggal : <?= tgl_indo5(@$cek['timestamp']); ?></span></td>
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
                        <th class="P-2" style="width: 3%;">No</th>
                        <th class="P-2">Nama File</th>
                        <th class="P-2">Tanggal Upload</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (empty($sql)) {
                        echo '<tr><td class="p-2" colspan="3">Belum ada Data</td></tr>';
                    } else {
                        $no = 1;
                        foreach ($sql as $row) {
                    ?>
                            <tr>
                                <td class="P-2 text-center"><?= $no; ?></td>
                                <td class="P-2"><a href="<?= $url; ?>berkas/<?= @$row['file']; ?>" target="_blank"><?= @$row['nama_file']; ?></a></td>
                                <td class="P-2"><?= tgl_indo5(@$row['timestamp']); ?></td>
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
                        <th style="width: 3%;" class="P-2">No</th>
                        <th class="P-2">Nama File</th>
                        <th class="P-2">Tanggal Upload</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (empty($sql)) {
                        echo '<tr><td class="p-2" colspan="3">Belum ada Data</td></tr>';
                    } else {
                        $no = 1;
                        foreach ($sql as $row) {
                    ?>
                            <tr>
                                <td class="text-center P-2"><?= $no; ?></td>
                                <td class="P-2"><a href="<?= $url; ?>berkas/<?= @$row['file']; ?>" target="_blank"><?= @$row['nama_file']; ?></a></td>
                                <td class="P-2"><?= tgl_indo5(@$row['timestamp']); ?></td>
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
                        <th class="P-2" style="width: 3%;">No</th>
                        <th class="P-2">Nama File</th>
                        <th class="P-2">Tanggal Upload</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (empty($sql)) {
                        echo '<tr><td class="p-2" colspan="3">Belum ada Data</td></tr>';
                    } else {
                        $no = 1;
                        foreach ($sql as $row) {
                    ?>
                            <tr>
                                <td class="text-center P-2"><?= $no; ?></td>
                                <td class="P-2"><a href="<?= $url; ?>berkas/<?= @$row['file']; ?>" target="_blank"><?= @$row['nama_file']; ?></a></td>
                                <td class="P-2"><?= tgl_indo5(@$row['timestamp']); ?></td>
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
                            <th class="P-2" style="width: 3%;">No</th>
                            <th class="P-2">Nama File</th>
                            <th class="P-2">Tanggal Upload</th>
                            <th class="text-center P-2" style="width: 5%;">Aksi</th>
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
                                    <td class="text-center P-2"><?= $no; ?></td>
                                    <td class="P-2"><a href="<?= $url; ?>berkas/<?= @$row['file']; ?>" target="_blank"><?= @$row['nama_file']; ?></a></td>
                                    <td class="P-2"><?= tgl_indo5(@$row['timestamp']); ?></td>
                                    <td class="text-center P-2"><a href="#" id="del" data-id="<?= @$row['id']; ?>" data-nama="<?= @$row['nama_file']; ?>" data-act="delfile"><i class="ri-delete-bin-fill align-bottom text-danger fs-15"></i></a></td>
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

        var rupiahFields = document.querySelectorAll('.nilai_hps');
        rupiahFields.forEach(function(field) {
            field.addEventListener('keyup', function(e) {
                field.value = formatRupiah(this.value);
            });
        });
    </script>
<?php }
if (@$_POST['judul'] == 'pokja') {
    $cek = $proses->cek_count('penugasan a LEFT JOIN paket_pekerjaan b ON a.kode_paket = b.kode_paket', 'b.kode_paket = "' . $_POST['id'] . '" AND a.status = "POKJA"');
    if ($cek == 0) {
        $link = '<a href="#" class="btn btn-warning btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="' . $_POST['id'] . '" data-act="form_pokja"> <i class="ri-home-3-line"></i> Tambah POKJA</a>';
        $display = 'style="display:none;"';
    } else {
        $link = '<a href="#" class="btn btn-warning btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="' . $_POST['id'] . '" data-act="form_pokja"> <i class="ri-home-3-line"></i> Tambah POKJA</a>';
        $display = "";
    }
?>
    <?= $link; ?>
    <div <?= $display; ?>>
        <table class="table table-sm fs-13 mb-0">
            <thead>
                <tr class="table-light">
                    <th class="p-2 text-center" style="width: 3%;">No</th>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Tanggal</th>
                    <th style="width: 5%;" class="text-center P-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = $proses->tampil_data_select(
                    'a.id,a.timestamp,b.nama,b.email',
                    'penugasan a LEFT JOIN operator b 
                    ON a.id_operator = b.id_operator',
                    '1=1 AND a.kode_paket = "' . $_POST['id'] . '" 
                    AND a.status = "POKJA"'
                );
                if (empty($sql)) {
                    echo '<tr><td class="p-2" colspan="5">Belum ada Data</td></tr>';
                } else {
                    $no = 1;
                    foreach ($sql as $row) {
                ?>
                        <tr>
                            <td class="p-2 text-center"><?= $no; ?></td>
                            <td class="p-2"><?= @$row['nama']; ?></td>
                            <td class="p-2"><?= @$row['email']; ?></td>
                            <td class="p-2"><?= tgl_indo(@$row['timestamp']); ?></td>
                            <td class="text-center P-2"><a href="#" id="hapus_pokja" data-nama="<?= @$row['nama']; ?>" data-id="<?= @$row['id']; ?>"><i class="ri-delete-bin-fill text-danger fs-15"></i></a></td>
                        </tr>
                <?php $no++;
                    }
                } ?>
            </tbody>
        </table>
    </div>
<?php }
if (@$_POST['judul'] == 'status_paket') {
    $row = $proses->tampil_data_saja('status_paket', 'paket_pekerjaan', '1=1 AND kode_paket = "' . $_POST['id'] . '"');
    if ($row['status_paket'] == 'Lengkap') {
        echo '<span class="btn btn-success btn-sm"><i class="ri-check-line"></i> Lengkap</span>';
    } else if ($row['status_paket'] == 'Tidak-Lengkap') {
        echo '<span class="btn btn-danger btn-sm"><i class="ri-close-line"></i> Tidak Lengkap</span>';
    } else {
        echo '<a href="#" data-id="' . $_POST['id'] . '" data-sts="Lengkap" data-nama="Lengkap" class="btn btn-success btn-sm status"><i class="ri-check-line"></i> Lengkap</a> <a href="#" data-id="' . $_POST['id'] . '" data-nama="Tidak Lengkap" data-sts="Tidak-Lengkap" class="btn btn-sm btn-danger status"><i class="ri-close-line"></i> Tidak Lengkap</a>';
    }
}
if (@$_POST['judul'] == 'kirim_pokja') {
    $cek = $proses->tampil_data_saja('*', 'undangan_pokja', '1=1 AND kode_paket = "' . $_POST['id'] . '" ORDER BY timestamp DESC');
    if (empty($cek['id'])) {
        echo '<a href="#" class="btn btn-warning btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="' . $_POST['id'] . '" data-act="email_pokja"> <i class="ri-mail-send-line"></i> Kirim Email POKJA</a>';
    } else {
        $kirimulang = '<span class="cursor-pointer btn btn-warning btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="' . $_POST['id'] . '" data-act="email_pokja"> <i class="ri-mail-send-line"></i> Kirim Ulang</span>';
        $file = '<a href="' . $url . 'berkas/' . $cek['file'] . '" class="btn btn-info btn-sm mb-0" target="_blank"><i class="ri-file-download-line"></i> Nota Dinas Kepala UKPBJ</a>';
        echo '
        <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
            Sudah dikirim Email Tanggal ' . tgl_indo7($cek['timestamp']) . '
            ' . $kirimulang . ' ' . $file . '
        </div>';
    }
}
if (@$_POST['act'] == 'form_pokja') {
    $s = $proses->tampil_data_saja('*', 'paket_pekerjaan', '1=1 AND kode_paket = "' . $_POST['id'] . '"');
?>
    <div class="modal-header">
        <h5 class="modal-title">Pilih POKJA</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-3">
        <table class="table table-bordered table-sm fs-13">
            <tbody>
                <tr>
                    <td class="P-2">Kode Paket</td>
                    <td class="P-2"><?= $s['kode_paket']; ?></td>
                </tr>
                <tr>
                    <td class="P-2">Nama Pekerjaan</td>
                    <td class="P-2"><?= $s['nama_pekerjaan']; ?></td>
                </tr>
                <tr>
                    <td class="P-2">Lokasi Pekerjaan</td>
                    <td class="P-2"><?= $s['lokasi_pekerjaan']; ?></td>
                </tr>
                <tr>
                    <td class="P-2">Sumber Dana</td>
                    <td class="P-2"><?= $s['sumber_dana']; ?></td>
                </tr>
                <tr>
                    <td class="P-2">Tahun Anggaran</td>
                    <td class="P-2"><?= $s['tahun_anggaran']; ?></td>
                </tr>
            </tbody>
        </table>
        <table id="example" class="table table-bordered table-sm mb-0 fs-13">
            <thead class="table-light">
                <tr>
                    <th class="P-2">Nama</th>
                    <th class="P-2">Email</th>
                    <th class="P-2">Alamat</th>
                    <th class="P-2">Jabatan</th>
                    <th style="width: 5%;" class="text-center P-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = $proses->tampil_data_select(
                    'a.*,b.kode_paket',
                    'operator a LEFT JOIN penugasan b
                    ON a.id_operator = b.id_operator
                    AND b.kode_paket = "' . $_POST['id'] . '"',
                    '1=1 AND a.level = "POKJA"
                    AND b.id IS NULL'
                );
                if (empty($sql)) {
                    echo '<tr><td class="p-2" colspan="5">Belum ada Data</td></tr>';
                } else {
                    foreach ($sql as $row) {
                ?>
                        <tr>
                            <td class="P-2"><?= $row['nama']; ?></td>
                            <td class="P-2"><?= $row['email']; ?></td>
                            <td class="P-2"><?= $row['alamat']; ?></td>
                            <td class="P-2"><?= $row['jabatan']; ?></td>
                            <td class="text-center P-2"><a href="#" id="terapkan" data-id="<?= $s['kode_paket']; ?>" data-operator="<?= $row['id_operator']; ?>" data-nama="<?= $row['nama']; ?>"><span class="badge bg-success-subtle text-success fs-13">Pilih</span></a></td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
    </div>
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
<?php }
if (@$_POST['act'] == 'email_pokja') {
    $s = $proses->tampil_data_saja('*', 'paket_pekerjaan', '1=1 AND kode_paket = "' . $_POST['id'] . '"');
    $p = $proses->tampil_data_saja('b.id_operator, b.email', 'penugasan a LEFT JOIN operator b ON a.id_operator = b.id_operator', '1=1 AND a.kode_paket = "' . $_POST['id'] . '"');
?>
    <div class="modal-header">
        <h5 class="modal-title">Kirim Email POKJA</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="kirim_email" enctype="multipart/form-data">
        <?php
        echo '<input type="hidden" name="act" value="kirim_email_pokja">';
        echo '<input type="hidden" name="kode_paket" value="' . @$s['kode_paket'] . '">';
        ?>
        <textarea name="isi_undangan" style="display:none">
        <p>Kami informasikan bahwa anda telah di tunjuk oleh <?= $_SESSION['nama']; ?> pada paket pekerjaan</p>
                <table>
                        <tr>
                            <td >Kode Paket</td>
                            <td ><?= @$s['kode_paket']; ?></td>
                        </tr>
                        <tr>
                            <td >Nama Pekerjaan</td>
                            <td ><?= @$s['nama_pekerjaan']; ?></td>
                        </tr>
                        <tr>
                            <td >Lokasi Pekerjaan</td>
                            <td ><?= @$s['lokasi_pekerjaan']; ?></td>
                        </tr>
                        <tr>
                            <td >Sumber Dana</td>
                            <td ><?= @$s['sumber_dana']; ?></td>
                        </tr>
                        <tr>
                            <td >Tahun Anggaran</td>
                            <td ><?= @$s['tahun_anggaran']; ?></td>
                        </tr>
                        <tr>
                            <td >Nilai PAGU</td>
                            <td >Rp. <?= number_format(@$s['nilai_pagu']); ?></td>
                        </tr>
                        <tr>
                            <td >Nilai HPS</td>
                            <td >Rp. <?= number_format(@$s['nilai_hps']); ?></td>
                        </tr>
                        <tr>
                            <td  colspan="2">
                                Demikian disampaikan untuk dapat diproses lebih lanjut, atas perhatian dan kerjasamanya diucapkan terima kasih
                                <br><br><br>
                                Hormat Kami<br>
                                <?= $_SESSION['nama']; ?>
                            </td>
                        </tr>
                </table>
        </textarea>
        <div class="modal-body pt-3">
            <?php
            if (empty(@$p['email'])) {
                echo '
                <div class="alert alert-danger" role="alert">
                   Belum ada POKJA yang dipilih!
                </div>
                ';
                $display = 'none';
            } else {
                $display = '';
            ?>
                <p>Kami informasikan bahwa anda telah di tunjuk oleh <?= $_SESSION['nama']; ?> pada paket pekerjaan</p>
                <table class="table table-bordered table-sm fs-13">
                    <tbody>
                        <tr>
                            <td class="P-2">Kode Paket</td>
                            <td class="P-2"><?= @$s['kode_paket']; ?></td>
                        </tr>
                        <tr>
                            <td class="P-2">Nama Pekerjaan</td>
                            <td class="P-2"><?= @$s['nama_pekerjaan']; ?></td>
                        </tr>
                        <tr>
                            <td class="P-2">Lokasi Pekerjaan</td>
                            <td class="P-2"><?= @$s['lokasi_pekerjaan']; ?></td>
                        </tr>
                        <tr>
                            <td class="P-2">Sumber Dana</td>
                            <td class="P-2"><?= @$s['sumber_dana']; ?></td>
                        </tr>
                        <tr>
                            <td class="P-2">Tahun Anggaran</td>
                            <td class="P-2"><?= @$s['tahun_anggaran']; ?></td>
                        </tr>
                        <tr>
                            <td class="P-2">Nilai PAGU</td>
                            <td class="P-2">Rp. <?= number_format(@$s['nilai_pagu']); ?></td>
                        </tr>
                        <tr>
                            <td class="P-2">Nilai HPS</td>
                            <td class="P-2">Rp. <?= number_format(@$s['nilai_hps']); ?></td>
                        </tr>
                        <tr>
                            <td class="P-2">Nota Dinas</td>
                            <td class="P-2">
                                <input type="file" name="fupload" id="file" onchange="return validasiFile()" class="form-control" required>
                                <div id="passwordHelpBlock" class="form-text">
                                    *Accepted formats: *.pdf
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="P-2" colspan="2">
                                Demikian disampaikan untuk dapat diproses lebih lanjut, atas perhatian dan kerjasamanya diucapkan terima kasih
                                <br><br><br>
                                Hormat Kami<br>
                                <?= $_SESSION['nama']; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <?php } ?>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-light fw-medium" data-bs-dismiss="modal">Batal</a>
            <button id="simpan" class="btn btn-success" style="display:<?= $display; ?>;" type="submit"><i class="ri-mail-send-line"></i> Kirim</button>
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
<?php } ?>