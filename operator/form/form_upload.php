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
if (@$_POST['judul'] == 'dokumen_persiapan') {
    $cek1 = $proses->tampil_data_saja('nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "KAK"');
    $cek2 = $proses->tampil_data_saja('nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Kontrak"');
    $cek3 = $proses->tampil_data_saja('nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Pekerjaan"');
    $cek4 = $proses->tampil_data_saja('nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Lainnya"');
    if (empty(@$cek1['file'])) {
        $ceklist1 = '';
    } else {
        $ceklist1 = '<i class="ri-checkbox-circle-fill text-success fs-20"></i>';
    }
    if (empty(@$cek2['file'])) {
        $ceklist2 = '';
    } else {
        $ceklist2 = '<i class="ri-checkbox-circle-fill text-success fs-20"></i>';
    }
    if (empty(@$cek3['file'])) {
        $ceklist3 = '';
    } else {
        $ceklist3 = '<i class="ri-checkbox-circle-fill text-success fs-20"></i>';
    }
    if (empty(@$cek3['file'])) {
        $ceklist3 = '';
    } else {
        $ceklist3 = '<i class="ri-checkbox-circle-fill text-success fs-20"></i>';
    }
    if (empty(@$cek4['file'])) {
        $ceklist4 = '';
    } else {
        $ceklist4 = '<i class="ri-checkbox-circle-fill text-success fs-20"></i>';
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
                <div class="flex-grow-1 pt-1 ms-3">
                    Kerangka Acuan Kerja (KAK) Spesifikasi Teknis dan Gambar * <?= $ceklist1; ?>
                </div>
                <div class="flex-shrink-0 ms-0">
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $_POST['id']; ?>" data-act="form_kak"><i class="ri-upload-cloud-2-line"></i> Upload</button>
                </div>
            </div>
        </li>
        <li class="list-group-item ps-0 pe-3">
            <div class="d-flex align-items-start">
                <div class="flex-grow-1 pt-1 ms-3">
                    Rancangan Kontrak * <?= @$ceklist2; ?>
                </div>
                <div class="flex-shrink-0 ms-2">
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $_POST['id']; ?>" data-act="form_kontrak"><i class="ri-upload-cloud-2-line"></i> Upload</button>
                </div>
            </div>
        </li>
        <li class="list-group-item ps-0 pe-3">
            <div class="d-flex align-items-start">
                <div class="flex-grow-1 pt-1 ms-3">
                    Uraian Singkat Pekerjaan * <?= @$ceklist3; ?>
                </div>
                <div class="flex-shrink-0 ms-2">
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $_POST['id']; ?>" data-act="form_pekerjaan"><i class="ri-upload-cloud-2-line"></i> Upload</button>
                </div>
            </div>
        </li>
        <li class="list-group-item ps-0 pe-3">
            <div class="d-flex align-items-start">
                <div class="flex-grow-1 pt-1 ms-3">
                    Informasi Lainnya (jika ada) <?= @$ceklist4; ?>
                </div>
                <div class="flex-shrink-0 ms-2">
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $_POST['id']; ?>" data-act="form_lainnya"><i class="ri-upload-cloud-2-line"></i> Upload</button>
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
        <h5 class="modal-title">Upload Rincian HPS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="form" enctype="multipart/form-data">
        <?php
        if (empty(@$cek['file'])) {
            echo '<input type="hidden" name="act" value="upload_hps">';
            $text = '';
            $required = 'required';
        } else {
            echo '<input type="hidden" name="act" value="update_hps">';
            $text = '<br>Kosongkan Jika tidak merubah file';
            $required = '';
        }
        ?>
        <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
        <div class="modal-body pt-3">
            <div class="row">
                <div class="col-xxl-6 col-md-6 pt-2">
                    <label for="basiInput" class="form-label">Total PAGU</label>
                    <input type="text" class="form-control" value="<?= number_format(@$row['nilai_pagu']); ?>" readonly>
                </div>
                <div class="col-xxl-6 col-md-6 pt-2">
                    <label for="basiInput" class="form-label">Nilai HPS</label>
                    <input type="text" class="form-control nilai_hps" name="nilai_hps" value="<?= number_format(@$row['nilai_hps']); ?>" required>
                </div>
                <div class="col-xxl-12 col-md-12 pt-2">
                    <label for="basiInput" class="form-label">Upload File</label>
                    <input type="file" onchange="return validasiFile()" name="fupload" id="file" class="form-control" <?= $required; ?>>
                    <div id="passwordHelpBlock" class="form-text">
                        *Accepted formats: *.xlsx, *.xls Max file size 5Mb <?= @$text; ?>
                    </div>
                </div>
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
            var ekstensiOk = /(\.xlsx|\.xls)$/i;
            var file_size = $('#file')[0].files[0].size;
            if (!ekstensiOk.exec(pathFile)) {
                alert('Silakan upload file yang memiliki ekstensi *.xls, *.xlsx');
                inputFile.value = '';
                return false;
            } else {
                if (file_size > 5000000) {
                    alert('Ukuran file harus kurang dari 5Mb');
                    inputFile.value = '';
                    return false;
                }
            }
        }

        var rupiahFields = document.querySelectorAll('.nilai_hps');
        rupiahFields.forEach(function(field) {
            field.addEventListener('keyup', function(e) {
                field.value = formatRupiah(this.value);
            });
        });
    </script>
<?php }
if (@$_POST['act'] == 'form_kak') {
    $sql = $proses->tampil_data_select('id,nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "KAK"');
?>
    <div class="modal-header">
        <h5 class="modal-title">Daftar Kerangka Acuan Kerja (KAK) Spesifikasi Teknis dan Gambar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="form" enctype="multipart/form-data">
        <?php
        echo '<input type="hidden" name="act" value="upload_kak">';
        ?>
        <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
        <div class="modal-body pt-3">
            <div class="col-xxl-12 col-md-12 pt-2">
                <!-- Primary Alert -->
                <div class="alert alert-primary mb-2" role="alert">
                    <ol type="1" class="ps-2 mb-0">
                        Petunjuk upload dokumen Kerangka Acuan Kerja (KAK)/Spesifikasi Teknis dan Gambar:
                        <li>Perhatikan file yang akan di upload, pastikan bahwa file tersebut adalah dokumen Kerangka Acuan Kerja (KAK)/Spesifikasi Teknis dan Gambar untuk Tender ini;</li>
                        <li>Harap Jangan upload Dokumen Persiapan Pengadaan di sini,</li>
                        <li>Dokumen yang dapat di upload hanya File/dokumen yang memiliki ekstensi <b> *.doc, *.docx, *.xls, *.xlsx, *.pdf, *.jpg, *.jpeg, *.png, *.zip atau *.rar, </b>dan</li>
                        <li>Klik button Upload yang ada dibawah ini untuk upload bagian dari dokumen Kerangka Acuan Kerja (KAK)/Spesifikasi Teknis dan Gambar (bisa lebih dari 1 (satu) file/dokumen).</li>
                    </ol>
                </div>
                <label for="basiInput" class="form-label">Upload File</label>
                <input type="file" onchange="return validasiFile()" name="fupload" id="file" class="form-control" required>
                <div id="passwordHelpBlock" class="form-text">
                    *Max file size 10Mb
                </div>
                <table class="table table-bordered mt-3">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 3%;">No</th>
                            <th>Nama File</th>
                            <th>Tanggal Upload</th>
                            <th class="text-center" style="width: 5%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($sql as $row) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                                <td><a href="<?= $url; ?>berkas/<?= @$row['file']; ?>" target="_blank"><?= @$row['nama_file']; ?></a></td>
                                <td><?= tgl_indo5(@$row['timestamp']); ?></td>
                                <td class="text-center"><a href="#" id="del" data-id="<?= @$row['id']; ?>" data-nama="<?= @$row['nama_file']; ?>" data-act="delfile"><i class="ri-delete-bin-fill align-bottom text-danger fs-15"></i></a></td>
                            </tr>
                        <?php $no++;
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
            var allowedExtensions = /(\.doc|\.docx|\.xls|\.xlsx|\.pdf|\.jpg|\.jpeg|\.png|\.zip|\.rar)$/i;

            if (!allowedExtensions.exec(pathFile)) {
                alert('Silakan upload file dengan ekstensi *.doc, *.docx, *.xls, *.xlsx, *.pdf, *.jpg, *.jpeg, *.png, *.zip, atau *.rar');
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
if (@$_POST['act'] == 'form_kontrak') {
    $sql = $proses->tampil_data_select('id,nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Kontrak"');
?>
    <div class="modal-header">
        <h5 class="modal-title">Daftar Rancangan Kontrak</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="form" enctype="multipart/form-data">
        <?php
        echo '<input type="hidden" name="act" value="upload_kontrak">';
        ?>
        <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
        <div class="modal-body pt-3">
            <div class="col-xxl-12 col-md-12 pt-2">
                <!-- Primary Alert -->
                <div class="alert alert-primary mb-2" role="alert">
                    <ol type="1" class="ps-2 mb-0">
                        Petunjuk upload dokumen Rancangan Kontrak:
                        <li>Perhatikan file yang akan di upload, pastikan bahwa file torsebut adalah dokuman Rancangan Kontrak untuk Tender ini; </li>
                        <li>Harap Jangan upload Dokumen Persiapan Pengadaan di sini,</li>
                        <li>Dokumen yang dapat di upload hanya lile/dokumen yang memiliki ekstensi <b>*.pdf,</b> dan</li>
                        <li>Klik tombol Simpan yang ada dibawah ini untuk upload bagian dari Rancangan Kontak (bisa lebih dari 1 (satu) file/dokumen).</li>
                    </ol>
                </div>
                <div class="alert alert-warning mb-2" role="alert">
                    Bagian dari Rancangan Kontrak adalah Surat Perjanjian, Syarat-Syarat Khusus Kontrak (SSKK) dan Syarat-Syarat Umum Kontrak (SSUK)
                </div>
                <label for="basiInput" class="form-label">Upload File</label>
                <input type="file" onchange="return validasiFile()" name="fupload" id="file" class="form-control" required>
                <div id="passwordHelpBlock" class="form-text">
                    *Max file size 10Mb
                </div>
                <table class="table table-bordered mt-3">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 3%;">No</th>
                            <th>Nama File</th>
                            <th>Tanggal Upload</th>
                            <th class="text-center" style="width: 5%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($sql as $row) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                                <td><a href="<?= $url; ?>berkas/<?= @$row['file']; ?>" target="_blank"><?= @$row['nama_file']; ?></a></td>
                                <td><?= tgl_indo5(@$row['timestamp']); ?></td>
                                <td class="text-center"><a href="#" id="del" data-id="<?= @$row['id']; ?>" data-nama="<?= @$row['nama_file']; ?>" data-act="delfile"><i class="ri-delete-bin-fill align-bottom text-danger fs-15"></i></a></td>
                            </tr>
                        <?php $no++;
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
if (@$_POST['act'] == 'form_pekerjaan') {
    $sql = $proses->tampil_data_select('id,nama_file,file,timestamp', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Pekerjaan"');
    $cek = $proses->tampil_data_saja('file', 'dokumen_persiapan', '1=1 AND kode_paket = "' . $_POST['id'] . '" AND jenis = "Pekerjaan"');
?>
    <div class="modal-header">
        <h5 class="modal-title">Daftar Uraian Singkat Pekerjaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="form" enctype="multipart/form-data">
        <?php
        echo '<input type="hidden" name="act" value="upload_pekerjaan">';
        ?>
        <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
        <div class="modal-body pt-3">
            <div class="col-xxl-12 col-md-12 pt-2">
                <!-- Primary Alert -->
                <div class="alert alert-primary mb-2" role="alert">
                    <ol type="1" class="ps-2 mb-0">
                        Petunjuk upload dokumen Uraian Singkat Pekerjaan:
                        <li>Perhatikan file yang akan di upload, pastikan bahwa filo torsobut adalah dokuman Uraian Singkat Pokerjaan untuk Tondor ini: </li>
                        <li>Harap Jangan upload Dokumen Persiapan Pengadaan di sini,</li>
                        <li>Dokumen yang dapat di upload hanya lile/dokumen yang memiliki ekstensi <b>*.pdf,</b> dan</li>
                        <li>Klik tombol Simpan yang ada dibawah ini untuk upload bagian dari dokumen Uraian Singkat Pekerjaan (hanya 1 (satu) file/dokumen).</li>
                    </ol>
                </div>
                <?php
                if (empty(@$cek['file'])) {
                ?>
                    <label for="basiInput" class="form-label">Upload File</label>
                    <input type="file" onchange="return validasiFile()" name="fupload" id="file" class="form-control" required>
                    <div id="passwordHelpBlock" class="form-text">
                        *Max file size 10Mb
                    </div>
                <?php } ?>
                <table class="table table-bordered mt-3">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 3%;">No</th>
                            <th>Nama File</th>
                            <th>Tanggal Upload</th>
                            <th class="text-center" style="width: 5%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($sql as $row) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                                <td><a href="<?= $url; ?>berkas/<?= @$row['file']; ?>" target="_blank"><?= @$row['nama_file']; ?></a></td>
                                <td><?= tgl_indo5(@$row['timestamp']); ?></td>
                                <td class="text-center"><a href="#" id="del" data-id="<?= @$row['id']; ?>" data-nama="<?= @$row['nama_file']; ?>" data-act="delfile"><i class="ri-delete-bin-fill align-bottom text-danger fs-15"></i></a></td>
                            </tr>
                        <?php $no++;
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

        var rupiahFields = document.querySelectorAll('.nilai_hps');
        rupiahFields.forEach(function(field) {
            field.addEventListener('keyup', function(e) {
                field.value = formatRupiah(this.value);
            });
        });
    </script>
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
                <table class="table table-bordered mt-3">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 3%;">No</th>
                            <th>Nama File</th>
                            <th>Tanggal Upload</th>
                            <th class="text-center" style="width: 5%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($sql as $row) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                                <td><a href="<?= $url; ?>berkas/<?= @$row['file']; ?>" target="_blank"><?= @$row['nama_file']; ?></a></td>
                                <td><?= tgl_indo5(@$row['timestamp']); ?></td>
                                <td class="text-center"><a href="#" id="del" data-id="<?= @$row['id']; ?>" data-nama="<?= @$row['nama_file']; ?>" data-act="delfile"><i class="ri-delete-bin-fill align-bottom text-danger fs-15"></i></a></td>
                            </tr>
                        <?php $no++;
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
if (@$_POST['judul'] == 'ukpbj') {
    $cek = $proses->cek_count('penugasan a LEFT JOIN paket_pekerjaan b ON a.id_paket = b.id_paket', 'b.kode_paket = "' . $_POST['id'] . '"');
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
        <table class="table table-bordered mb-0">
            <thead>
                <tr class="table-light">
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th style="width: 5%;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $row = $proses->tampil_data_saja(
                    'a.id,a.timestamp,b.nama',
                    'penugasan a LEFT JOIN operator b ON a.id_operator = b.id_operator',
                    '1=1'
                );
                ?>
                <tr>
                    <td><?= @$row['nama']; ?></td>
                    <td><?= tgl_indo(@$row['timestamp']); ?></td>
                    <td class="text-center"><a href="#" id="hapus_ukpbj" data-id="<?= @$row['id']; ?>"><i class="ri-delete-bin-line fs-15"></i></a></td>
                </tr>
            </tbody>
        </table>
    </div>
<?php }
if (@$_POST['judul'] == 'kirim_ukpbj') {
?>
    <a href="#" class="btn btn-warning btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#DetailModal" data-id="<?= $_POST['id']; ?>" data-act="email_ukpbj"> <i class="ri-mail-send-line"></i> Kirim Email UKPBJ</a>
<?php }
if (@$_POST['act'] == 'form_ukpbj') {
    $s = $proses->tampil_data_saja('*', 'paket_pekerjaan', '1=1 AND kode_paket = "' . $_POST['id'] . '"');
?>
    <div class="modal-header">
        <h5 class="modal-title">Pilih UKPBJ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-3">
        <table class="table table-bordered fs-13">
            <tbody>
                <tr>
                    <td>Kode Paket</td>
                    <td><?= $s['kode_paket']; ?></td>
                </tr>
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
            </tbody>
        </table>
        <table id="example" class="table table-bordered mb-0 fs-13">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Jabatan</th>
                    <th style="width: 5%;" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = $proses->tampil_data_select('*', 'operator', '1=1 AND level = "UKPBJ" ORDER BY id_operator DESC');
                foreach ($sql as $row) {
                ?>
                    <tr>
                        <td><?= $row['nama']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['alamat']; ?></td>
                        <td><?= $row['jabatan']; ?></td>
                        <td class="text-center"><a href="#" id="terapkan" data-id="<?= $s['id_paket']; ?>" data-operator="<?= $row['id_operator']; ?>" data-nama="<?= $row['nama']; ?>"><i class="ri-send-plane-line"></i></a></td>
                    </tr>
                <?php } ?>
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
if (@$_POST['act'] == 'email_ukpbj') {
    $s = $proses->tampil_data_saja('*', 'paket_pekerjaan', '1=1 AND kode_paket = "' . $_POST['id'] . '"');
?>
    <div class="modal-header">
        <h5 class="modal-title">Kirim Email UKPBJ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="form" enctype="multipart/form-data">
        <div class="modal-body pt-3">
            <p>Kami informasikan bahwa anda telah di tunjuk oleh PPK pada paket pekerjaan</p>
            <table class="table table-bordered fs-13">
                <tbody>
                    <tr>
                        <td>Kode Paket</td>
                        <td><?= $s['kode_paket']; ?></td>
                    </tr>
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
                        <td>Nilai PAGU</td>
                        <td>Rp. <?= number_format(@$s['nilai_pagu']); ?></td>
                    </tr>
                    <tr>
                        <td>Nilai HPS</td>
                        <td>Rp. <?= number_format(@$s['nilai_hps']); ?></td>
                    </tr>
                    <tr>
                        <td>Nota Dinas</td>
                        <td>
                            <input type="file" name="fupload" id="file" onchange="return validasiFile()" class="form-control" required>
                            <div id="passwordHelpBlock" class="form-text">
                                *Accepted formats: *.pdf
                            </div>
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
<?php } ?>