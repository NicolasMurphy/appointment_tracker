<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Only for development!

require 'db_connect.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $sql = "SELECT * FROM appointments WHERE id = :id";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $appointment = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($appointment);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error fetching appointment.']);
        }
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error preparing statement.']);
    }
    unset($stmt);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid appointment ID.']);
}

unset($conn);
?>
