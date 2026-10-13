<?php

declare(strict_types=1);
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/security.php';
if (!empty($_SESSION['user_id'])) {
    header('Location: /versity_management_DBMS/');
    exit;
}
$error = '';
$identity = '';
$next = $_GET['next'] ?? $_POST['next'] ?? '/versity_management_DBMS/';
if (!is_string($next) || !str_starts_with($next, '/versity_management_DBMS/')) $next = '/versity_management_DBMS/';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $identity = trim((string)($_POST['identity'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    if ($identity === '' || $password === '') {
        $error = 'Email and password are required.';
    } elseif (!filter_var($identity, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $stmt = mysqli_prepare($conn, 'SELECT id,username,email,status FROM users WHERE email=? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 's', $identity);
        mysqli_stmt_execute($stmt);
        $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        mysqli_stmt_close($stmt);
        if (!$user || (int)$user['status'] !== 1) {
            $error = 'The email is incorrect, or the account is inactive.';
        } else {
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int)$user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_email'] = $user['email'];
            unset($_SESSION['csrf_token']);
            header('Location: ' . $next);
            exit;
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login | Northern University Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="/versity_management_DBMS/css/style.css">
</head>

<body class="login-page">
    <div class="login-overlay"></div>
    <main class="portal-login-card">
        <div class="portal-logo"><img src="/versity_management_DBMS/assets/images/northern-university-logo.png" alt="Northern University"></div>
        <div class="portal-welcome">
            <h1>Hello NUBIAN,</h1>
            <p>Please Login to Your Account!</p>
        </div>
        <?php if (isset($_GET['logged_out'])): ?><div class="alert alert-success py-2">You have been signed out securely.</div><?php endif; ?>
        <?php if (isset($_GET['account_inactive'])): ?><div class="alert alert-warning py-2">Your account is unavailable or inactive.</div><?php endif; ?>
        <?php if ($error !== ''): ?><div class="alert alert-danger py-2" role="alert"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form class="portal-login-form" method="post" action="login.php" novalidate><?= csrf_field() ?><input type="hidden" name="next" value="<?= htmlspecialchars($next) ?>">
            <div class="portal-field"><i class="far fa-envelope"></i><input type="email" id="identity" name="identity" value="<?= htmlspecialchars($identity) ?>" autocomplete="email" placeholder="Email Address" aria-label="Email address" required autofocus></div>
            <div class="portal-field"><i class="fas fa-lock"></i><input type="password" id="password" name="password" autocomplete="current-password" placeholder="Password" aria-label="Password" required><button type="button" id="passwordToggle" aria-label="Show password"><i class="far fa-eye"></i></button></div>
            <button class="portal-login-button" type="submit">LOGIN</button>
        </form>
        <p class="portal-security"><i class="fas fa-shield-alt"></i> Secure University Management Portal</p>
        <p class="portal-credit">Northern University Bangladesh</p>
    </main>
    <script>
        document.getElementById('passwordToggle').addEventListener('click', function() {
            const input = document.getElementById('password');
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            this.innerHTML = show ? '<i class="far fa-eye-slash"></i>' : '<i class="far fa-eye"></i>';
            this.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
        });
    </script>
</body>

</html>