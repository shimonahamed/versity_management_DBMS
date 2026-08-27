<?php
require_once "../config/database.php";
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';

// Filter values from GET
$session_id  = $_GET['session_id']  ?? '';
$semester_id = $_GET['semester_id'] ?? '';
$department_id = $_GET['department_id'] ?? '';

// Dropdown data
$sessions    = mysqli_query($conn, "SELECT id, session_name FROM session ORDER BY id DESC");
$semesters   = mysqli_query($conn, "SELECT id, semester_name FROM semester ORDER BY id ASC");
$departments = mysqli_query($conn, "SELECT id, department_name FROM department ORDER BY department_name ASC");

// Build query dynamically based on filters
$query = "SELECT cr.*, 
                 s.student_name,
                 c.course_name,
                 c.department_id,
                 d.department_name,
                 sem.semester_name,
                 ses.session_name
          FROM course_registration cr
          LEFT JOIN students s ON cr.student_id = s.id
          LEFT JOIN course c ON cr.course_id = c.id
          LEFT JOIN department d ON c.department_id = d.id
          LEFT JOIN semester sem ON cr.semester_id = sem.id
          LEFT JOIN session ses ON cr.session_id = ses.id
          WHERE 1=1";

if (!empty($session_id)) {
    $query .= " AND cr.session_id = " . intval($session_id);
}
if (!empty($semester_id)) {
    $query .= " AND cr.semester_id = " . intval($semester_id);
}
if (!empty($department_id)) {
    $query .= " AND c.department_id = " . intval($department_id);
}

$query .= " ORDER BY cr.id DESC";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}
?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Course Registration Report</h2>
                <a href="/versity_management_DBMS/registrations/index.php" class="btn btn-secondary">Back to List</a>
            </div>

            <!-- Filter Form -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Session</label>
                                <select name="session_id" class="form-select">
                                    <option value="">-- All Sessions --</option>
                                    <?php while ($ses = mysqli_fetch_assoc($sessions)): ?>
                                        <option value="<?= $ses['id'] ?>" <?= $session_id == $ses['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($ses['session_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Semester</label>
                                <select name="semester_id" class="form-select">
                                    <option value="">-- All Semesters --</option>
                                    <?php while ($sem = mysqli_fetch_assoc($semesters)): ?>
                                        <option value="<?= $sem['id'] ?>" <?= $semester_id == $sem['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($sem['semester_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Department</label>
                                <select name="department_id" class="form-select">
                                    <option value="">-- All Departments --</option>
                                    <?php while ($dept = mysqli_fetch_assoc($departments)): ?>
                                        <option value="<?= $dept['id'] ?>" <?= $department_id == $dept['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($dept['department_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                        <?php if (!empty($session_id) || !empty($semester_id) || !empty($department_id)): ?>
                            <div class="mt-2">
                                <a href="/versity_management_DBMS/registrations/index.php" class="btn btn-sm btn-outline-secondary">Clear Filters</a>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <!-- Result Table -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Department</th>
                            <th>Semester</th>
                            <th>Session</th>
                            <th>Registration Date</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $sl = 1; ?>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $sl++ ?></td>
                                    <td><?= htmlspecialchars($row['student_name'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($row['course_name'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($row['department_name'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($row['semester_name'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($row['session_name'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($row['registration_date']) ?></td>
                                    <td>
                                        <?php if ($row['status'] == 1): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-3">No records found for the selected filters.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>