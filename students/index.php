<?php
require_once "../config/database.php";
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';

$result = mysqli_query($conn, "SELECT students.*, department.department_name, session.session_name FROM students LEFT JOIN department ON students.department_id = department.id LEFT JOIN session ON students.session_id = session.id ORDER BY students.id DESC");
$status_labels = [1 => ['Active', 'success'], 2 => ['Inactive', 'secondary'], 3 => ['Passout', 'info'], 4 => ['Dropout', 'danger']];
?>
<div class="main-content"><div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4"><h2>Student List</h2><a href="create.php" class="btn btn-primary">+ Add New Student</a></div>
    <?php if (isset($_GET['status'])): ?><div id="status-alert" class="alert alert-success alert-dismissible fade show"><?php if ($_GET['status'] === 'created') echo 'Student added successfully!'; if ($_GET['status'] === 'updated') echo 'Student updated successfully!'; if ($_GET['status'] === 'deleted') echo 'Student deleted successfully!'; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
    <div class="card shadow-sm"><div class="card-body p-0 table-responsive"><table class="table table-striped table-hover mb-0">
        <thead class="table-dark"><tr><th>ID</th><th>Student ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Gender</th><th>Department</th><th>Session</th><th>Status</th><th>Action</th></tr></thead><tbody>
        <?php $sl = 1; ?>
        <?php if ($result && mysqli_num_rows($result) > 0): while ($student = mysqli_fetch_assoc($result)): ?>
            <?php $status = $status_labels[(int) $student['status']] ?? ['Unknown', 'dark']; ?>
            <tr><td><?= $sl++ ?></td><td><?= htmlspecialchars($student['student_id']) ?></td><td><?= htmlspecialchars($student['student_name']) ?></td><td><?= htmlspecialchars($student['student_email'] ?? '-') ?></td><td><?= htmlspecialchars($student['student_phone'] ?? '-') ?></td><td><?= htmlspecialchars($student['student_gender'] ?? '-') ?></td><td><?= htmlspecialchars($student['department_name'] ?? 'Not available') ?></td><td><?= htmlspecialchars($student['session_name'] ?? 'Not available') ?></td><td><span class="badge bg-<?= $status[1] ?>"><?= $status[0] ?></span></td><td class="text-nowrap"><a href="view.php?id=<?= $student['id'] ?>" class="btn btn-sm btn-info text-white">View</a> <a href="edit.php?id=<?= $student['id'] ?>" class="btn btn-sm btn-warning">Edit</a> <a href="delete.php?id=<?= $student['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a></td></tr>
        <?php endwhile; else: ?><tr><td colspan="10" class="text-center py-3">No students found.</td></tr><?php endif; ?>
        </tbody></table></div></div>
</div></div>
<script>if (window.history.replaceState) { const url = new URL(window.location.href); url.searchParams.delete('status'); window.history.replaceState(null, null, url.pathname); } setTimeout(function () { const alert = document.getElementById('status-alert'); if (alert) { alert.classList.remove('show'); setTimeout(function () { alert.remove(); }, 500); } }, 3000);</script>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
