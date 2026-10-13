<?php
require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../includes/security.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}
verify_csrf();
$id = (int) ($_POST['id'] ?? 0);
$courseStmt = mysqli_prepare($conn, 'SELECT COUNT(*) total FROM course WHERE department_id=?');
mysqli_stmt_bind_param($courseStmt, 'i', $id);
mysqli_stmt_execute($courseStmt);
$courses = (int) (mysqli_fetch_assoc(mysqli_stmt_get_result($courseStmt))['total'] ?? 0);
mysqli_stmt_close($courseStmt);
$studentStmt = mysqli_prepare($conn, 'SELECT COUNT(*) total FROM students WHERE department_id=?');
mysqli_stmt_bind_param($studentStmt, 'i', $id);
mysqli_stmt_execute($studentStmt);
$students = (int) (mysqli_fetch_assoc(mysqli_stmt_get_result($studentStmt))['total'] ?? 0);
mysqli_stmt_close($studentStmt);
if ($courses || $students) {
    flash('danger', "Department cannot be deleted: it has $courses course(s) and $students student(s).");
    header('Location: index.php');
    exit;
}
$stmt = mysqli_prepare($conn, 'DELETE FROM department WHERE id=?');
mysqli_stmt_bind_param($stmt, 'i', $id);
try {
    $ok = mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0;
    flash($ok ? 'success' : 'danger', $ok ? 'Department deleted successfully.' : 'Department not found.');
} catch (mysqli_sql_exception $e) {
    flash('danger', 'Department could not be deleted because another record depends on it.');
}
mysqli_stmt_close($stmt);
header('Location: index.php');
exit;
