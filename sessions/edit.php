<?php
require_once "../config/database.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$id) {
    header("Location: index.php");
    exit;
}

$message = "";

if (isset($_POST['submit'])) {
    $session_name = trim($_POST['session_name'] ?? '');
    $session_code = trim($_POST['session_code'] ?? '');
    $status       = (int)($_POST['status'] ?? 1);

    if (!empty($session_name) && !empty($session_code)) {

        $safe_name = mysqli_real_escape_string($conn, $session_name);
        $safe_code = mysqli_real_escape_string($conn, $session_code);

        $update_query = "UPDATE sessions SET 
                            session_name = '$safe_name', 
                            session_code = '$safe_code', 
                            status = '$status',
                            updated_at = NOW() 
                         WHERE id = $id";

        try {
            if (mysqli_query($conn, $update_query)) {
                header("Location: index.php?status=updated");
                exit;
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
        } catch (Exception $e) {
            $message = "Error: " . $e->getMessage();
        }

    } else {
        $message = "সবগুলো ঘর পূরণ করুন।";
    }
}

$select_query = "SELECT * FROM session WHERE id = $id";
$result = mysqli_query($conn, $select_query);
$session = mysqli_fetch_assoc($result);

if (!$session) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Edit Session</title>
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
            <h5 class="mb-0 fw-bold">Edit Session</h5>
            <a href="index.php" class="btn btn-secondary btn-sm">Back</a>
        </div>
        <div class="card-body p-4">
            <form action="edit.php?id=<?= $id ?>" method="post">
                <div class="mb-3">
                    <label class="form-label">Session Name</label>
                    <input type="text" class="form-control" name="session_name" value="<?= htmlspecialchars($session['session_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Session Code</label>
                    <input type="text" class="form-control" name="session_code" value="<?= htmlspecialchars($session['session_code']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="1" <?= $session['status'] == 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= $session['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <div class="d-grid">
                    <button type="submit" name="submit" class="btn btn-primary">Update Session</button>
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