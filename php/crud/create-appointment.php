<?php
require dirname(__DIR__) . '/Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client = filter_input(INPUT_POST, 'client', FILTER_SANITIZE_SPECIAL_CHARS);
    $caregiver = filter_input(INPUT_POST, 'caregiver', FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
    $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
    $startTime = filter_input(INPUT_POST, 'startTime', FILTER_SANITIZE_SPECIAL_CHARS);
    $endTime = filter_input(INPUT_POST, 'endTime', FILTER_SANITIZE_SPECIAL_CHARS);
    $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS);

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    function validateTime($time, $format = 'H:i')
    {
        $t = DateTime::createFromFormat($format, $time);
        return $t && $t->format($format) === $time;
    }

    if (validateDate($date) && validateTime($startTime) && validateTime($endTime)) {
        try {
            $db = Database::getInstance();
            $pdo = $db->getConnection();

            $sql = "INSERT INTO appointments (client, caregiver, address, date, startTime, endTime, notes) VALUES (:client, :caregiver, :address, :date, :startTime, :endTime, :notes)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':caregiver', $caregiver, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':startTime', $startTime, PDO::PARAM_STR);
            $stmt->bindParam(':endTime', $endTime, PDO::PARAM_STR);
            $stmt->bindParam(':notes', $notes, PDO::PARAM_STR);

            if ($stmt->execute()) {
                header('Location: ../../');
                exit();
            } else {
                echo "Failed to create appointment.";
            }
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            echo "Error: Unable to create appointment.";
        }
    } else {
        echo "Invalid date or time format.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Appointment</title>
</head>

<body>
    <h1>Create New Appointment</h1>
    <form method="POST" action="create-appointment.php">
        <label for="client">Client:</label><br>
        <input type="text" id="client" name="client" required><br><br>

        <label for="caregiver">Caregiver:</label><br>
        <input type="text" id="caregiver" name="caregiver" required><br><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" required><br><br>

        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" required><br><br>

        <label for="startTime">Start Time:</label><br>
        <input type="time" id="startTime" name="startTime" required><br><br>

        <label for="endTime">End Time:</label><br>
        <input type="time" id="endTime" name="endTime" required><br><br>

        <label for="notes">Notes:</label><br>
        <textarea id="notes" name="notes"></textarea><br><br>

        <button type="submit">Create Appointment</button>
    </form>
</body>

</html>
