<?php
require_once '../config/database.php';
require_once __DIR__ . '/../includes/auth.php';

$departmentId = filter_input(INPUT_GET, 'department_id', FILTER_VALIDATE_INT) ?: 0;
$designationId = filter_input(INPUT_GET, 'designation_id', FILTER_VALIDATE_INT) ?: 0;
$departments = mysqli_query($conn, 'SELECT id, name FROM employee_departments ORDER BY name');
$designations = mysqli_query($conn, 'SELECT id, name FROM employee_designations ORDER BY name');
$filtered = $departmentId > 0 || $designationId > 0;
$result = null;

if ($filtered) {
    $conditions = [];
    if ($departmentId > 0) $conditions[] = 'e.department_id = ' . $departmentId;
    if ($designationId > 0) $conditions[] = 'e.designation_id = ' . $designationId;
    $query = 'SELECT e.*, d.name department_name, g.name designation_name
              FROM employees e
              LEFT JOIN employee_departments d ON d.id = e.department_id
              LEFT JOIN employee_designations g ON g.id = e.designation_id
              WHERE ' . implode(' AND ', $conditions) . '
              ORDER BY e.name';
    $result = mysqli_query($conn, $query);
}

$statusMap = [0 => ['Inactive', 'secondary'], 1 => ['Active', 'success'], 2 => ['Resigned', 'warning'], 3 => ['Terminated', 'danger']];
$typeMap = [1 => 'Teacher', 2 => 'Staff', 3 => 'Support Staff'];
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
?>
<div class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Employee Report</h2>
            <a href="/versity_management_DBMS/employees/index.php" class="btn btn-secondary">Back to List</a>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="get">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4"><label class="form-label">Department</label><select name="department_id" class="form-select">
                                <option value="">-- All Departments --</option><?php while ($row = mysqli_fetch_assoc($departments)): ?><option value="<?= $row['id'] ?>" <?= $departmentId === (int)$row['id'] ? 'selected' : '' ?>><?= htmlspecialchars($row['name']) ?></option><?php endwhile; ?>
                            </select></div>
                        <div class="col-md-4"><label class="form-label">Designation</label><select name="designation_id" class="form-select">
                                <option value="">-- All Designations --</option><?php while ($row = mysqli_fetch_assoc($designations)): ?><option value="<?= $row['id'] ?>" <?= $designationId === (int)$row['id'] ? 'selected' : '' ?>><?= htmlspecialchars($row['name']) ?></option><?php endwhile; ?>
                            </select></div>
                        <div class="col-md-4"><button type="submit" class="btn btn-primary w-100">Search</button></div>
                    </div>
                    <?php if ($filtered): ?><div class="mt-2"><a href="employee_report.php" class="btn btn-sm btn-outline-secondary">Clear Filters</a></div><?php endif; ?>
                </form>
            </div>
        </div>

        <?php if ($filtered): ?>
            <div class="card shadow-sm">
                <div class="card-body p-0 table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Employee ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Type</th>
                                <th>Joining Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody><?php $i = 1;
                                if ($result && mysqli_num_rows($result) > 0): while ($row = mysqli_fetch_assoc($result)): $status = $statusMap[(int)$row['status']] ?? ['Unknown', 'dark']; ?><tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= htmlspecialchars($row['employee_id'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                        <td><?= htmlspecialchars($row['email'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['phone'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['department_name'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($row['designation_name'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($typeMap[(int)$row['employee_type']] ?? 'Unknown') ?></td>
                                        <td><?= htmlspecialchars($row['joining_date'] ?? '-') ?></td>
                                        <td><span class="badge bg-<?= $status[1] ?>"><?= $status[0] ?></span></td>
                                    </tr><?php endwhile;
                                    else: ?><tr>
                                    <td colspan="10" class="text-center py-3">No employees found for the selected filters.</td>
                                </tr><?php endif; ?></tbody>
                    </table>
                </div>
            </div>
        <?php else: ?><div class="alert alert-info">Please select at least one filter (Department or Designation) to view the report.</div><?php endif; ?>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>