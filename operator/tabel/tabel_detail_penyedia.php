<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/fungsi_indotgl.php');
require_once('../../config/cek_ajax.php');

$judul = $_POST['judul'];
if ($judul == 'izin_usaha') {
?>
    <div class="table-responsive">
        <table class="table table-bordered small tabel1">
            <thead class="table-light">
                <tr>
                    <th>Jenis Izin</th>
                    <th>Nomor</th>
                    <th>Tanggal</th>
                    <th>Berlaku</th>
                    <th>Kualifikasi</td>
                    <th class="text-center">File</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Verifikasi</th>
                    <th class="text-center">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql1 = $proses->tampil_data_join2('a.*,b.nama', 'izin_usaha', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
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
                        <td><?= str_replace('-', ' ', $a['jenis_izin']); ?></td>
                        <td><?= $a['nomor']; ?></td>
                        <td><?= tgl_indo($a['tanggal']); ?></td>
                        <td>
                            <?= sisa_waktu($a['masa_berlaku']); ?>
                        </td>
                        <td><?= str_replace('-', ' ', $a['grade']); ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $a['file']; ?>"><i class="ri-file-line"></i></a></td>
                        <td align="center"><?= $status; ?></td>
                        <td align="center"><?= $ver; ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-action="<?= $action; ?>" data-status="<?= $a['status']; ?>" data-catatan="<?= @$a['catatan']; ?>" data-db="izin_usaha" data-text="Izin Usaha" data-id="<?= $a['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
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
if ($judul == 'npwp') {
?>
    <div class="table-responsive">
        <table class="table table-bordered small tabel2">
            <thead class="table-light">
                <tr>
                    <th>Nomor NPWP</th>
                    <th class="text-center">File</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Verifikasi</th>
                    <th class="text-center">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql11 = $proses->tampil_data_join2('a.*,b.nama', 'npwp', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                foreach ($sql11 as $k) {
                    $act = pathinfo(@$k['file'], PATHINFO_EXTENSION);
                    if (!$k['nama']) {
                        $ver = 'Belum Verifikasi';
                        $action = 'add';
                    } else {
                        $ver = $k['nama'];
                        $action = 'edit';
                    }
                    if ($k['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($k['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }
                ?>
                    <tr>
                        <td><?= $k['npwp']; ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $k['file']; ?>"><i class="ri-file-line"></i></a></td>
                        <td align="center"><?= $status; ?></td>
                        <td align="center"><?= $ver; ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-action="<?= $action; ?>" data-status="<?= $k['status']; ?>" data-catatan="<?= @$k['catatan']; ?>" data-db="npwp" data-text="NPWP" data-id="<?= $k['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
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
if ($judul == 'domisili') {
?>
    <div class="table-responsive">
        <table class="table table-bordered small tabel3">
            <thead class="table-light">
                <tr>
                    <th>Nomor</th>
                    <th>Tanggal</th>
                    <th>Berlaku</th>
                    <th class="text-center">File</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Verifikasi</th>
                    <th class="text-center">#</th>
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
                        <td><?= $b['nomor']; ?></td>
                        <td><?= tgl_indo($b['tanggal']); ?></td>
                        <td><?= sisa_waktu($b['masa_berlaku']); ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $b['file']; ?>"><i class="ri-file-line"></i></a></td>
                        <td align="center"><?= $status; ?></td>
                        <td align="center"><?= $ver; ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-action="<?= $action; ?>" data-status="<?= $b['status']; ?>" data-catatan="<?= @$b['catatan']; ?>" data-db="domisili" data-text="Domisili" data-id="<?= $b['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
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
if ($judul == 'tdp') {
?>
    <div class="table-responsive">
        <table class="table table-bordered small tabel4">
            <thead class="table-light">
                <tr>
                    <th>Nomor</th>
                    <th>Tanggal</th>
                    <th>Berlaku</th>
                    <th class="text-center">File</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Verifikasi</th>
                    <th class="text-center">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql3 = $proses->tampil_data_join2('a.*,b.nama', 'tdp', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                foreach ($sql3 as $c) {
                    $act = pathinfo(@$c['file'], PATHINFO_EXTENSION);
                    if (!$c['nama']) {
                        $ver = 'Belum Verifikasi';
                        $action = 'add';
                    } else {
                        $ver = $c['nama'];
                        $action = 'edit';
                    }
                    if ($c['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($c['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }
                ?>
                    <tr>
                        <td><?= $c['nomor']; ?></td>
                        <td><?= tgl_indo($c['tanggal']); ?></td>
                        <td><?= sisa_waktu($c['masa_berlaku']); ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $c['file']; ?>"><i class="ri-file-line"></i></a></td>
                        <td align="center"><?= $status; ?></td>
                        <td align="center"><?= $ver; ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-action="<?= $action; ?>" data-status="<?= $c['status']; ?>" data-catatan="<?= @$c['catatan']; ?>" data-db="tdp" data-text="TDP" data-id="<?= $c['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
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
if ($judul == 'akta') {
?>
    <div class="table-responsive">
        <table class="table table-bordered small tabel5">
            <thead class="table-light">
                <tr>
                    <th>Jenis</th>
                    <th>Nomor</th>
                    <th>Tanggal</th>
                    <th>Nama Notaris</th>
                    <th class="text-center">File</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Verifikasi</th>
                    <th class="text-center">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql4 = $proses->tampil_data_join2('a.*,b.nama', 'akta', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                foreach ($sql4 as $d) {
                    $act = pathinfo(@$d['file'], PATHINFO_EXTENSION);
                    if (!$d['nama']) {
                        $ver = 'Belum Verifikasi';
                        $action = 'add';
                    } else {
                        $ver = $d['nama'];
                        $action = 'edit';
                    }
                    if ($d['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($d['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }
                ?>
                    <tr>
                        <td><?= str_replace('-', ' ', $d['jenis']); ?></td>
                        <td><?= $d['nomor']; ?></td>
                        <td><?= tgl_indo($d['tanggal']); ?></td>
                        <td><?= $d['nama_notaris']; ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $d['file']; ?>"><i class="ri-file-line"></i></a></td>
                        <td align="center"><?= $status; ?></td>
                        <td align="center"><?= $ver; ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-action="<?= $action; ?>" data-status="<?= $d['status']; ?>" data-catatan="<?= @$d['catatan']; ?>" data-db="akta" data-text="Akta" data-id="<?= $d['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
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
if ($judul == 'pengurus') {
?>
    <div class="table-responsive">
        <table class="table table-bordered small tabel6">
            <thead class="table-light">
                <tr>
                    <th>Jabatan</th>
                    <th>No. KTP</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th class="text-center">File</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Verifikasi</th>
                    <th class="text-center">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql5 = $proses->tampil_data_join2('a.*,b.nama AS namas', 'pengurus', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                foreach ($sql5 as $e) {
                    $act = pathinfo(@$e['file'], PATHINFO_EXTENSION);
                    if (!$e['namas']) {
                        $ver = 'Belum Verifikasi';
                        $action = 'add';
                    } else {
                        $ver = $e['namas'];
                        $action = 'edit';
                    }
                    if ($e['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($e['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }
                ?>
                    <tr>
                        <td><?= str_replace('-', ' ', $e['jabatan']); ?></td>
                        <td><?= $e['nomor_ktp']; ?></td>
                        <td><?= $e['nama']; ?></td>
                        <td><?= $e['alamat']; ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $e['file']; ?>"><i class="ri-file-line"></i></a></td>
                        <td align="center"><?= $status; ?></td>
                        <td align="center"><?= $ver; ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-action="<?= $action; ?>" data-status="<?= $e['status']; ?>" data-catatan="<?= @$e['catatan']; ?>" data-db="pengurus" data-text="Pengurus" data-id="<?= $e['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
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
if ($judul == 'pemilik_saham') {
?>
    <div class="table-responsive">
        <table class="table table-bordered small tabel7">
            <thead class="table-light">
                <tr>
                    <th>No. KTP</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Persen Saham</th>
                    <th>Tipe Saham</th>
                    <th class="text-center">File</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Verifikasi</th>
                    <th class="text-center">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql6 = $proses->tampil_data_join2('a.*,b.nama AS namas', 'pemilik_saham', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                foreach ($sql6 as $f) {
                    $act = pathinfo(@$f['file'], PATHINFO_EXTENSION);
                    if (!$f['namas']) {
                        $ver = 'Belum Verifikasi';
                        $action = 'add';
                    } else {
                        $ver = $f['namas'];
                        $action = 'edit';
                    }
                    if ($f['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($f['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }
                ?>
                    <tr>
                        <td><?= $f['nomor_ktp']; ?></td>
                        <td><?= $f['nama']; ?></td>
                        <td><?= $f['alamat']; ?></td>
                        <td class="text-center"><?= $f['persen_saham']; ?></td>
                        <td><?= $f['tipe_saham']; ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $f['file']; ?>"><i class="ri-file-line"></i></a></td>
                        <td align="center"><?= $status; ?></td>
                        <td align="center"><?= $ver; ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-action="<?= $action; ?>" data-status="<?= $f['status']; ?>" data-catatan="<?= @$f['catatan']; ?>" data-db="pemilik_saham" data-text="Pemilik Saham" data-id="<?= $f['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
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
if ($judul == 'pajak') {
?>
    <div class="table-responsive">
        <table class="table table-bordered small tabel8">
            <thead class="table-light">
                <tr>
                    <th>Jenis Laporan</th>
                    <th>Nomor</th>
                    <th>Tanggal</th>
                    <th class="text-center">File</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Verifikasi</th>
                    <th class="text-center">#</th>
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
                        <td><?= str_replace('-', ' ', $g['jenis_laporan']); ?></td>
                        <td><?= $g['nomor']; ?></td>
                        <td><?= tgl_indo($g['tanggal']); ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $g['file']; ?>"><i class="ri-file-line"></i></a></td>
                        <td align="center"><?= $status; ?></td>
                        <td align="center"><?= $ver; ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-action="<?= $action; ?>" data-status="<?= $g['status']; ?>" data-catatan="<?= @$g['catatan']; ?>" data-db="pajak" data-text="Pajak" data-id="<?= $g['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
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
if ($judul == 'tenaga_ahli') {
?>
    <div class="table-responsive">
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
                $sql8 = $proses->tampil_data_select('*', 'tenaga_ahli', 'id_profil = ' . $_POST['id'] . '');
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
if ($judul == 'peralatan') {
?>
    <div class="table-responsive">
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
                $sql9 = $proses->tampil_data_select('*', 'peralatan', 'id_profil = ' . $_POST['id'] . '');
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
if ($judul == 'pengalaman') {
?>
    <div class="table-responsive">
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
                $sql10 = $proses->tampil_data_select('*', 'pengalaman', 'id_profil = ' . $_POST['id'] . '');
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
if ($judul == 'penyedia') {
    $row = $proses->tampil_data_saja_join2('a.*,b.email', 'profil_badan_usaha', 'akun_penyedia', 'id_akun', 'a.id_profil = "' . $_POST['id'] . '"');
    $jow = $proses->tampil_data_saja('file', 'company_profile', 'id_profil = "' . $_POST['id'] . '"');
    $act = pathinfo(@$jow['file'], PATHINFO_EXTENSION);
    if ($row['status'] == 'Belum-Verifikasi') {
        $status = '<span class="badge text-bg-danger">Belum Verifikasi</span>';
    } else {
        $status = '<span class="badge text-bg-success">Terverifikasi</span>';
    }
?>
    <table class="table table-striped">
        <tr>
            <td>NPWP</td>
            <td><?= $row['npwp']; ?></td>
        </tr>
        <tr>
            <td>Badan Usaha</td>
            <td><?= $row['badan_usaha']; ?></td>
        </tr>
        <tr>
            <td>Nama Perusahaan</td>
            <td><?= $row['nama_perusahaan']; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><a href="mailto:<?= $row['email']; ?>"><?= $row['email']; ?></a></td>
        </tr>
        <tr>
            <td>Status</td>
            <td><?= $row['status_usaha']; ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><?= $row['alamat']; ?></td>
        </tr>
        <tr>
            <td>Provinsi</td>
            <td><?= $row['provinsi']; ?></td>
        </tr>
        <tr>
            <td>Kabupaten / Kota</td>
            <td><?= $row['kab_kota']; ?></td>
        </tr>
        <tr>
            <td>Kode POS</td>
            <td><?= $row['kode_pos']; ?></td>
        </tr>
        <tr>
            <td>Telepon</td>
            <td><?= $row['telepon']; ?></td>
        </tr>
        <tr>
            <td>Faximile</td>
            <td><?= $row['fax']; ?></td>
        </tr>
        <tr>
            <td>Website</td>
            <td><a href="<?= $row['website']; ?>" target="_blank"><?= $row['website']; ?></a></td>
        </tr>
        <tr>
            <td>Company Profil</td>
            <td>
                <?php if (!empty($jow['file'])) { ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $jow['file']; ?>"><span class="badge text-bg-success">Lihat Company Profil</span></a>
                <?php } else {
                } ?>
            </td>
        </tr>
        <tr>
            <td>Kontak Person</td>
            <td><?= $row['contact_person']; ?></td>
        </tr>
        <tr>
            <td>No. Handphone</td>
            <td><?= $row['telepon_cp']; ?></td>
        </tr>
        <tr>
            <td>Status Verifikasi</td>
            <td><?= $status; ?></td>
        </tr>
        <tr>
            <td>Registrasi</td>
            <td><?= $row['registrasi']; ?></td>
        </tr>
    </table>
<?php }
if ($judul == 'nib') {
?>
    <div class="table-responsive">
        <table class="table table-bordered small">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Jenis Izin</th>
                    <th>Nomor</th>
                    <th>Tanggal</th>
                    <th>Berlaku</th>
                    <th>Kualifikasi</td>
                    <th>File</th>
                    <th>Status</th>
                    <th>Verifikasi</th>
                    <th>#</th>
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
                        <td><?= str_replace('-', ' ', $a['jenis_izin']); ?></td>
                        <td><?= $a['nomor']; ?></td>
                        <td><?= $a['tanggal']; ?></td>
                        <td><?= $a['masa_berlaku']; ?>
                            <div id="passwordHelpBlock" class="form-text">
                                <?= sisa_waktu($a['masa_berlaku']); ?>
                            </div>
                        </td>
                        <td><?= str_replace('-', ' ', $a['grade']); ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $a['file']; ?>"><i class="ri-file-line"></i></a></td>
                        <td align="center"><?= $status; ?></td>
                        <td align="center"><?= $ver; ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-action="<?= $action; ?>" data-status="<?= $a['status']; ?>" data-catatan="<?= @$a['catatan']; ?>" data-db="izin_usaha" data-text="Nomor Induk Berusaha (NIB)" data-id="<?= $a['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php }
if ($judul == 'sbu') {
?>
    <div class="table-responsive">
        <table class="table table-bordered small">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Jenis Izin</th>
                    <th>Nomor Registrasi</th>
                    <th>Nama Badan Usaha</th>
                    <th>Masa Berlaku</th>
                    <th>Jenis Usaha</th>
                    <th>File</th>
                    <th>Status</th>
                    <th>Verifikasi</th>
                    <th>#</th>
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
                        <td><?= str_replace('-', ' ', $a['jenis_izin']); ?></td>
                        <td><?= $a['no_registrasi']; ?></td>
                        <td><?= $a['nama_badan_usaha']; ?></td>
                        <td><?= $a['masa_berlaku']; ?>
                            <div id="passwordHelpBlock" class="form-text">
                                <?= sisa_waktu($a['masa_berlaku']); ?>
                            </div>
                        </td>
                        <td><?= $a['jenis_usaha']; ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $a['file']; ?>"><i class="ri-file-line"></i></a></td>
                        <td align="center"><?= $status; ?></td>
                        <td align="center"><?= $ver; ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-action="<?= $action; ?>" data-status="<?= $a['status']; ?>" data-catatan="<?= @$a['catatan']; ?>" data-db="sbu" data-text="Sertifikat Badan Usaha (SBU)" data-id="<?= $a['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php }
if ($judul == 'kswp') {
?>
    <div class="table-responsive">
        <table class="table table-bordered small tabel12">
            <thead class="table-light">
                <tr>
                    <th>Nomor NPWP</th>
                    <th class="text-center">File</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Verifikasi</th>
                    <th class="text-center">#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql11 = $proses->tampil_data_join2('a.*,b.nama', 'kswp', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                foreach ($sql11 as $k) {
                    $act = pathinfo(@$k['file'], PATHINFO_EXTENSION);
                    if (!$k['nama']) {
                        $ver = 'Belum Verifikasi';
                        $action = 'add';
                    } else {
                        $ver = $k['nama'];
                        $action = 'edit';
                    }
                    if ($k['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($k['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }
                ?>
                    <tr>
                        <td><?= $k['npwp']; ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalview" data-act="<?= $act; ?>" data-id="<?= $k['file']; ?>"><i class="ri-file-line"></i></a></td>
                        <td align="center"><?= $status; ?></td>
                        <td align="center"><?= $ver; ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-action="<?= $action; ?>" data-status="<?= $k['status']; ?>" data-catatan="<?= @$k['catatan']; ?>" data-db="kswp" data-text="KSWP" data-id="<?= $k['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
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
if ($judul == 'teknis') {
?>
    <div class="table-responsive">
        <table class="table table-bordered small">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Nama File</th>
                    <th>File</th>
                    <th>Status</th>
                    <th>Verifikasi</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql11 = $proses->tampil_data_join2('a.*,b.nama', 'dokumen_penawaran_teknis', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                foreach ($sql11 as $k) {
                    $act = pathinfo(@$k['file'], PATHINFO_EXTENSION);
                    if (!$k['nama']) {
                        $ver = 'Belum Verifikasi';
                        $action = 'add';
                    } else {
                        $ver = $k['nama'];
                        $action = 'edit';
                    }
                    if ($k['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($k['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }
                ?>
                    <tr class="text-center">
                        <td><?= $k['file']; ?></td>
                        <td align="center"><a href="<?= $url; ?>berkas/<?= $k['file']; ?>" target="_blank"><i class="ri-file-line"></i></a></td>
                        <td align="center"><?= $status; ?></td>
                        <td align="center"><?= $ver; ?></td>
                        <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-action="<?= $action; ?>" data-status="<?= $k['status']; ?>" data-catatan="<?= @$k['catatan']; ?>" data-db="dokumen_penawaran_teknis" data-text="Dokumen Penawaran Teknis" data-id="<?= $k['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php }
if ($judul == 'biaya') {
?>
    <div class="table-responsive">
        <table class="table table-bordered small">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Surat Penawaran Biaya</th>
                    <th>Rekapitulasi Penawaran Biaya</th>
                    <th>Rincian Komponen Remunerasi Personel</th>
                    <th>Status</th>
                    <th>Verifikasi</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql11 = $proses->tampil_data_join2('a.*,b.nama', 'dokumen_penawaran_biaya', 'operator', 'id_operator', 'a.id_profil = ' . $_POST['id'] . '');
                foreach ($sql11 as $k) {
                    $act = pathinfo(@$k['file'], PATHINFO_EXTENSION);
                    if (!$k['nama']) {
                        $ver = 'Belum Verifikasi';
                        $action = 'add';
                    } else {
                        $ver = $k['nama'];
                        $action = 'edit';
                    }
                    if ($k['status'] == 'Pending') {
                        $status = '<span class="badge text-bg-danger">Pending</span>';
                    } else if ($k['status'] == 'Waiting') {
                        $status = '<span class="badge text-bg-warning">Waiting</span>';
                    } else if ($k['status'] == NULL) {
                        $status = '<span class="badge text-bg-danger">Belum Upload</span>';
                    } else {
                        $status = '<span class="badge text-bg-success">Verified</span>';
                    }

                    if (!$k['file_penawaran_biaya']) {
                        $file1 = '<span class="badge text-bg-danger">Belum Upload</span>';
                    } else {
                        $file1 = '<a href="' . $url . 'berkas/' . $k['file_penawaran_biaya'] . '" target="_blank"><i class="ri-file-line fs-14"></i></a>';
                    }

                    if (!$k['file_rekapitulasi']) {
                        $file2 = '<span class="badge text-bg-danger">Belum Upload</span>';
                    } else {
                        $file2 = '<a href="' . $url . 'berkas/' . $k['file_rekapitulasi'] . '" target="_blank"><i class="ri-file-line fs-14"></i></a>';
                    }

                    if (!$k['file_rincian_komponen']) {
                        $file3 = '<span class="badge text-bg-danger">Belum Upload</span>';
                    } else {
                        $file3 = '<a href="' . $url . 'berkas/' . $k['file_rincian_komponen'] . '" target="_blank"><i class="ri-file-line fs-14"></i></a>';
                    }
                ?>
                    <tr class="text-center">
                        <td align="center"><?= $file1; ?></td>
                        <td align="center"><?= $file2; ?></td>
                        <td align="center"><?= $file3; ?></td>
                        <td align="center"><?= $status; ?></td>
                        <td align="center"><?= $ver; ?></td>
                        <?php
                        if (!$k['file_penawaran_biaya'] and !$k['file_rekapitulasi'] and !$k['file_rincian_komponen']) {
                            echo "<td><i class='ri-close-circle-line fs-14 text-danger'></i></td>";
                        } else {
                        ?>
                            <td align="center"><a href="#" data-bs-toggle="modal" data-bs-target="#modalproses" data-action="<?= $action; ?>" data-status="<?= $k['status']; ?>" data-catatan="<?= @$k['catatan']; ?>" data-db="dokumen_penawaran_biaya" data-text="Dokumen Penawaran Biaya" data-id="<?= $k['id']; ?>"><i class="ri-send-plane-fill"></i></a></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>