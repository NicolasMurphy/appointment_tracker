<?php
header('Content-Type: application/json');

require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Preflight request, just return 200 OK
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Parse the input to get the appointment ID
    parse_str(file_get_contents("php://input"), $input);
    $id = $input['id'] ?? null;

    if ($id) {
        // Prepare a delete statement
        $sql = "DELETE FROM appointments WHERE id = :id";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                echo json_encode(['message' => 'Appointment deleted successfully.']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error deleting appointment.']);
            }
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error preparing statement.']);
        }

        // Close statement
        unset($stmt);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'No ID provided for deletion.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed.']);
}

// Close connection
unset($conn);
