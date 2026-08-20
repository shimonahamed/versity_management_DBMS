<?php
require_once "../config/database.php";
require_once __DIR__ . '/../includes/auth.php';
$message = '';
$student = ['student_id' => '', 'student_name' => '', 'student_email' => '', 'student_phone' => '', 'student_gender' => '', 'department_id' => '', 'session_id' => '', 'admission_date' => '', 'date_of_birth' => '', 'address' => '', 'status' => ''];
if (isset($_POST['submit'])) {
    foreach ($student as $field => $value) $student[$field] = trim($_POST[$field] ?? '');
    $department_id = (int) $student['department_id'];
    $session_id = (int) $student['session_id'];
    $valid_gender = in_array($student['student_gender'], ['Male', 'Female', 'Other', ''], true);
    $valid_status = in_array($student['status'], ['1', '2', '3', '4'], true);
    if ($student['student_id'] !== '' && $student['student_name'] !== '' && $department_id > 0 && $session_id > 0 && $valid_gender && $valid_status) {
        $stmt = mysqli_prepare($conn, "INSERT INTO students (student_id, student_name, student_email, student_phone, student_gender, department_id, session_id, admission_date, date_of_birth, address, status) VALUES (?, ?, NULLIF(?, ''), NULLIF(?, ''), NULLIF(?, ''), ?, ?, NULLIF(?, ''), NULLIF(?, ''), NULLIF(?, ''), ?)");
        if ($stmt) {
            $status = (int) $student['status'];
            mysqli_stmt_bind_param($stmt, 'sssssiisssi', $student['student_id'], $student['student_name'], $student['student_email'], $student['student_phone'], $student['student_gender'], $department_id, $session_id, $student['admission_date'], $student['date_of_birth'], $student['address'], $status);
            try {
                if (mysqli_stmt_execute($stmt)) {
                    header('Location: index.php?status=created');
                    exit;
                }
            } catch (mysqli_sql_exception $e) {
                $message = $e->getCode() === 1062 ? 'The Student ID already exists in the database.' : 'Database Error: ' . $e->getMessage();
            }
            mysqli_stmt_close($stmt);
        } else $message = 'Failed to prepare query: ' . mysqli_error($conn);
    } else $message = 'Please fill in all required fields correctly.';
}
$departments = mysqli_query($conn, 'SELECT id, department_name, department_code FROM department WHERE status = 1 ORDER BY department_name');
$sessions = mysqli_query($conn, 'SELECT id, session_name, session_code FROM session WHERE status = 1 ORDER BY session_name');
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>
<div class="main-content">
    <div class="container-fluid">
        <?php if ($message): ?><div class="alert alert-danger alert-dismissible fade show"><?= htmlspecialchars($message) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold">Add New Student</h5><a href="index.php" class="btn btn-secondary btn-sm">Back</a>
            </div>
            <div class="card-body p-4">
                <form action="create.php" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3"><label class="form-label">Student ID</label><input type="text" class="form-control" name="student_id" value="<?= htmlspecialchars($student['student_id']) ?>" placeholder="Enter student ID" required></div>
                            <div class="mb-3"><label class="form-label">Student Name</label><input type="text" class="form-control" name="student_name" value="<?= htmlspecialchars($student['student_name']) ?>" placeholder="Enter student name" required></div>
                            <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" name="student_email" value="<?= htmlspecialchars($student['student_email']) ?>" placeholder="Enter email address"></div>
                            <div class="mb-3"><label class="form-label">Phone</label><input type="text" class="form-control" name="student_phone" value="<?= htmlspecialchars($student['student_phone']) ?>" placeholder="Enter phone number"></div>
                            <div class="mb-3"><label class="form-label">Gender</label><select name="student_gender" class="form-select">
                                    <option value="" disabled <?= $student['student_gender'] === '' ? 'selected' : '' ?>>Select Gender</option><?php foreach (['Male', 'Female', 'Other'] as $gender): ?><option value="<?= $gender ?>" <?= $student['student_gender'] === $gender ? 'selected' : '' ?>><?= $gender ?></option><?php endforeach; ?>
                                </select></div>
                            <div class="mb-3"><label class="form-label">Status</label><select name="status" class="form-select" required>
                                    <option value="" disabled <?= $student['status'] === '' ? 'selected' : '' ?>>Select Status</option>
                                    <option value="1" <?= $student['status'] === '1' ? 'selected' : '' ?>>Active</option>
                                    <option value="2" <?= $student['status'] === '2' ? 'selected' : '' ?>>Inactive</option>
                                    <option value="3" <?= $student['status'] === '3' ? 'selected' : '' ?>>Passout</option>
                                    <option value="4" <?= $student['status'] === '4' ? 'selected' : '' ?>>Dropout</option>
                                </select></div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3"><label class="form-label">Department</label><select name="department_id" class="form-select" required>
                                    <option value="" disabled <?= $student['department_id'] === '' ? 'selected' : '' ?>>Select Department</option><?php while ($department = mysqli_fetch_assoc($departments)): ?><option value="<?= $department['id'] ?>" <?= (int) $student['department_id'] === (int) $department['id'] ? 'selected' : '' ?>><?= htmlspecialchars($department['department_name']) ?> (<?= htmlspecialchars($department['department_code']) ?>)</option><?php endwhile; ?>
                                </select></div>
                            <div class="mb-3"><label class="form-label">Session</label><select name="session_id" class="form-select" required>
                                    <option value="" disabled <?= $student['session_id'] === '' ? 'selected' : '' ?>>Select Session</option><?php while ($session = mysqli_fetch_assoc($sessions)): ?><option value="<?= $session['id'] ?>" <?= (int) $student['session_id'] === (int) $session['id'] ? 'selected' : '' ?>><?= htmlspecialchars($session['session_name']) ?> (<?= htmlspecialchars($session['session_code']) ?>)</option><?php endwhile; ?>
                                </select></div>
                            <div class="mb-3"><label class="form-label">Admission Date</label><input type="date" class="form-control" name="admission_date" value="<?= htmlspecialchars($student['admission_date']) ?>"></div>
                            <div class="mb-3"><label class="form-label">Date of Birth</label><input type="date" class="form-control" name="date_of_birth" value="<?= htmlspecialchars($student['date_of_birth']) ?>"></div>
                            <div class="mb-3"><label class="form-label">Address</label><textarea class="form-control" name="address" rows="3" placeholder="Enter address"><?= htmlspecialchars($student['address']) ?></textarea></div>

                        </div>
                    </div>
                    <div class="d-grid"><button type="submit" name="submit" class="btn btn-primary">Save Student</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>