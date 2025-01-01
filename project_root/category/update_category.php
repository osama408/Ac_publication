<?php
require '../../includes/db_connect.php';

// Hide errors
ini_set('display_errors', 'Off');
ini_set('error_reporting', E_ALL);
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);

session_start();

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirect to login page if not authenticated
    header("location: ../login.php");
    exit;
}

$cat_name = '';

if (isset($_GET['update_id'])) {
    $update_id = $_GET['update_id'];

    // Use prepared statement to fetch the category name based on the update_id
    $select_category_query = "SELECT cat_name FROM categories WHERE id = ?";
    $stmt = $connect->prepare($select_category_query);
    $stmt->bind_param("i", $update_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $cat_name = $row['cat_name'];
    } else {
        echo "Category not found.";
    }

    $stmt->close();
}

if (isset($_POST['update'])) {
    $cat_name = $_POST['categories'];

    // Use prepared statement to update the category name
    $update_query = "UPDATE categories SET cat_name = ? WHERE id = ?";
    $stmt_update = $connect->prepare($update_query);
    $stmt_update->bind_param("si", $cat_name, $update_id);

    if ($stmt_update->execute()) {
        echo "<script>alert('Category Updated Successfully')</script>";
        echo "<script>window.location.href='display_cat.php'</script>";
    } else {
        echo "<script>alert('Failed To Update The Category')</script>";
    }

    $stmt_update->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Update Category</title>
</head>
<body>

<h3>Update Category Page</h3>

<form action="" method="post">
    <label for="category">Category</label>
    <input type="text" class="form-control" name="categories" value="<?php echo htmlspecialchars($cat_name); ?>"><br>
    <input type="submit" value="Update Category" name="update" class="btn btn-sm btn-success"><br>
</form>

<a href="../../dashboard.php" class="btn btn-sm btn-dark">Admin Panel</a>
<a href="display_cat.php" class="btn btn-sm btn-warning">Categories Table</a>
<a href="../../index.php" class="btn btn-sm btn-primary">Home Page</a>

</body>
</html>
