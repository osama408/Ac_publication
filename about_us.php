
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<style>
  <style>
  
</style>
</style>
<body>
  


<section id ="about-us" class="about-section">
        <h2>About Us</h2>

                  <?php
                  $select_about_us = "SELECT * FROM about_us";
                  $confirm_about_us_query = mysqli_query($connect,$select_about_us);

                  while($row = mysqli_fetch_array($confirm_about_us_query))
                  {
                    $about = $row['about'];
                    $phone_number = $row['phone_number'];
                    $email = $row['email'];
                    $address = $row['address'];
               
                  }
                    ?>

        <div class="about-details">
            <div class="icon-box">
                <p><i class="bi bi-telephone-fill"></i> Phone:</p>
                <p><i class="bi bi-envelope-fill"></i> Email:</p>
                <p><i class="bi bi-geo-alt-fill"></i> Location:</p>
            </div>
            <div class="about-text">
                <p><?php echo htmlspecialchars($phone_number); ?></p> <br> 
                <p><?php echo htmlspecialchars($email); ?></p> <br>
                <p><?php echo htmlspecialchars($address); ?></p>
            </div>
        </div>
        <div class="about-description">
            <p><?php echo nl2br(strip_tags($about));?></p>
        </div>
    </section>

    </body>
</html>