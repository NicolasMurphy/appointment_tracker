<?php
require 'db_connect.php';

// Fetch existing appointment data
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM appointments WHERE id = :id";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $appointment = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
    // Close statement
    unset($stmt);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming the 'id' is being sent via a hidden input in the form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Prepare an update statement
    $sql = "UPDATE appointments SET title = :title, description = :description, date = :date, time = :time WHERE id = :id";

    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            echo "Appointment updated successfully.";
        } else {
            echo "Error updating appointment.";
        }
    }

    // Close statement
    unset($stmt);

    // After updating, redirect back to index.php
    header('Location: index.php');
    exit;
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
