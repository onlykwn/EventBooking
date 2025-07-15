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

if (!isset($_GET['id'])) {
    echo "No booking ID provided.";
    exit;
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM bookings WHERE booking_id = '$id'");
$booking = $result->fetch_assoc();

if (!$booking) {
    echo "Booking not found.";
    exit;
}

$facilities = $conn->query("SELECT * FROM facilities");
?>

<!-- Keep your PHP code as is -->

<!DOCTYPE html>
<html>
<head>
    <title>Edit Booking</title>
    <link rel="stylesheet" href="style.css">
    <style>
    .btn-cancel {
        background: #a17c61;
        color: white;
        padding: 8px 16px;
        border-radius: 5px;
        display: inline-block;
        margin-left: 10px;
        margin-top: 10px;
        text-decoration: none !important; /* FORCE remove underline */
    }

    .btn-cancel:hover {
        background: #8c6750;
    }

    .form-buttons {
        margin-top: 10px;
        text-align: right; /* ✅ Align buttons to the right */
    }

    .form-buttons input[type="submit"] {
        padding: 8px 16px;
        background: #a17c61;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .form-buttons input[type="submit"]:hover {
        background: #8c6750;
    }
</style>

</head>
<body>
<div class="container form-page">
    <h2>Edit Booking</h2>
    <form method="POST" action="update_booking.php">
        <input type="hidden" name="booking_id" value="<?= $booking['booking_id'] ?>">

        <!-- Form fields -->
        <div class="form-row">
            <div class="form-group half">
                <label>Facility:</label>
                <select name="facility_id" required>
                    <?php while($f = $facilities->fetch_assoc()): ?>
                        <option value="<?= $f['facility_id'] ?>" <?= $f['facility_id'] == $booking['facility_id'] ? 'selected' : '' ?>>
                            <?= $f['name'] . ' - ' . $f['location'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group half">
                <label>Time In:</label>
                <input type="time" name="time_in" value="<?= $booking['time_in'] ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group half">
                <label>Date:</label>
                <input type="date" name="date" value="<?= $booking['date'] ?>" required>
            </div>

            <div class="form-group half">
                <label>Time Out:</label>
                <input type="time" name="time_out" value="<?= $booking['time_out'] ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group full">
                <label>Booked By:</label>
                <input type="text" name="booked_by" value="<?= $booking['booked_by'] ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group full">
                <label>Description:</label>
                <textarea name="description" rows="4" required><?= $booking['description'] ?></textarea>
            </div>
        </div>

        <!-- Submit -->
        <div class="form-buttons">
            <input type="submit" value="Update Booking">
            <a href="index.php" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>
