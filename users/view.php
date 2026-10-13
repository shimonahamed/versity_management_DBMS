<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, 'SELECT u.*,(SELECT COUNT(*) FROM employees e WHERE e.user_id=u.id) employee_count FROM users u WHERE u.id=?');
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
                <h5 class="mb-0">User Details</h5>
                <div><a class="btn btn-warning btn-sm" href="edit.php?id=<?= $id ?>">Edit</a> <a class="btn btn-secondary btn-sm" href="index.php">Back</a></div>
            </div>
            <div class="card-body p-4">
                <div class="text-center mb-4"><?php if ($row['image']): ?><img class="user-detail-avatar" src="<?= htmlspecialchars($row['image']) ?>" alt="User photo"><?php else: ?><span class="user-detail-avatar"><i class="fas fa-user"></i></span><?php endif; ?></div>
                <div class="row g-4"><?php foreach (['Username' => $row['username'], 'Email' => $row['email'], 'Phone' => $row['phone'] ?: '-', 'Status' => $row['status'] == 1 ? 'Active' : 'Inactive', 'Linked Employee Records' => $row['employee_count'], 'Created' => $row['created_at'] ?: '-', 'Updated' => $row['updated_at'] ?: '-'] as $label => $value): ?><div class="col-md-6">
                            <div class="detail-label"><?= htmlspecialchars($label) ?></div>
                            <div class="detail-value"><?= htmlspecialchars((string)$value) ?></div>
                        </div><?php endforeach; ?></div>
            </div>
        </div>
    </div>
</div><?php require_once '../includes/footer.php'; ?>