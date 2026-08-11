<?php
session_start();
require_once "../config/database.php";
require_once __DIR__ . '/../includes/auth.php';

$message = "";
$session_name = "";
$session_code = "";
$status = 1;

if (isset($_POST['submit'])) {
    $session_name = trim($_POST['session_name'] ?? '');
    $session_code = trim($_POST['session_code'] ?? '');
    $status       = (int)($_POST['status'] ?? 1);

    if (!empty($session_name) && !empty($session_code)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO session (session_name, session_code, status, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssi", $session_name, $session_code, $status);

            try {
                if (mysqli_stmt_execute($stmt)) {
                    header("Location: index.php?status=created");
                    exit;
                }
            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() === 1062) {
                    $message = "This Session Code or Name already exists.";
                } else {
                    $message = "Database Error: " . $e->getMessage();
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            $message = "Failed to prepare query: " . mysqli_error($conn);
        }
    } else {
        $message = "Please fill in all the fields";
    }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

    <div class="main-content">
        <div class="container-fluid">

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
<?php require_once __DIR__ . '/../includes/footer.php'; ?>