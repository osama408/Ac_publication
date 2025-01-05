<?php 
session_start();
require '../../includes/db_connect.php';

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirect to login page if not authenticated
    header("location: ../login.php");
    exit;
}



if (isset($_GET['update_id'])) {
    $edit = mysqli_real_escape_string($connect, $_GET['update_id']);
    
    $select = "SELECT * FROM essays WHERE essay_id = '$edit'";
    $confirm_update = mysqli_query($connect, $select);

    // Fetch Data From Database
    if ($confirm_update && $row = mysqli_fetch_assoc($confirm_update)) {
        $author = $row['author_name'];
        $title = $row['title'];
        $content = $row['content'];
        $current_category = $row['category'];
        $current_pdf = '../../assets/book/' . $row['file_name']; // Full path
    }
}

if (isset($_POST['update_essay'])) {
    $author_name = mysqli_real_escape_string($connect, $_POST['author_form']);
    $title_Name = mysqli_real_escape_string($connect, $_POST['title_form']);
    $content_name = mysqli_real_escape_string($connect, $_POST['content_form']);
    $category_Name = mysqli_real_escape_string($connect, $_POST['category_form']);
    $errors = [];

    // Check if a new PDF file is uploaded
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {
        $pdf_file = $_FILES['pdf'];
        $pdf_filename = $pdf_file['name'];
        $pdf_temp_location = $pdf_file['tmp_name'];
        $upload_directory = '../../assets/book/';
        $new_pdf_path = $upload_directory . $pdf_filename;

        // Move the file to the uploads directory
        if (move_uploaded_file($pdf_temp_location, $new_pdf_path)) {
            // If a new file is uploaded, delete the old file
            if (!empty($current_pdf) && file_exists($current_pdf)) {
                unlink($current_pdf); // Delete the old file
            }
            $file_path_to_update = $pdf_filename; // Store only the file name in DB
        } else {
            $errors[] = "Failed to upload new PDF.";
        }
    } else {
        // If no file uploaded, keep the existing file path
        $file_path_to_update = basename($current_pdf); // Extract file name for DB
    }

    if (empty($errors)) {
        $edit_query = "UPDATE essays SET 
                       author_name = '$author_name', 
                       title = '$title_Name', 
                       content = '$content_name', 
                       category = '$category_Name', 
                       file_name = '$file_path_to_update'
                       WHERE essay_id = '$edit'";

        $confirm_update = mysqli_query($connect, $edit_query);

        if (!$confirm_update) {
            die("Error: " . mysqli_error($connect));
        } else {
            echo '<script>alert("Updated Successfully")</script>';
            echo "<script>window.location.href='view_essay.php';</script>";
            exit();
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Essay</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

      <!-- Script for fully interactive content form -->
      <script src="https://cdn.tiny.cloud/1/md4twn817rasnyt1auvdqtldj5h3p6frdem95rg40d5menzb/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>

<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#contentTab">Content</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#optionsTab">Options</a>
    </li>
</ul>

<div class="tab-content">
    <div id="contentTab" class="container tab-pane active">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="content"><b>Content</b></label>
                <!-- Display content with HTML tags preserved -->
                <textarea class="form-control" id="reportContent" rows="8" name="content_form" placeholder="Write your essay here..."><?php echo isset($content) ? $content : ''; ?></textarea>
            </div>

               <!-- Script fot fully interactive form -->
               <script>
                        tinymce.init({
                        selector: '#reportContent',
                        plugins: 'lists link image table code',
                        toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                        menubar: false
                        });
                    </script>

            <div class="form-group">
                <label for="upload"><b>Upload File</b></label>
                <?php if (!empty($current_pdf)) : ?>
                    <p>Current PDF: <?php echo htmlspecialchars($current_pdf); ?></p>
                <?php endif; ?>
                <input type="file" name="pdf" class="form-control-file">
            </div>

            <button type="submit" name="update_essay" class="btn btn-primary">Update</button>
      
    </div>

    <!-- option -->
    <div id="optionsTab" class="container tab-pane fade">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Title" name="title_form" value="<?php echo isset($title) ? htmlspecialchars($title) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="author"><b>Author</b></label>
            <input type="text" value="<?php echo isset($author) ? htmlspecialchars($author) : ''; ?>" class="form-control" name="author_form" required>
        </div>

        <div class="form-group">
            <label for="category"><b>Category</b></label>
            <select name="category_form" class="form-control">
                <?php 
                    $select_category = "SELECT * FROM categories";
                    $confirm_select_query = mysqli_query($connect, $select_category);
                    while($row = mysqli_fetch_assoc($confirm_select_query)) {
                        $category_name = $row['cat_name'];
                        $selected = (isset($current_category) && $current_category == $category_name) ? 'selected' : '';
                        echo "<option value=\"$category_name\" $selected>$category_name</option>";
                    }
                ?>
            </select>
        </div>
    </div>
</div>
</form>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php

?>
