<?php
include 'db.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['booking_id'];
    $facility_id = $_POST['facility_id'];
    $date = $_POST['date'];
    $time_in = $_POST['time_in'];
    $time_out = $_POST['time_out'];
    $booked_by = $_POST['booked_by'];
    $description = $_POST['description'];

    $sql = "UPDATE bookings SET 
                facility_id = '$facility_id',
                date = '$date',
                time_in = '$time_in',
                time_out = '$time_out',
                booked_by = '$booked_by',
                description = '$description',
                status = 'Booked'
            WHERE booking_id = '$id'";

    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Error updating booking: " . $conn->error;
    }
}
?>
