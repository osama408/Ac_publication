<?php
session_start();

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirect to login page if not authenticated
    header("location: ../login.php");
    exit;
}




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Table</title>
    <link rel="stylesheet" href="../../css/comment.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <div class="main-content">
        <!-- Table section -->
        <h2>Comments Table</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Nmae</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

            <?php
            require '../../includes/db_connect.php';
            $select_users = "SELECT * FROM authors";
            $confirm_users_query = mysqli_query($connect,$select_users);

            while($row = mysqli_fetch_assoc($confirm_users_query))
            {
                $id = $row['id'];
                $username = $row['username'];
                $role = $row['role'];
           
            ?>
                <tr>
                    <td><?php echo $id;?></td>
                    <td><?php echo $username;?></td>
                    <td><?php echo $role; ?></td>
                    <td>
                    <!-- <a href="#" class="btn btn-sm btn-info">Edit</a> -->
                    <a href="delete_user.php?delete_id=<?php echo $id;?>" class="btn btn-sm btn-danger"onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
           <?php } ?>
                <!-- More rows as needed -->
            </tbody>
        </table><br>
      
        <a href="../dashboard.php" class="btn btn-sm btn-dark">Admin Panel</a> 
        <a href="../../index.php" class="btn btn-sm btn-primary">Home Page</a> 
    </div>
</body>
</html>
