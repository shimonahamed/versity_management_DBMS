<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/security.php';
$result = mysqli_query($conn, 'SELECT e.*,d.name department_name,g.name designation_name FROM employees e LEFT JOIN employee_departments d ON d.id=e.department_id LEFT JOIN employee_designations g ON g.id=e.designation_id ORDER BY e.sort_order,e.id DESC');
$notice = pull_flash();
$statusLabels = [0 => ['Inactive', 'secondary'], 1 => ['Active', 'success'], 2 => ['Resigned', 'warning'], 3 => ['Terminated', 'danger']];
require_once '../includes/header.php';
require_once '../includes/navbar.php'; ?>
<div class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Employee List</h2><a class="btn btn-primary" href="create.php">+ Add Employee</a>
        </div><?php if ($notice): ?><div class="alert alert-<?= htmlspecialchars($notice['type']) ?> alert-dismissible fade show"><?= htmlspecialchars($notice['message']) ?><button class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?><div class="card shadow-sm">
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody><?php $i = 1;
                            if ($result && mysqli_num_rows($result)): while ($row = mysqli_fetch_assoc($result)): $s = $statusLabels[(int)$row['status']] ?? ['Unknown', 'dark']; ?><tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['employee_id'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= htmlspecialchars($row['email'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($row['department_name'] ?? 'Not assigned') ?></td>
                                    <td><?= htmlspecialchars($row['designation_name'] ?? 'Not assigned') ?></td>
                                    <td><span class="badge bg-<?= $s[1] ?>"><?= $s[0] ?></span></td>
                                    <td class="text-nowrap"><a class="btn btn-sm btn-info text-white" href="view.php?id=<?= $row['id'] ?>">View</a> <a class="btn btn-sm btn-warning" href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                                        <form class="d-inline" method="post" action="delete.php" onsubmit="return confirm('Delete this employee permanently?')"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $row['id'] ?>"><button class="btn btn-sm btn-danger">Delete</button></form>
                                    </td>
                                </tr><?php endwhile;
                                else: ?><tr>
                                <td colspan="8" class="text-center py-4">No employees found.</td>
                            </tr><?php endif; ?></tbody>
                </table>
            </div>
        </div>
    </div>
</div><?php require_once '../includes/footer.php'; ?>