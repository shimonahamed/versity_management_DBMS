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
$stmt = mysqli_prepare($conn, 'DELETE FROM employees WHERE id=?');
mysqli_stmt_bind_param($stmt, 'i', $id);
try {
    $ok = mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0;
    flash($ok ? 'success' : 'danger', $ok ? 'Employee deleted successfully.' : 'Employee not found.');
} catch (mysqli_sql_exception $e) {
    flash('danger', 'Employee could not be deleted because another record depends on it.');
}
mysqli_stmt_close($stmt);
header('Location: index.php');
exit;
