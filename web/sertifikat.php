<?php
session_start();
require_once('../config/koneksi.php');
require_once('../config/fungsi_indotgl.php');
require_once('../config/phpqrcode/qrlib.php');
$row = $proses->tampil_data_saja('*', 'profil_badan_usaha', 'id_profil = "' . $_GET['id'] . '"');
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="content-type" content="text/html" />
    <meta charset="UTF-8" />
    <title>Sertifikat Verifikasi Eproc UNG <?= $row['nama_perusahaan']; ?></title>
    <link href="<?= $url; ?>assets/css/print/print.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
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
        @media screen {
            body {
                background-color: #ccc;
                font-family: 'Montserrat';
            }

            .page {
                width: 297mm;
                height: 210mm;
                position: relative;
            }

            .img {
                width: 297mm;
                height: 210mm;
                background-repeat: no-repeat;
                background-size: cover;
            }

            .orientation-L .page {
                width: 297mm;
                height: 210mm;
                padding: 1mm;
                margin: 40px auto;
            }

            .container {
                margin: 50px auto;
                max-width: 800px;
                padding: 30px;
                z-index: 100;
                position: absolute;
                left: 15%;
            }

            .header {
                text-align: center;
                margin-bottom: 10px;
            }

            .title {
                font-size: 78px;
                font-weight: bold;
                margin-bottom: 5px;
                color: #1F2837;
            }

            .subtitle {
                font-size: 16px;
                margin-bottom: 50px;
                font-weight: bold;
                color: #1F2837;
            }

            .text {
                font-size: 18px;
                margin-bottom: 30px;
                font-weight: bold;
                color: #1F2837;
            }

            .name {
                font-size: 38px;
                font-weight: bold;
                margin-bottom: 30px;
                text-align: center;
                color: #1F2837;
            }

            .description {
                font-size: 18px;
                text-align: center;
                font-weight: bold;
                line-height: 1.5;
                color: #1F2837;
            }
        }

        @page {
            size: A4 landscape;
            margin: 0;
        }

        @media print {
            body {
                font-family: 'Montserrat';
            }

            .lap-action {
                display: none;
            }

            .pt {
                display: none;
            }

            .page {
                padding: 0;
                height: 205mm;
                position: relative;
            }

            .img {
                width: 293mm;
                height: 206mm;
                background-repeat: no-repeat;
                background-size: cover;
            }

            .container {
                margin: 0px auto;
                max-width: 800px;
                padding: 90px 30px 30px 30px;
                position: absolute;
                left: 15%;
            }

            .header {
                text-align: center;
                margin-bottom: 10px;
            }

            .title {
                font-size: 78px;
                font-weight: bold;
                margin-bottom: 5px;
                color: #1F2837;
            }

            .subtitle {
                font-size: 16px;
                margin-bottom: 50px;
                font-weight: bold;
                color: #1F2837;
            }

            .text {
                font-size: 18px;
                margin-bottom: 30px;
                font-weight: bold;
                color: #1F2837;
            }

            .name {
                font-size: 38px;
                font-weight: bold;
                margin-bottom: 30px;
                text-align: center;
                color: #1F2837;
            }

            .description {
                font-size: 18px;
                font-weight: bold;
                text-align: center;
                line-height: 1.5;
                color: #1F2837;
            }

        }
    </style>
</head>

<body class="orientation-L">
    <div class="page">
        <div class="container">
            <div class="header">
                <div class="title">SERTIFIKAT</div>
                <div class="subtitle">NOMOR : <?= no_sertifikat($_GET['id'], $row['verifikasi_tgl']); ?></div>
                <div class="text">D I B E R I K A N &nbsp; K E P A D A</div>
            </div>
            <div class="name"><?= $row['badan_usaha'] . '. ' . $row['nama_perusahaan']; ?></div>
            <div class="description">
                Telah Terverifikasi pada Sistem Informasi Pengelola Pengadaan Barang dan Jasa<br>
                Badan Layanan Umum, Universitas Negeri Gorontalo<br><br>
                Gorontalo, <?= tgl_indo($row['verifikasi_tgl']); ?>
                <br><br>
                <?php
                $isi = no_sertifikat($_GET['id'], $row['verifikasi_tgl']);
                qrcode($isi);
                ?>
            </div>
        </div>
        <img src="../../assets/images/template.jpg" class="img">
    </div>
</body>

</html>