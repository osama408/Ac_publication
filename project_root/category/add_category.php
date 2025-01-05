<?php
session_start();
require '../../includes/db_connect.php';
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirect to login page if not authenticated
    header("location: ../login.php");
    exit;
}

if (isset($_POST['add'])) {
    $category = $_POST['categories'];

    // Check if category already exists
    $duplicate_category_query = "SELECT * FROM categories WHERE cat_name = ?";
    $stmt = $connect->prepare($duplicate_category_query);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('The Data Already in The Database');</script>";
    } else {
        // Insert new category
        $insert_category_query = "INSERT INTO categories(cat_name) VALUES (?)";
        $stmt_insert = $connect->prepare($insert_category_query);
        $stmt_insert->bind_param("s", $category);

        if (!$stmt_insert->execute()) {
            die("Failed to Insert data: " . $stmt_insert->error);
        } else {
            echo "<script>alert('Data Inserted Successfully');</script>";
            echo "<script>window.location.href ='display_cat.php';</script>";
        }

        $stmt_insert->close();
    }

    $stmt->close();
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- bootstrap -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>

<h3>Category Page</h3>

<form action="" method="post">
        <label for="category">Category</label>
        <input type="text" class="form-control" name="categories" placeholder="Enter Category" required><br>
        <input type="submit" value="Add Category" name="add" class="btn btn-sm btn-success"><br>
        
</form>

<a href="../dashboard.php" class="btn btn-sm btn-dark">Admin Panel</a>
<a href="display_cat.php" class="btn btn-sm btn-warning">Categories Table</a>
<a href="../../view_essay.php" class="btn btn-sm btn-primary">Home Page</a>

</body>
</html>

<?php

?>
