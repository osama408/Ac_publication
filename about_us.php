<style>
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  color: #333;
}

/* General Section Styling */
section {
  width: 100%;
  padding: 60px 20px;
  color: black;
}

.container {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: row;
}

.text_section {
  width: 60%;
  padding: 20px;
}

/* About Us Section Styling */
.about-header {
  text-align: center;
  color: #142d4c;
  text-decoration: underline;
  text-decoration-thickness: 3px;
  text-decoration-color: #142d4c;
  margin-bottom: 40px;
  font-size: 2.5rem;
}

.about-container {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap; /* Ensures responsiveness */
  gap: 20px;
  max-width: 1200px;
  margin: 0 auto;
}

.about-image {
  width: 50%; /* Adjust width as needed */
  max-width: 500px;
  height: auto;
  border-radius: 18px;
  order: 1; /* Ensure image is on the left */
}

.about-text {
  width: 45%; /* Adjust width as needed */
  font-size: 1.2rem;
  line-height: 1.6;
  order: 2; /* Ensure text is on the right */
}

.about-text p {
  margin: 0 0 20px 0;
}

/* Contact Us Section Styling */
.contact-header {
  text-align: center;
  color: #142d4c;
  text-decoration: underline;
  text-decoration-thickness: 3px;
  text-decoration-color: #142d4c;
  margin-bottom: 40px;
}

.contact-container {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 20px;
  margin: 0 auto;
  max-width: 800px;
}

.contact-image {
  width: 400px; /* Increased size from 150px */
  height: auto;
  border-radius: 10px;
}

.contact-details {
  font-size: 1.2rem;
  color: #333;
}

.contact-details p {
  margin: 0;
  font-weight: bold;
}

/* Add spacing between sections */
.spacer {
  height: 60px;
  margin: 60px 0; /* Add top and bottom margins to create space between sections */
}

.spacer2 {
  height: 60px;
  margin: 60px 0; /* Add top and bottom margins to create space between sections */
}


</style>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us</title>
  <style>
    /* Insert the updated CSS here */
  </style>
</head>
<body>
<div class="spacer2"></div>

<!-- About Us Section -->
 <section id="about">


<h2 class="about-header" >About Us</h2>
<div class="about-container">
  <!-- About Us Image -->
  <img src="about_us2.png"  alt="About Us" class="about-image">
  
  <!-- About Us Text -->
  <div class="about-text"> 

  <?php 
  $select_about_us = "SELECT * FROM about_us"; 
  $confirm_about_us_query = mysqli_query($connect, $select_about_us); 
  while ($row = mysqli_fetch_array($confirm_about_us_query)) { 
    $about = $row['about']; 
    $email = $row['email']; 
  } 
    
    ?>
    <p>
      <?php echo $about; ?>
    </p>
 
  </div>
</div>
</section>


<div class="spacer"></div>

<!-- Contact Us Section -->
 <section id="contact">
<h2 class="contact-header">Contact Us</h2>
<div class="contact-container">
  <img src="contact-img.jpg" alt="Contact Us" class="contact-image">
  <div class="contact-details">
    <p>Email: <?php echo $email;?></p>
  </div>
</div>
</section>


<div class="spacer"></div>

</body>
</html>
