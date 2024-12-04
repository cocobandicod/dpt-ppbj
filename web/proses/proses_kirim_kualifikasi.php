<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

if (@$_POST['act1'] == 'izin') {
    $hapus = $proses->hapus_data2('kirim_kualifikasi', 'id_profil = "' . $_SESSION['kode_profil'] . '" AND id_paket = "' . $_POST['id_paket'] . '" AND act = "izin"');

    $selectizin = $_POST['izin'];
    $data = []; // Create an empty array for batch insert

    // Loop through each selected izin
    foreach ($selectizin as $izin_id) {
        // Create an array for each izin and push to the $data array
        $data[] = array(
            'id_kirim'  => $izin_id,
            'id_profil' => $_POST['id_profil'],
            'id_paket'  => $_POST['id_paket'],
            'act'       => $_POST['act1']
        );
    }

    // If there's data to insert
    if (!empty($data)) {
        $result = $proses->tambah_data('kirim_kualifikasi', $data); // Perform batch insert
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Data successfully saved']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save data']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No data selected']);
    }

    // UPDATE STATUS KIRIM

    $data2[] = array(
        'id_paket'        => $_POST['id_paket'],
        'id_profil'       => $_POST['id_profil'],
        'jenis'           => 'Kualifikasi',
        'status'          => 'Kirim'
    );
    $result2 = $proses->tambah_data('status_kirim', $data2); // SIMPAN KE DATABASE
}

if (@$_POST['act2'] == 'sertifikat') {
    $hapus = $proses->hapus_data2('kirim_kualifikasi', 'id_profil = "' . $_SESSION['kode_profil'] . '" AND id_paket = "' . $_POST['id_paket'] . '" AND act = "sertifikat"');

    $select_sertifikat = $_POST['sertifikat'];
    $data = []; // Create an empty array for batch insert

    // Loop through each selected izin
    foreach ($select_sertifikat as $sertifikat_id) {
        // Create an array for each izin and push to the $data array
        $data[] = array(
            'id_kirim'  => $sertifikat_id,
            'id_profil' => $_POST['id_profil'],
            'id_paket'  => $_POST['id_paket'],
            'act'       => $_POST['act2']
        );
    }

    // If there's data to insert
    if (!empty($data)) {
        $result = $proses->tambah_data('kirim_kualifikasi', $data); // Perform batch insert
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Data successfully saved']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save data']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No data selected']);
    }
}

if (@$_POST['act3'] == 'akta') {
    $hapus = $proses->hapus_data2('kirim_kualifikasi', 'id_profil = "' . $_SESSION['kode_profil'] . '" AND id_paket = "' . $_POST['id_paket'] . '" AND act = "akta"');

    $select_akta = $_POST['akta'];
    $data = []; // Create an empty array for batch insert

    // Loop through each selected izin
    foreach ($select_akta as $akta_id) {
        // Create an array for each izin and push to the $data array
        $data[] = array(
            'id_kirim'  => $akta_id,
            'id_profil' => $_POST['id_profil'],
            'id_paket'  => $_POST['id_paket'],
            'act'       => $_POST['act3']
        );
    }

    // If there's data to insert
    if (!empty($data)) {
        $result = $proses->tambah_data('kirim_kualifikasi', $data); // Perform batch insert
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Data successfully saved']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save data']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No data selected']);
    }
}

if (@$_POST['act4'] == 'pengurus') {
    $hapus = $proses->hapus_data2('kirim_kualifikasi', 'id_profil = "' . $_SESSION['kode_profil'] . '" AND id_paket = "' . $_POST['id_paket'] . '" AND act = "pengurus"');

    $select_pengurus = $_POST['pengurus'];
    $data = []; // Create an empty array for batch insert

    // Loop through each selected izin
    foreach ($select_pengurus as $pengurus_id) {
        // Create an array for each izin and push to the $data array
        $data[] = array(
            'id_kirim'  => $pengurus_id,
            'id_profil' => $_POST['id_profil'],
            'id_paket'  => $_POST['id_paket'],
            'act'       => $_POST['act4']
        );
    }

    // If there's data to insert
    if (!empty($data)) {
        $result = $proses->tambah_data('kirim_kualifikasi', $data); // Perform batch insert
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Data successfully saved']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save data']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No data selected']);
    }
}

if (@$_POST['act5'] == 'pengalaman') {
    $hapus = $proses->hapus_data2('kirim_kualifikasi', 'id_profil = "' . $_SESSION['kode_profil'] . '" AND id_paket = "' . $_POST['id_paket'] . '" AND act = "pengalaman"');

    $select_pengalaman = $_POST['pengalaman'];
    $data = []; // Create an empty array for batch insert

    // Loop through each selected izin
    foreach ($select_pengalaman as $pengalaman_id) {
        // Create an array for each izin and push to the $data array
        $data[] = array(
            'id_kirim'  => $pengalaman_id,
            'id_profil' => $_POST['id_profil'],
            'id_paket'  => $_POST['id_paket'],
            'act'       => $_POST['act5']
        );
    }

    // If there's data to insert
    if (!empty($data)) {
        $result = $proses->tambah_data('kirim_kualifikasi', $data); // Perform batch insert
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Data successfully saved']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save data']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No data selected']);
    }
}

if (@$_POST['act6'] == 'pekerjaan_berjalan') {
    $hapus = $proses->hapus_data2('kirim_kualifikasi', 'id_profil = "' . $_SESSION['kode_profil'] . '" AND id_paket = "' . $_POST['id_paket'] . '" AND act = "pekerjaan_berjalan"');

    $select_pekerjaan_berjalan = $_POST['pekerjaan_berjalan'];
    $data = []; // Create an empty array for batch insert

    // Loop through each selected izin
    foreach ($select_pekerjaan_berjalan as $pekerjaan_berjalan_id) {
        // Create an array for each izin and push to the $data array
        $data[] = array(
            'id_kirim'  => $pekerjaan_berjalan_id,
            'id_profil' => $_POST['id_profil'],
            'id_paket'  => $_POST['id_paket'],
            'act'       => $_POST['act6']
        );
    }

    // If there's data to insert
    if (!empty($data)) {
        $result = $proses->tambah_data('kirim_kualifikasi', $data); // Perform batch insert
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Data successfully saved']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save data']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No data selected']);
    }
}

if (@$_POST['act8'] == 'kswp') {
    $hapus = $proses->hapus_data2('kirim_kualifikasi', 'id_profil = "' . $_SESSION['kode_profil'] . '" AND id_paket = "' . $_POST['id_paket'] . '" AND act = "kswp"');

    $select_kswp = $_POST['kswp'];
    $data = []; // Create an empty array for batch insert

    // Loop through each selected izin
    foreach ($select_kswp as $kswp_id) {
        // Create an array for each izin and push to the $data array
        $data[] = array(
            'id_kirim'  => $kswp_id,
            'id_profil' => $_POST['id_profil'],
            'id_paket'  => $_POST['id_paket'],
            'act'       => $_POST['act8']
        );
    }

    // If there's data to insert
    if (!empty($data)) {
        $result = $proses->tambah_data('kirim_kualifikasi', $data); // Perform batch insert
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Data successfully saved']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save data']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No data selected']);
    }
}
