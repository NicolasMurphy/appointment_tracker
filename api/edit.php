<?php
require 'db_connect.php';

// Fetch existing appointment data for editing
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT * FROM appointments WHERE id = :id";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $appointment = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
    unset($stmt);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate POST data
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
    $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_STRING);

    // Before the validation checks
    echo "Date: $date, Time: $time";

    // Validate date and time format
    if (!validateDate($date) || !validateTime($time)) {
        echo "Invalid date or time format.";
        exit;
    }

    // Prepare an update statement
    $sql = "UPDATE appointments SET title = :title, description = :description, date = :date, time = :time WHERE id = :id";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);

        if ($stmt->execute()) {
            echo "Appointment updated successfully.";
        } else {
            echo "Error updating appointment.";
        }
    }

    unset($stmt);
    header('Location: index.php');
    exit;
}

// Function to validate date format
function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

// Function to validate time format
function validateTime($time, $format = 'H:i:s') {
    $t = DateTime::createFromFormat($format, $time);
    return $t && $t->format($format) === $time;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Appointment</title>
    <!-- Add any additional head elements here -->
</head>
<body>
    <h1>Edit Appointment</h1>

    <form action="edit.php?id=<?php echo $id; ?>" method="post">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo $appointment['title']; ?>" required><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description"><?php echo $appointment['description']; ?></textarea><br>

        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" value="<?php echo $appointment['date']; ?>" required><br>

        <label for="time">Time:</label><br>
        <input type="time" id="time" name="time" value="<?php echo $appointment['time']; ?>" required><br>

        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <input type="submit" value="Submit">
    </form>

    <a href="index.php">Back to Appointment List</a>
</body>
</html>
