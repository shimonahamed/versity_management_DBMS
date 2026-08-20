<?php
require_once "../config/database.php";
require_once __DIR__ . '/../includes/auth.php';

$message = '';
$course_code = '';
$course_name = '';
$department_id = '';
$credit = '';
$status = '';

if (isset($_POST['submit'])) {
    $course_code = trim($_POST['course_code'] ?? '');
    $course_name = trim($_POST['course_name'] ?? '');
    $department_id = (int) ($_POST['department_id'] ?? 0);
    $credit = trim($_POST['credit'] ?? '');
    $status = $_POST['status'] ?? '';

    if ($course_code !== '' && $course_name !== '' && $department_id > 0 && is_numeric($credit) && (float) $credit > 0 && ($status === '0' || $status === '1')) {
        $stmt = mysqli_prepare($conn, 'INSERT INTO course (course_code, course_name, department_id, credit, status) VALUES (?, ?, ?, ?, ?)');
        if ($stmt) {
            $credit_value = (float) $credit;
            $status_value = (int) $status;
            mysqli_stmt_bind_param($stmt, 'ssidi', $course_code, $course_name, $department_id, $credit_value, $status_value);
            try {
                if (mysqli_stmt_execute($stmt)) {
                    header('Location: index.php?status=created');
                    exit;
                }
            } catch (mysqli_sql_exception $e) {
                $message = $e->getCode() === 1062 ? 'The course code already exists in the database.' : 'Database Error: ' . $e->getMessage();
            }
            mysqli_stmt_close($stmt);
        } else {
            $message = 'Failed to prepare query: ' . mysqli_error($conn);
        }
    } else {
        $message = 'Please select a status and fill in all fields correctly. Credit must be greater than zero.';
    }
}

$departments = mysqli_query($conn, 'SELECT id, department_name, department_code FROM department WHERE status = 1 ORDER BY department_name ASC');

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>

<div class="main-content">
    <div class="container-fluid">
        <?php if ($message !== ''): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold">Add New Course</h5>
                <a href="index.php" class="btn btn-secondary btn-sm">Back</a>
            </div>
            <div class="card-body p-4">
                <form action="create.php" method="post">
                    <div class="mb-3">
                        <label class="form-label">Course Code</label>
                        <input type="text" class="form-control" name="course_code" value="<?= htmlspecialchars($course_code) ?>" placeholder="Enter course code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Course Name</label>
                        <input type="text" class="form-control" name="course_name" value="<?= htmlspecialchars($course_name) ?>" placeholder="Enter course name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-select" required>
                            <option value="">Select Department</option>
                            <?php while ($department = mysqli_fetch_assoc($departments)): ?>
                                <option value="<?= $department['id'] ?>" <?= (int) $department_id === (int) $department['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($department['department_name']) ?> (<?= htmlspecialchars($department['department_code']) ?>)
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Credit</label>
                        <input type="number" class="form-control" name="credit" value="<?= htmlspecialchars($credit) ?>" placeholder="Enter credit (e.g. 3.0)" min="0.1" max="99.9" step="0.1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="" disabled <?= $status === '' ? 'selected' : '' ?>>Select Status</option>
                            <option value="1" <?= $status === '1' ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?= $status === '0' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="submit" class="btn btn-primary">Save Course</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
