<?php
require_once "../config/database.php";
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';

$query = "SELECT course.*, department.department_name
          FROM course
          LEFT JOIN department ON course.department_id = department.id
          ORDER BY course.id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Course List</h2>
            <a href="create.php" class="btn btn-primary">+ Add New Course</a>
        </div>

        <?php if (isset($_GET['status'])): ?>
            <div id="status-alert" class="alert alert-success alert-dismissible fade show">
                <?php
                if ($_GET['status'] === 'created') echo 'Course added successfully!';
                if ($_GET['status'] === 'updated') echo 'Course updated successfully!';
                if ($_GET['status'] === 'deleted') echo 'Course deleted successfully!';
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Department</th>
                        <th>Credit</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $sl = 1; ?>
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= htmlspecialchars($row['course_code']) ?></td>
                                <td><?= htmlspecialchars($row['course_name']) ?></td>
                                <td><?= htmlspecialchars($row['department_name'] ?? 'Not available') ?></td>
                                <td><?= htmlspecialchars($row['credit']) ?></td>
                                <td>
                                    <?php if ((int) $row['status'] === 1): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-3">No courses found.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    if (window.history.replaceState) {
        const url = new URL(window.location.href);
        url.searchParams.delete('status');
        window.history.replaceState(null, null, url.pathname);
    }

    setTimeout(function () {
        const alert = document.getElementById('status-alert');
        if (alert) {
            alert.classList.remove('show');
            setTimeout(function () { alert.remove(); }, 500);
        }
    }, 3000);
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
