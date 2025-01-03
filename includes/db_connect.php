<?php
session_start();


$jawsdb_url = getenv('JAWSDB_URL');


$dbparts = parse_url($jawsdb_url);

$hostname = $dbparts['host'];
$username = $dbparts['user'];
$password = $dbparts['pass'];
$database = ltrim($dbparts['path'], '/');

// Create connection
$connect = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}
?>
