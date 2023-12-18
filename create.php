<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Appointment</title>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'db_connect.php';

    // Prepare an insert statement
    $sql = "INSERT INTO appointments (title, description, date, time) VALUES (:title, :description, :date, :time)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);

        // Set parameters and execute
        $title = $_POST["title"];
        $description = $_POST["description"];
        $date = $_POST["date"];
        $time = $_POST["time"];

        if ($stmt->execute()) {
            echo "Appointment added successfully.";
        } else {
            echo "Error adding appointment.";
        }
    }

    // Close statement
    unset($stmt);

    // Close connection
    unset($conn);
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
