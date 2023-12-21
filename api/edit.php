<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Only for development!
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require 'db_connect.php';

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

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Preflight request, just return 200 OK
    http_response_code(200);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = json_decode(file_get_contents('php://input'), true);

    // Sanitize and validate POST data
    $id = filter_var($input['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($input['title'], FILTER_SANITIZE_STRING);
    $description = filter_var($input['description'], FILTER_SANITIZE_STRING);
    $date = filter_var($input['date'], FILTER_SANITIZE_STRING);
    $time = filter_var($input['time'], FILTER_SANITIZE_STRING);

    if (!validateDate($date) || !validateTime($time)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid date or time format.']);
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
            echo json_encode(['message' => 'Appointment updated successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error updating appointment.']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error preparing statement.']);
    }

    unset($stmt);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed.']);
}

// Close connection
unset($conn);
?>
