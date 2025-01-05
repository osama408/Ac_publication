<?php
session_start();
require '../../includes/db_connect.php';
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("location: ../login.php");
    exit;
}

if (isset($_GET['update_id'])) {
    $edit = $_GET['update_id'];

    $select = "SELECT * FROM about_us WHERE id = ?";
    $stmt = mysqli_prepare($connect, $select);
    mysqli_stmt_bind_param($stmt, "i", $edit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $about = $row['about'];
        $phone_number = $row['phone_number'];
        $email = $row['email'];
        $address = $row['address'];
    } else {
        echo "<script>alert('No record found.');</script>";
        exit;
    }

    mysqli_stmt_close($stmt);
}

if (isset($_POST['update_about'])) {
    $about_us = filter_var($_POST['about_form'], FILTER_SANITIZE_STRING);
    $phone_number = filter_var($_POST['phone_number'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Validate phone number
    if (!preg_match("/^\+?[0-9]{7,15}$/", $phone_number)) {
        echo "Invalid phone number format.";
        exit;
    }

    $update = "UPDATE about_us SET about = ?, phone_number = ?, email = ?, address = ? WHERE id = ?";
    $stmt = mysqli_prepare($connect, $update);
    mysqli_stmt_bind_param($stmt, "ssssi", $about_us, $phone_number, $email, $address, $edit);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Your Information Updated Successfully');</script>";
        echo "<script>window.location.href='display_about_us.php';</script>";
    } else {
        echo "<script>alert('Failed To Update The Information');</script>";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit About Me</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Script for fully interactive content form -->
  <script src="https://cdn.tiny.cloud/1/md4twn817rasnyt1auvdqtldj5h3p6frdem95rg40d5menzb/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
<div class="container">
    <form action="" method="post">
        <div class="form-group">
            <label for="content"><b>About Me</b></label>
            <textarea class="form-control" id="About_me" rows="8" name="about_form"><?php echo htmlspecialchars($about ?? ''); ?></textarea>
        </div>

        <script>
            tinymce.init({
                selector: '#About_me',
                plugins: 'lists link image table code',
                toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                menubar: false,
                setup: function(editor) {
                    editor.on('change', function() {
                        tinymce.triggerSave();
                    });
                }
            });
        </script>

        <label for="phone_number">Phone Number</label>
        <input type="text" value="<?php echo htmlspecialchars($phone_number ?? ''); ?>" name="phone_number" id="phone_number" required pattern="^\+?[0-9]{7,15}$" class="form-control">

        <label for="email">Email</label>
        <input type="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" name="email" id="email" class="form-control">

        <label for="address">Address</label>
        <input type="text" value="<?php echo htmlspecialchars($address ?? ''); ?>" name="address" id="address" class="form-control">

        <button type="submit" name="update_about" class="btn btn-primary mt-3">Update</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
