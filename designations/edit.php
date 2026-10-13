<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/security.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, 'SELECT * FROM employee_designations WHERE id=?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);
if (!$row) {
    flash('danger', 'Designation not found.');
    header('Location: index.php');
    exit;
}
$name = $row['name'];
$status = (string)$row['status'];
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim((string)($_POST['name'] ?? ''));
    $status = (string)($_POST['status'] ?? '');
    if ($name === '' || mb_strlen($name) > 255 || !valid_status($status)) {
        $error = 'Enter a designation name (maximum 255 characters) and valid status.';
    } else {
        $check = mysqli_prepare($conn, 'SELECT id FROM employee_designations WHERE LOWER(name)=LOWER(?) AND id<>? LIMIT 1');
        mysqli_stmt_bind_param($check, 'si', $name, $id);
        mysqli_stmt_execute($check);
        $exists = mysqli_fetch_assoc(mysqli_stmt_get_result($check));
        mysqli_stmt_close($check);
        if ($exists) {
            $error = 'A designation with this name already exists.';
        } else {
            $stmt = mysqli_prepare($conn, 'UPDATE employee_designations SET name=?,status=?,updated_at=NOW() WHERE id=?');
            $s = (int)$status;
            mysqli_stmt_bind_param($stmt, 'sii', $name, $s, $id);
            if (mysqli_stmt_execute($stmt)) {
                flash('success', 'Designation updated successfully.');
                header('Location: index.php');
                exit;
            }
            $error = 'Designation could not be updated.';
        }
    }
}
require_once '../includes/header.php';
require_once '../includes/navbar.php'; ?>
<div class="main-content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between py-3">
                <h5 class="mb-0">Edit Designation</h5><a class="btn btn-secondary btn-sm" href="index.php">Back</a>
            </div>
            <div class="card-body p-4"><?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?><form method="post"><?= csrf_field() ?><div class="mb-3"><label class="form-label">Name</label><input class="form-control" name="name" maxlength="255" value="<?= htmlspecialchars($name) ?>" required></div>
                    <div class="mb-3"><label class="form-label">Status</label><select class="form-select" name="status">
                            <option value="1" <?= $status === '1' ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?= $status === '0' ? 'selected' : '' ?>>Inactive</option>
                        </select></div><button class="btn btn-primary">Update Designation</button>
                </form>
            </div>
        </div>
    </div>
</div><?php require_once '../includes/footer.php'; ?>