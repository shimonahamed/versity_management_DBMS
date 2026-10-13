<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/security.php';
require_once '../includes/employee_support.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, 'SELECT * FROM employees WHERE id=?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$row) {
    flash('danger', 'Employee not found.');
    header('Location: index.php');
    exit;
}
$data = employee_input($row);
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $data = employee_input($_POST);
    $errors = validate_employee($conn, $data, $id);
    if (!$errors) {
        try {
            if (update_employee($conn, $data, $id)) {
                flash('success', 'Employee updated successfully.');
                header('Location: index.php');
                exit;
            }
            $errors[] = 'Employee could not be updated.';
        } catch (mysqli_sql_exception $e) {
            $errors[] = $e->getCode() === 1062 ? 'Employee ID, email, or NID already exists.' : 'Employee could not be updated due to a database error.';
        }
    }
}
[$departments, $designations] = employee_options($conn);
$submitLabel = 'Update Employee';
require_once '../includes/header.php';
require_once '../includes/navbar.php'; ?>
<div class="main-content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between py-3">
                <h5 class="mb-0">Edit Employee</h5><a class="btn btn-secondary btn-sm" href="index.php">Back</a>
            </div>
            <div class="card-body p-4"><?php require '../includes/employee_form.php'; ?></div>
        </div>
    </div>
</div><?php require_once '../includes/footer.php'; ?>