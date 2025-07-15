<?php
include 'db.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'staff') {
    echo "Access denied. Only staff or admin can access this page.";
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("UPDATE bookings SET status='Available' WHERE booking_id='$id'");
}

header("Location: index.php");
?>
