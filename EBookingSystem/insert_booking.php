<?php
include 'db.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Get form data
$facility_id = $_POST['facility_id'];
$date = $_POST['date'];
$time_in = $_POST['time_in'];
$time_out = $_POST['time_out'];
$booked_by = $_POST['booked_by'];
$description = $_POST['description'];

// Conflict check: look for overlap on the same date
$sql_check = "SELECT * FROM bookings 
    WHERE facility_id = '$facility_id' 
    AND date = '$date' 
    AND (
        (time_in <= '$time_in' AND time_out > '$time_in') OR 
        (time_in < '$time_out' AND time_out >= '$time_out') OR
        ('$time_in' <= time_in AND '$time_out' >= time_out)
    ) AND status = 'Booked'";

$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    echo "<script>alert('Conflict: Facility is already booked during this time.'); window.history.back();</script>";
} else {
    // No conflict, insert booking
    $stmt = $conn->prepare("INSERT INTO bookings (facility_id, date, time_in, time_out, booked_by, description) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $facility_id, $date, $time_in, $time_out, $booked_by, $description);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
