<?php
require dirname(__DIR__) . '/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
    $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
    $time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_SPECIAL_CHARS);

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

    if (validateDate($date) && validateTime($time)) {
        try {
            $sql = "UPDATE appointments SET title = :title, description = :description, address = :address, date = :date, time = :time WHERE id = :id";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':time', $time, PDO::PARAM_STR);
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
    $stmt = $pdo->prepare("SELECT id, title, description, address, date, TIME_FORMAT(time, '%H:%i') AS time FROM appointments WHERE id = :id");
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

        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($appointment['title']); ?>" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($appointment['description']); ?></textarea><br><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($appointment['address']); ?>" required><br><br>

        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($appointment['date']); ?>" required><br><br>

        <label for="time">Time:</label><br>
        <input type="time" id="time" name="time" value="<?php echo htmlspecialchars($appointment['time']); ?>" required><br><br>

        <button type="submit">Update Appointment</button>
    </form>
</body>

</html>
