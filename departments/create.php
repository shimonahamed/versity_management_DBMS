<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../config/database.php";
require_once __DIR__ . '/../includes/auth.php';

$message = "";
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
        $stmt = mysqli_prepare($conn, "INSERT INTO department (department_name, department_code, slug, status) VALUES (?, ?, ?, ?)");

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssi", $department_name, $department_code, $slug, $status);

            try {
                if (mysqli_stmt_execute($stmt)) {
                    header("Location: index.php?status=created");
                    exit;
                }
            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() === 1062) {
                    $message = "The Slug or Department Code already exists in the database.";
                } else {
                    $message = "Database Error: " . $e->getMessage();
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            $message = "Failed to prepare query: " . mysqli_error($conn);
        }
    } else {
        $message = "Please fill in all the fields correctly.";
    }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

    <div class="main-content">
        <div class="container-fluid">
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
                            <input type="text" class="form-control" id="slug" name="slug" value="<?= htmlspecialchars($slug) ?>" required>
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

<?php require_once __DIR__ . '/../includes/footer.php'; ?>