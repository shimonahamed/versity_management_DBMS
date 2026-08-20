<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

function getTotalCount(mysqli $conn, string $table): int
{
    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM {$table}");
    $row = $result ? mysqli_fetch_assoc($result) : null;

    return (int) ($row['total'] ?? 0);
}

$student_count = getTotalCount($conn, 'students');
$department_count = getTotalCount($conn, 'department');
$course_count = getTotalCount($conn, 'course');
$semester_count = getTotalCount($conn, 'semester');
$session_count = getTotalCount($conn, 'session');
$registration_count = getTotalCount($conn, 'course_registration');

?>
<div class="main-content">
    <div class="container-fluid dashboard-overview">
        <section class="dashboard-hero">
            <div>
                <span class="dashboard-eyebrow"><i class="fas fa-circle"></i> Live database overview</span>
                <h1>Welcome back, Administrator</h1>
                <p>Manage your university records from one organized dashboard.</p>
            </div>
            <div class="dashboard-hero-icon"><i class="fas fa-graduation-cap"></i></div>
        </section>

        <div class="dashboard-section-heading">
            <div><h2>University at a glance</h2><p>Current records across all modules</p></div>
            <span><i class="far fa-calendar-alt"></i> <?= date('d M, Y') ?></span>
        </div>

        <div class="row g-4">
            <div class="col-sm-6 col-xl-4"><a href="students/index.php" class="overview-card students-card"><span class="overview-icon"><i class="fas fa-user-graduate"></i></span><span class="overview-content"><small>Total Students</small><strong><?= $student_count ?></strong><em>View students <i class="fas fa-arrow-right"></i></em></span></a></div>
            <div class="col-sm-6 col-xl-4"><a href="departments/index.php" class="overview-card departments-card"><span class="overview-icon"><i class="fas fa-building"></i></span><span class="overview-content"><small>Departments</small><strong><?= $department_count ?></strong><em>View departments <i class="fas fa-arrow-right"></i></em></span></a></div>
            <div class="col-sm-6 col-xl-4"><a href="courses/index.php" class="overview-card courses-card"><span class="overview-icon"><i class="fas fa-book-open"></i></span><span class="overview-content"><small>Total Courses</small><strong><?= $course_count ?></strong><em>View courses <i class="fas fa-arrow-right"></i></em></span></a></div>
            <div class="col-sm-6 col-xl-4"><a href="registrations/index.php" class="overview-card registrations-card"><span class="overview-icon"><i class="fas fa-clipboard-check"></i></span><span class="overview-content"><small>Registrations</small><strong><?= $registration_count ?></strong><em>View registrations <i class="fas fa-arrow-right"></i></em></span></a></div>
            <div class="col-sm-6 col-xl-4"><a href="semesters/index.php" class="overview-card semesters-card"><span class="overview-icon"><i class="fas fa-calendar-alt"></i></span><span class="overview-content"><small>Semesters</small><strong><?= $semester_count ?></strong><em>View semesters <i class="fas fa-arrow-right"></i></em></span></a></div>
            <div class="col-sm-6 col-xl-4"><a href="sessions/index.php" class="overview-card sessions-card"><span class="overview-icon"><i class="fas fa-clock"></i></span><span class="overview-content"><small>Academic Sessions</small><strong><?= $session_count ?></strong><em>View sessions <i class="fas fa-arrow-right"></i></em></span></a></div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
