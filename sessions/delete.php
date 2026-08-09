<?php
session_start();
require_once "../config/database.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $delete_query = "DELETE FROM session WHERE id = $id";

    if (mysqli_query($conn, $delete_query)) {
        $_SESSION['message'] = "Session deleted successfully!";
        $_SESSION['alert_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to delete session: " . mysqli_error($conn);
        $_SESSION['alert_type'] = "danger";
    }
}

header("Location: index.php");
exit;
?>