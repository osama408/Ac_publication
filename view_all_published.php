<?php 
// Enable error reporting for debugging
ini_set('display_errors', 'off');
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View All Published</title>
  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icons link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
  <style>
   /* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #ffffff;
    color: #333;
}

/* Navbar Styles */
.navbar {
    background-color: #142d4c;
}

.navbar a {
    color: white !important;
    margin-right: 15px;
}

/* Dropdown Menu Styles */
.dropdown-menu .dropdown-item {
    background-color: #243749;
    color: #333;
    transition: background-color 0.3s, color 0.3s;
}

.dropdown-menu .dropdown-item:hover {
    background-color: #142d4c;
    color: #fff;
}

/* Content Styles */
.content {
    text-align: left;
    padding: 50px 20px;
}

.content h2 {
    color: #142d4c;
    margin-bottom: 20px;
}

/* Read More Button Styles */
.read-more {
    padding: 8px 12px;
    background: #142d4c;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s, color 0.3s, border 0.3s;
}

.read-more:hover {
    background: white;
    color: #142d4c;
    text-decoration: none;
    border: 1px solid #142d4c;
}

/* Footer Styles */
footer {
    background-color: #142d4c;
    color: white;
    text-align: center;
    padding: 10px 0;
    position: fixed;
    bottom: 0;
    width: 100%;
}

  </style>
</head>
<body>
<header>
  <div class="translate-container">
    <div id="google_translate_element"></div>
  </div>
</header>
<nav class="navbar navbar-expand-lg">
 
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home Page</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-book"></i> Select Category
        </a>
        <div class="dropdown-menu" aria-labelledby="categoryDropdown">
          <?php
          require 'includes/db_connect.php';
          $select_categories = "SELECT * FROM categories";
          $confirm_select_query = mysqli_query($connect, $select_categories);
          if ($confirm_select_query && mysqli_num_rows($confirm_select_query) > 0) {
            while ($row = mysqli_fetch_assoc($confirm_select_query)) {
              $cat_name = htmlspecialchars($row['cat_name']);
              echo "<a class='dropdown-item' href='?type_of_paper=" . urlencode($cat_name) . "'>$cat_name</a>";
            }
          } else {
            echo "<p class='dropdown-item'>No categories available.</p>";
          }
          ?>
        </div>
      </li>
    </ul>
  </div>
</nav>


<div class="content">
  <?php 
  $selected_type = isset($_GET['type_of_paper']) ? $_GET['type_of_paper'] : '';
  $query = "";
  $message = "";
  $result = null;
  $limit = 1000;
  $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
  $offset = ($page - 1) * $limit;

  if ($selected_type) {
    switch ($selected_type) {
      case 'Essays': $query = "SELECT * FROM essays WHERE category = 'Essays'"; $message = "Category: Essays"; break;
      case 'Reports': $query = "SELECT * FROM essays WHERE category = 'Reports'"; $message = "Category: Reports"; break;
      case 'Research Papers': $query = "SELECT * FROM essays WHERE category = 'Research Papers'"; $message = "Category: Research Papers"; break;
      case 'Politics Report': $query = "SELECT * FROM essays WHERE category = 'Politics Report'"; $message = "Category: Politics Report"; break;
      default: $message = "No valid category selected."; break;
    }

    if ($query) {
      $result = mysqli_query($connect, $query);
      if ($result) {
        $total_essays = mysqli_num_rows($result);
        $total_pages = ceil($total_essays / $limit);

        $query .= " LIMIT $limit OFFSET $offset";
        $result = mysqli_query($connect, $query);
      }
    }
  }

  function display_20_words($content, $wordLimit = 15) {
    $content = strip_tags($content);
    $words = explode(" ", $content);
    return implode(" ", array_slice($words, 0, $wordLimit)) . '...';
  }

  if ($selected_type && $result && mysqli_num_rows($result) > 0) {
    echo "<div class='row'>"; // Start row
    $counter = 0;

    while ($row = mysqli_fetch_assoc($result)) {
      echo "<div class='col-md-6'>"; // Half-width column
      echo "<div class='entry mb-4'>"; // Add margin-bottom for spacing
      echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
      echo "<p>" . display_20_words($row['content']) . "</p>";
      echo "<a href='read_more.php?read_more_id=" . urlencode($row['essay_id']) . "' class='read-more'>Read More</a>";
      echo "</div>"; // Close entry
      echo "</div>"; // Close column

      $counter++;
      if ($counter % 2 == 0) {
        echo "</div><div class='row'>"; // Close the current row and start a new one
      }
    }

    echo "</div>"; // Close the last row
  } elseif ($selected_type) {
    echo "<p>No records found for " . htmlspecialchars($selected_type) . ".</p>";
  }
  ?>
  <div class="pagination">
    <?php
    if ($selected_type && isset($page, $total_pages) && $page < $total_pages) {
      echo '<a href="?type_of_paper=' . urlencode($selected_type) . '&page=' . ($page + 1) . '" class="read-more">Show More</a>';
    }
    ?>
  </div>
</div>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
