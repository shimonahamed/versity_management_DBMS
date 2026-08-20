<?php
require_once "../config/database.php";
require_once __DIR__ . '/../includes/auth.php';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id > 0 && ($stmt = mysqli_prepare($conn, 'DELETE FROM students WHERE id = ?'))) { mysqli_stmt_bind_param($stmt, 'i', $id); mysqli_stmt_execute($stmt); mysqli_stmt_close($stmt); header('Location: index.php?status=deleted'); exit; }
header('Location: index.php'); exit;
