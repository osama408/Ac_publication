<?php 
session_start();
require '../../includes/db_connect.php';
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirect to login page if not authenticated
    header("location: ../login.php");
    exit;
}




// Set the number of results per page
$per_page = 2;

// Get the current page from URL, default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Ensure $page is at least 1
$page_1 = ($page - 1) * $per_page;

// Count the total records in the essays table
$count_query = "SELECT COUNT(*) AS total FROM essays";
$count_result = mysqli_query($connect, $count_query);
$total_records = mysqli_fetch_assoc($count_result)['total'] ?? 0;

// Calculate the total number of pages
$total_pages = ceil($total_records / $per_page);

// Fetch the essays for the current page
$select_essay = "SELECT * FROM essays LIMIT $page_1, $per_page";
$confirm_select_query = mysqli_query($connect, $select_essay);

if (!$confirm_select_query) {
    die("Error in query execution: " . mysqli_error($connect));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Table</title>
    <link rel="stylesheet" href="../../css/essay_table.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="main-content">
        <h2>Table Example</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Author</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Created_at</th>
                    <th>File Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $num = $page_1 + 1; // Initialize numbering for current page
            if (mysqli_num_rows($confirm_select_query) > 0) {
                while ($row = mysqli_fetch_assoc($confirm_select_query)) {
                    $id = $row['essay_id'];
                    $author_name = htmlspecialchars($row['author_name']);
                    $title = htmlspecialchars($row['title']);
                    $category = htmlspecialchars($row['category']);
                    $created_at = htmlspecialchars($row['created_at']);
                    $file_name = htmlspecialchars($row['file_name']);
                    ?>
                    <tr>
                        <td><?php echo $num++; ?></td>
                        <td><?php echo $author_name; ?></td>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $category; ?></td>
                        <td><?php echo $created_at; ?></td>
                        <td><?php echo $file_name; ?></td>
                        <td>
                            <a href="update_essay.php?update_id=<?php echo $id; ?>" class="btn btn-sm btn-info">Edit</a>
                            <a href="delete_essay.php?delete_id=<?php echo $id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this essay?');">Delete</a>
                            <a href="../../read_more.php?read_more_id=<?php echo $id; ?>" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='7' class='text-center'>No essays found.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <ul class="pagination">
        <?php
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo "<li class='page-item active'><a class='page-link' href='view_essay.php?page=$i'>$i</a></li>";
            } else {
                echo "<li class='page-item'><a class='page-link' href='view_essay.php?page=$i'>$i</a></li>";
            }
        }
        ?>
    </ul>

    <a href="publish.php" class="btn btn-sm btn-success">Add More</a> 
    <a href="../dashboard.php" class="btn btn-sm btn-dark">Admin Panel</a> 
    <a href="../../index.php" class="btn btn-sm btn-primary">Home Page</a> 
</body>
</html>
