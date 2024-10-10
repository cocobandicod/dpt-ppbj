<?php
session_start();
require_once('../config/koneksi.php');
require_once('../config/fungsi_indotgl.php');
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="content-type" content="text/html" />
    <meta charset="UTF-8" />
    <title>Cetak Lembar Verifikasi</title>
    <link href="<?= $url; ?>assets/css/print/print.css" rel="stylesheet">
    <script type="text/javascript" src="<?= $url; ?>assets/css/print/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('body').append('<div class="lap-action">' +
                '<button type="button" class="btn-back" onclick="window.close()">Tutup</button> &nbsp;' +
                '<button type="button" onclick="window.print()">Cetak</button> &nbsp;' +
                '</div>');
        });
    </script>
    <style type="text/css">
        <!--
        @media screen {
            body {
                background-color: #fff;
            }

            .page {
                min-width: 215mm;
                max-width: 215mm;
                padding: 0;
                margin: 15px auto;
            }

            .orientation-L .page {
                min-width: 330mm;
                max-width: 330mm;
                padding: 0;
                margin: 15px auto;
            }

            .wrapper {
                padding-left: 13mm;
                padding-right: 13mm;
                padding-top: 16mm;
                padding-bottom: 16mm;
            }
        }

        @media print {
            .lap-action {
                display: none;
            }
        }

        .kotak {
            width: 40px;
            padding: 0px 10px;
            border: 1px solid;
        }

        .kotak2 {
            padding: 0px 10px;
            border: 1px solid;
        }
        -->
    </style>
</head>

<BODY class="orientation-P" style="font-family:'Arial'; font-size:10pt; line-height:20px;">
    <?php
    $row = $proses->tampil_data_saja('*', 'profil_badan_usaha', 'id_profil = "' . $_GET['id'] . '"');
    ?>
    <div class="page">
        <div class="wrapper">
            <center>
                <h2 style="margin: 0px; font-size:13pt;">BUKTI PENERIMAAN DOKUMEN REGISTRASI PENYEDIA BARANG DAN JASA</h2>
                <h2 style="margin: 0px; font-size:13pt;">Sistem Informasi Penyedia Barang dan Jasa Universitas Negeri Gorontalo</h2>
            </center>
            <br>
            <hr>
            <br>
            I. IDENTITAS
            <br><br>
            <table style="font-size: 10pt; line-height:20px; width: 100%;">
                <tr>
                    <td></td>
                    <td>NAMA</td>
                    <td>:</td>
                    <td><?= $row['nama_perusahaan']; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>ALAMAT</td>
                    <td>:</td>
                    <td><?= $row['alamat']; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>TELEPON</td>
                    <td>:</td>
                    <td><?= $row['telepon']; ?></td>
                </tr>
            </table>
            <hr>
            <br>
            II. REGISTRASI
            <br><br>
            <table style="font-size: 10pt; line-height:20px; width: 100%;">
                <tr>
                    <td>A.</td>
                    <td>Pendaftaran Online</td>
                    <td colspan="2">
                        <div class="kotak2">Tgl: <?= tgl_indo($row['registrasi']); ?></div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="2">
                        <div class="kotak2">Jam: <?= jam($row['registrasi']); ?></div>
                    </td>
                </tr>
                <tr>
                    <td>B.</td>
                    <td>Dokumen Registrasi/Verifikasi</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td align="center">Valid</td>
                    <td align="center">Tidak</td>
                </tr>
                <tr>
                    <td>1.</td>
                    <td>Formulir Keikutsertaan</td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Surat Penunjukan Admin dan KTP</td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>Surat Kuasa</td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>KTP Seluruh Direksi/Direktur/Pemilik/Pejabat yang berwenang di perusahaan</td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td>NPWP</td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td>6.</td>
                    <td>SIUP dan SIUJK dan Izin Usaha sesuai dengan bidang masing-masing</td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td>7.</td>
                    <td>Tanda Daftar Perusahaan (TDP)</td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td>8.</td>
                    <td>Akta Pendirian Perusahaan dan Akta Perubahan Terakhir</td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td>9.</td>
                    <td>Surat Keterangan Domisili</td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td>10.</td>
                    <td>Bukti Pajak : Surat Keterangan Fiskal atau SPT PPh tahun terakhir</td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                    <td align="center">
                        <div class="kotak">&nbsp;</div>
                    </td>
                </tr>
            </table>
            <hr>
            <br>
            III. CATATAN
            <br><br><br><br><br>
            <hr>
            <br>
            <div style="float: right; margin-right: 50px;">
                <center>
                    Admin Satker
                    <br><br><br><br><br>
                    (...................................)
                </center>
                <br>
            </div>
        </div> <!-- #wapper -->
    </div>
</BODY>

</html>