<?php
session_start();
require '../../includes/db_connect.php';
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirect to login page if not authenticated
    header("location: ../login.php");
    exit;
}




if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($connect,$_GET['delete_id']);

    // Use prepared statement to delete category
    $delete_cat_query = "DELETE FROM categories WHERE id = ?";
    $stmt = $connect->prepare($delete_cat_query);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<script>alert('The Record Deleted Successfully')</script>";
        echo "<script>window.location.href = 'display_cat.php'; </script>";
        exit();
    } else {
        echo "<script>alert('Error: Unable to delete the record.')</script>";
    }

    $stmt->close();
}
?>
