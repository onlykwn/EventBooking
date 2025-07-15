<?php
session_start();

$conn = new mysqli("localhost", "root", "", "ebookingsystem");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// db.php - Database connection setup
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ebookingsystem";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
