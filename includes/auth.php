# Author authentication and session management
# Functions for handling CRUD operations

<?php

session_start();

function CheckAdminAccess()
{
    if(!isset($_SESSION['user_id'] || $_SESSION['role'] !== 'admin'))
    {
        header("Location: ../project_root/login.php");
    }
    exit();
}

?>