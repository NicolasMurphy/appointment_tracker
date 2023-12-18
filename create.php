<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Appointment</title>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'db_connect.php';

    // Validate and sanitize inputs
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
    $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_STRING);

    // Validate date and time format (add your own validation logic here)
    if (!validateDate($date) || !validateTime($time)) {
        echo "Invalid date or time format.";
        exit;
    }

    // Prepare an insert statement
    $sql = "INSERT INTO appointments (title, description, date, time) VALUES (:title, :description, :date, :time)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to index.php after successful insertion
            header('Location: index.php');
            exit;
        } else {
            echo "Error adding appointment.";
        }
    }

    // Close statement
    unset($stmt);

    // Close connection
    unset($conn);
}

// Function to validate date format
function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

// Function to validate time format
function validateTime($time, $format = 'H:i') {
    $t = DateTime::createFromFormat($format, $time);
    return $t && $t->format($format) === $time;
}
?>

</head>
<body>
    <h1>Add New Appointment</h1>

    <form action="create.php" method="post">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description"></textarea><br>

        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" required><br>

        <label for="time">Time:</label><br>
        <input type="time" id="time" name="time" required><br>

        <input type="submit" value="Submit">
    </form>

    <a href="index.php">Back to Appointment List</a>
</body>
</html>
