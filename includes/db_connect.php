<?php
$localhost = "localhost";
$username = "root";
$password = "";
$dbname = "publish_an_essay";

$connect = new mysqli($localhost,$username,$password,$dbname);

if($connect->connect_error)
{
   die("Connection Failed: ". $connect->connect_error);
}



?>

<?php

?>