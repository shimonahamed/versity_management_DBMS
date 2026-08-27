<?php
require_once "../config/database.php";
require_once __DIR__ . '/../includes/auth.php';

$id = intval($_GET['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = intval($_POST['student_id']);
    $course_id = intval($_POST['course_id']);
    $semester_id = intval($_POST['semester_id']);
    $session_id = intval($_POST['session_id']);
    $registration_date = mysqli_real_escape_string($conn, $_POST['registration_date']);
    $status = isset($_POST['status']) ? 1 : 0;

    $query = "UPDATE course_registration SET
                student_id = $student_id,
                course_id = $course_id,
                semester_id = $semester_id,
                session_id = $session_id,
                registration_date = '$registration_date',
                status = $status,
                updated_at = NOW()
              WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: list.php?status=updated");
        exit;
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';

$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM course_registration WHERE id = $id"));
if (!$row) {
    echo "<div class='container-fluid'><div class='alert alert-danger'>Registration not found.</div></div>";
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

$students = mysqli_query($conn, "SELECT id, name FROM students ORDER BY name ASC");
$courses = mysqli_query($conn, "SELECT id, course_name FROM courses ORDER BY course_name ASC");
$semesters = mysqli_query($conn, "SELECT id, semester_name FROM semesters ORDER BY id ASC");
$sessions = mysqli_query($conn, "SELECT id, session_name FROM sessions ORDER BY id DESC");
?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Edit Course Registration</h2>
                <a href="list.php" class="btn btn-secondary">Back to List</a>
            </div>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Student</label>
                                <select name="student_id" class="form-select" required>
                                    <?php while ($s = mysqli_fetch_assoc($students)): ?>
                                        <option value="<?= $s['id'] ?>" <?= $s['id'] == $row['student_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($s['name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Course</label>
                                <select name="course_id" class="form-select" required>
                                    <?php while ($c = mysqli_fetch_assoc($courses)): ?>
                                        <option value="<?= $c['id'] ?>" <?= $c['id'] == $row['course_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($c['course_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Semester</label>
                                <select name="semester_id" class="form-select" required>
                                    <?php while ($sem = mysqli_fetch_assoc($semesters)): ?>
                                        <option value="<?= $sem['id'] ?>" <?= $sem['id'] == $row['semester_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($sem['semester_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Session</label>
                                <select name="session_id" class="form-select" required>
                                    <?php while ($ses = mysqli_fetch_assoc($sessions)): ?>
                                        <option value="<?= $ses['id'] ?>" <?= $ses['id'] == $row['session_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($ses['session_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Registration Date</label>
                                <input type="date" name="registration_date" class="form-control" value="<?= htmlspecialchars($row['registration_date']) ?>" required>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <div class="form-check">
                                    <input type="checkbox" name="status" class="form-check-input" id="statusCheck" <?= $row['status'] == 1 ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="statusCheck">Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update Registration</button>
                            <a href="list.php" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>