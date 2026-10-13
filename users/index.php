<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/security.php';
$result = mysqli_query($conn, 'SELECT u.*,(SELECT COUNT(*) FROM employees e WHERE e.user_id=u.id) employee_count FROM users u ORDER BY u.id DESC');
$notice = pull_flash();
require_once '../includes/header.php';
require_once '../includes/navbar.php'; ?>
<div class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">User List</h2>
                <p class="text-muted mb-0">Manage system login accounts</p>
            </div><a class="btn btn-primary" href="create.php">+ Add User</a>
        </div><?php if ($notice): ?><div class="alert alert-<?= htmlspecialchars($notice['type']) ?> alert-dismissible fade show"><?= htmlspecialchars($notice['message']) ?><button class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?><div class="card shadow-sm">
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Employee Link</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody><?php $i = 1;
                            if ($result && mysqli_num_rows($result)): while ($row = mysqli_fetch_assoc($result)): ?><tr>
                                    <td><?= $i++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2"><?php if ($row['image']): ?><img class="user-list-avatar" src="<?= htmlspecialchars($row['image']) ?>" alt=""><?php else: ?><span class="user-list-avatar"><i class="fas fa-user"></i></span><?php endif; ?><strong><?= htmlspecialchars($row['username']) ?></strong><?= (int)$row['id'] === (int)$_SESSION['user_id'] ? '<span class="badge bg-primary">You</span>' : '' ?></div>
                                    </td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= htmlspecialchars($row['phone'] ?: '-') ?></td>
                                    <td><?= (int)$row['employee_count'] ?></td>
                                    <td><span class="badge bg-<?= $row['status'] == 1 ? 'success' : 'secondary' ?>"><?= $row['status'] == 1 ? 'Active' : 'Inactive' ?></span></td>
                                    <td class="text-nowrap"><a class="btn btn-sm btn-info text-white" href="view.php?id=<?= $row['id'] ?>">View</a> <a class="btn btn-sm btn-warning" href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                                        <form class="d-inline" method="post" action="delete.php" onsubmit="return confirm('Delete this user account?')"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $row['id'] ?>"><button class="btn btn-sm btn-danger" <?= (int)$row['id'] === (int)$_SESSION['user_id'] ? 'disabled' : '' ?>>Delete</button></form>
                                    </td>
                                </tr><?php endwhile;
                                else: ?><tr>
                                <td colspan="7" class="text-center py-4">No users found.</td>
                            </tr><?php endif; ?></tbody>
                </table>
            </div>
        </div>
    </div>
</div><?php require_once '../includes/footer.php'; ?>