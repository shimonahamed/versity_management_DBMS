<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/security.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}
verify_csrf();
$id = (int)($_POST['id'] ?? 0);
if ($id === (int)$_SESSION['user_id']) {
    flash('danger', 'You cannot delete your own signed-in account.');
    header('Location: index.php');
    exit;
}
$check = mysqli_prepare($conn, 'SELECT COUNT(*) total FROM employees WHERE user_id=?');
mysqli_stmt_bind_param($check, 'i', $id);
mysqli_stmt_execute($check);
$linked = (int)(mysqli_fetch_assoc(mysqli_stmt_get_result($check))['total'] ?? 0);
mysqli_stmt_close($check);
if ($linked) {
    flash('danger', 'This user cannot be deleted because an employee record is linked to it.');
    header('Location: index.php');
    exit;
}
$stmt = mysqli_prepare($conn, 'DELETE FROM users WHERE id=?');
mysqli_stmt_bind_param($stmt, 'i', $id);
try {
    $ok = mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0;
    flash($ok ? 'success' : 'danger', $ok ? 'User deleted successfully.' : 'User not found.');
} catch (mysqli_sql_exception $e) {
    flash('danger', 'User could not be deleted because another record depends on it.');
}
mysqli_stmt_close($stmt);
header('Location: index.php');
exit;
