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

// Handle selected date or default to today
$filter_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Get booked facilities for the selected date
$booked_result = $conn->query("
    SELECT b.*, f.name, f.location 
    FROM bookings b 
    JOIN facilities f ON b.facility_id = f.facility_id 
    WHERE b.status = 'Booked' AND b.date = '$filter_date'
    ORDER BY b.time_in
");

// Get facility list for dropdown
$facilities = $conn->query("SELECT * FROM facilities");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Booking</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .two-column-layout {
            display: flex;
            gap: 20px;
        }
        .left-booked-list {
            flex: 1;
            background: #fff5eb;
            padding: 20px;
            border-radius: 10px;
            max-height: 600px;
            overflow-y: auto;
        }
        .right-form {
            flex: 1.3;
        }
        .booked-item {
            background: #fefcf9;
            padding: 10px;
            border-left: 4px solid #a97b5c;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .booked-item strong {
            color: #7a4f36;
        }
        .filter-form {
            margin-bottom: 15px;
        }
        .filter-form input[type="date"] {
    padding: 6px 12px;
    width: 75%;
    border-radius: 6px;
    border: 1px solid #cdbba7;
    font-size: 14px;
}

        .filter-form button {
            padding: 6px 12px;
            background-color: #a17c61;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-left: 10px;
        }
        .filter-form button:hover {
            background-color: #8c6d56;
        }
    </style>
</head>
<body>
<div class="container form-page">
    <a href="index.php" style="text-decoration: none; font-size: 14px;">&larr; Back to Booking List</a>
    <h2>Add New Booking</h2><br>   
    <div class="two-column-layout">
        <!-- ✅ Booked Facilities with Date Filter -->
        <div class="left-booked-list">
            <form class="filter-form" method="GET" action="add_booking.php">
    <label><strong>View Booked Facilities On:</strong></label><br>
    <input type="date" name="date" value="<?= $filter_date ?>" required>
    <button type="submit" style="
    float: right;
    padding: 6px 26px;
    font-size: 14px;
    border-radius: 6px;
    background-color: #a17c61;
    color: white;
    border: none;
    cursor: pointer;
    ">Filter</button>
</form>
            <h3>Booked on <?= $filter_date ?></h3>
            <?php
            if ($booked_result->num_rows > 0) {
                while ($row = $booked_result->fetch_assoc()) {
                    echo "<div class='booked-item'>
                        <strong>{$row['name']} - {$row['location']}</strong><br>
                        Time: {$row['time_in']} - {$row['time_out']}<br>
                        By: {$row['booked_by']}
                    </div>";
                }
            } else {
                echo "<p>No bookings found on this date.</p>";
            }
            ?>
        </div>

        <!-- ✅ Booking Form -->
        <div class="right-form">
            <form method="POST" action="insert_booking.php">
                <div class="form-row">
                    <div class="form-group half">
                        <label>Facility:</label>
                        <select name="facility_id" required>
                            <option value="">--Select Facility--</option>
                            <?php while ($f = $facilities->fetch_assoc()): ?>
                                <option value="<?= $f['facility_id'] ?>">
                                    <?= $f['name'] ?> - <?= $f['location'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group half">
                        <label>Time In:</label>
                        <input type="time" name="time_in" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label>Date:</label>
                        <input type="date" name="date" required>
                    </div>

                    <div class="form-group half">
                        <label>Time Out:</label>
                        <input type="time" name="time_out" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group full">
                        <label>Booked By:</label>
                        <input type="text" name="booked_by" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group full">
                        <label>Description:</label>
                        <textarea name="description" rows="4" required></textarea>
                    </div>
                </div>

                <input type="submit" value="Book Facility">
            </form>
        </div>

    </div>
</div>
</body>
</html>

