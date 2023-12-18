<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointment Tracker</title>
    <!-- Add any additional head elements here -->
</head>
<body>
    <h1>Appointment Tracker</h1>
    <a href="create.php">Schedule New Appointment</a>
    <hr>

    <?php
    // Include your database connection file here
    require 'db_connect.php';

    // Fetch appointments from database
    $sql = "SELECT * FROM appointments";
    $result = $conn->query($sql);

    // Check if there are any appointments
    if ($result->rowCount() > 0) {
        // Output data of each row
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // Display appointment details
            echo "Date: " . $row["date"] . " - Title: " . $row["title"] . "<br>";
            // Add edit and delete links here
        }
    } else {
        echo "No appointments scheduled.";
    }

    // Close database connection
    $conn = null;
    ?>

</body>
</html>
