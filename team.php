<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<style>
    .team {
  text-align: center;
  padding: 63px 25px;
  border-radius: 20px;
  margin-top: 89px;
  background: #f1f1f1;
}

.team h2 {
  margin-bottom: 20px;
  color: #142d4c;
}

.team-member {
  display: inline-block;
  margin: 10px;
  text-align: center;
  width: 150px;
}

.team-member img {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  margin-bottom: 10px;
}

.team-member h4 {
  margin: 10px 0 5px;
  color: #333;
}

.team-member p {
  color: #666;
  margin-bottom: 10px;
}

.social-icons {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin-top: 10px;
}

.social-icons a {
  text-decoration: none;
  color: #142d4c;
  font-size: 18px;
  transition: color 0.3s;
}

.social-icons a:hover {
  color: #0077b5; /* LinkedIn blue hover color */
}

</style>
<section class="team">
  <h2>Meet the Team</h2>
  
    <?php
    require 'includes/db_connect.php';
    $select_profile = "SELECT * FROM profile_information";
    $confirm_prof_query = mysqli_query($connect, $select_profile);

    while ($row = mysqli_fetch_assoc($confirm_prof_query)) {
        $username = $row['username'];
        $major = $row['major'];
        $facebook = $row['facebook'];
        $twitter = $row['twitter'];
        $linkedin = $row['linkedin'];
        $profile_image = htmlspecialchars(basename($row['profile_image']), ENT_QUOTES, 'UTF-8');

        $user_image_path = "assets/profile_images/" . $profile_image;
        if (!file_exists($user_image_path) || empty($profile_image)) {
            $user_image_path = "assets/about_me_images/about-img.png";
        }
    ?>

    <div class="team-member">
      <img src="<?php echo $user_image_path; ?>" alt="Team Member">
      <h4><b>Publisher</b> <?php echo $username; ?></h4>
      <p><b>Major:</b> <?php echo $major; ?></p>
      <div class="social-icons">
        <?php if (!empty($facebook)): ?>
          <a href="<?php echo $facebook; ?>" target="_blank"><i class="fab fa-facebook"></i></a>
        <?php endif; ?>
        <?php if (!empty($twitter)): ?>
          <a href="<?php echo $twitter; ?>" target="_blank"><i class="fab fa-twitter"></i></a>
        <?php endif; ?>
        <?php if (!empty($linkedin)): ?>
          <a href="<?php echo $linkedin; ?>" target="_blank"><i class="fab fa-linkedin"></i></a>
        <?php endif; ?>
      </div>
    </div>

    <?php } // End of while loop ?>
</section>
    
</body>
</html>