<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/menu.php');
require_once('../../config/fungsi_indotgl.php');
require_once('../../config/cek_ajax.php');
?>
<?php
if (@$_POST['act'] == 'pengalaman') {
?>
    <div class="col-xxl-12 col-md-12 pt-2">
        <div class="col-12">
            <span data-bs-toggle="modal" data-bs-target="#DetailModal" data-act="kbli" class="btn btn-primary btn-sm mb-2 cursor-pointer"><i class="ri-add-line align-bottom me-1"></i> Klasifikasi</span>
        </div>
        <table class="table table-bordered dt-responsive table-striped align-middle table-sm fs-13">
            <thead class="table-light">
                <tr>
                    <th class="text-center w-sm p-2">Kode KBLI</th>
                    <th class="w-100 p-2">Klasifikasi</th>
                    <th class="text-center w-xs p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = $proses->tampil_data_select('*', 'kode_kbli', 'id_profil = "' . $_SESSION['kode_profil'] . '" AND nomor_nib = "' . @$_POST['kode'] . '"');
                foreach ($sql as $row) {
                ?>
                    <tr>
                        <td class="text-center p-2"><?= $row['kode_kbli']; ?></td>
                        <td class="p-2"><?= $row['klasifikasi']; ?></td>
                        <td class="text-center p-2">
                            <span class="cursor-pointer" id="del" data-id="<?= $row['id']; ?>" data-act="delkbli" data-nama="<?= $row['kode_kbli'] . ' - ' . $row['klasifikasi']; ?>"><i class="ri-delete-bin-fill align-bottom me-2 text-danger fs-18"></i></span>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php
} else if (@$_POST['act'] == 'Nomor-Induk-Berusaha-(NIB)') {
?>
    <div class="col-xxl-12 col-md-12 pt-2">
        <label for="basiInput" class="form-label">Klasifikasi Bidang Usaha</label>
        <div class="col-12">
            <span data-bs-toggle="modal" data-bs-target="#DetailModal" data-act="kbli" class="btn btn-primary btn-sm mb-2 cursor-pointer"><i class="ri-add-line align-bottom me-1"></i> Klasifikasi</span>
        </div>
        <p>Silahkan masukan klasifikasi baku lapangan usaha (KBLI) perusahaan anda</p>
        <table class="table table-bordered dt-responsive table-striped table-sm align-middle fs-13">
            <thead class="table-light">
                <tr>
                    <th class="text-center p-2" style="width:10%;">Kode KBLI</th>
                    <th class="p-2">Klasifikasi</th>
                    <th class="text-center w-xs p-2" style="width: 3%;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = $proses->tampil_data_select('*', 'kode_kbli', 'id_profil = "' . $_SESSION['kode_profil'] . '" AND nomor_nib = "' . @$_POST['kode'] . '"');
                if (empty($sql)) { ?>
                    <tr>
                        <td class="p-2" colspan="3">Belum ada Data</td>
                    </tr>
                    <?php } else {
                    foreach ($sql as $row) {
                    ?>
                        <tr>
                            <td class="text-center p-2"><?= $row['kode_kbli']; ?></td>
                            <td class="p-2"><?= $row['klasifikasi']; ?></td>
                            <td class="text-center p-2">
                                <span class="cursor-pointer" id="del" data-id="<?= $row['id']; ?>" data-act="delkbli" data-nama="<?= $row['kode_kbli'] . ' - ' . $row['klasifikasi']; ?>"><i class="ri-delete-bin-fill align-bottom me-2 text-danger fs-18"></i></span>
                            </td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>
<?php }
if (@$_POST['act'] == 'kbli') { // MODAL CARI KBLI
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
?>