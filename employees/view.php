<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, 'SELECT e.*,d.name department_name,g.name designation_name FROM employees e LEFT JOIN employee_departments d ON d.id=e.department_id LEFT JOIN employee_designations g ON g.id=e.designation_id WHERE e.id=?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$row) {
    header('Location: index.php');
    exit;
}
$maps = ['gender' => [1 => 'Male', 2 => 'Female', 3 => 'Other'], 'marital_status' => [1 => 'Married', 2 => 'Unmarried'], 'religion' => [1 => 'Islam', 2 => 'Hindu', 3 => 'Buddhist', 4 => 'Christian'], 'employee_type' => [1 => 'Teacher', 2 => 'Staff', 3 => 'Support Staff'], 'status' => [0 => 'Inactive', 1 => 'Active', 2 => 'Resigned', 3 => 'Terminated']];
$fields = ['Employee ID' => $row['employee_id'], 'Name' => $row['name'], 'Email' => $row['email'], 'Phone' => $row['phone'], 'NID' => $row['nid'], "Father's Name" => $row['father_name'], "Mother's Name" => $row['mother_name'], 'Department' => $row['department_name'], 'Designation' => $row['designation_name'], 'Employee Type' => $maps['employee_type'][$row['employee_type']] ?? 'Unknown', 'Gender' => $maps['gender'][$row['gender']] ?? 'Unknown', 'Marital Status' => $maps['marital_status'][$row['marital_status']] ?? 'Unknown', 'Religion' => $maps['religion'][$row['religion']] ?? 'Unknown', 'Joining Date' => $row['joining_date'], 'Date of Birth' => $row['date_of_birth'], 'Resign Date' => $row['resign_date'], 'Terminate Date' => $row['terminate_date'], 'Status' => $maps['status'][$row['status']] ?? 'Unknown', 'Sort Order' => $row['sort_order'], 'Created' => $row['created_at'], 'Updated' => $row['updated_at']];
require_once '../includes/header.php';
require_once '../includes/navbar.php'; ?>
<div class="main-content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between py-3">
                <h5 class="mb-0">Employee Details</h5>
                <div><a class="btn btn-warning btn-sm" href="edit.php?id=<?= $id ?>">Edit</a> <a class="btn btn-secondary btn-sm" href="index.php">Back</a></div>
            </div>
            <div class="card-body p-4">
                <div class="row g-4"><?php foreach ($fields as $label => $value): ?><div class="col-md-6 col-xl-4">
                            <div class="detail-label"><?= htmlspecialchars($label) ?></div>
                            <div class="detail-value"><?= htmlspecialchars((string)($value ?: '-')) ?></div>
                        </div><?php endforeach; ?></div>
            </div>
        </div>
    </div>
</div><?php require_once '../includes/footer.php'; ?>