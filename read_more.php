<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Read More Page</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      margin: 0;
      padding: 0;
      background: #f8f9fa;
      color: #333;
    }
    header {
      background: #142d4c;
      color: white;
      padding: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    header a {
      color: white;
      text-decoration: none;
      margin: 0 10px;
    }
    header a:hover {
      text-decoration: underline;
    }
    .content {
      padding: 20px;
    }
    .content h1 {
      font-size: 2rem;
      margin-bottom: 20px;
    }
    .content p {
      margin-bottom: 20px;
    }
    .search-bar {
      margin: 20px 0;
      text-align: center;
    }
    .search-bar input[type="text"] {
      padding: 10px;
      width: 80%;
      max-width: 500px;
      border: 1px solid #ddd;
      border-radius: 8px;
    }
    .search-bar .search-button {
      padding: 5px 10px;
      font-size: 14px;
      max-width: 100px;
      border: 1px solid #ddd;
      border-radius: 8px;
      cursor: pointer;
    }
    .buttons {
      margin-top: 30px;
      text-align: center;
    }
    .buttons a {
      text-decoration: none;
      color: white;
      background: #142d4c;
      padding: 10px 15px;
      border-radius: 5px;
      margin: 5px;
      display: inline-block;
      border: 2px solid #142d4c;
    }
    .buttons a:hover {
      background: white;
      color: #142d4c;
    }
    .goog-te-gadget-simple {
    background-color: #FFF;
    border-left: 1px solid #D5D5D5;
    border-top: 1px solid #9B9B9B;
    border-bottom: 1px solid #E8E8E8;
    border-right: 1px solid #D5D5D5;
    font-size: 10pt;
    display: inline-block;
    padding-top: 1px;
    padding-bottom: 4px;
    cursor: pointer;
    margin-left: 10px;
    border-radius: 9px;
}
.logo {
    width: 50px; /* Adjust size as needed */
    height: auto;
}
    .google_translate_element
    {
      background:#142d4c;
    }
    .highlight {
      color: rgb(224, 68, 40);
      font-weight: bold;
    }
  </style>
</head>
<body>
  <header>
  <div class="translate-container">
    <div id="google_translate_element"></div>
  </div>
    <h1>Read More Page</h1>
    <a href="index.php"><img src="publishing.png" alt="Logo" class="logo"></a>
  </header>

  <?php
  require 'includes/db_connect.php';

  // Hide errors
ini_set('display_errors', 'Off');
ini_set('error_reporting', E_ALL);
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);



  // Function to highlight search term
  function highlightTerm($text, $term) {
      return preg_replace("/($term)/i", "<span class='highlight'>$1</span>", $text);
  }

  $title = '';
  $content = '';
  $author = '';
  $date = '';
  $file_name = '';
  $search = '';
  $no_results = false;

  if (isset($_GET['read_more_id'])) {
    $essay_id = $_GET['read_more_id'];
    
    $stmt = $connect->prepare("SELECT * FROM essays WHERE essay_id = ? LIMIT 1");
    $stmt->bind_param("s", $essay_id); // "s" indicates the parameter type is a string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<p style='text-align: center;'>Essay not found.</p>";
    } else {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $content = $row['content'];
        $author = $row['author_name'];
        $date = $row['created_at'];
        $file_name = $row['file_name'];


        // Remove \r\n
        
        $content = nl2br($content); // Convert \r\n to <br> for display


        // Process content highlighting
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
            $search = trim($_POST['search']);
            if (!empty($search) && stripos($content, $search) !== false) {
                $content = highlightTerm($content, $search);
            } else {
                $no_results = true;
            }
        }
    }
}
  ?>

  <form action="" method="POST">
    <div class="content">
      <div class="search-bar">
        <input type="text" name="search" placeholder="Search for specific words..." value="<?php echo htmlspecialchars($search); ?>">
        <input type="submit" class="search-button" value="Search">
      </div>
    </form>

    <?php if ($no_results): ?>
      <p class="no-results">No matching words found for <strong><?php echo htmlspecialchars($search); ?></strong>.</p>
    <?php endif; ?>

    <h1><?php echo htmlspecialchars($title); ?></h1>
    <p class="meta-info"><strong>Date:</strong> <?php echo htmlspecialchars($date); ?> | <strong>Publisher:</strong> <?php echo htmlspecialchars($author); ?></p>
    <p><?php echo strip_tags($content, '<\r><\n><p><br><strong><em><img><ul><li><ol><h1><h2><h3><h4><h5><h6><a><span>'); ?></p>

    <div class="buttons">
    <?php if (!empty($file_name) && file_exists("assets/book/" . $file_name)): ?>
    <a href="assets/book/<?php echo rawurlencode($file_name); ?>" download>Download Essay</a>
  <?php else: ?>
    <p>Sorry, this file is not currently available for download.</p>
  <?php endif; ?>

      <a href="index.php">Home Page</a>
    </div>
  </div>

  <!-- translation -->
  <script type="text/javascript">
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,ar,fr,th',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
      }, 'google_translate_element');
    }
  </script>
  <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</body>
</html>
