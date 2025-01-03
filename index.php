<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- bootstrap  -->
   <link rel="stylesheet" href="main_page.css">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- icons  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
  <!-- fontawesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  <title>Main Page</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      margin: 0;
      padding: 0;
      background: #ffffff;
      color: #333;
    }
    header {
      background: #142d4c;
      color: white;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    header nav a {
      color: white;
      text-decoration: none;
      margin: 0 10px;
    }
    header nav a:hover {
      text-decoration: underline;
    }
    
    .logo {
    width: 50px; /* Adjust size as needed */
    height: auto;
}
    footer {
      background: #142d4c;
      color: white;
      text-align: center;
      padding: 10px 0;
      margin-top: 40px;
    }
  </style>
</head>
<body>
  <header>
  <a href="#"><img src="publishing.png" alt="Logo" class="logo"></a>

    <nav class="navbar navbar-expand-lg">
      <ul class="navbar-nav">
<!--       <li class="nav-item"><a class="nav-link" href="project_root/login.php">Admin Panel</a></li> -->
        <li class="nav-item"><a class="nav-link" href="#about-us">About Us</a></li>
<!--         <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li> -->
        
        <!-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Language
          </a>
          <div class="dropdown-menu" aria-labelledby="languageDropdown">
            <a class="dropdown-item" href="#">English</a>
            <a class="dropdown-item" href="#">Arabic</a>
          </div>
        </li> -->
      </ul>
    </nav>
  </header>
  <div class="content">
    <h2>Recent Published</h2>
    <a href="view_all_published.php" class="btn btn-primary">view all published</a>


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

    $counter = 0; // Initialize counter to track essay positioning
    echo '<div class="row">'; // Open the first row
    while ($row = mysqli_fetch_assoc($confirm_display)) {
        $title = $row['title'];
        $date = $row['created_at'];
        $author = $row['author_name'];
        $content = $row['content'];
        $essay_id = $row['essay_id']; // Assuming there's an 'essay_id' column

        // Display each essay
        echo '<div class="recent-item">';
        echo "<h3>Title: $title</h3>";
        echo "<p>Date: $date</p>";
        echo "<p>Publisher: $author</p>";
        echo "<p>" . getExcerpt($content) . "</p>";
        echo "<button onclick=\"location.href='read_more.php?read_more_id=$essay_id'\">Read More</button>";
        echo '</div>';

        $counter++; // Increment counter

        // Start a new row every two essays
        if ($counter % 2 == 0 && $counter != 0) {
            echo '</div><div class="row">'; // Close and open a new row
        }
    }
    echo '</div>'; // Close the final row
  ?>
</div>





      <?php echo require 'team.php';?>

    <?php //require 'contact_us.php'; ?>

    <?php require 'about_us.php'; ?>

  <footer>
    <p>&copy; 2024 Our Platform. All rights reserved.</p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
