<?php
require_once "../config/database.php";
require_once __DIR__ . '/../includes/auth.php';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$stmt = mysqli_prepare($conn, 'SELECT students.*, department.department_name, department.department_code, session.session_name, session.session_code FROM students LEFT JOIN department ON students.department_id = department.id LEFT JOIN session ON students.session_id = session.id WHERE students.id = ?'); mysqli_stmt_bind_param($stmt, 'i', $id); mysqli_stmt_execute($stmt); $student = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt)); mysqli_stmt_close($stmt);
if (!$student) { header('Location: index.php'); exit; }
$status_labels = [1 => ['Active', 'success'], 2 => ['Inactive', 'secondary'], 3 => ['Passout', 'info'], 4 => ['Dropout', 'danger']]; $status = $status_labels[(int) $student['status']] ?? ['Unknown', 'dark'];
require_once __DIR__ . '/../includes/header.php'; require_once __DIR__ . '/../includes/navbar.php';
?>
<div class="main-content"><div class="container-fluid"><div class="card shadow-sm"><div class="card-header bg-white d-flex justify-content-between align-items-center py-3"><h5 class="mb-0 fw-bold">Student Details</h5><a href="index.php" class="btn btn-secondary btn-sm">Back</a></div><div class="card-body p-4"><div class="row">
<?php $fields = ['Student ID' => $student['student_id'], 'Student Name' => $student['student_name'], 'Email' => $student['student_email'] ?: '-', 'Phone' => $student['student_phone'] ?: '-', 'Gender' => $student['student_gender'] ?: '-', 'Department' => ($student['department_name'] ?? 'Not available') . (!empty($student['department_code']) ? ' (' . $student['department_code'] . ')' : ''), 'Session' => ($student['session_name'] ?? 'Not available') . (!empty($student['session_code']) ? ' (' . $student['session_code'] . ')' : ''), 'Admission Date' => $student['admission_date'] ?: '-', 'Date of Birth' => $student['date_of_birth'] ?: '-', 'Address' => $student['address'] ?: '-', 'Created At' => $student['created_at'] ?: '-', 'Updated At' => $student['updated_at'] ?: '-']; foreach ($fields as $label => $value): ?><div class="col-md-6 mb-3"><strong><?= $label ?>:</strong><br><?= nl2br(htmlspecialchars($value)) ?></div><?php endforeach; ?>
<div class="col-md-6 mb-3"><strong>Status:</strong><br><span class="badge bg-<?= $status[1] ?>"><?= $status[0] ?></span></div></div></div></div></div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
