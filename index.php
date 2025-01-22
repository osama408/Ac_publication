<style>
  .content {
    padding: 20px;
  }

  .recent-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
  }

  .recent-item {
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    width: calc(33.333% - 20px);
    margin: 10px 0;
  }

  .recent-item img {
    width: 100%;
    height: 150px;
    object-fit: cover;
  }

  .recent-item h3 {
    font-size: 1.2rem;
    margin: 10px;
  }

  .recent-item p {
    font-size: 0.9rem;
    margin: 10px;
  }

  .recent-item button {
    margin: 10px;
    background-color: #142d4c;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
  }

  .recent-item button:hover {
    background-color: white;
    color: #142d4c;
  }

  footer {
    background: #142d4c;
    color: white;
    text-align: center;
    padding: 10px 0;
  }

</style>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- bootstrap -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
  <!-- fontawesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="main_page.css">
  <title>Main Page</title>
  <style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
  }

  .background {
    width: 100%;
    height: 100vh;
    background-image: url('hero-bg.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    position: relative;
  }

  header {
    position: absolute; /* Place the header on top of the image */
    top: 0;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background: transparent; /* Remove background color */
    color: white;
    z-index: 10;
  }

  header nav a {
    color: white;
    text-decoration: none;
    margin: 0 10px;
    font-weight: bold;
  }

  header nav a:hover {
    text-decoration: underline;
  }

  .logo {
    width: 50px;
    height: auto;
  }

  .spacer
  {
    height: 60px;
    margin: 50px 0; /* Add top and bottom margins to create space between sections */
  }

  
</style>

</head>
<body>
  <div class="background">
  <header>
    <a href="#"><img src="publishing.png" alt="Logo" class="logo"></a>
    <nav class="navbar navbar-expand-lg">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="project_root/dashboard.php">Admin Panel</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
        <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="#the-team">The Team </a></li>
       
      </ul>
    </nav>
  </header>
  </div>

  <div class="spacer"></div>
  <div class="content">
    <h2>Recent Publications</h2>
    <a href="view_all_published.php" class="btn btn-primary mb-3">View All Published</a>
    <div class="recent-container">
      <?php 
        require 'includes/db_connect.php';
        $display_essay = "SELECT * FROM essays LIMIT 6";
        $confirm_display = mysqli_query($connect, $display_essay);

        function getExcerpt($content, $wordLimit = 15) {
          $content = strip_tags($content); // Remove HTML Tags
          $words = explode(" ", $content); // Split into words
          $excerpt = array_slice($words, 0, $wordLimit); // Extract first n words
          return implode(" ", $excerpt) . '...';
        }

        while ($row = mysqli_fetch_assoc($confirm_display)) {
          $title = $row['title'];
          $date = $row['created_at'];
          $author = $row['author_name'];
          $content = $row['content'];
          $essay_id = $row['essay_id'];
          

          echo '<div class="recent-item">';
         
          echo "<h3>$title</h3>";
          echo "<p><strong>Date:</strong> $date</p>";
          echo "<p><strong>Author:</strong> $author</p>";
          echo "<p>" . getExcerpt($content) . "</p>";
          echo "<button onclick=\"location.href='read_more.php?read_more_id=$essay_id'\">Read More</button>";
          echo '</div>';
        }
      ?>
    </div>
  </div>

  <?php echo require 'team.php'; ?>
  
  <?php require 'about_us.php'; ?>

  <footer>
    <p>&copy; 2024 Our Platform. All rights reserved.</p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
