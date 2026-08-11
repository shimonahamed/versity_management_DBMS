<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>University Management System</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet"
          href="/university_management/css/style.css">
</head>

<body>
<header class="main-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between">

            <!-- Logo / Brand -->
            <div class="d-flex align-items-center">
                <button class="btn sidebar-toggle me-3" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>

                <a href="/university_management/" class="brand">
                    <div class="brand-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>

                    <div>
                        <h5 class="mb-0">University Management</h5>
                        <small>Management System</small>
                    </div>
                </a>
            </div>

            <!-- Right Side -->
            <div class="d-flex align-items-center gap-3">

                <!-- Notification -->
                <button class="header-icon-btn position-relative">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </button>

                <!-- User -->
                <div class="dropdown">
                    <button
                        class="btn user-dropdown d-flex align-items-center"
                        data-bs-toggle="dropdown">

                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>

                        <div class="user-info text-start ms-2 d-none d-md-block">
                            <strong>Super Admin</strong>
                            <small>Administrator</small>
                        </div>

                        <i class="fas fa-chevron-down ms-3"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user me-2"></i>
                                Profile
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog me-2"></i>
                                Settings
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item text-danger" href="#">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</header>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById('sidebarToggle').addEventListener('click', function () {
        document.body.classList.toggle('sidebar-collapsed');
    });
</script>