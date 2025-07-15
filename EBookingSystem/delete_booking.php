<?php
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Restrict delete to staff/admin only
if ($_SESSION['role'] === 'student') {
    echo "Access denied. Students are not allowed to delete bookings.";
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM bookings WHERE booking_id = $id");
    header("Location: index.php");
    exit();
}
?>
