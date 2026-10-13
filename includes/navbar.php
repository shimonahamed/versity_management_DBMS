<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
$isPath = static fn(string $segment): bool => str_contains($currentPath, '/versity_management_DBMS/' . $segment . '/');
$academicOpen = $isPath('courses') || $isPath('sessions') || $isPath('semesters') || $isPath('departments');
$studentOpen = $isPath('students') || $isPath('registrations');
$employeeOpen = $isPath('employees') || $isPath('employee_departments') || $isPath('designations');
$reportOpen = $isPath('reports');
?>
<div class="sidebar">
    <div class="sidebar-header">
        <img src="/versity_management_DBMS/assets/images/northern-university-logo.png" alt="Northern University logo" class="sidebar-logo">
    </div>

    <ul class="sidebar-menu">
        <li><a href="/versity_management_DBMS/" class="<?= $currentPath === '/versity_management_DBMS/' || str_ends_with($currentPath, '/versity_management_DBMS/index.php') ? 'active' : '' ?>"><i class="fas fa-home"></i><span>Dashboard</span></a></li>

        <li><a href="/versity_management_DBMS/users/index.php" class="<?= $isPath('users') ? 'active' : '' ?>"><i class="fas fa-user-shield"></i><span>User</span></a></li>

        <li class="sidebar-group">
            <a href="#academicMenu" class="menu-toggle <?= $academicOpen ? 'active' : 'collapsed' ?>" data-bs-toggle="collapse" role="button" aria-expanded="<?= $academicOpen ? 'true' : 'false' ?>" aria-controls="academicMenu"><i class="fas fa-university"></i><span>Academic</span><i class="fas fa-chevron-down submenu-arrow"></i></a>
            <ul class="collapse sidebar-submenu <?= $academicOpen ? 'show' : '' ?>" id="academicMenu">
                <li><a href="/versity_management_DBMS/courses/index.php" class="<?= $isPath('courses') ? 'active' : '' ?>"><i class="fas fa-book"></i><span>Courses</span></a></li>
                <li><a href="/versity_management_DBMS/sessions/index.php" class="<?= $isPath('sessions') ? 'active' : '' ?>"><i class="fas fa-clock"></i><span>Sessions</span></a></li>
                <li><a href="/versity_management_DBMS/semesters/index.php" class="<?= $isPath('semesters') ? 'active' : '' ?>"><i class="fas fa-calendar-alt"></i><span>Semesters</span></a></li>
                <li><a href="/versity_management_DBMS/departments/index.php" class="<?= $isPath('departments') ? 'active' : '' ?>"><i class="fas fa-building"></i><span>Departments</span></a></li>
            </ul>
        </li>

        <li class="sidebar-group">
            <a href="#studentMenu" class="menu-toggle <?= $studentOpen ? 'active' : 'collapsed' ?>" data-bs-toggle="collapse" role="button" aria-expanded="<?= $studentOpen ? 'true' : 'false' ?>" aria-controls="studentMenu"><i class="fas fa-user-graduate"></i><span>Student</span><i class="fas fa-chevron-down submenu-arrow"></i></a>
            <ul class="collapse sidebar-submenu <?= $studentOpen ? 'show' : '' ?>" id="studentMenu">
                <li><a href="/versity_management_DBMS/students/index.php" class="<?= $isPath('students') ? 'active' : '' ?>"><i class="fas fa-users"></i><span>Students</span></a></li>
                <li><a href="/versity_management_DBMS/registrations/index.php" class="<?= $isPath('registrations') ? 'active' : '' ?>"><i class="fas fa-clipboard-list"></i><span>Registrations</span></a></li>
            </ul>
        </li>

        <li class="sidebar-group">
            <a href="#employeeMenu" class="menu-toggle <?= $employeeOpen ? 'active' : 'collapsed' ?>" data-bs-toggle="collapse" role="button" aria-expanded="<?= $employeeOpen ? 'true' : 'false' ?>" aria-controls="employeeMenu"><i class="fas fa-user-tie"></i><span>Employee</span><i class="fas fa-chevron-down submenu-arrow"></i></a>
            <ul class="collapse sidebar-submenu <?= $employeeOpen ? 'show' : '' ?>" id="employeeMenu">
                <li><a href="/versity_management_DBMS/employee_departments/index.php" class="<?= $isPath('employee_departments') ? 'active' : '' ?>"><i class="fas fa-sitemap"></i><span>Departments</span></a></li>
                <li><a href="/versity_management_DBMS/designations/index.php" class="<?= $isPath('designations') ? 'active' : '' ?>"><i class="fas fa-id-badge"></i><span>Designations</span></a></li>
                <li><a href="/versity_management_DBMS/employees/index.php" class="<?= $isPath('employees') ? 'active' : '' ?>"><i class="fas fa-users-cog"></i><span>Employees</span></a></li>
            </ul>
        </li>

        <li class="sidebar-group">
            <a href="#reportMenu" class="menu-toggle <?= $reportOpen ? 'active' : 'collapsed' ?>" data-bs-toggle="collapse" role="button" aria-expanded="<?= $reportOpen ? 'true' : 'false' ?>" aria-controls="reportMenu"><i class="fas fa-chart-bar"></i><span>Report</span><i class="fas fa-chevron-down submenu-arrow"></i></a>
            <ul class="collapse sidebar-submenu <?= $reportOpen ? 'show' : '' ?>" id="reportMenu">
                <li><a href="/versity_management_DBMS/reports/registration_report.php" class="<?= str_contains($currentPath, 'registration_report.php') ? 'active' : '' ?>"><i class="fas fa-clipboard-check"></i><span>Registration Report</span></a></li>
                <li><a href="/versity_management_DBMS/reports/student_report.php" class="<?= str_contains($currentPath, 'student_report.php') ? 'active' : '' ?>"><i class="fas fa-user-graduate"></i><span>Student Report</span></a></li>
                <li><a href="/versity_management_DBMS/reports/employee_report.php" class="<?= str_contains($currentPath, 'employee_report.php') ? 'active' : '' ?>"><i class="fas fa-user-tie"></i><span>Employee Report</span></a></li>
            </ul>
        </li>
    </ul>
</div>