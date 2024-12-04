<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/menu.php');
require_once('../../config/fungsi_indotgl.php');
require_once('../../config/cek_ajax.php');
?>
<form id="form">
    <?php
    if ($_POST['act'] == 'add') {
        $judul = 'Tambah Jadwal';
        echo '<input type="hidden" name="act" value="add">';
        echo '<input type="hidden" name="id_paket" value="' . $_POST['id'] . '">';
    } else {
        $s = $proses->tampil_data_saja('*', 'jadwal_paket', '1=1 AND id_jadwal = "' . $_POST['id'] . '"');
        $judul = 'Edit Jadwal';
        echo '<input type="hidden" name="act" value="edit">';
        echo '<input type="hidden" name="id" value="' . $s['id_jadwal'] . '">';
    }
    ?>
    <div class="modal-header">
        <h5 class="modal-title"><?= $judul; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body pt-3">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-xxl-12 col-md-12 pt-2">
                    <label for="basiInput" class="form-label">Tahap</label>
                    <?= tahap('tahap', @$s['tahap']); ?>
                </div>
                <div class="row">
                    <div class="col-xxl-6 col-md-6 pt-2">
                        <label for="basiInput" class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tgl_mulai1" class="form-control" value="<?= ubah_tgl_edit2(@$s['tgl_mulai']); ?>" required>
                        <input type="time" name="tgl_mulai2" class="form-control" value="<?= ubah_jam_edit(@$s['tgl_selesai']); ?>" required>
                    </div>
                    <div class="col-xxl-6 col-md-6 pt-2">
                        <label for="basiInput" class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tgl_selesai1" class="form-control" value="<?= ubah_tgl_edit2(@$s['tgl_selesai']); ?>" required>
                        <input type="time" name="tgl_selesai2" class="form-control" value="<?= ubah_jam_edit(@$s['tgl_selesai']); ?>" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0);" class="btn btn-link link-primary fw-medium" data-bs-dismiss="modal">Batal</a>
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</form>