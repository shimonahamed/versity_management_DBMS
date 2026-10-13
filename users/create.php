<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/security.php';
require_once '../includes/user_support.php';
$data = user_input([]);
$errors = [];
$passwordRequired = true;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $data = user_input($_POST);
    $errors = validate_user($conn, $data, 0, true);
    if (!$errors) {
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $status = (int)$data['status'];
        $phone = null_if_empty($data['phone']);
        $stmt = mysqli_prepare($conn, 'INSERT INTO users(id,username,email,password,image,phone,status,created_at,updated_at) SELECT COALESCE(MAX(id),0)+1,?,?,?,NULL,?,?,NOW(),NOW() FROM users');
        mysqli_stmt_bind_param($stmt, 'ssssi', $data['username'], $data['email'], $hash, $phone, $status);
        try {
            if (mysqli_stmt_execute($stmt)) {
                flash('success', 'User created successfully.');
                header('Location: index.php');
                exit;
            }
            $errors[] = 'User could not be created.';
        } catch (mysqli_sql_exception $e) {
            $errors[] = $e->getCode() === 1062 ? 'Username or email already exists.' : 'User could not be created due to a database error.';
        }
        mysqli_stmt_close($stmt);
    }
}
$submitLabel = 'Save User';
require_once '../includes/header.php';
require_once '../includes/navbar.php'; ?>
<div class="main-content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between py-3">
                <h5 class="mb-0">Add User</h5><a class="btn btn-secondary btn-sm" href="index.php">Back</a>
            </div>
            <div class="card-body p-4"><?php require '../includes/user_form.php'; ?></div>
        </div>
    </div>
</div><?php require_once '../includes/footer.php'; ?>