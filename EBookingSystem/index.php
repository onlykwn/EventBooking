<?php 
include 'db.php'; 
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Display logged in role (red-maroon themed)
echo "<div style='text-align:right; padding: 10px; font-weight: bold; font-family: Arial;'>
Logged in as: <span style='color:#8b2f33'>" . ucfirst($_SESSION['role']) . "</span>
</div>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking List</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .btn {
            color: #912d2b;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.2s ease;
        }
    </style>
</head>
<body>
<div class="container home-page">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2 style="color: #7c2e2e;">FACILITY BOOKING LIST</h2>
        <div>
            <?php if ($_SESSION['role'] !== 'student') { ?>
                <a href="add_booking.php" class="btn">+ Add New Booking</a>
            <?php } ?>
            <a href="logout.php" class="btn" style="margin-left: 10px;">Logout</a>
        </div>
    </div>

    <br>

    <table border="1" cellpadding="8">
        <tr>
            <th>Facility</th>
            <th>Date</th>
            <th>Time</th>
            <th>Booked By</th>
            <th>Description</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php
        $sql = "SELECT b.*, f.name, f.location 
                FROM bookings b 
                JOIN facilities f ON b.facility_id = f.facility_id 
                ORDER BY b.date, b.time_in";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $status_class = $row['status'] == 'Booked' ? 'status-booked' : 'status-available';

            echo "<tr>
                <td>{$row['name']} - {$row['location']}</td>
                <td>{$row['date']}</td>
                <td>{$row['time_in']} - {$row['time_out']}</td>
                <td>{$row['booked_by']}</td>
                <td>{$row['description']}</td>
                <td class='$status_class'>{$row['status']}</td>
                <td class='button-action'>";

            if ($row['status'] == 'Booked') {
                if ($_SESSION['role'] !== 'student') {
                    echo '<div class="action-buttons">
                            <a href="edit_booking.php?id=' . $row['booking_id'] . '">Edit</a>
                            <a href="mark_available.php?id=' . $row['booking_id'] . '">Mark as Available</a>
                          </div>';
                } else {
                    echo "<em>N/A</em>";
                }
            } else {
                if ($_SESSION['role'] !== 'student') {
                    echo '<div class="action-buttons">
                            <a href="edit_booking.php?id=' . $row['booking_id'] . '">Edit</a>
                            <a href="delete_booking.php?id=' . $row['booking_id'] . '" onclick="return confirm(\'Are you sure you want to delete this booking?\');">Delete</a>
                          </div>';
                } else {
                    echo "<em>N/A</em>";
                }
            }

            echo "</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
