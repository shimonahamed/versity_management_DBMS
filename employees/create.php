<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/security.php';
require_once '../includes/employee_support.php';
$data = employee_input([]);
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $data = employee_input($_POST);
    $errors = validate_employee($conn, $data);
    if (!$errors) {
        try {
            if (insert_employee($conn, $data)) {
                flash('success', 'Employee added successfully.');
                header('Location: index.php');
                exit;
            }
            $errors[] = 'Employee could not be saved.';
        } catch (mysqli_sql_exception $e) {
            $errors[] = $e->getCode() === 1062 ? 'Employee ID, email, or NID already exists.' : 'Employee could not be saved due to a database error.';
        }
    }
}
[$departments, $designations] = employee_options($conn);
$submitLabel = 'Save Employee';
require_once '../includes/header.php';
require_once '../includes/navbar.php'; ?>
<div class="main-content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between py-3">
                <h5 class="mb-0">Add Employee</h5><a class="btn btn-secondary btn-sm" href="index.php">Back</a>
            </div>
            <div class="card-body p-4"><?php require '../includes/employee_form.php'; ?></div>
        </div>
    </div>
</div><?php require_once '../includes/footer.php'; ?>