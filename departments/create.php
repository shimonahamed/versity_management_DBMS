<?php
// ১. ব্রাউজারে আসল এরর মেসেজটি ফুটিয়ে তোলার জন্য
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ২. ডাটাবেজ ফাইল অন্তর্ভুক্ত করা
require_once "../config/database.php";

$message = "";

// ফর্মের মান ধরে রাখার জন্য
$department_name = "";
$department_code = "";
$slug            = "";
$status          = 1;

if (isset($_POST['submit'])) {
    $department_name = trim($_POST['department_name'] ?? '');
    $department_code = trim($_POST['department_code'] ?? '');
    $slug            = trim($_POST['slug'] ?? '');
    $status          = (int)($_POST['status'] ?? 1);

    if (!empty($department_name) && !empty($department_code) && !empty($slug)) {

        $safe_name = mysqli_real_escape_string($conn, $department_name);
        $safe_code = mysqli_real_escape_string($conn, $department_code);
        $safe_slug = mysqli_real_escape_string($conn, $slug);

        $insert_query = "INSERT INTO department (department_name, department_code, slug, status) 
                        VALUES ('$safe_name', '$safe_code', '$safe_slug', '$status')";
        try {
            $result = mysqli_query($conn, $insert_query);
            if ($result) {
                header("Location: index.php?status=created");
                exit;
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        } catch (Exception $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $message = "এই Slug বা Department Code-টি ইতিমধ্যে ডাটাবেজে রয়েছে।";
            } else {
                $message = "Database Error: " . $e->getMessage();
            }
        }

    } else {
        $message = "সবগুলো ঘর সঠিকভাবে পূরণ করুন।";
    }
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Create Department</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<script>
    setTimeout(function() {
        let alertNode = document.querySelector('.alert');
        if (alertNode) {
            let alert = bootstrap.Alert.getOrCreateInstance(alertNode);
            alert.close();
        }
    }, 5000);
</script>
<div class="container py-5" style="max-width: 600px;">
    <?php if (!empty($message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold">Add New Department</h5>
            <a href="index.php" class="btn btn-secondary btn-sm">Back</a>
        </div>
        <div class="card-body p-4">
            <form action="create.php" method="post">
                <div class="mb-3">
                    <label class="form-label">Department Name</label>
                    <input
                        type="text"
                        class="form-control"
                        id="department_name"
                        name="department_name"
                        value="<?= htmlspecialchars($department_name) ?>"
                        required
                    >
                </div>
                <div class="mb-3">
                    <label class="form-label">Department Code</label>
                    <input
                        type="text"
                        class="form-control"
                        name="department_code"
                        value="<?= htmlspecialchars($department_code) ?>"
                        required
                    >
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input
                        type="text"
                        class="form-control"
                        id="slug"
                        name="slug"
                        value="<?= htmlspecialchars($slug) ?>"
                        required
                    >
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="1" <?= $status == 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= $status == 0 ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <div class="d-grid">
                    <button type="submit" name="submit" class="btn btn-primary">Save Department</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const nameInput = document.getElementById('department_name');
    const slugInput = document.getElementById('slug');

    nameInput.addEventListener('keyup', function() {
        slugInput.value = nameInput.value
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    });
</script>

</body>
</html>