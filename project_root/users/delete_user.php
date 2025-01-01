    <?php 
    require '../../includes/db_connect.php';
    session_start();

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirect to login page if not authenticated
    header("location: ../login.php");
    exit;
}


    if(isset($_GET['delete_id']))
    {
        $delete_id = $_GET['delete_id'];
        $delete_user = "DELETE FROM authors WHERE id = '$delete_id'";
        $confirm_delete_query = mysqli_query($connect,$delete_user);

    if($confirm_delete_query)
        {
            echo "<script>alert('The Record Deleted Successfully')</script>";
            echo "<script>window.location.href = 'display_users.php'; </script>";
            exit();
        }
    }

    ?>