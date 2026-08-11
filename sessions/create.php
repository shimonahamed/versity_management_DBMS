<?php
session_start();
require_once "../config/database.php";

$message = "";
$session_name = "";
$session_code = "";
$status = 1;

if (isset($_POST['submit'])) {
    $session_name = trim($_POST['session_name'] ?? '');
    $session_code = trim($_POST['session_code'] ?? '');
    $status       = (int)($_POST['status'] ?? 1);

    if (!empty($session_name) && !empty($session_code)) {

        $safe_name = mysqli_real_escape_string($conn, $session_name);
        $safe_code = mysqli_real_escape_string($conn, $session_code);

        $insert_query = "INSERT INTO session (session_name, session_code, status, created_at, updated_at) 
                        VALUES ('$safe_name', '$safe_code', '$status', NOW(), NOW())";

        try {
            if (mysqli_query($conn, $insert_query)) {
                header("Location: index.php?status=created");
                exit;
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        } catch (Exception $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $message = "This Session Code or Name already exists.";
            } else {
                $message = "Database Error: " . $e->getMessage();
            }
        }

    } else {
        $message = "Please fill in all the fields";
    }
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Create Session</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5" style="max-width: 600px;">
    <?php if (!empty($message)): ?>
        <div id="error-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold">Add New Session</h5>
            <a href="index.php" class="btn btn-secondary btn-sm">Back</a>
        </div>
        <div class="card-body p-4">
            <form action="create.php" method="post">
                <div class="mb-3">
                    <label class="form-label">Session Name</label>
                    <input type="text" class="form-control" name="session_name" value="<?= htmlspecialchars($session_name) ?>" placeholder="e.g. 2023-2024" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Session Code</label>
                    <input type="text" class="form-control" name="session_code" value="<?= htmlspecialchars($session_code) ?>" placeholder="e.g. S2324" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="1" <?= $status == 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= $status == 0 ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <div class="d-grid">
                    <button type="submit" name="submit" class="btn btn-primary">Save Session</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    setTimeout(function() {
        let alertNode = document.getElementById('error-alert');
        if (alertNode) {
            let alert = bootstrap.Alert.getOrCreateInstance(alertNode);
            alert.close();
        }
    }, 5000);
</script>

</body>
</html>