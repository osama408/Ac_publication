<?php 
error_reporting(E_ALL);
ini_set('display_errors', 0);

require '../includes/db_connect.php'; ?>

<?php

session_start();

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirect to login page if not authenticated
    header("location: login.php");
    exit;
}

if(isset($_POST['publish']))
{
    $title = $_POST['title'];
    $author = $_POST['author']; // This should be author_name, not author_id unless you're using it as ID
    $category = $_POST['category'];
    $date = $_POST['publish-date'];
    $content = $_POST['content'];
    $author_id = 1; // You can replace this with the actual author ID logic (e.g., from session)
    $essay_status = 'approved';

    // Add author_id in the insert query
    $query ="INSERT INTO essays (author_id, title, author_name, content, category, created_at,essay_status) ";
    $query .= "VALUES('{$author_id}', '{$title}', '{$author}', '{$content}', '{$category}', '{$date}','{$essay_status}')";
    
    $registration_query = mysqli_query($connect, $query);
   if($registration_query)
   {
    echo "<script>alert('The Essay Added Successfully')</script>";  
    echo "<script>window.location.href='Essays/view_essay.php'</script>";
    exit();
   }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lara Admin 0.1</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
   
   <!--Include Sidebar  -->
    <?php require 'sidebar.php'; ?>


    

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

