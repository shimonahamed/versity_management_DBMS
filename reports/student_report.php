<?php
require_once "../config/database.php";
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';

// Filter values from GET
$session_id    = $_GET['session_id']    ?? '';
$department_id = $_GET['department_id'] ?? '';

// Dropdown data
$sessions    = mysqli_query($conn, "SELECT id, session_name FROM session ORDER BY id DESC");
$departments = mysqli_query($conn, "SELECT id, department_name FROM department ORDER BY department_name ASC");

$result = null;
$filtered = !empty($session_id) || !empty($department_id);

if ($filtered) {
    $query = "SELECT s.*, 
                     d.department_name,
                     ses.session_name
              FROM students s
              LEFT JOIN department d ON s.department_id = d.id
              LEFT JOIN session ses ON s.session_id = ses.id
              WHERE 1=1";

    if (!empty($session_id)) {
        $query .= " AND s.session_id = " . intval($session_id);
    }
    if (!empty($department_id)) {
        $query .= " AND s.department_id = " . intval($department_id);
    }

    $query .= " ORDER BY s.student_name ASC";

    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("SQL Error: " . mysqli_error($conn));
    }
}

// Status label + badge color map
$statusMap = [
    1 => ['label' => 'Active',   'class' => 'bg-success'],
    2 => ['label' => 'Inactive', 'class' => 'bg-secondary'],
    3 => ['label' => 'Passout',  'class' => 'bg-primary'],
    4 => ['label' => 'Dropout',  'class' => 'bg-danger'],
];
?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Student Report</h2>
                <a href="/versity_management_DBMS/students/index.php" class="btn btn-secondary">Back to List</a>
            </div>

            <!-- Filter Form -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
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
                            <div class="col-md-4">
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
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">Search</button>
                            </div>
                        </div>
                        <?php if ($filtered): ?>
                            <div class="mt-2">
                                <a href="/versity_management_DBMS/students/index.php" class="btn btn-sm btn-outline-secondary">Clear Filters</a>
                            </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <?php if ($filtered): ?>
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Department</th>
                                <th>Session</th>
                                <th>Admission Date</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sl = 1; ?>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <?php $st = $statusMap[$row['status']] ?? ['label' => 'Unknown', 'class' => 'bg-dark']; ?>
                                    <tr>
                                        <td><?= $sl++ ?></td>
                                        <td><?= htmlspecialchars($row['student_name']) ?></td>
                                        <td><?= htmlspecialchars($row['student_email']) ?></td>
                                        <td><?= htmlspecialchars($row['student_phone']) ?></td>
                                        <td><?= htmlspecialchars($row['student_gender']) ?></td>
                                        <td><?= htmlspecialchars($row['department_name'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($row['session_name'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($row['admission_date']) ?></td>
                                        <td><span class="badge <?= $st['class'] ?>"><?= $st['label'] ?></span></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center py-3">No students found for the selected filters.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">Please select at least one filter (Session or Department) to view the report.</div>
            <?php endif; ?>
        </div>
    </div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>