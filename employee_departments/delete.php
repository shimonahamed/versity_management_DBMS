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
$check = mysqli_prepare($conn, 'SELECT COUNT(*) total FROM employees WHERE department_id=?');
mysqli_stmt_bind_param($check, 'i', $id);
mysqli_stmt_execute($check);
$total = (int)(mysqli_fetch_assoc(mysqli_stmt_get_result($check))['total'] ?? 0);
mysqli_stmt_close($check);
if ($total > 0) {
    flash('danger', 'This department cannot be deleted because employees are assigned to it.');
    header('Location: index.php');
    exit;
}
$stmt = mysqli_prepare($conn, 'DELETE FROM employee_departments WHERE id=?');
mysqli_stmt_bind_param($stmt, 'i', $id);
try {
    $ok = mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0;
    flash($ok ? 'success' : 'danger', $ok ? 'Department deleted successfully.' : 'Department not found.');
} catch (mysqli_sql_exception $e) {
    flash('danger', 'This department could not be deleted because it is in use.');
}
mysqli_stmt_close($stmt);
header('Location: index.php');
exit;
