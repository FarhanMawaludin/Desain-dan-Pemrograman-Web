<?php
session_start();
header('Content-Type: application/json');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$headers = apache_request_headers();

if (isset($headers['Csrf-Token'])) {
    if ($headers['Csrf-Token'] !== $_SESSION['csrf_token']) {
        exit(json_encode(['error' => 'Invalid CSRF token']));
    }
} else {
    exit(json_encode(['error' => 'Missing CSRF token']));
}
?>
