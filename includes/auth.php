<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    ]);
    session_start();
}

if (empty($_SESSION['user_id'])) {
    $next = $_SERVER['REQUEST_URI'] ?? '/versity_management_DBMS/';
    header('Location: /versity_management_DBMS/login.php?next=' . urlencode($next));
    exit;
}

if (isset($conn) && $conn instanceof mysqli) {
    $authUserId = (int) $_SESSION['user_id'];
    $authStmt = mysqli_prepare($conn, 'SELECT username, email FROM users WHERE id = ? AND status = 1 LIMIT 1');
    mysqli_stmt_bind_param($authStmt, 'i', $authUserId);
    mysqli_stmt_execute($authStmt);
    $authUser = mysqli_fetch_assoc(mysqli_stmt_get_result($authStmt));
    mysqli_stmt_close($authStmt);
    if (!$authUser) {
        $_SESSION = [];
        session_destroy();
        header('Location: /versity_management_DBMS/login.php?account_inactive=1');
        exit;
    }
    $_SESSION['username'] = $authUser['username'];
    $_SESSION['user_email'] = $authUser['email'];
}
