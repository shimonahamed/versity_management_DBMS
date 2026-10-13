<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/security.php';
require_once '../includes/user_support.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, 'SELECT * FROM users WHERE id=?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$row) {
    flash('danger', 'User not found.');
    header('Location: index.php');
    exit;
}
$data = user_input($row);
$errors = [];
$passwordRequired = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $data = user_input($_POST);
    $errors = validate_user($conn, $data, $id, false);
    if ($id === (int)$_SESSION['user_id'] && $data['status'] === '0') $errors[] = 'You cannot deactivate your own signed-in account.';
    if (!$errors) {
        $status = (int)$data['status'];
        $phone = null_if_empty($data['phone']);
        if ($data['password'] !== '') {
            $hash = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($conn, 'UPDATE users SET username=?,email=?,password=?,phone=?,status=?,updated_at=NOW() WHERE id=?');
            mysqli_stmt_bind_param($stmt, 'ssssii', $data['username'], $data['email'], $hash, $phone, $status, $id);
        } else {
            $stmt = mysqli_prepare($conn, 'UPDATE users SET username=?,email=?,phone=?,status=?,updated_at=NOW() WHERE id=?');
            mysqli_stmt_bind_param($stmt, 'sssii', $data['username'], $data['email'], $phone, $status, $id);
        }
        try {
            if (mysqli_stmt_execute($stmt)) {
                flash('success', 'User updated successfully.');
                header('Location: index.php');
                exit;
            }
            $errors[] = 'User could not be updated.';
        } catch (mysqli_sql_exception $e) {
            $errors[] = $e->getCode() === 1062 ? 'Username or email already exists.' : 'User could not be updated due to a database error.';
        }
        mysqli_stmt_close($stmt);
    }
}
$submitLabel = 'Update User';
require_once '../includes/header.php';
require_once '../includes/navbar.php'; ?>
<div class="main-content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between py-3">
                <h5 class="mb-0">Edit User</h5><a class="btn btn-secondary btn-sm" href="index.php">Back</a>
            </div>
            <div class="card-body p-4"><?php require '../includes/user_form.php'; ?></div>
        </div>
    </div>
</div><?php require_once '../includes/footer.php'; ?>