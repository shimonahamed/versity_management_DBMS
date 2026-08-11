<?php
require_once "../config/database.php";
require_once __DIR__ . '/../includes/auth.php';

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
        $stmt = mysqli_prepare($conn, "UPDATE session SET session_name = ?, session_code = ?, status = ?, updated_at = NOW() WHERE id = ?");

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssii", $session_name, $session_code, $status, $id);

            try {
                if (mysqli_stmt_execute($stmt)) {
                    header("Location: index.php?status=updated");
                    exit;
                }
            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() === 1062) {
                    $message = "The Session Code already exists in the database.";
                } else {
                    $message = "Database Error: " . $e->getMessage();
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            $message = "Failed to prepare query: " . mysqli_error($conn);
        }
    } else {
        $message = "Please fill in all the fields.";
    }
}

$stmt_select = mysqli_prepare($conn, "SELECT * FROM session WHERE id = ?");
mysqli_stmt_bind_param($stmt_select, "i", $id);
mysqli_stmt_execute($stmt_select);
$result = mysqli_stmt_get_result($stmt_select);
$session = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt_select);

if (!$session) {
    header("Location: index.php");
    exit;
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