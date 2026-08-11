<?php
require_once "../config/database.php";

$query = "SELECT * FROM department ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Department List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Department List</h2>
        <a href="create.php" class="btn btn-primary">+ Add New Department</a>
    </div>

    <?php if (isset($_GET['status'])): ?>
        <div id="status-alert" class="alert alert-success alert-dismissible fade show">
            <?php
            if ($_GET['status'] == 'created') echo "Department added successfully!";
            if ($_GET['status'] == 'updated') echo "Department updated successfully!";
            if ($_GET['status'] == 'deleted') echo "Department deleted successfully!";
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
                    <th>Name</th>
                    <th>Code</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $sl = 1;
                ?>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $sl++ ?></td>
                            <td><?= htmlspecialchars($row['department_name']) ?></td>
                            <td><?= htmlspecialchars($row['department_code']) ?></td>
                            <td><?= htmlspecialchars($row['slug']) ?></td>
                            <td>
                                <?php if ($row['status'] == 1): ?>
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
                        <td colspan="6" class="text-center py-3">No departments found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    setTimeout(function () {
        const alert = document.getElementById('status-alert');

        if (alert) {
            alert.classList.remove('show');

            setTimeout(function () {
                alert.remove();
            }, 500);
        }
    }, 3000);
</script>
</body>
</html>