<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/fungsi_indotgl.php');
require_once('../../config/cek_ajax.php');
$judul = $_POST['judul'];
if (@$judul == 'koppenyedia') {
    $row = $proses->tampil_data_saja('*', 'profil_badan_usaha', 'id_profil = "' . $_POST['id'] . '"');
    echo '<input type="hidden" name="id" value="' . $row['id_profil'] . '">';
    echo '<input type="hidden" name="act" value="detail">';
    if ($row['status'] == 'Terverifikasi') {
        $status = '<i class="ri-checkbox-circle-line text-success"></i>';
    } else {
        $status = '<i class="ri-close-circle-line text-danger"></i>';
    }
?>
    <div class="row">
        <div class="col-sm-6 pt-3 pb-3">
            <div class="revdiv">
                <h2><?= $row['nama_perusahaan'] . ' ' . $status; ?> </h2>
            </div>
        </div>
        <div class="col-sm-6 pt-3 pb-3">
            <?php
            $cek = $proses->cek_row('catatan', 'id_profil = "' . $_POST['id'] . '" AND status = "Verified" AND id_operator = "' . $_SESSION['kode_user'] . '" GROUP BY menu');
            $ver = $proses->cek_row('profil_badan_usaha', '1=1 AND id_profil = "' . $_POST['id'] . '" AND status = "Terverifikasi"');
            $ok = $proses->cek_row('verifikator', '1=1 AND id_profil = "' . $_POST['id'] . '" AND verifikasi = "Kualifikasi"');
            $oksaya = $proses->cek_row('verifikator', '1=1 AND id_profil = "' . $_POST['id'] . '" AND id_operator = "' . $_SESSION['kode_user'] . '" AND verifikasi = "Kualifikasi"');
            if ($ver == 1) {
                $kunci = 'disabled';
                $ket = '';
                $text = 'Terverifikasi';
                $color = 'btn-success';
                $ket = '
                <div class="alert alert-success" role="alert">
                Penyedia ini telah terverifikasi
                </div>
            ';
            } else {
                if ($oksaya == 1) {
                    $kunci = 'disabled';
                    $ket = '';
                    $text = 'Telah Diverifikasi';
                    $color = 'btn-success';
                    $ket = '
                    <div class="alert alert-success" role="alert">
                    Terima Kasih anda telah melakukan verifikasi pada penyedia ini 
                    </div>
                ';
                } else {
                    if ($cek >= 6) {
                        $kunci = '';
                        $text = 'Verifikasi Sekarang';
                        $color = 'btn-warning';
                        $ket = '
                        <div class="alert alert-warning" role="alert">
                        Klik Tombol Verifikasi Sekarang untuk mengubah status penyedia menjadi Terverifikasi<br>
                        Mohon untuk mengecek kembali dokumen pendaftaran penyedia apakah sudah benar-benar sesuai dengan persyaratan
                        </div>';
                        if ($ok == 3) {
                            $aksi = 'verifikasiemail';
                        } else {
                            $aksi = 'verifikasi';
                        }
                    } else {
                        $kunci = 'disabled';
                        $text = 'Belum Terverifikasi';
                        $color = 'btn-danger';
                        $ket = '
                        <div class="alert alert-danger" role="alert">
                        Tombol Verifikasi Penyedia akan aktif jika semua berkas syarat pendaftaran telah di verifikasi<br>
                        Klik Tombol Terverifikasi untuk mengubah status penyedia menjadi Terverifikasi
                        </div>
                    ';
                    }
                }
            }
            ?>
            <button id="<?= @$aksi; ?>" data-id="<?= $row['id_profil']; ?>" data-ok="<?= $ok; ?>" data-nama="<?= $row['nama_perusahaan']; ?>" type="button" class="btn <?= @$color; ?> btn-label waves-effect waves-light float-end <?= $kunci; ?>"><i class="ri-checkbox-circle-line label-icon align-middle fs-16 me-2"></i> <?= $text; ?></button>
        </div>

        <!-- Base Example -->
        <div class="col-sm-12 pt-0 pb-0">
            <?= $ket; ?>
        </div>
        <div class="col-sm-6 pt-0 pb-2">
            <div class="form-check card-radio">
                <label class="form-check-label" for="listGroupRadioGrid1">
                    <table class="table table-sm fs-12 mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th class="p-2">Nama Verifikator</th>
                                <th class="p-2 text-center">Status</th>
                                <th class="p-2">Tanggal Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = $proses->tampil_data_select(
                                'a.nama AS nama_verifikator, b.timestamp, CASE WHEN b.id_operator IS NOT NULL AND b.id_profil = "' . $_POST['id'] . '" THEN "Verifikasi" ELSE "Belum Verifikasi" END AS status',
                                'operator a LEFT JOIN verifikator b ON a.id_operator = b.id_operator AND b.id_profil = "' . $_POST['id'] . '"',
                                '1=1 AND a.level = "Verifikator"'
                            );
                            foreach ($sql as $row) {
                                if (@$row['status'] == 'Verifikasi') {
                                    $sts = '<span class="badge bg-success fs-11">Verifikasi</span>';
                                } else {
                                    $sts = '<span class="badge bg-danger fs-11">Belum Verifikasi</span>';
                                }
                            ?>
                                <tr>
                                    <td class="p-2"><?= @$row['nama_verifikator']; ?></td>
                                    <td class="p-2 text-center"><?= @$sts; ?></td>
                                    <td class="p-2"><?= @$row['timestamp']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </label>
            </div>
        </div>
    </div>
<?php
}
if (@$judul == 'izin_usaha') {
?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm fs-12 tabel1">
            <thead class="table-light">
                <tr>
                    <th class="ps-2 pe-2">Jenis Izin</th>
                    <th class="ps-2 pe-2">Nomor</th>
                    <th class="ps-2 pe-2">Tanggal</th>
                    <th class="ps-2 pe-2">Berlaku</th>
                    <th class="ps-2 pe-2">Kualifikasi</td>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">File</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">Status</th>
                    <th class="ps-2 pe-2 text-center" style="width: 15%;">Verifikator</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //$sql1 = $proses->tampil_data_join2('a.*,b.nama', 'izin_usaha', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                $sql1 = $proses->tampil_data_select('*', 'izin_usaha', '1=1 AND id_profil = ' . $_POST['id'] . '');
                foreach ($sql1 as $a) {
                    $act = pathinfo(@$a['file'], PATHINFO_EXTENSION);

                    $cek1 = $proses->tampil_data_select(
                        'a.timestamp, b.id_operator, b.nama',
                        'catatan a INNER JOIN operator b ON a.id_operator = b.id_operator',
                        '1=1 AND a.id = "' . $a['id'] . '" 
                        AND a.menu = "izin_usaha" 
                        AND a.id_profil = "' . $_POST['id'] . '"'
                    );

                    if ($a['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($a['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }
                ?>
                    <tr>
                        <td class="ps-2 pe-2"><?= str_replace('-', ' ', $a['jenis_izin']); ?></td>
                        <td class="ps-2 pe-2"><?= $a['nomor']; ?></td>
                        <td class="ps-2 pe-2"><?= tgl_indo($a['tanggal']); ?></td>
                        <td class="ps-2 pe-2">
                            <?= sisa_waktu($a['masa_berlaku']); ?>
                        </td>
                        <td class="ps-2 pe-2"><?= str_replace('-', ' ', $a['grade']); ?></td>
                        <td class="ps-2 pe-2" align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $a['file']; ?>"><i class="ri-file-line fs-14"></i></a></td>
                        <td class="ps-2 pe-2" align="center"><?= $status; ?></td>
                        <td class="ps-2 pe-2" align="center">
                            <?php
                            foreach ($cek1 as $aa) {
                                if ($aa['id_operator'] == $_SESSION['kode_user']) {
                                    echo '<span class="badge bg-success fs-10" title="' . @$aa['timestamp'] . '">' . @$aa['nama'] . '</span>';
                                } else {
                                    echo '<small title="' . @$aa['timestamp'] . '">' . @$aa['nama'] . ',</small> ';
                                }
                            }
                            ?>
                        </td>
                        <td class="ps-2 pe-2" align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-profil="<?= $_POST['id']; ?>" data-text="Izin Usaha" data-db="izin_usaha" data-id="<?= $a['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        dataTable = $('.tabel1').DataTable({
            stateSave: true,
            autoWidth: false,
            processing: true,
            ordering: false,
            responsive: true
        });
    </script>
<?php }
if (@$judul == 'npwp') {
?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm fs-12 tabel2">
            <thead class="table-light">
                <tr>
                    <th class="ps-2 pe-2">Nomor NPWP</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">File</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">Status</th>
                    <th class="ps-2 pe-2 text-center" style="width: 15%;">Verifikator</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //$sql11 = $proses->tampil_data_join2('a.*,b.nama', 'npwp', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                $sql11 = $proses->tampil_data_select('*', 'npwp', '1=1 AND id_profil = ' . $_POST['id'] . '');
                foreach ($sql11 as $k) {
                    $act = pathinfo(@$k['file'], PATHINFO_EXTENSION);

                    $cek2 = $proses->tampil_data_select(
                        'a.timestamp, b.id_operator, b.nama',
                        'catatan a INNER JOIN operator b ON a.id_operator = b.id_operator',
                        '1=1 AND a.id = "' . $k['id'] . '"
                        AND a.menu = "npwp" 
                        AND a.id_profil = "' . $_POST['id'] . '"'
                    );

                    if ($k['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($k['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }
                ?>
                    <tr>
                        <td class="ps-2 pe-2"><?= $k['npwp']; ?></td>
                        <td class="ps-2 pe-2 text-center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $k['file']; ?>"><i class="ri-file-line fs-14"></i></a></td>
                        <td class="ps-2 pe-2 text-center"><?= $status; ?></td>
                        <td class="ps-2 pe-2" align="center">
                            <?php
                            foreach ($cek2 as $aa) {
                                if ($aa['id_operator'] == $_SESSION['kode_user']) {
                                    echo '<span class="badge bg-success fs-10" title="' . @$aa['timestamp'] . '">' . @$aa['nama'] . '</span>';
                                } else {
                                    echo '<small title="' . @$aa['timestamp'] . '">' . @$aa['nama'] . ',</small> ';
                                }
                            }
                            ?>
                        </td>
                        <td class="ps-2 pe-2" align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-profil="<?= $_POST['id']; ?>" data-text="NPWP" data-db="npwp" data-id="<?= $k['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        dataTable = $('.tabel2').DataTable({
            stateSave: true,
            autoWidth: false,
            processing: true,
            ordering: false,
            responsive: true
        });
    </script>
<?php
}
if (@$judul == 'domisili') {
?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm fs-12 tabel3">
            <thead class="table-light">
                <tr>
                    <th class="ps-2 pe-2">Nomor</th>
                    <th class="ps-2 pe-2">Tanggal</th>
                    <th class="ps-2 pe-2">Berlaku</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">File</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">Status</th>
                    <th class="ps-2 pe-2 text-center" style="width: 15%;">Verifikator</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql2 = $proses->tampil_data_join2('a.*,b.nama', 'domisili', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                foreach ($sql2 as $b) {
                    $act = pathinfo(@$b['file'], PATHINFO_EXTENSION);
                    if (!$b['nama']) {
                        $ver = 'Belum Verifikasi';
                        $action = 'add';
                    } else {
                        $ver = $b['nama'];
                        $action = 'edit';
                    }
                    if ($b['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($b['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }
                ?>
                    <tr>
                        <td class="ps-2 pe-2"><?= $b['nomor']; ?></td>
                        <td class="ps-2 pe-2"><?= tgl_indo($b['tanggal']); ?></td>
                        <td class="ps-2 pe-2"><?= sisa_waktu($b['masa_berlaku']); ?></td>
                        <td class="ps-2 pe-2 text-center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $b['file']; ?>"><i class="ri-file-line fs-14"></i></a></td>
                        <td class="ps-2 pe-2 text-center"><?= $status; ?></td>
                        <td class="ps-2 pe-2 text-center"><?= $ver; ?></td>
                        <td class="ps-2 pe-2 text-center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-action="<?= $action; ?>" data-status="<?= $b['status']; ?>" data-catatan="<?= @$b['catatan']; ?>" data-db="domisili" data-text="Domisili" data-id="<?= $b['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        dataTable = $('.tabel3').DataTable({
            stateSave: true,
            autoWidth: false,
            processing: true,
            ordering: false,
            responsive: true
        });
    </script>
<?php
}
if (@$judul == 'sertifikat') {
?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm fs-12 tabel4">
            <thead class="table-light">
                <tr>
                    <th class="ps-2 pe-2">Nama Sertifikat</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">File</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">Status</th>
                    <th class="ps-2 pe-2 text-center" style="width: 15%;">Verifikator</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //$sql11 = $proses->tampil_data_join2('a.*,b.nama', 'sertifikat', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                $sql11 = $proses->tampil_data_select('*', 'sertifikat', '1=1 AND id_profil = ' . $_POST['id'] . '');
                foreach ($sql11 as $k) {
                    $act = pathinfo(@$k['file'], PATHINFO_EXTENSION);

                    $cek2 = $proses->tampil_data_select(
                        'a.timestamp, b.id_operator, b.nama',
                        'catatan a INNER JOIN operator b ON a.id_operator = b.id_operator',
                        '1=1 AND a.id = "' . $k['id'] . '"
                        AND a.menu = "sertifikat" 
                        AND a.id_profil = "' . $_POST['id'] . '"'
                    );

                    if ($k['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($k['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }
                ?>
                    <tr>
                        <td class="ps-2 pe-2"><?= $k['nama_sertifikat']; ?></td>
                        <td class="ps-2 pe-2 text-center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $k['file']; ?>"><i class="ri-file-line fs-14"></i></a></td>
                        <td class="ps-2 pe-2 text-center"><?= $status; ?></td>
                        <td class="ps-2 pe-2" align="center">
                            <?php
                            foreach ($cek2 as $aa) {
                                if ($aa['id_operator'] == $_SESSION['kode_user']) {
                                    echo '<span class="badge bg-success fs-10" title="' . @$aa['timestamp'] . '">' . @$aa['nama'] . '</span>';
                                } else {
                                    echo '<small title="' . @$aa['timestamp'] . '">' . @$aa['nama'] . ',</small> ';
                                }
                            }
                            ?>
                        </td>
                        <td class="ps-2 pe-2" align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-profil="<?= $_POST['id']; ?>" data-text="Sertifikat Standar" data-db="sertifikat" data-id="<?= $k['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        dataTable = $('.tabel4').DataTable({
            stateSave: true,
            autoWidth: false,
            processing: true,
            ordering: false,
            responsive: true
        });
    </script>
<?php
}
if (@$judul == 'akta') {
?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm fs-12 tabel5">
            <thead class="table-light">
                <tr>
                    <th class="ps-2 pe-2">Jenis</th>
                    <th class="ps-2 pe-2">Nomor</th>
                    <th class="ps-2 pe-2">Tanggal</th>
                    <th class="ps-2 pe-2">Nama Notaris</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">File</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">Status</th>
                    <th class="ps-2 pe-2 text-center" style="width: 15%;">Verifikator</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //$sql4 = $proses->tampil_data_join2('a.*,b.nama', 'akta', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                $sql4 = $proses->tampil_data_select('*', 'akta', '1=1 AND id_profil = ' . $_POST['id'] . '');
                foreach ($sql4 as $d) {
                    $act = pathinfo(@$d['file'], PATHINFO_EXTENSION);

                    $cek2 = $proses->tampil_data_select(
                        'a.timestamp, b.id_operator, b.nama',
                        'catatan a INNER JOIN operator b ON a.id_operator = b.id_operator',
                        '1=1 AND a.id = "' . $d['id'] . '" 
                        AND a.menu = "akta" 
                        AND a.id_profil = "' . $_POST['id'] . '"'
                    );

                    if ($d['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($d['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }
                ?>
                    <tr>
                        <td class="ps-2 pe-2"><?= str_replace('-', ' ', $d['jenis']); ?></td>
                        <td class="ps-2 pe-2"><?= $d['nomor']; ?></td>
                        <td class="ps-2 pe-2"><?= tgl_indo($d['tanggal']); ?></td>
                        <td class="ps-2 pe-2"><?= $d['nama_notaris']; ?></td>
                        <td class="ps-2 pe-2 text-center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $d['file']; ?>"><i class="ri-file-line fs-14"></i></a></td>
                        <td class="ps-2 pe-2 text-center"><?= $status; ?></td>
                        <td class="ps-2 pe-2" align="center">
                            <?php
                            foreach ($cek2 as $aa) {
                                if ($aa['id_operator'] == $_SESSION['kode_user']) {
                                    echo '<span class="badge bg-success fs-10" title="' . @$aa['timestamp'] . '">' . @$aa['nama'] . '</span>';
                                } else {
                                    echo '<small title="' . @$aa['timestamp'] . '">' . @$aa['nama'] . ',</small> ';
                                }
                            }
                            ?>
                        </td>
                        <td class="ps-2 pe-2" align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-profil="<?= $_POST['id']; ?>" data-text="Akta" data-db="akta" data-id="<?= $d['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        dataTable = $('.tabel5').DataTable({
            stateSave: true,
            autoWidth: false,
            processing: true,
            ordering: false,
            responsive: true
        });
    </script>
<?php
}
if (@$judul == 'pengurus') {
?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm fs-12 tabel6">
            <thead class="table-light">
                <tr>
                    <th class="ps-2 pe-2">Jabatan</th>
                    <th class="ps-2 pe-2">No. KTP</th>
                    <th class="ps-2 pe-2">Nama</th>
                    <th class="ps-2 pe-2">Alamat</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">File</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">Status</th>
                    <th class="ps-2 pe-2 text-center" style="width: 15%;">Verifikasi</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //$sql5 = $proses->tampil_data_join2('a.*,b.nama AS namas', 'pengurus', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                $sql5 = $proses->tampil_data_select('*', 'pengurus', '1=1 AND id_profil = ' . $_POST['id'] . '');
                foreach ($sql5 as $e) {
                    $act = pathinfo(@$e['file'], PATHINFO_EXTENSION);

                    $cek2 = $proses->tampil_data_select(
                        'a.timestamp, b.id_operator, b.nama',
                        'catatan a INNER JOIN operator b ON a.id_operator = b.id_operator',
                        '1=1 AND a.id = "' . $e['id'] . '" 
                        AND a.menu = "pengurus" 
                        AND a.id_profil = "' . $_POST['id'] . '"'
                    );

                    if ($e['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($e['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }
                ?>
                    <tr>
                        <td class="ps-2 pe-2"><?= str_replace('-', ' ', $e['jabatan']); ?></td>
                        <td class="ps-2 pe-2"><?= $e['nomor_ktp']; ?></td>
                        <td class="ps-2 pe-2"><?= $e['nama']; ?></td>
                        <td class="ps-2 pe-2"><?= $e['alamat']; ?></td>
                        <td class="ps-2 pe-2 text-center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $e['file']; ?>"><i class="ri-file-line fs-14"></i></a></td>
                        <td class="ps-2 pe-2 text-center"><?= $status; ?></td>
                        <td class="ps-2 pe-2" align="center">
                            <?php
                            foreach ($cek2 as $aa) {
                                if ($aa['id_operator'] == $_SESSION['kode_user']) {
                                    echo '<span class="badge bg-success fs-10" title="' . @$aa['timestamp'] . '">' . @$aa['nama'] . '</span>';
                                } else {
                                    echo '<small title="' . @$aa['timestamp'] . '">' . @$aa['nama'] . ',</small> ';
                                }
                            }
                            ?>
                        </td>
                        <td class="ps-2 pe-2" align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-profil="<?= $_POST['id']; ?>" data-text="Pengurus" data-db="pengurus" data-id="<?= $e['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        dataTable = $('.tabel6').DataTable({
            stateSave: true,
            autoWidth: false,
            processing: true,
            ordering: false,
            responsive: true
        });
    </script>
<?php
}
if (@$judul == 'pemilik_saham') {
?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm fs-12 tabel7">
            <thead class="table-light">
                <tr>
                    <th class="ps-2 pe-2">No. KTP</th>
                    <th class="ps-2 pe-2">Nama</th>
                    <th class="ps-2 pe-2">Alamat</th>
                    <th class="ps-2 pe-2">Persen Saham</th>
                    <th class="ps-2 pe-2">Tipe Saham</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">File</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">Status</th>
                    <th class="ps-2 pe-2 text-center" style="width: 15%;">Verifikasi</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //$sql6 = $proses->tampil_data_join2('a.*,b.nama AS namas', 'pemilik_saham', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                $sql6 = $proses->tampil_data_select('*', 'pemilik_saham', '1=1 AND id_profil = ' . $_POST['id'] . '');
                foreach ($sql6 as $f) {
                    $act = pathinfo(@$f['file'], PATHINFO_EXTENSION);

                    $cek2 = $proses->tampil_data_select(
                        'a.timestamp, b.id_operator, b.nama',
                        'catatan a INNER JOIN operator b ON a.id_operator = b.id_operator',
                        '1=1 AND a.id = "' . $f['id'] . '" 
                        AND a.menu = "pemilik_saham" 
                        AND a.id_profil = "' . $_POST['id'] . '"'
                    );

                    if ($f['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($f['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }
                ?>
                    <tr>
                        <td class="ps-2 pe-2"><?= $f['nomor_ktp']; ?></td>
                        <td class="ps-2 pe-2"><?= $f['nama']; ?></td>
                        <td class="ps-2 pe-2"><?= $f['alamat']; ?></td>
                        <td class="text-center"><?= $f['persen_saham']; ?></td>
                        <td class="ps-2 pe-2"><?= $f['tipe_saham']; ?></td>
                        <td class="ps-2 pe-2 text-center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $f['file']; ?>"><i class="ri-file-line fs-14"></i></a></td>
                        <td class="ps-2 pe-2 text-center"><?= $status; ?></td>
                        <td class="ps-2 pe-2" align="center">
                            <?php
                            foreach ($cek2 as $aa) {
                                if ($aa['id_operator'] == $_SESSION['kode_user']) {
                                    echo '<span class="badge bg-success fs-10" title="' . @$aa['timestamp'] . '">' . @$aa['nama'] . '</span>';
                                } else {
                                    echo '<small title="' . @$aa['timestamp'] . '">' . @$aa['nama'] . ',</small> ';
                                }
                            }
                            ?>
                        </td>
                        <td class="ps-2 pe-2" align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-profil="<?= $_POST['id']; ?>" data-text="Pemilik Saham" data-db="pemilik_saham" data-id="<?= $f['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        dataTable = $('.tabel7').DataTable({
            stateSave: true,
            autoWidth: false,
            processing: true,
            ordering: false,
            responsive: true
        });
    </script>
<?php
}
if (@$judul == 'pajak') {
?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm fs-12 tabel8">
            <thead class="table-light">
                <tr>
                    <th class="ps-2 pe-2">Jenis Laporan</th>
                    <th class="ps-2 pe-2">Nomor</th>
                    <th class="ps-2 pe-2">Tanggal</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">File</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">Status</th>
                    <th class="ps-2 pe-2 text-center" style="width: 15%;">Verifikasi</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql7 = $proses->tampil_data_join2('a.*,b.nama', 'pajak', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                foreach ($sql7 as $g) {
                    $act = pathinfo(@$g['file'], PATHINFO_EXTENSION);
                    if (!$g['nama']) {
                        $ver = 'Belum Verifikasi';
                        $action = 'add';
                    } else {
                        $ver = $g['nama'];
                        $action = 'edit';
                    }
                    if ($g['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($g['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }
                ?>
                    <tr>
                        <td class="ps-2 pe-2"><?= str_replace('-', ' ', $g['jenis_laporan']); ?></td>
                        <td class="ps-2 pe-2"><?= $g['nomor']; ?></td>
                        <td class="ps-2 pe-2"><?= tgl_indo($g['tanggal']); ?></td>
                        <td class="ps-2 pe-2 text-center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $g['file']; ?>"><i class="ri-file-line fs-14"></i></a></td>
                        <td class="ps-2 pe-2 text-center"><?= $status; ?></td>
                        <td class="ps-2 pe-2 text-center"><?= $ver; ?></td>
                        <td class="ps-2 pe-2 text-center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-action="<?= $action; ?>" data-status="<?= $g['status']; ?>" data-catatan="<?= @$g['catatan']; ?>" data-db="pajak" data-text="Pajak" data-id="<?= $g['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        dataTable = $('.tabel8').DataTable({
            stateSave: true,
            autoWidth: false,
            processing: true,
            ordering: false,
            responsive: true
        });
    </script>
<?php
}
if (@$judul == 'tenaga_ahli') {
?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm fs-12 tabel9">
            <thead class="table-light">
                <tr>
                    <th class="ps-2 pe-2">Nama</th>
                    <th class="ps-2 pe-2">Tanggal Lahir</th>
                    <th class="ps-2 pe-2">Pendidikan</th>
                    <th class="ps-2 pe-2">Jabatan</th>
                    <th class="ps-2 pe-2">Pengalaman</th>
                    <th class="ps-2 pe-2">Keahlian</th>
                    <th class="ps-2 pe-2">Tahun Ijazah</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql8 = $proses->tampil_data_select('*', 'tenaga_ahli', 'id_profil = ' . $_POST['id'] . '');
                foreach ($sql8 as $h) {
                ?>
                    <tr>
                        <td class="ps-2 pe-2"><?= $h['nama']; ?></td>
                        <td class="ps-2 pe-2"><?= tgl_indo($h['tgl_lahir']); ?></td>
                        <td class="ps-2 pe-2"><?= $h['pendidikan']; ?></td>
                        <td class="ps-2 pe-2"><?= $h['jabatan']; ?></td>
                        <td class="ps-2 pe-2"><?= $h['pengalaman']; ?></td>
                        <td class="ps-2 pe-2"><?= $h['keahlian']; ?></td>
                        <td class="ps-2 pe-2"><?= $h['tahun_ijazah']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        dataTable = $('.tabel9').DataTable({
            stateSave: true,
            autoWidth: false,
            processing: true,
            ordering: false,
            responsive: true
        });
    </script>
<?php }
if (@$judul == 'peralatan') {
?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm fs-12 tabel10">
            <thead class="table-light">
                <tr>
                    <th class="ps-2 pe-2">Jenis Peralatan</th>
                    <th class="ps-2 pe-2">Jumlah</th>
                    <th class="ps-2 pe-2">Kapasitas</th>
                    <th class="ps-2 pe-2">Merek</th>
                    <th class="ps-2 pe-2">Tahun</th>
                    <th class="ps-2 pe-2">Kondisi</th>
                    <th class="ps-2 pe-2">Lokasi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql9 = $proses->tampil_data_select('*', 'peralatan', 'id_profil = ' . $_POST['id'] . '');
                foreach ($sql9 as $i) {
                ?>
                    <tr>
                        <td class="ps-2 pe-2"><?= $i['jenis_peralatan']; ?></td>
                        <td class="ps-2 pe-2"><?= $i['jumlah']; ?></td>
                        <td class="ps-2 pe-2"><?= $i['kapasitas']; ?></td>
                        <td class="ps-2 pe-2"><?= $i['merek']; ?></td>
                        <td class="ps-2 pe-2"><?= $i['tahun']; ?></td>
                        <td class="ps-2 pe-2"><?= $i['kondisi']; ?></td>
                        <td class="ps-2 pe-2"><?= $i['lokasi']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        dataTable = $('.tabel10').DataTable({
            stateSave: true,
            autoWidth: false,
            processing: true,
            ordering: false,
            responsive: true
        });
    </script>
<?php }
if (@$judul == 'pengalaman') {
?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm fs-12 tabel11">
            <thead class="table-light">
                <tr>
                    <th class="ps-2 pe-2">Nama Pekerjaan</th>
                    <th class="ps-2 pe-2">Bidang</th>
                    <th class="ps-2 pe-2">Lokasi</th>
                    <th class="ps-2 pe-2">Nama Pemberi</th>
                    <th class="ps-2 pe-2">Alamat</th>
                    <th class="ps-2 pe-2">Telepon</th>
                    <th class="ps-2 pe-2">No. Kontrak</th>
                    <th class="ps-2 pe-2">Nilai Kontrak</th>
                    <th class="ps-2 pe-2">Tgl Selesai</th>
                    <th class="ps-2 pe-2">Tgl Berita Acara</th>
                    <th class="ps-2 pe-2 text-center" style="width:3%;">File</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql10 = $proses->tampil_data_join2('a.*,b.nama', 'pengalaman', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                foreach ($sql10 as $j) {
                    $act = pathinfo(@$j['file'], PATHINFO_EXTENSION);
                ?>
                    <tr>
                        <td class="ps-2 pe-2"><?= $j['nama_pekerjaan']; ?></td>
                        <td class="ps-2 pe-2"><?= $j['bidang_pekerjaan']; ?></td>
                        <td class="ps-2 pe-2"><?= $j['lokasi']; ?></td>
                        <td class="ps-2 pe-2"><?= $j['nama_pemberi']; ?></td>
                        <td class="ps-2 pe-2"><?= $j['alamat_pemberi']; ?></td>
                        <td class="ps-2 pe-2"><?= $j['telepon_pemberi']; ?></td>
                        <td class="ps-2 pe-2"><?= $j['no_kontrak']; ?></td>
                        <td class="p-2 text-end"><?= number_format($j['nilai_kontrak'], 0, ',', '.'); ?></td>
                        <td class="p-2"><?= tgl_indo($j['tgl_selesai']); ?></td>
                        <td class="p-2"><?= tgl_indo($j['tgl_berita_acara']); ?></td>
                        <td align="center" class="p-2"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $j['file']; ?>"><i class="ri-file-line"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        dataTable = $('.tabel11').DataTable({
            stateSave: true,
            autoWidth: false,
            processing: true,
            ordering: false,
            responsive: true
        });
    </script>
<?php }
if (@$judul == 'penyedia') {
    $row = $proses->tampil_data_saja_join2('a.*,b.email', 'profil_badan_usaha', 'akun_penyedia', 'id_akun', 'a.id_profil = "' . $_POST['id'] . '"');
    $jow = $proses->tampil_data_saja('file', 'company_profile', 'id_profil = "' . $_POST['id'] . '"');
    $act = pathinfo(@$jow['file'], PATHINFO_EXTENSION);
    if ($row['status'] == 'Belum-Verifikasi') {
        $status = '<span class="badge text-bg-danger">Belum Verifikasi</span>';
    } else {
        $status = '<span class="badge text-bg-success">Terverifikasi</span>';
    }
?>
    <table class="table table-striped table-sm fs-13">
        <tr>
            <td class="ps-2 pe-2">NPWP</td>
            <td class="ps-2 pe-2"><?= $row['npwp']; ?></td>
        </tr>
        <tr>
            <td class="ps-2 pe-2">Badan Usaha</td>
            <td class="ps-2 pe-2"><?= $row['badan_usaha']; ?></td>
        </tr>
        <tr>
            <td class="ps-2 pe-2">Nama Perusahaan</td>
            <td class="ps-2 pe-2"><?= $row['nama_perusahaan']; ?></td>
        </tr>
        <tr>
            <td class="ps-2 pe-2">Email</td>
            <td class="ps-2 pe-2"><a href="mailto:<?= $row['email']; ?>"><?= $row['email']; ?></a></td>
        </tr>
        <tr>
            <td class="ps-2 pe-2">Status</td>
            <td class="ps-2 pe-2"><?= $row['status_usaha']; ?></td>
        </tr>
        <tr>
            <td class="ps-2 pe-2">Alamat</td>
            <td class="ps-2 pe-2"><?= $row['alamat']; ?></td>
        </tr>
        <tr>
            <td class="ps-2 pe-2">Provinsi</td>
            <td class="ps-2 pe-2"><?= $row['provinsi']; ?></td>
        </tr>
        <tr>
            <td class="ps-2 pe-2">Kabupaten / Kota</td>
            <td class="ps-2 pe-2"><?= $row['kab_kota']; ?></td>
        </tr>
        <tr>
            <td class="ps-2 pe-2">Kode POS</td>
            <td class="ps-2 pe-2"><?= $row['kode_pos']; ?></td>
        </tr>
        <tr>
            <td class="ps-2 pe-2">Telepon</td>
            <td class="ps-2 pe-2"><?= $row['telepon']; ?></td>
        </tr>
        <tr>
            <td class="ps-2 pe-2">Faximile</td>
            <td class="ps-2 pe-2"><?= $row['fax']; ?></td>
        </tr>
        <tr>
            <td class="ps-2 pe-2">Website</td>
            <td class="ps-2 pe-2"><a href="<?= $row['website']; ?>" target="_blank"><?= $row['website']; ?></a></td>
        </tr>
        <tr>
            <td class="ps-2 pe-2">Company Profil</td>
            <td class="ps-2 pe-2">
                <?php if (!empty($jow['file'])) { ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $jow['file']; ?>"><span class="badge text-bg-success">Lihat Company Profil</span></a>
                <?php } else {
                } ?>
            </td>
        </tr>
        <tr>
            <td class="ps-2 pe-2">Kontak Person</td>
            <td class="ps-2 pe-2"><?= $row['contact_person']; ?></td>
        </tr>
        <tr>
            <td class="ps-2 pe-2">No. Handphone</td>
            <td class="ps-2 pe-2"><?= $row['telepon_cp']; ?></td>
        </tr>
        <tr>
            <td class="ps-2 pe-2">Status Verifikasi</td>
            <td class="ps-2 pe-2"><?= $status; ?></td>
        </tr>
        <tr>
            <td class="ps-2 pe-2">Registrasi</td>
            <td class="ps-2 pe-2"><?= $row['registrasi']; ?></td>
        </tr>
    </table>
<?php }
if (@$judul == 'nib') {
?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm fs-12">
            <thead class="table-light">
                <tr class="text-center">
                    <th class="ps-2 pe-2">Jenis Izin</th>
                    <th class="ps-2 pe-2">Nomor</th>
                    <th class="ps-2 pe-2">Tanggal</th>
                    <th class="ps-2 pe-2">Berlaku</th>
                    <th class="ps-2 pe-2">Kualifikasi</td>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">File</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">Status</th>
                    <th class="ps-2 pe-2 text-center" style="width: 15%;">Verifikasi</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql1 = $proses->tampil_data_join2('a.*,b.nama', 'izin_usaha', 'operator', 'id_operator', 'a.id_profil = "' . $_POST['id'] . '" AND a.jenis_izin = "Nomor-Induk-Berusaha-(NIB)"');
                foreach ($sql1 as $a) {
                    $act = pathinfo(@$a['file'], PATHINFO_EXTENSION);
                    if (!$a['nama']) {
                        $ver = 'Belum Verifikasi';
                        $action = 'add';
                    } else {
                        $ver = $a['nama'];
                        $action = 'edit';
                    }
                    if ($a['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($a['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }
                ?>
                    <tr>
                        <td class="ps-2 pe-2"><?= str_replace('-', ' ', $a['jenis_izin']); ?></td>
                        <td class="ps-2 pe-2"><?= $a['nomor']; ?></td>
                        <td class="ps-2 pe-2"><?= $a['tanggal']; ?></td>
                        <td class="ps-2 pe-2"><?= $a['masa_berlaku']; ?>
                            <div id="passwordHelpBlock" class="form-text">
                                <?= sisa_waktu($a['masa_berlaku']); ?>
                            </div>
                        </td>
                        <td class="ps-2 pe-2"><?= str_replace('-', ' ', $a['grade']); ?></td>
                        <td class="ps-2 pe-2 text-center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $a['file']; ?>"><i class="ri-file-line fs-14"></i></a></td>
                        <td class="ps-2 pe-2 text-center"><?= $status; ?></td>
                        <td class="ps-2 pe-2 text-center"><?= $ver; ?></td>
                        <td class="ps-2 pe-2 text-center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-action="<?= $action; ?>" data-status="<?= $a['status']; ?>" data-catatan="<?= @$a['catatan']; ?>" data-db="izin_usaha" data-text="Nomor Induk Berusaha (NIB)" data-id="<?= $a['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php }
if (@$judul == 'sbu') {
?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm fs-12">
            <thead class="table-light">
                <tr class="text-center">
                    <th class="ps-2 pe-2">Jenis Izin</th>
                    <th class="ps-2 pe-2">Nomor Registrasi</th>
                    <th class="ps-2 pe-2">Nama Badan Usaha</th>
                    <th class="ps-2 pe-2">Masa Berlaku</th>
                    <th class="ps-2 pe-2">Jenis Usaha</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">File</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">Status</th>
                    <th class="ps-2 pe-2 text-center" style="width: 15%;">Verifikasi</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql1 = $proses->tampil_data_join2('a.*,b.nama', 'sbu', 'operator', 'id_operator', 'a.id_profil = "' . $_POST['id'] . '"');
                foreach ($sql1 as $a) {
                    $act = pathinfo(@$a['file'], PATHINFO_EXTENSION);
                    if (!$a['nama']) {
                        $ver = 'Belum Verifikasi';
                        $action = 'add';
                    } else {
                        $ver = $a['nama'];
                        $action = 'edit';
                    }
                    if ($a['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($a['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }
                ?>
                    <tr>
                        <td class="ps-2 pe-2"><?= str_replace('-', ' ', $a['jenis_izin']); ?></td>
                        <td class="ps-2 pe-2"><?= $a['no_registrasi']; ?></td>
                        <td class="ps-2 pe-2"><?= $a['nama_badan_usaha']; ?></td>
                        <td class="ps-2 pe-2"><?= $a['masa_berlaku']; ?>
                            <div id="passwordHelpBlock" class="form-text">
                                <?= sisa_waktu($a['masa_berlaku']); ?>
                            </div>
                        </td>
                        <td class="ps-2 pe-2"><?= $a['jenis_usaha']; ?></td>
                        <td class="ps-2 pe-2 text-center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $a['file']; ?>"><i class="ri-file-line fs-14"></i></a></td>
                        <td class="ps-2 pe-2 text-center"><?= $status; ?></td>
                        <td class="ps-2 pe-2 text-center"><?= $ver; ?></td>
                        <td class="ps-2 pe-2 text-center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-action="<?= $action; ?>" data-status="<?= $a['status']; ?>" data-catatan="<?= @$a['catatan']; ?>" data-db="sbu" data-text="Sertifikat Badan Usaha (SBU)" data-id="<?= $a['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php }
if (@$judul == 'kswp') {
?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm fs-12 tabel12">
            <thead class="table-light">
                <tr>
                    <th class="ps-2 pe-2">Nomor NPWP</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">File</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">Status</th>
                    <th class="ps-2 pe-2 text-center" style="width: 15%;">Verifikasi</th>
                    <th class="ps-2 pe-2 text-center" style="width: 5%;">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                //$sql11 = $proses->tampil_data_join2('a.*,b.nama', 'kswp', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                $sql11 = $proses->tampil_data_select('*', 'kswp', '1=1 AND id_profil = ' . $_POST['id'] . '');
                foreach ($sql11 as $k) {
                    $act = pathinfo(@$k['file'], PATHINFO_EXTENSION);

                    $cek2 = $proses->tampil_data_select(
                        'a.timestamp, b.id_operator, b.nama',
                        'catatan a INNER JOIN operator b ON a.id_operator = b.id_operator',
                        '1=1 AND a.id = "' . $k['id'] . '" 
                        AND a.menu = "kswp" 
                        AND a.id_profil = "' . $_POST['id'] . '"'
                    );

                    if ($k['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($k['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }
                ?>
                    <tr>
                        <td class="ps-2 pe-2"><?= $k['npwp']; ?></td>
                        <td class="ps-2 pe-2 text-center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $k['file']; ?>"><i class="ri-file-line fs-14"></i></a></td>
                        <td class="ps-2 pe-2 text-center"><?= $status; ?></td>
                        <td class="ps-2 pe-2" align="center">
                            <?php
                            foreach ($cek2 as $aa) {
                                if ($aa['id_operator'] == $_SESSION['kode_user']) {
                                    echo '<span class="badge bg-success fs-10" title="' . @$aa['timestamp'] . '">' . @$aa['nama'] . '</span>';
                                } else {
                                    echo '<small title="' . @$aa['timestamp'] . '">' . @$aa['nama'] . ',</small> ';
                                }
                            }
                            ?>
                        </td>
                        <td class="ps-2 pe-2" align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-profil="<?= $_POST['id']; ?>" data-text="KSWP" data-db="kswp" data-id="<?= $k['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        dataTable = $('.tabel12').DataTable({
            stateSave: true,
            autoWidth: false,
            processing: true,
            ordering: false,
            responsive: true
        });
    </script>
<?php }
if (@$judul == 'pekerjaan_dilaksanakan') {
?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm fs-12 tabel13">
            <thead class="table-light">
                <tr>
                    <th class="p-2">Nama Pekerjaan</th>
                    <th class="p-2">Bidang</th>
                    <th class="p-2">Lokasi</th>
                    <th class="p-2">Nama Pemberi</th>
                    <th class="p-2">Alamat</th>
                    <th class="p-2">Telepon</th>
                    <th class="p-2">No. Kontrak</th>
                    <th class="p-2">Nilai Kontrak</th>
                    <th class="p-2 text-center" style="width:3%;">File</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql11 = $proses->tampil_data_join2('a.*,b.nama', 'pekerjaan_berjalan', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                foreach ($sql11 as $k) {
                    $act = pathinfo(@$k['file'], PATHINFO_EXTENSION);
                ?>
                    <tr>
                        <td class="p-2"><?= $k['nama_pekerjaan']; ?></td>
                        <td class="p-2"><?= $k['bidang_pekerjaan']; ?></td>
                        <td class="p-2"><?= $k['lokasi']; ?></td>
                        <td class="p-2"><?= $k['nama_pemberi']; ?></td>
                        <td class="p-2"><?= $k['alamat_pemberi']; ?></td>
                        <td class="p-2"><?= $k['telepon_pemberi']; ?></td>
                        <td class="p-2"><?= $k['no_kontrak']; ?></td>
                        <td class="p-2 text-end"><?= number_format($k['nilai_kontrak'], 0, ',', '.'); ?></td>
                        <td align="center" class="p-2"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $k['file']; ?>"><i class="ri-file-line"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script>
        dataTable = $('.tabel13').DataTable({
            stateSave: true,
            autoWidth: false,
            processing: true,
            ordering: false,
            responsive: true
        });
    </script>
<?php } ?>