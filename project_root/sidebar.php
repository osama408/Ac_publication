<?php
session_start();

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirect to login page if not authenticated
    header("location: login.php");
    exit;
}
?>





            


<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CSS Libraries -->
<link rel="stylesheet" href="../css/sidebar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-V1B4HCg6V6sMTOdNfnjB+DFhDCOGZ7n/DZsL7BPt+o86i8SbOwSnCMl57dD+v+FAmqnF9US4DgUKai/2jzFPkw==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<title>Document</title>
                
            </head>
<style>
    .custom-text {
        color: #142d4c !important;
    }
    .custom-bg {
        background-color: #142d4c !important;
    }
</style>

            <body>
            <div class="wrapper d-flex">
    <!-- Sidebar -->
    <nav id="sidebar" class="bg-dark p-3">
        <div class="sidebar-header text-white">
            <h3><i class="fas fa-user-shield"></i> </h3>
            <p><i class="fas fa-circle text-success"></i> Super Admin <span class="online-status">Online</span></p>
        </div>

        <ul class="list-unstyled components">

         <!-- Home Page -->
         <li class="active">
                <a href="../index.php" class="text-white"><i class="fas fa-solid fa-house"></i>Home Page</a>
            </li>

            <!-- Dashboard -->
            <li class="active">
                <a href="#" class="text-white"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>


         
          
            <?php 
            require '../includes/db_connect.php';
            $select_from_profile_information = "SELECT * FROM profile_information";
            $confirm_query = mysqli_query($connect,$select_from_profile_information);
            
            while($row = mysqli_fetch_assoc($confirm_query))
            {
                $id = $row['id'];
            }
            ?>

            
            <!--Profile -->
            <li class="dropdown">
                <a href="#profileDropdown" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-white">
                    <i class="fas fa-file-alt"></i> Profile
                </a>
                <ul class="collapse list-unstyled" id="profileDropdown">
                <a href="profile/add_profile_data.php" class="text-white"><i class="fas fa-solid fa-user"></i>Adding Personal Info</a>
                    <li><a href="profile/view_profile.php?profile_id=<?php echo $id;?>" class="text-white"><i class="fas fa-solid fa-user"></i>View Profile Info</a></li>
                </ul>
            </li>
            


         
          


            <!-- about me -->
            <li class="dropdown">
                <a href="#AboutDropdown" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-white">
                    <i class="fas fa-file-alt"></i> About us
                </a>
                <ul class="collapse list-unstyled" id="AboutDropdown">
                    <li><a href="about_us/display_about_us.php" class="text-white"><i class="fas fa-eye"></i> Display About us</a></li>
                    <li><a href="about_us/insert_about_us.php" class="text-white"><i class="fas fa-plus"></i> Add About us</a></li>
                </ul>
            </li>

            <!-- Essay -->
            <li class="dropdown">
                <a href="#EssayDropdown" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-white">
                    <i class="fas fa-file-alt"></i> Essay
                </a>
                <ul class="collapse list-unstyled" id="EssayDropdown">
                    <li><a href="Essays/view_essay.php" class="text-white"><i class="fas fa-eye"></i> Display Essay</a></li>
                    <li><a href="Essays/publish.php" class="text-white"><i class="fas fa-plus"></i> Add an Essay</a></li>
                </ul>
            </li>

            <!-- Categories -->
            <li class="dropdown">
                <a href="#categoryDropdown" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-white">
                    <i class="fas fa-tags"></i> Categories
                </a>
                <ul class="collapse list-unstyled" id="categoryDropdown">
                    <li><a href="category/add_category.php" class="text-white"><i class="fas fa-plus"></i> Add Categories</a></li>
                    <li><a href="category/display_cat.php" class="text-white"><i class="fas fa-list"></i> Display Categories</a></li>
                </ul>
            </li>

            <!-- Users -->
            <li class="dropdown">
                <a href="#userDropdown" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-white">
                    <i class="fas fa-users"></i> Users
                </a>
                <ul class="collapse list-unstyled" id="userDropdown">
                    <li><a href="users/add_user.php" class="text-white"><i class="fas fa-user-plus"></i> Add User</a></li>
                    <li><a href="users/display_users.php" class="text-white"><i class="fas fa-user-friends"></i> Display Users</a></li>
                </ul>
            </li>

            <!-- Logout -->
            <li>
                <a href="logout.php" class="text-white"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>

            <!-- Books -->
            </body>
            </html>