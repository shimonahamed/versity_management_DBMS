<?php
require_once "../config/database.php";
require_once __DIR__ . '/../includes/auth.php';

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $query = "DELETE FROM course_registration WHERE id = $id";
    mysqli_query($conn, $query);
}

header("Location: list.php?status=deleted");
exit;