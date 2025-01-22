<?php 
session_start();
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );


require '../../includes/db_connect.php';
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirect to login page if not authenticated
    header("location: ../login.php");
    exit;
}


if(isset($_POST['publish'])) {
    $title = mysqli_real_escape_string($connect, $_POST['title']);
    $author = mysqli_real_escape_string($connect, $_POST['author']);
    $category = mysqli_real_escape_string($connect, $_POST['category']);
    $date = mysqli_real_escape_string($connect, $_POST['publish-date']);
    $content = mysqli_real_escape_string($connect,$_POST['content']);

    
    $author_id = 1; // Replace with actual logic if needed
    $essay_status = 'approved';
    


    // pdf codes
    $errors = array();
    $pdf_name = $_FILES['pdf']['name'];
    $pdf_tmp = $_FILES['pdf']['tmp_name'];
    $pdf_error = $_FILES['pdf']['error'];
    $pdf_size = $_FILES['pdf']['size'];

      // Allowed Extensions
      $allowed_extentions = array('pdf');
      $tmp = explode('.', $pdf_name);
      $image_extention = strtolower(end($tmp));

         // Check if pdf is empty
    if ($pdf_error == UPLOAD_ERR_NO_FILE) {
        $errors[] = 'pdf is not uploaded.';
    } elseif ($pdf_size > 7000000) { // Check for size
        $errors[] = "The pdf size can't be more than 7MB.";
    } elseif (!in_array($image_extention, $allowed_extentions)) { // Check if the file is valid
        $errors[] = 'This extension is not allowed.';
    }


    if (empty($errors)) {
        $upload_path = "../../assets/book/$pdf_name";
        if (move_uploaded_file($pdf_tmp, $upload_path)) {
            

            $query = "INSERT INTO essays (author_id, title, author_name, content, category, created_at, file_name, essay_status) VALUES(?,?,?,?,?,?,?,?)";
            $insert_stmt = mysqli_prepare($connect,$query);
            mysqli_stmt_bind_param($insert_stmt,'isssssss',$author_id,$title,$author,$content,$category,$date,$pdf_name,$essay_status);
            if(mysqli_stmt_execute($insert_stmt))
            {
                echo "<script>alert('The Essay Added Successfully');</script>";  
                echo "<script>window.location.href='view_essay.php';</script>";
                exit();
            }
    
    
        } else {
            echo "Failed to upload the image.";
        }
    } else {
        // Print the error messages if there are any
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
    <title>Document</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
     <!-- Script for fully interactive content form -->
    <script src="https://cdn.tiny.cloud/1/md4twn817rasnyt1auvdqtldj5h3p6frdem95rg40d5menzb/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
     
</head>
<body>

 


    <!-- Tab Section -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#contentTab">Content</a>
        </li>


        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#optionsTab">Options</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Content Tab -->
        <div id="contentTab" class="container tab-pane active">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="content"><b>Content</b></label>
                    <textarea id="reportContent" class="form-control" rows="8" name="content" placeholder="Write your essay here..."></textarea>

                </div>
                       <!-- Script fot fully interactive form -->
                       <script>
            tinymce.init({
                        selector: '#reportContent',
                        plugins: 'lists link image table code textcolor',
                        toolbar: 'undo redo | formatselect | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                        menubar: false
                    });
            </script>


                <div class="form-group">
                    <label for="upload"><b>Upload File</b></label>
                    <input type="file" name="pdf" class="form-control-file">
                </div>


                <!-- Publish Button -->
                <button type="submit" name="publish" class="btn btn-primary">Publish</button>

            </div>

            <!-- Options Tab -->
            <div id="optionsTab" class="container tab-pane fade">
                <div class="form-group">
                    <label for="title"><b>Title</b></label>
                    <input type="text" class="form-control" placeholder="Title" name="title">
                </div>

                <div class="form-group">
                    <label for="publish-date"><b>Date</b></label>
                    <input type="date" name="publish-date"  id="publish-date" class="form-control date-input">
                </div>

                <div class="form-group">
                    <label for="author"><b>Author</b></label>
                    <input type="text" class="form-control" name="author" required>
                </div>


                <div class="form-group">
                    <label for="category"><b>Category</b></label>
                    <select name="category" class="form-control">
                        <?php 
                            $select_category = "SELECT * FROM categories";
                            $confirm_select_query = mysqli_query($connect, $select_category);
                            while($row = mysqli_fetch_assoc($confirm_select_query)) {
                                $category = $row['cat_name'];
                                echo "<option value=\"$category\">$category</option>";
                            }
                        ?>
                    </select>
                </div>

                
            </form>
        </div>
    </div>

    <!-- JavaScript for Bootstrap (Optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php

?>
