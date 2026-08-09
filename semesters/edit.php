<?php
require_once "../config/database.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: index.php");
    exit;
}

$message = "";

$stmt = mysqli_prepare($conn, "SELECT * FROM semester WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$semester = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$semester) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['submit'])) {
    $semester_name = trim($_POST['semester_name'] ?? '');
    $semester_code = trim($_POST['semester_code'] ?? '');
    $semester_number = trim($_POST['semester_number'] ?? '');
    $status = (int)($_POST['status'] ?? 1);

    $semester['semester_name'] = $semester_name;
    $semester['semester_code'] = $semester_code;
    $semester['semester_number'] = $semester_number;
    $semester['status'] = $status === 0 ? 0 : 1;

    if ($semester_name === '' || $semester_code === '' || $semester_number === '') {
        $message = "সবগুলো ঘর পূরণ করুন।";
    } elseif (filter_var($semester_code, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false) {
        $message = "Semester Code অবশ্যই ১ বা তার বেশি পূর্ণসংখ্যা হতে হবে।";
    } elseif (filter_var($semester_number, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) === false) {
        $message = "Semester Number অবশ্যই ১ বা তার বেশি হতে হবে।";
    } else {
        $code = (int)$semester_code;
        $number = (int)$semester_number;
        $status = $semester['status'];

        try {
            $stmt = mysqli_prepare($conn, "UPDATE semester SET semester_name = ?, semester_code = ?, semester_number = ?, status = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "siiii", $semester_name, $code, $number, $status, $id);
            mysqli_stmt_execute($stmt);
            header("Location: index.php?status=updated");
            exit;
        } catch (mysqli_sql_exception $e) {
            $message = $e->getCode() === 1062
                ? "এই Semester Code-টি ইতিমধ্যে ডাটাবেজে রয়েছে।"
                : "Database Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Edit Semester</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5" style="max-width: 600px;">
    <?php if ($message !== ''): ?>
        <div id="error-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold">Edit Semester</h5>
            <a href="index.php" class="btn btn-secondary btn-sm">Back</a>
        </div>
        <div class="card-body p-4">
            <form action="edit.php?id=<?= $id ?>" method="post">
                <div class="mb-3">
                    <label class="form-label">Semester Name</label>
                    <input type="text" class="form-control" name="semester_name" value="<?= htmlspecialchars($semester['semester_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Semester Code</label>
                    <input type="number" min="1" step="1" class="form-control" name="semester_code" value="<?= htmlspecialchars($semester['semester_code']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Semester Number</label>
                    <input type="number" min="1" class="form-control" name="semester_number" value="<?= htmlspecialchars((string)$semester['semester_number']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="1" <?= (int)$semester['status'] === 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= (int)$semester['status'] === 0 ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <div class="d-grid">
                    <button type="submit" name="submit" class="btn btn-primary">Update Semester</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    setTimeout(function () {
        const alertNode = document.getElementById('error-alert');
        if (alertNode) bootstrap.Alert.getOrCreateInstance(alertNode).close();
    }, 5000);
</script>
</body>
</html>
