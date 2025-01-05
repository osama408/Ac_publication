<?php
session_start();
require '../../includes/db_connect.php';

// Check if user is authenticated
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("Location: ../login.php");
    exit;
}

if(isset($_GET['profile_id']))
{
  $profile_id = $_GET['profile_id'];

  $select_profile_query = "SELECT * FROM profile_information WHERE id = '$profile_id'";
  $confirm_prof_query = mysqli_query($connect,$select_profile_query);

  while($row = mysqli_fetch_assoc($confirm_prof_query))
  {
    $username = htmlspecialchars($row['username']);
    $major = htmlspecialchars($row['major']);
    $facebook = htmlspecialchars($row['facebook']);
    $twitter = htmlspecialchars($row['twitter']);
    $linkedin = htmlspecialchars($row['linkedin']);
    $profile_image = htmlspecialchars($row['profile_image']);
  }

}

else {
    $username = "Unknown User";
    $major = "Unknown Major";
    $facebook = "#";
    $twitter = "#";
    $linkedin = "#";
    $profile_image = "https://via.placeholder.com/150";
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <title>Publisher Profile</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      color: #333;
    }
    .profile-container {
      max-width: 800px;
      margin: 50px auto;
      background: white;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      padding: 20px;
      text-align: center;
    }
    .profile-img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      margin-bottom: 20px;
    }
    .profile-name {
      font-size: 1.5rem;
      color: #142d4c;
      margin-bottom: 10px;
    }
    .profile-major {
      font-size: 1.2rem;
      color: #666;
      margin-bottom: 20px;
    }
    .social-links a {
      font-size: 1.5rem;
      margin: 0 10px;
      color: #142d4c;
      text-decoration: none;
    }
    .social-links a:hover {
      color: #007bff;
    }
    .action-buttons button {
      margin: 10px;
      padding: 10px 20px;
      font-size: 1rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .btn-update {
      background-color: #28a745;
      color: white;
    }
    .btn-update:hover {
      background-color: #218838;
    }
    .btn-admin {
      background-color: #142d4c;
      color: white;
    }
    .btn-admin:hover {
      background-color: #0f213a;
    }
  </style>
</head>
<body>


<div class="profile-container">
    <img src="<?php echo $profile_image ? '../../assets/profile_images/' . $profile_image : 'https://via.placeholder.com/150'; ?>" 
         alt="Publisher Profile Image" 
         class="profile-img">
    <h2 class="profile-name"><?php echo $username; ?></h2>
    <p class="profile-major">Major: <?php echo $major; ?></p>
    <div class="social-links">
        <a href="<?php echo $facebook; ?>" target="_blank" class="fab fa-facebook"></a>
        <a href="<?php echo $twitter; ?>" target="_blank" class="fab fa-twitter"></a>
        <a href="<?php echo $linkedin; ?>" target="_blank" class="fab fa-linkedin"></a>
    </div>
    <div class="action-buttons">
        <button class="btn-update" onclick="location.href='update_profile.php?update_profile_id=<?php echo $profile_id;?>'">Update</button>
        <button class="btn-admin" onclick="location.href='../dashboard.php'">Admin Panel</button>
    </div>
</div>

  <!-- Bootstrap and FontAwesome Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
