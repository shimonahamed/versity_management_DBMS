<?php
require_once "../config/database.php";

$query = "SELECT * FROM semester ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Semester List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Semester List</h2>
        <a href="create.php" class="btn btn-primary">+ Add New Semester</a>
    </div>

    <?php if (isset($_GET['status'])): ?>
        <div id="status-alert" class="alert alert-success alert-dismissible fade show">
            <?php
            if ($_GET['status'] === 'created') echo "Semester added successfully!";
            if ($_GET['status'] === 'updated') echo "Semester updated successfully!";
            if ($_GET['status'] === 'deleted') echo "Semester deleted successfully!";
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Semester Name</th>
                        <th>Semester Code</th>
                        <th>Semester Number</th>
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
                                <td><?= htmlspecialchars($row['semester_name']) ?></td>
                                <td><?= htmlspecialchars($row['semester_code']) ?></td>
                                <td><?= (int)$row['semester_number'] ?></td>
                                <td>
                                    <?php if ((int)$row['status'] === 1): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-nowrap">
                                    <a href="edit.php?id=<?= (int)$row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="delete.php?id=<?= (int)$row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-3">No semesters found.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    setTimeout(function () {
        const alertNode = document.getElementById('status-alert');
        if (alertNode) bootstrap.Alert.getOrCreateInstance(alertNode).close();
    }, 3000);
</script>
</body>
</html>
