<?php

declare(strict_types=1);

function user_input(array $source): array
{
    return [
        'username' => trim((string)($source['username'] ?? '')),
        'email' => trim((string)($source['email'] ?? '')),
        'phone' => trim((string)($source['phone'] ?? '')),
        'status' => (string)($source['status'] ?? '1'),
        'password' => (string)($source['password'] ?? ''),
        'password_confirmation' => (string)($source['password_confirmation'] ?? ''),
    ];
}

function validate_user(mysqli $conn, array $data, int $ignoreId = 0, bool $passwordRequired = true): array
{
    $errors = [];
    if ($data['username'] === '' || mb_strlen($data['username']) > 100 || !preg_match('/^[A-Za-z0-9_.-]+$/', $data['username'])) $errors[] = 'Username is required, may contain letters, numbers, dot, dash and underscore, and must not exceed 100 characters.';
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($data['email']) > 150) $errors[] = 'Enter a valid email address of at most 150 characters.';
    if (mb_strlen($data['phone']) > 255) $errors[] = 'Phone may not exceed 255 characters.';
    if (!in_array($data['status'], ['0', '1'], true)) $errors[] = 'Select a valid status.';
    if ($passwordRequired && $data['password'] === '') $errors[] = 'Password is required.';
    if ($data['password'] !== $data['password_confirmation']) $errors[] = 'Password confirmation does not match.';
    foreach (['username' => 'Username', 'email' => 'Email'] as $column => $label) {
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE $column=? AND id<>? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 'si', $data[$column], $ignoreId);
        mysqli_stmt_execute($stmt);
        if (mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) $errors[] = "$label already exists.";
        mysqli_stmt_close($stmt);
    }
    return array_values(array_unique($errors));
}
