<?php
require_once "../config/database.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$id) {
    header("Location: index.php");
    exit;
}

$message = "";

if (isset($_POST['submit'])) {
    $department_name = mysqli_real_escape_string($conn, trim($_POST['department_name']));
    $department_code = mysqli_real_escape_string($conn, trim($_POST['department_code']));
    $slug            = mysqli_real_escape_string($conn, trim($_POST['slug']));
    $status          = (int)$_POST['status'];

    if (!empty($department_name) && !empty($department_code) && !empty($slug)) {
        $update_query = "UPDATE department SET 
                            department_name = '$department_name', 
                            department_code = '$department_code', 
                            slug = '$slug', 
                            status = '$status' 
                         WHERE id = $id";

        if (mysqli_query($conn, $update_query)) {
            header("Location: index.php?status=updated");
            exit;
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    } else {
        $message = "All fields are required.";
    }
}

// আগের ডাটা ফেস করা
$select_query = "SELECT * FROM department WHERE id = $id";
$result = mysqli_query($conn, $select_query);
$department = mysqli_fetch_assoc($result);

if (!$department) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Edit Department</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5" style="max-width: 600px;">
    <?php if (!empty($message)): ?>
        <div class="alert alert-danger"><?= $message ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold">Edit Department</h5>
            <a href="index.php" class="btn btn-secondary btn-sm">Back</a>
        </div>
        <div class="card-body p-4">
            <form action="edit.php?id=<?= $id ?>" method="post">
                <div class="mb-3">
                    <label class="form-label">Department Name</label>
                    <input type="text" class="form-control" id="department_name" name="department_name" value="<?= htmlspecialchars($department['department_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Department Code</label>
                    <input type="text" class="form-control" name="department_code" value="<?= htmlspecialchars($department['department_code']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="<?= htmlspecialchars($department['slug']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="1" <?= $department['status'] == 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= $department['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <div class="d-grid">
                    <button type="submit" name="submit" class="btn btn-primary">Update Department</button>
                </div>
            </form>
        </div>
    </div>
</div>

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