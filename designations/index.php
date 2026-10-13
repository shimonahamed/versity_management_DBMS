<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/security.php';
$result = mysqli_query($conn, 'SELECT d.*,(SELECT COUNT(*) FROM employees e WHERE e.designation_id=d.id) employee_count FROM employee_designations d ORDER BY d.id DESC');
$notice = pull_flash();
require_once '../includes/header.php';
require_once '../includes/navbar.php'; ?>
<div class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Designation List</h2><a class="btn btn-primary" href="create.php">+ Add Designation</a>
        </div><?php if ($notice): ?><div class="alert alert-<?= htmlspecialchars($notice['type']) ?> alert-dismissible fade show"><?= htmlspecialchars($notice['message']) ?><button class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?><div class="card shadow-sm">
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Employees</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody><?php $i = 1;
                            if ($result && mysqli_num_rows($result)): while ($row = mysqli_fetch_assoc($result)): ?><tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= (int)$row['employee_count'] ?></td>
                                    <td><span class="badge bg-<?= $row['status'] == 1 ? 'success' : 'secondary' ?>"><?= $row['status'] == 1 ? 'Active' : 'Inactive' ?></span></td>
                                    <td class="text-nowrap"><a class="btn btn-sm btn-info text-white" href="view.php?id=<?= $row['id'] ?>">View</a> <a class="btn btn-sm btn-warning" href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                                        <form class="d-inline" method="post" action="delete.php" onsubmit="return confirm('Delete this designation?')"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $row['id'] ?>"><button class="btn btn-sm btn-danger">Delete</button></form>
                                    </td>
                                </tr><?php endwhile;
                                else: ?><tr>
                                <td colspan="5" class="text-center py-4">No designations found.</td>
                            </tr><?php endif; ?></tbody>
                </table>
            </div>
        </div>
    </div>
</div><?php require_once '../includes/footer.php'; ?>