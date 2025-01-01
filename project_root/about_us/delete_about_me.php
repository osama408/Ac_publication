<?php
require '../../includes/db_connect.php';

session_start();

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirect to login page if not authenticated
    header("location: ../login.php");
    exit;
}
?>

<?php
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Fetch the file name first
    $select_from_db = "SELECT * FROM about_us WHERE id = ?";
    $stmt = $connect->prepare($select_from_db);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Now delete the record from the database
        $delete_essay_query = "DELETE FROM about_us WHERE id = ?";
        $delete_stmt = $connect->prepare($delete_essay_query);
        $delete_stmt->bind_param("i", $delete_id);
        $confirm_delete_query = $delete_stmt->execute();
        
        if ($confirm_delete_query) {
            echo "<script>alert('Your Information Deleted Successfully')</script>";
            echo "<script>window.location.href='display_about_us.php';</script>";
        } else {
            echo "<script>alert('Error deleting the essay.')</script>";
        }
        $delete_stmt->close();
    } else {
        echo "<script>alert('Record not found.')</script>";
    }
    $stmt->close();
}
?>
