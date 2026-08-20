<?php
require_once "../config/database.php";
require_once __DIR__ . '/../includes/auth.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$message = '';

if (isset($_POST['submit'])) {
    $course_code = trim($_POST['course_code'] ?? '');
    $course_name = trim($_POST['course_name'] ?? '');
    $department_id = (int) ($_POST['department_id'] ?? 0);
    $credit = trim($_POST['credit'] ?? '');
    $status = (int) ($_POST['status'] ?? 1);

    if ($course_code !== '' && $course_name !== '' && $department_id > 0 && is_numeric($credit) && (float) $credit > 0) {
        $stmt = mysqli_prepare($conn, 'UPDATE course SET course_code = ?, course_name = ?, department_id = ?, credit = ?, status = ? WHERE id = ?');
        if ($stmt) {
            $credit_value = (float) $credit;
            mysqli_stmt_bind_param($stmt, 'ssidii', $course_code, $course_name, $department_id, $credit_value, $status, $id);
            try {
                if (mysqli_stmt_execute($stmt)) {
                    header('Location: index.php?status=updated');
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
        $message = 'Please fill in all fields correctly. Credit must be greater than zero.';
    }
}

$course_stmt = mysqli_prepare($conn, 'SELECT * FROM course WHERE id = ?');
mysqli_stmt_bind_param($course_stmt, 'i', $id);
mysqli_stmt_execute($course_stmt);
$course = mysqli_fetch_assoc(mysqli_stmt_get_result($course_stmt));
mysqli_stmt_close($course_stmt);

if (!$course) {
    header('Location: index.php');
    exit;
}

$departments = mysqli_query($conn, 'SELECT id, department_name, department_code FROM department ORDER BY department_name ASC');

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
                <h5 class="mb-0 fw-bold">Edit Course</h5>
                <a href="index.php" class="btn btn-secondary btn-sm">Back</a>
            </div>
            <div class="card-body p-4">
                <form action="edit.php?id=<?= $id ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label">Course Code</label>
                        <input type="text" class="form-control" name="course_code" value="<?= htmlspecialchars($course['course_code']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Course Name</label>
                        <input type="text" class="form-control" name="course_name" value="<?= htmlspecialchars($course['course_name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-select" required>
                            <?php while ($department = mysqli_fetch_assoc($departments)): ?>
                                <option value="<?= $department['id'] ?>" <?= (int) $course['department_id'] === (int) $department['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($department['department_name']) ?> (<?= htmlspecialchars($department['department_code']) ?>)
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Credit</label>
                        <input type="number" class="form-control" name="credit" value="<?= htmlspecialchars($course['credit']) ?>" min="0.1" max="99.9" step="0.1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" <?= (int) $course['status'] === 1 ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?= (int) $course['status'] === 0 ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="submit" class="btn btn-primary">Update Course</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
