<?php
session_start();
require '../../includes/db_connect.php';

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("location: ../login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $errors = array();


    /* Sanitize input with prepared statement */
    // General sanitization
    $username = filter_var($_POST['username'],FILTER_SANITIZE_STRING); 
    if(strlen($username) > 50 || empty($username))
    {
        $errors[] = "Invalid username";
    }

    $major = filter_var($_POST['major'],FILTER_SANITIZE_STRING); 
    if(strlen($major) > 50 || empty($major))
    {
        $errors[] = "Invalid Major Type";
    }


      // Validate URLs
    $facebook = filter_var($_POST['facebook'],FILTER_VALIDATE_URL); 
    if($facebook === false)
    {
        $errors[] = "Invalid Facebook URL";
    }

    $twitter = filter_var($_POST['twitter'],FILTER_VALIDATE_URL); 
    if($twitter === false)
    {
        $errors[] = "Invalid twitter URL";
    }

    $linkedin = filter_var($_POST['linkedin'],FILTER_VALIDATE_URL); 
    if($twitter === false)
    {
        $errors[] = "Invalid linkedin URL";
    }
  


    // Handle file upload
    if (isset($_FILES['prof_image'])) {
        $image_name = $_FILES['prof_image']['name'];
        $image_tmp = $_FILES['prof_image']['tmp_name'];
        $image_error = $_FILES['prof_image']['error'];
        $image_size = $_FILES['prof_image']['size'];
    
        $allowed_extensions = array('png', 'jpeg', 'jpg');
        $finfo = finfo_open(FILEINFO_MIME_TYPE); // Initialize the Fileinfo Resource
        $mime = finfo_file($finfo, $image_tmp); // Get the MIME type of the uploaded file
        finfo_close($finfo); // Close the Fileinfo Resource
    
        $tmp = explode('.', $image_name);
        $image_extension = strtolower(end($tmp));
    
        if ($image_error == UPLOAD_ERR_NO_FILE) {
            $errors[] = 'Image is not uploaded.';
        } elseif ($image_size > 7000000) {
            $errors[] = "The image size can't be more than 7MB.";
        } elseif (!in_array($image_extension, $allowed_extensions) || !in_array($mime, ['image/jpeg', 'image/png'])) {
            $errors[] = 'Invalid image type.';
        } else {
            $image_name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $image_name);
            $upload_path = "../../assets/profile_images/$image_name";
            if (!move_uploaded_file($image_tmp, $upload_path)) {
                $errors[] = 'Failed to upload image.';
            }
        }
    } else {
        $errors[] = 'No file uploaded.';
    }
    

    // If no errors, insert into the database
    if (empty($errors)) {


        // Prepared statment
        $query = "INSERT INTO profile_information (username, major, facebook, twitter, linkedin, profile_image) VALUES (?, ?, ?, ?, ?, ?)";
        $insert_stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($insert_stmt, 'ssssss', $username, $major, $facebook, $twitter, $linkedin, $image_name);
        if (mysqli_stmt_execute($insert_stmt)) {
            echo "<script>alert('Profile data added successfully');</script>";
            header("Location: ../dashboard.php");
            exit;
        } else {
            $errors[] = 'Failed to save data to the database.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center">Profile Page</h3>
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <?php foreach ($errors as $error): ?>
                                    <p><?= htmlspecialchars($error) ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" maxlength="50" id="username" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label for="major" class="form-label">Major</label>
                                <input type="text" name="major" class="form-control" id="major" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input type="url" name="facebook" class="form-control" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="twitter" class="form-label">Twitter</label>
                                <input type="url" name="twitter" pattern="https?://.+" class="form-control" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="linkedin" class="form-label">LinkedIn</label>
                                <input type="url" name="linkedin" class="form-control" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="prof_image" class="form-label">Profile Image</label>
                                <input type="file" name="prof_image" class="form-control" autocomplete="off">
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
