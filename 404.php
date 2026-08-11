<?php

http_response_code(404);

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

?>

    <div class="main-content">

        <div class="container-fluid">

            <div class="text-center py-5">

                <div style="font-size: 100px; font-weight: 700; color: #0d6efd;">
                    404
                </div>

                <h2 class="fw-bold mb-3">
                    Page Not Found
                </h2>

                <p class="text-muted mb-4">
                    Sorry, the page you are looking for does not exist.
                </p>

                <a href="/university_management/" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i>
                    Back to Dashboard
                </a>

            </div>

        </div>

    </div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>