<?php
session_start();
require '../includes/db_connect.php';


// Initialize error messages
$error_username = '';
$error_password = '';
$error_message = '';

function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

if (isset($_POST['login'])) {
    $username = sanitize_input($_POST['username']);
    $password = $_POST['password'];

    // Validate username
    if (empty($username)) {
        $error_username = 'Username field can\'t be empty.';
    } elseif (!filter_var($username, FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
        $error_username = 'Invalid characters in username.';
    }

    // Validate password
    if (empty($password)) {
        $error_password = "Please insert your password.";
    }

    if (empty($error_username) && empty($error_password)) {
        $stmt = mysqli_prepare($connect, "SELECT * FROM authors WHERE username = ?");
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['password'];

            if (password_verify($password, $hashed_password)) {
                $_SESSION['auth'] = true;
                $_SESSION['message'] = "Login Successfully";
                header("Location: dashboard.php");
                exit();
            } else {
                $error_message = 'Invalid username or password.';
            }
        } else {
            $error_message = 'Invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .login-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h2 class="text-center">Admin Panel Login</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" autocomplete="off" required>
                <?php if ($error_username) { ?>
                    <small class="text-danger"><?php echo $error_username; ?></small>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" autocomplete="off" required>
                <?php if ($error_password) { ?>
                    <small class="text-danger"><?php echo $error_password; ?></small>
                <?php } ?>
            </div>
            <?php if ($error_message) { ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php } ?>
            <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
