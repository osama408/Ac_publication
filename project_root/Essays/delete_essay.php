<?php session_start();
require '../../includes/db_connect.php'; 
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirect to login page if not authenticated
    header("location: ../login.php");
    exit;


}
?>
<?php
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($connect, $_GET['delete_id']);
    
    // Fetch the file name first
    $select_pdf_query = "SELECT file_name FROM essays WHERE essay_id = '$delete_id'";
    $result = mysqli_query($connect, $select_pdf_query);



    
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $pdf_name = $row['file_name'];
        $file_path = "../../assets/book/$pdf_name";
        
        // Delete the PDF file if it exists
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Now delete the record from the database
        $delete_essay_query = "DELETE FROM essays WHERE essay_id = '$delete_id'";
        $confirm_delete_query = mysqli_query($connect, $delete_essay_query);
        
        if ($confirm_delete_query) {
            echo "<script>alert('Essay Deleted Successfully')</script>";
            echo "<script>window.location.href='view_essay.php';</script>";
        } else {
            echo "<script>alert('Error deleting the essay.')</script>";
        }
    } else {
        echo "<script>alert('Record not found.')</script>";
    }
}


?>
?>
