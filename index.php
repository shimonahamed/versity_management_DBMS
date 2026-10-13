<?php
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
$employee_count = getTotalCount($conn, 'employees');
$employee_department_count = getTotalCount($conn, 'employee_departments');
$designation_count = getTotalCount($conn, 'employee_designations');

$employee_status_counts = [0 => 0, 1 => 0, 2 => 0, 3 => 0];
$status_result = mysqli_query($conn, 'SELECT status, COUNT(*) total FROM employees GROUP BY status');
while ($status_result && $row = mysqli_fetch_assoc($status_result)) {
    $employee_status_counts[(int) $row['status']] = (int) $row['total'];
}
$active_end = $employee_count ? round(($employee_status_counts[1] / $employee_count) * 360, 2) : 0;
$inactive_end = $active_end + ($employee_count ? round(($employee_status_counts[0] / $employee_count) * 360, 2) : 0);
$resigned_end = $inactive_end + ($employee_count ? round(($employee_status_counts[2] / $employee_count) * 360, 2) : 0);

$employee_departments = [];
$department_result = mysqli_query($conn, 'SELECT d.name, COUNT(e.id) total FROM employee_departments d LEFT JOIN employees e ON e.department_id=d.id GROUP BY d.id,d.name ORDER BY total DESC,d.name LIMIT 7');
while ($department_result && $row = mysqli_fetch_assoc($department_result)) $employee_departments[] = $row;
$max_department_employees = max(1, ...array_map(static fn(array $row): int => (int) $row['total'], $employee_departments));

$record_chart = ['Students'=>$student_count, 'Employees'=>$employee_count, 'Courses'=>$course_count, 'Registrations'=>$registration_count];
$max_record_count = max(1, ...array_values($record_chart));

?>
<div class="main-content dashboard-main">
    <div class="container-fluid dashboard-overview">
        <section class="dashboard-hero">
            <div>
                <span class="dashboard-eyebrow"><i class="fas fa-circle"></i> Live database overview</span>
                <h1>Welcome back, <?= htmlspecialchars($_SESSION['username'] ?? 'Administrator') ?></h1>
                <p>Manage your university records from one organized dashboard.</p>
            </div>
            <div class="dashboard-hero-icon"><i class="fas fa-graduation-cap"></i></div>
        </section>

        <div class="dashboard-section-heading">
            <div>
                <h2>University at a glance</h2>
                <p>Current records across all modules</p>
            </div>
            <span><i class="far fa-calendar-alt"></i> <?= date('d M, Y') ?></span>
        </div>

        <div class="row g-4">
            <div class="col-sm-6 col-xl-4"><a href="employees/index.php" class="overview-card students-card"><span class="overview-icon"><i class="fas fa-users"></i></span><span class="overview-content"><small>Total Employees</small><strong><?= $employee_count ?></strong><em>View employees <i class="fas fa-arrow-right"></i></em></span></a></div>
            <div class="col-sm-6 col-xl-4"><a href="employee_departments/index.php" class="overview-card departments-card"><span class="overview-icon"><i class="fas fa-sitemap"></i></span><span class="overview-content"><small>Employee Departments</small><strong><?= $employee_department_count ?></strong><em>View employee departments <i class="fas fa-arrow-right"></i></em></span></a></div>
            <div class="col-sm-6 col-xl-4"><a href="designations/index.php" class="overview-card courses-card"><span class="overview-icon"><i class="fas fa-id-badge"></i></span><span class="overview-content"><small>Designations</small><strong><?= $designation_count ?></strong><em>View designations <i class="fas fa-arrow-right"></i></em></span></a></div>
            <div class="col-sm-6 col-xl-4"><a href="students/index.php" class="overview-card students-card"><span class="overview-icon"><i class="fas fa-user-graduate"></i></span><span class="overview-content"><small>Total Students</small><strong><?= $student_count ?></strong><em>View students <i class="fas fa-arrow-right"></i></em></span></a></div>
            <div class="col-sm-6 col-xl-4"><a href="departments/index.php" class="overview-card departments-card"><span class="overview-icon"><i class="fas fa-building"></i></span><span class="overview-content"><small>Departments</small><strong><?= $department_count ?></strong><em>View departments <i class="fas fa-arrow-right"></i></em></span></a></div>
            <div class="col-sm-6 col-xl-4"><a href="courses/index.php" class="overview-card courses-card"><span class="overview-icon"><i class="fas fa-book-open"></i></span><span class="overview-content"><small>Total Courses</small><strong><?= $course_count ?></strong><em>View courses <i class="fas fa-arrow-right"></i></em></span></a></div>
            <div class="col-sm-6 col-xl-4"><a href="registrations/index.php" class="overview-card registrations-card"><span class="overview-icon"><i class="fas fa-clipboard-check"></i></span><span class="overview-content"><small>Registrations</small><strong><?= $registration_count ?></strong><em>View registrations <i class="fas fa-arrow-right"></i></em></span></a></div>
            <div class="col-sm-6 col-xl-4"><a href="semesters/index.php" class="overview-card semesters-card"><span class="overview-icon"><i class="fas fa-calendar-alt"></i></span><span class="overview-content"><small>Semesters</small><strong><?= $semester_count ?></strong><em>View semesters <i class="fas fa-arrow-right"></i></em></span></a></div>
            <div class="col-sm-6 col-xl-4"><a href="sessions/index.php" class="overview-card sessions-card"><span class="overview-icon"><i class="fas fa-clock"></i></span><span class="overview-content"><small>Academic Sessions</small><strong><?= $session_count ?></strong><em>View sessions <i class="fas fa-arrow-right"></i></em></span></a></div>
        </div>

        <div class="dashboard-section-heading">
            <div><h2>Data insights</h2><p>Live charts generated from current database records</p></div>
        </div>

        <div class="row g-3 dashboard-charts">
            <div class="col-lg-4"><div class="dashboard-chart-card h-100"><div class="chart-card-heading"><div><h3>Employee Status</h3><p>Current workforce distribution</p></div><i class="fas fa-chart-pie"></i></div><div class="status-chart-wrap"><div class="status-donut" style="background: conic-gradient(#20a66a 0deg <?= $active_end ?>deg,#94a3b8 <?= $active_end ?>deg <?= $inactive_end ?>deg,#f0a329 <?= $inactive_end ?>deg <?= $resigned_end ?>deg,#dc4b5f <?= $resigned_end ?>deg 360deg)"><div><strong><?= $employee_count ?></strong><span>Total</span></div></div><div class="chart-legend"><?php foreach([[1,'Active','legend-green'],[0,'Inactive','legend-gray'],[2,'Resigned','legend-yellow'],[3,'Terminated','legend-red']] as [$key,$label,$class]):?><span><i class="<?=$class?>"></i><?=$label?><strong><?=$employee_status_counts[$key]?></strong></span><?php endforeach;?></div></div></div></div>

            <div class="col-lg-4"><div class="dashboard-chart-card h-100"><div class="chart-card-heading"><div><h3>Employees by Department</h3><p>Top department distribution</p></div><i class="fas fa-chart-bar"></i></div><div class="bar-chart"><?php if($employee_departments):foreach($employee_departments as $row):$width=((int)$row['total']/$max_department_employees)*100;?><div class="bar-row"><div><span><?=htmlspecialchars($row['name'])?></span><strong><?=(int)$row['total']?></strong></div><div class="bar-track"><span style="width:<?=$width?>%"></span></div></div><?php endforeach;else:?><div class="chart-empty">No department data available.</div><?php endif;?></div></div></div>

            <div class="col-lg-4"><div class="dashboard-chart-card h-100"><div class="chart-card-heading"><div><h3>Records Overview</h3><p>Key module comparison</p></div><i class="fas fa-chart-line"></i></div><div class="record-chart"><?php $colors=['#3478db','#7c5cdb','#18a474','#e38a31'];$colorIndex=0;foreach($record_chart as $label=>$value):?><div class="record-bar"><span><?=$label?></span><div class="bar-track"><i style="width:<?=($value/$max_record_count)*100?>%;background:<?=$colors[$colorIndex++]?>"></i></div><strong><?=$value?></strong></div><?php endforeach;?></div></div></div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
