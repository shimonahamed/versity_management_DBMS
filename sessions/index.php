<?php
require_once "../config/database.php";
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
$query = "SELECT * FROM session ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

    <div class="main-content">
        <div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Session List</h2>
        <a href="create.php" class="btn btn-primary">+ Add New Session</a>
    </div>
<?php
$sl=1
?>
    <?php if (isset($_GET['status'])): ?>
        <div id="status-alert" class="alert alert-success alert-dismissible fade show">
            <?php
            if ($_GET['status'] == 'created') echo "Session added successfully!";
            if ($_GET['status'] == 'updated') echo "Session updated successfully!";
            if ($_GET['status'] == 'deleted') echo "Session deleted successfully!";
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
                    <th>Session Name</th>
                    <th>Session Code</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $sl++ ?></td>
                            <td><?= htmlspecialchars($row['session_name']) ?></td>
                            <td><?= htmlspecialchars($row['session_code']) ?></td>
                            <td>
                                <?php if ($row['status'] == 1): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $row['created_at'] ?? 'N/A' ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-3">No sessions found.</td>
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
    if (window.history.replaceState) {
        const url = new URL(window.location.href);
        url.searchParams.delete('status');
        window.history.replaceState(null, null, url.pathname);
    }
    setTimeout(function() {
        let alertNode = document.getElementById('status-alert');
        if (alertNode) {
            let alert = bootstrap.Alert.getOrCreateInstance(alertNode);
            alert.close();
        }
    }, 5000);
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>