<?php 
session_start();
 require '../../includes/db_connect.php';

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirect to login page if not authenticated
    header("location: ../login.php");
    exit;
}


$select_essay = "SELECT * FROM categories";
$confirm_select_query = mysqli_query($connect,$select_essay);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Table</title>
    <link rel="stylesheet" href="../../css/essay_table.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <div class="main-content">
        <!-- Table section -->
        <h2>Table Example</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php
            $num = 1;
            while($row = mysqli_fetch_assoc($confirm_select_query))
            {
                    $id = $row['id'];
                    $cat_name = $row['cat_name'];
                  
       
            ?>
                <tr>
                    <td><?php echo $num++;?></td>
                    <td><?php echo $cat_name; ?></td>
                  
                    <td>
                               
                                <a href="update_category.php?update_id=<?php echo $id;?>" class="btn btn-sm btn-info">Edit</a>
                                <a href="delete_cat.php?delete_id=<?php echo $id; ?>" class="btn btn-sm btn-danger"onclick="return confirm('Are you sure you want to delete this essay?');">Delete</a>
                              
                    </td>
                    <?php      } ?>
                </tr>
                
            </tbody>
        
        </table>
        <br>
        
        <a href="add_category.php" class="btn btn-sm btn-success">Add More Categories</a>
        <a href="../../index.php" class="btn btn-sm btn-primary">Home Page</a>
        <a href="../dashboard.php" class="btn btn-sm btn-dark">Admin Panel</a>
    </div>
</body>
</html>

<?php

?>
