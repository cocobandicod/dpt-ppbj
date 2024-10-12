<?php
$headers = apache_request_headers();

// Pastikan token CSRF ada di header
if (isset($headers['csrf-token'])) {
    $receivedToken = $headers['csrf-token'];
} elseif (isset($headers['Csrf-Token'])) {
    $receivedToken = $headers['Csrf-Token'];
} else {
    exit(json_encode(['error' => 'No CSRF token.']));
}

// Pastikan token CSRF adalah string
if (!is_string($receivedToken)) {
    exit(json_encode(['error' => 'CSRF token must be a string.']));
}

// Periksa kecocokan token CSRF dengan yang disimpan di sesi
if ($receivedToken !== $_SESSION['csrf_token']) {
    exit(json_encode(['error' => 'Wrong CSRF token.']));
}
