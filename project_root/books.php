
<?php require '../includes/db_connect.php'; ?>


        

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Table</title>
    <link rel="stylesheet" href="../css/comment.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <div class="main-content">
        <!-- Table section -->
        <h2>Books Table</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pdf Name </th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
                </thead>
            <tbody>

            <?php
            $select_essay = "SELECT essay_id,category,file_name FROM essays";
            $confirm_select_query = mysqli_query($connect,$select_essay);
            $num = 1;
            while($row = mysqli_fetch_assoc($confirm_select_query))
            {
                    $id = $row['essay_id'];
                    $file_name = $row['file_name'];
                    $category = $row['category'];
            
            ?>
                <tr>
                    <td><?php echo $num++;?></td>
                    <td><?= htmlspecialchars($file_name); ?></td>
                    <td><?php echo $category; ?></td>
                 
                    <td>
                        <a href="../assets/book/<?= urlencode($file_name);?>" class="btn btn-sm btn-primary" download>Downloads</a>
                    </td>
                    <?php } ?>
                </tr>
                
            </tbody>
        
        </table><br>
      
        <?php 

    ?>
        <a href="dashboard.php" class="btn btn-sm btn-dark">Admin Panel</a> 
        <a href="../view_essay.php" class="btn btn-sm btn-primary">Home Page</a> 
    </div>
</body>
</html>

