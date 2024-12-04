<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

try {
    // Konfigurasi database
    $host = 'localhost';
    $dbname = 'dpt-ppbj';
    $username = 'root';
    $password = '';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Periksa apakah file diunggah
    if ($_FILES['excel']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['excel']['tmp_name'];

        // Baca file Excel
        $spreadsheet = IOFactory::load($fileTmpPath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Hapus header (baris pertama)
        array_shift($rows);

        // Simpan data ke database
        $stmt = $pdo->prepare("
            INSERT INTO hps (id_profil, kode_paket, oleh, jenis_barang, satuan, volume, harga, pajak, total, keterangan) 
            VALUES (:id_profil, :kode_paket, :jenis_barang, :oleh, :satuan, :volume, :harga, :pajak, :total, :keterangan)
        ");

        foreach ($rows as $row) {
            $stmt->execute([
                ':id_profil'    => '0',
                ':kode_paket'   => '0',
                ':oleh'         => 'PPK',
                ':jenis_barang' => $row[0],
                ':satuan'       => $row[1],
                ':volume'       => $row[2],
                ':harga'        => $row[3],
                ':pajak'        => $row[4],
                ':total'        => $row[5],
                ':keterangan'   => $row[6],
            ]);
        }

        echo "Data berhasil diunggah ke database.";
    } else {
        throw new Exception("Terjadi kesalahan saat mengunggah file.");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
