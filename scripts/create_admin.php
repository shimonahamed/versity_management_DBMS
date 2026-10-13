<?php

declare(strict_types=1);
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require_once __DIR__ . '/../config/database.php';

$username = trim((string) readline('Username: '));
$email = trim((string) readline('Email: '));
fwrite(STDOUT, 'Password: ');
$password = trim((string) fgets(STDIN));
if ($username === '' || mb_strlen($username) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150 || strlen($password) < 8) {
    fwrite(STDERR, "Username, valid email, and a password of at least 8 characters are required.\n");
    exit(1);
}
$check = mysqli_prepare($conn, 'SELECT id FROM users WHERE username=? OR email=? LIMIT 1');
mysqli_stmt_bind_param($check, 'ss', $username, $email);
mysqli_stmt_execute($check);
if (mysqli_fetch_assoc(mysqli_stmt_get_result($check))) {
    fwrite(STDERR, "Username or email already exists.\n");
    exit(1);
}
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = mysqli_prepare($conn, 'INSERT INTO users(username,email,password,status,created_at,updated_at) VALUES(?,?,?,1,NOW(),NOW())');
mysqli_stmt_bind_param($stmt, 'sss', $username, $email, $hash);
if (!mysqli_stmt_execute($stmt)) {
    fwrite(STDERR, "User could not be created. Apply the schema hardening SQL first.\n");
    exit(1);
}
fwrite(STDOUT, "Administrator account created.\n");
