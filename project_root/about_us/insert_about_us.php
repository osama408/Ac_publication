<?php
require '../../includes/db_connect.php';
session_start();

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirect to login page if not authenticated
    header("location: login.php");
    exit;
}

if (isset($_POST['submit'])) {
    // Input sanitization
    $about_me = mysqli_real_escape_string($connect, $_POST['aboutme']);
    $phone_number = mysqli_real_escape_string($connect, $_POST['phone_number']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $address = mysqli_real_escape_string($connect, $_POST['address']);

    // Server-side validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
    } 
    // elseif (!preg_match('/^\+?[0-9]{7,15}$/', $phone_number)) { // Allows international format
    //     echo "<script>alert('Invalid phone number');</script>";
    // } 
    else {
        // Insert data into the database
        $query = "INSERT INTO about_us (id, about, phone_number, email, address) VALUES (NULL, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, 'ssss', $about_me, $phone_number, $email, $address);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Data submitted successfully');</script>";
            echo "<script>window.location.href='display_about_us.php';</script>";
        } else {
            echo "<script>alert('Failed to submit data. Please try again.');</script>";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../css/about_us.css">

  <!-- Script for a fully interactive content form -->
  <script src="https://cdn.tiny.cloud/1/py5zzcdfr80b0lq2dl91xy2wwu8pzwvoopriexzrjtrs9puk/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
  <title>About Us Form</title>
</head>
<body>
  <div class="container">
    <h1>About Us Upload Form</h1>
    <form action="" method="POST" enctype="multipart/form-data">
      <!-- About Us Section -->
      <label for="aboutUs">Write About Us:</label>
      <textarea id="aboutUs" name="aboutme" rows="8" required></textarea>

      <!-- Phone Number -->
      <label for="phone_number">Phone Number</label>
      <input type="text" name="phone_number" id="phone_number" placeholder="e.g., +123456789" required pattern="^\+?[0-9]{7,15}$">

      <!-- Email -->
      <label for="email">Email</label>
      <input type="email" name="email" id="email" placeholder="e.g., example@domain.com" required>

      <!-- Address -->
      <label for="address">Address</label>
      <input type="text" name="address" id="address" placeholder="Enter the address" required>

      <!-- Submit Button -->
      <button type="submit" name="submit">Submit</button>
    </form>
  </div>

  <!-- Script for TinyMCE -->
  <script>
    tinymce.init({
      selector: '#aboutUs',
      plugins: 'lists link image table code',
      toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
      menubar: false,
      setup: function (editor) {
        editor.on('change', function () {
          tinymce.triggerSave(); // Sync editor content to the textarea
        });
      }
    });
  </script>

  <!-- Optional Bootstrap (for future use) -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
