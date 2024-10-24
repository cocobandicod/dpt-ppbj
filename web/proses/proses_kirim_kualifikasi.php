<?php
session_start();
require_once('../../config/koneksi.php');
require_once('../../config/cek_ajax.php');

if (@$_POST['act1'] == 'izin') {
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

if (@$_POST['act2'] == 'tdp') {
    $select_tdp = $_POST['tdp'];
    $data = []; // Create an empty array for batch insert

    // Loop through each selected izin
    foreach ($select_tdp as $tdp_id) {
        // Create an array for each izin and push to the $data array
        $data[] = array(
            'id_kirim'  => $tdp_id,
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

if (@$_POST['act4'] == 'tenaga_ahli') {
    $select_sdm = $_POST['sdm'];
    $data = []; // Create an empty array for batch insert

    // Loop through each selected izin
    foreach ($select_sdm as $sdm_id) {
        // Create an array for each izin and push to the $data array
        $data[] = array(
            'id_kirim'  => $sdm_id,
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

if (@$_POST['act6'] == 'peralatan') {
    $select_peralatan = $_POST['peralatan'];
    $data = []; // Create an empty array for batch insert

    // Loop through each selected izin
    foreach ($select_peralatan as $peralatan_id) {
        // Create an array for each izin and push to the $data array
        $data[] = array(
            'id_kirim'  => $peralatan_id,
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

if (@$_POST['act7'] == 'pajak') {
    $select_pajak = $_POST['pajak'];
    $data = []; // Create an empty array for batch insert

    // Loop through each selected izin
    foreach ($select_pajak as $pajak_id) {
        // Create an array for each izin and push to the $data array
        $data[] = array(
            'id_kirim'  => $pajak_id,
            'id_profil' => $_POST['id_profil'],
            'id_paket'  => $_POST['id_paket'],
            'act'       => $_POST['act7']
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
