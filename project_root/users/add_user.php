<?php
require '../../includes/db_connect.php';
session_start();

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirect to login page if not authenticated
    header("location: ../login.php");
    exit;
}


// Initialize variables for error messages
$username_message = '';
$password_message = '';
$success_message = '';
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $user_role = $_POST['role'];
    
    // Validate inputs
    if (empty($username) || strlen($username) < 6) {
        $username_message = "Username must be at least 6 characters";
        $errors[] = true;
    }

    if (empty($password) || strlen($password) < 6) {
        $password_message = "Password must be at least 6 characters";
        $errors[] = true;
    }

    // Set default user role if none is selected
    if (empty($user_role)) {
        $user_role = 'none';
    }

   
    // Proceed if there are no validation errors
    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Check for duplicate usernames
        $dublicate = "SELECT * FROM authors WHERE username = ?";
        $stmt_duplicate = mysqli_prepare($connect, $dublicate);
        mysqli_stmt_bind_param($stmt_duplicate, 's', $username);
        mysqli_stmt_execute($stmt_duplicate);
        $result = mysqli_stmt_get_result($stmt_duplicate);
        
        if (mysqli_num_rows($result) > 0) {
            $username_message = 'The username is already taken.';
            $username = ''; // Clear the username field
            $password = ''; // Clear the password field (optional, for completeness)
        } else {
            // Insert new user into the database
            $insert_user = "INSERT INTO authors (username, password, role) VALUES (?, ?, ?);";
            $stmt_insert = mysqli_prepare($connect, $insert_user);
            mysqli_stmt_bind_param($stmt_insert, 'sss', $username, $password_hash, $user_role);
            
            if (mysqli_stmt_execute($stmt_insert)) {
                $success_message = 'User added successfully!';
                header("Location: ../dashboard.php");
                exit();
            } else {
                die("Failed to insert new user: " . mysqli_error($connect));
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .add-user-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
    </style>
</head>
<body>
    <div class="add-user-form">
        <h2 class="text-center">Add User</h2>
        <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" value="<?php echo isset($username_message) ? '' : htmlspecialchars($username); ?>" autocomplete="off" required>
        <?php if ($username_message) { ?>
            <small class="text-danger"><?php echo $username_message; ?></small>
        <?php } ?>
    </div>

    <div class="form-group">
        <label for="role">User Role</label>
        <select class="form-control" name="role" required>
            <option value="admin">Admin</option>
            <!-- <option value="normal_user">Normal User</option> -->
        </select>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" placeholder="Type Your Password" required>
        <?php if ($password_message) { ?>
            <small class="text-danger"><?php echo $password_message; ?></small>
        <?php } ?>
    </div>

    <?php if ($success_message) { ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php } ?>

    <button type="submit" class="btn btn-primary btn-block" name="add_user">Add User</button>
</form>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
