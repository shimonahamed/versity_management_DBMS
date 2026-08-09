<?php
require_once "../config/database.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $delete_query = "DELETE FROM department WHERE id = $id";

    if (mysqli_query($conn, $delete_query)) {
        header("Location: index.php?status=deleted");
        exit;
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    header("Location: index.php");
    exit;
}
?>