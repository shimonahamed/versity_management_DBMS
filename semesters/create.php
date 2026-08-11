<?php
require_once "../config/database.php";
require_once __DIR__ . '/../includes/auth.php';

$message = "";
$semester_name = "";
$semester_code = "";
$semester_number = "";
$status = 1;

if (isset($_POST['submit'])) {
    $semester_name = trim($_POST['semester_name'] ?? '');
    $semester_code = trim($_POST['semester_code'] ?? '');
    $semester_number = trim($_POST['semester_number'] ?? '');
    $status = (int)($_POST['status'] ?? 1);

    if ($semester_name === '' || $semester_code === '' || $semester_number === '') {
        $message = "Please fill in all the fields";
    } elseif (!ctype_digit($semester_number)) {
        $message = "The Semester Number must be a whole number";
    } else {
        $status = $status === 0 ? 0 : 1;
        $number = (int)$semester_number;

        try {
            $stmt = mysqli_prepare(
                    $conn,
                    "INSERT INTO semester (semester_name, semester_code, semester_number, status) VALUES (?, ?, ?, ?)"
            );

            if ($stmt) {
                mysqli_stmt_bind_param(
                        $stmt,
                        "ssii",
                        $semester_name,
                        $semester_code,
                        $number,
                        $status
                );

                if (mysqli_stmt_execute($stmt)) {
                    header("Location: index.php?status=created");
                    exit;
                }
                mysqli_stmt_close($stmt);
            } else {
                $message = "Failed to prepare query: " . mysqli_error($conn);
            }
        } catch (mysqli_sql_exception $e) {
            $message = $e->getCode() === 1062
                    ? "This Semester Code already exists in the database."
                    : "Database Error: " . $e->getMessage();
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

    <div class="main-content">
        <div class="container-fluid">
            <?php if ($message !== ''): ?>
                <div id="error-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold">Add New Semester</h5>
                    <a href="index.php" class="btn btn-secondary btn-sm">Back</a>
                </div>
                <div class="card-body p-4">
                    <form action="create.php" method="post">
                        <div class="mb-3">
                            <label class="form-label">Semester Name</label>
                            <input type="text" class="form-control" name="semester_name" value="<?= htmlspecialchars($semester_name) ?>" placeholder="Semester Name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Semester Code</label>
                            <input type="text" class="form-control" name="semester_code" value="<?= htmlspecialchars($semester_code) ?>" placeholder="Semester Code" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Semester Number</label>
                            <input type="number" min="1" class="form-control" name="semester_number" value="<?= htmlspecialchars((string)$semester_number) ?>" placeholder="Semester Number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="1" <?= $status == 1 ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= $status == 0 ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="submit" class="btn btn-primary">Save Semester</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(function() {
            const alertNode = document.getElementById('error-alert');
            if (alertNode) bootstrap.Alert.getOrCreateInstance(alertNode).close();
        }, 5000);
    </script>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>