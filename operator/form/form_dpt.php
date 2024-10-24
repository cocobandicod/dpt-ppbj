<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/menu.php');
require_once('../../config/fungsi_indotgl.php');
require_once('../../config/cek_ajax.php');
?>

<?php
if (@$_POST['act'] == 'add') {
    $judul = 'Tambah Daftar Penyedia Terpilih';
?>
    <form id="form">
        <?php
        echo '<input type="hidden" name="act" value="add">';
        echo '<input type="hidden" name="id_paket" value="' . $_POST['id'] . '">';
        ?>
        <div class="modal-header">
            <h5 class="modal-title"><?= $judul; ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pt-3">
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-xxl-12 col-md-12 pt-2">
                        <label for="basiInput" class="form-label">Penyedia</label>
                        <select name="id_profil" class="form-select mb-2" data-choices data-choices-sorting="true" required>
                            <option value="" selected>Pilih --</option>
                            <?php
                            $sql = $proses->tampil_data_select('*', 'profil_badan_usaha', '1=1 AND status = "Terverifikasi" ORDER BY id_profil ASC');
                            foreach ($sql as $row) {
                            ?>
                                <option value="<?= $row['id_profil']; ?>"><?= $row['nama_perusahaan']; ?></option>
                            <?php } ?>
                        </select>
                        <!-- warning Alert -->
                        <div class="alert alert-warning mb-0" role="alert">
                            Daftar Penyedia Terpilih yang telah terverifikasi
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:void(0);" class="btn btn-link link-primary fw-medium" data-bs-dismiss="modal">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
    <script src="<?= $url; ?>assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        $(document).ready(function() {
            // Konfigurasi Choices.js
            var elementsWithChoices = document.querySelectorAll("[data-choices]");
            Array.from(elementsWithChoices).forEach(function(element) {
                var choicesConfig = {};
                new Choices(element, choicesConfig);
            });
        });
    </script>
<?php }
if (@$_POST['act'] == 'kirim') {
    $judul = 'Kirim Undangan';
    $row = $proses->tampil_data_saja(
        'a.id_daftar, a.id_paket, a.id_profil, b.badan_usaha, b.nama_perusahaan, c.email',
        'daftar_penyedia_terpilih a LEFT JOIN profil_badan_usaha b
        ON a.id_profil = b.id_profil
        LEFT JOIN akun_penyedia c 
        ON b.id_profil = c.id_akun',
        '1=1 AND a.id_daftar = "' . $_POST['id'] . '"'
    );
?>
    <form id="undangan" enctype="multipart/form-data">
        <?php
        echo '<input type="hidden" name="act" value="kirim">';
        echo '<input type="hidden" name="id_paket" value="' . $row['id_paket'] . '">';
        echo '<input type="hidden" name="id_profil" value="' . $row['id_profil'] . '">';
        ?>
        <div class="modal-header">
            <h5 class="modal-title"><?= $judul; ?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pt-3">
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-xxl-12 col-md-12 pt-2">
                        <label for="basiInput" class="form-label">Nama Penyedia</label>
                        <input type="text" class="form-control" name="nama" value="<?= @$row['nama_perusahaan']; ?>" readonly>
                    </div>
                    <div class="col-xxl-12 col-md-12 pt-2">
                        <label for="basiInput" class="form-label">Email Penyedia</label>
                        <input type="email" class="form-control" name="email" value="<?= @$row['email']; ?>" readonly>
                    </div>
                    <div class="col-xxl-12 col-md-12 pt-2">
                        <label for="basiInput" class="form-label">Judul</label>
                        <input type="text" class="form-control" name="judul" required>
                    </div>
                    <div class="col-xxl-12 col-md-12 pt-2">
                        <label for="basiInput" class="form-label">Isi Undangan</label>
                        <textarea name="isi_undangan" class="form-control ckeditor-classic"></textarea>
                    </div>
                    <div class="col-xxl-12 col-md-12 pt-2">
                        <label for="basiInput" class="form-label">File Lampiran (Jika Ada)</label>
                        <input type="file" id="file" onchange="return validasiFile()" name="fupload" class="form-control">
                        <div id="passwordHelpBlock" class="form-text">
                            *Accepted formats: pdf, Max file size 2Mb
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="javascript:void(0);" class="btn btn-link link-primary fw-medium" data-bs-dismiss="modal">Batal</a>
            <button type="submit" class="btn btn-primary" id="kirim">Kirim</button>
        </div>
    </form>
    <script>
        ClassicEditor.create(document.querySelector('.ckeditor-classic'), {
            toolbar: {
                items: [
                    'heading',
                    'bold', 'italic',
                    'link', 'blockQuote',
                    'bulletedList', 'numberedList', 'outdent', 'indent',
                    'insertTable',
                    'undo', 'redo'
                ],
                shouldNotGroupWhenFull: true
            }
        }).catch(error => {
            console.error(error);
        });

        function validasiFile() {
            var inputFile = document.getElementById('file');
            var pathFile = inputFile.value;
            var ekstensiOk = /(\.pdf)$/i;
            var file_size = $('#file')[0].files[0].size;
            if (!ekstensiOk.exec(pathFile)) {
                alert('Silakan upload file yang memiliki ekstensi .pdf');
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
    </script>
<?php } ?>