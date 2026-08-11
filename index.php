<?php
session_start();
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

$page = $_GET['page'] ?? 'home';
$file = "pages/{$page}.php";

if (file_exists($file)) {
    require_once $file;
} else {
    http_response_code(404);
    require_once "404.php";
}
?>
    <div class="main-content">
        <div class="container-fluid">

            <div class="page-header mb-4">
                <h2>Dashboard</h2>
                <p class="text-muted">Welcome to University Management System</p>
            </div>

            <div class="row g-4">

                <div class="col-md-3">
                    <div class="dashboard-card">
                        <h5>Students</h5>
                        <h2>0</h2>
                        <a href="students/index.php">View Students</a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="dashboard-card">
                        <h5>Departments</h5>
                        <h2>0</h2>
                        <a href="departments/index.php">View Departments</a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="dashboard-card">
                        <h5>Courses</h5>
                        <h2>0</h2>
                        <a href="courses/index.php">View Courses</a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="dashboard-card">
                        <h5>Registrations</h5>
                        <h2>0</h2>
                        <a href="registrations/index.php">View Registrations</a>
                    </div>
                </div>

            </div>

        </div>
    </div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>