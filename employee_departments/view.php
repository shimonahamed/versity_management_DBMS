<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, 'SELECT d.*,COUNT(e.id) employee_count FROM employee_departments d LEFT JOIN employees e ON e.department_id=d.id WHERE d.id=? GROUP BY d.id');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$row) {
    header('Location: index.php');
    exit;
}
require_once '../includes/header.php';
require_once '../includes/navbar.php'; ?>
<div class="main-content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between py-3">
                <h5 class="mb-0">Department Details</h5><a class="btn btn-secondary btn-sm" href="index.php">Back</a>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="detail-label">Name</div>
                        <div class="detail-value"><?= htmlspecialchars($row['name']) ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-label">Status</div>
                        <div class="detail-value"><span class="badge bg-<?= $row['status'] == 1 ? 'success' : 'secondary' ?>"><?= $row['status'] == 1 ? 'Active' : 'Inactive' ?></span></div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-label">Employees</div>
                        <div class="detail-value"><?= (int)$row['employee_count'] ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-label">Created</div>
                        <div class="detail-value"><?= htmlspecialchars($row['created_at'] ?? '-') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php require_once '../includes/footer.php'; ?>