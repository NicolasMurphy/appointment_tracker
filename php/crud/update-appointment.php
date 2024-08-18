<?php
require dirname(__DIR__) . '/Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $client = filter_input(INPUT_POST, 'client', FILTER_SANITIZE_SPECIAL_CHARS);
    $caregiver = filter_input(INPUT_POST, 'caregiver', FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
    $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
    $startTime = filter_input(INPUT_POST, 'startTime', FILTER_SANITIZE_SPECIAL_CHARS);
    $endTime = filter_input(INPUT_POST, 'endTime', FILTER_SANITIZE_SPECIAL_CHARS);
    $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($id === false || $id === null) {
        echo "Invalid appointment ID.";
        exit();
    }

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

            $sql = "UPDATE appointments SET client = :client, caregiver = :caregiver, address = :address, date = :date, startTime = :startTime, endTime = :endTime, notes = :notes WHERE id = :id";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':client', $client, PDO::PARAM_STR);
            $stmt->bindParam(':caregiver', $caregiver, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':startTime', $startTime, PDO::PARAM_STR);
            $stmt->bindParam(':endTime', $endTime, PDO::PARAM_STR);
            $stmt->bindParam(':notes', $notes, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header('Location: ../../');
                exit();
            } else {
                echo "Failed to update appointment.";
            }
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            echo "Error: Unable to update appointment.";
        }
    } else {
        echo "Invalid date or time format.";
    }
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id === false || $id === null) {
    echo "Invalid appointment ID.";
    exit();
}

try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();

    $stmt = $pdo->prepare("SELECT id, client, caregiver, address, date, TIME_FORMAT(startTime, '%H:%i') AS startTime, TIME_FORMAT(endTime, '%H:%i') AS endTime, notes FROM appointments WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$appointment) {
        echo "Appointment not found.";
        exit();
    }
} catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage());
    echo "Error: Unable to fetch appointment.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Appointment</title>
</head>

<body>
    <h1>Update Appointment</h1>
    <form method="POST" action="update-appointment.php?id=<?php echo htmlspecialchars($appointment['id']); ?>">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($appointment['id']); ?>">

        <label for="client">Client:</label><br>
        <input type="text" id="client" name="client" value="<?php echo htmlspecialchars($appointment['client']); ?>" required><br><br>

        <label for="caregiver">Caregiver:</label><br>
        <input type="text" id="caregiver" name="caregiver" value="<?php echo htmlspecialchars($appointment['caregiver']); ?>" required><br><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($appointment['address']); ?>" required><br><br>

        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($appointment['date']); ?>" required><br><br>

        <label for="startTime">Start Time:</label><br>
        <select id="startTime" name="startTime" data-start-time="<?php echo htmlspecialchars($appointment['startTime']); ?>" required></select><br><br>

        <label for="endTime">End Time:</label><br>
        <select id="endTime" name="endTime" data-end-time="<?php echo htmlspecialchars($appointment['endTime']); ?>" required></select><br><br>

        <label for="notes">Notes:</label><br>
        <textarea id="notes" name="notes"><?php echo htmlspecialchars($appointment['notes']); ?></textarea><br><br>

        <button type="submit">Update Appointment</button>
    </form>
    <script src="../../js/timeSelector.js"></script>
</body>

</html>
