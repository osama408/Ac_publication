<?php
session_start();
require '../../includes/db_connect.php';

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("location: ../login.php");
    exit;
}

if (isset($_GET['update_profile_id'])) {
    $update_profile_id = mysqli_real_escape_string($connect, $_GET['update_profile_id']);
    $select = "SELECT * FROM profile_information WHERE id = ?";
    $stmt = mysqli_prepare($connect, $select);
    mysqli_stmt_bind_param($stmt, "i", $update_profile_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch data from database
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $username = $row['username'];
        $major = $row['major'];
        $facebook = $row['facebook'];
        $twitter = $row['twitter'];
        $linkedin = $row['linkedin'];
        $current_image = $row['profile_image'];
    } else {
        echo "No record found with ID: " . htmlspecialchars($update_profile_id) . ".";
        exit;
    }
    mysqli_stmt_close($stmt);
}

if (isset($_POST['update'])) {
    $errors = [];

    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $major = filter_var($_POST['major'], FILTER_SANITIZE_STRING);
    $facebook = filter_var($_POST['facebook'], FILTER_VALIDATE_URL);
    $twitter = filter_var($_POST['twitter'], FILTER_VALIDATE_URL);
    $linkedin = filter_var($_POST['linkedin'], FILTER_VALIDATE_URL);

    if ($facebook === false) $errors[] = "Invalid Facebook URL.";
    if ($twitter === false) $errors[] = "Invalid Twitter URL.";
    if ($linkedin === false) $errors[] = "Invalid LinkedIn URL.";

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_file = $_FILES['image'];
        $image_filename = uniqid() . "_" . basename($image_file['name']);
        $image_tmp_location = $image_file['tmp_name'];
        $upload_directory = '../../assets/profile_images/';
        $new_image_path = $upload_directory . $image_filename;

        // Move the file to the uploads directory
        if (move_uploaded_file($image_tmp_location, $new_image_path)) {
            // Delete the old file if it exists
            if (!empty($current_image) && file_exists($current_image)) {
                unlink($current_image);
            }
            $file_path_to_update = $new_image_path;
        } else {
            $errors[] = "Failed to upload the new image.";
        }
    } else {
        $file_path_to_update = $current_image;
    }

    if (empty($errors)) {
        $edit_query = "UPDATE profile_information SET 
                        username = ?, 
                        major = ?, 
                        facebook = ?, 
                        twitter = ?, 
                        linkedin = ?, 
                        profile_image = ? 
                        WHERE id = ?";

        $stmt = mysqli_prepare($connect, $edit_query);
        mysqli_stmt_bind_param($stmt, "ssssssi", $username, $major, $facebook, $twitter, $linkedin, $file_path_to_update, $update_profile_id);

        if (mysqli_stmt_execute($stmt)) {
            echo '<script>alert("Updated Successfully");</script>';
            echo "<script>window.location.href='../dashboard.php';</script>";
            exit;
        } else {
            $errors[] = "Failed to update the record.";
        }
        mysqli_stmt_close($stmt);
    } else {
        foreach ($errors as $error) {
            echo htmlspecialchars($error) . "<br>";
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
                        <h3 class="card-title text-center">Update Profile</h3>
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
                                <input type="text" name="username" class="form-control" id="username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" >
                            </div>
                            <div class="mb-3">
                                <label for="major" class="form-label">Major</label>
                                <input type="text" name="major" class="form-control" id="major" value="<?php echo isset($major) ? htmlspecialchars($major) : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input type="url" name="facebook" class="form-control" value="<?php echo isset($facebook) ? htmlspecialchars($facebook) : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="twitter" class="form-label">Twitter</label>
                                <input type="url" name="twitter" class="form-control" value="<?php echo isset($twitter) ? htmlspecialchars($twitter) : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="linkedin" class="form-label">LinkedIn</label>
                                <input type="url" name="linkedin" class="form-control" value="<?php echo isset($linkedin) ? htmlspecialchars($linkedin) : ''; ?>">
                            </div>


                            <div class="mb-3">
                                <label for="prof_image" class="form-label">Profile Image</label>
                                <?php if (!empty($current_image)) : ?>
                                <p>Current Image: <?php echo htmlspecialchars($current_image); ?></p>
                                 <?php endif; ?>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <button type="submit" name="update" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
