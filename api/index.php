<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Only for development!

require 'db_connect.php';

try {
    $sql = "SELECT * FROM appointments";
    $result = $conn->query($sql);

    $appointments = [];
    if ($result->rowCount() > 0) {
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $appointments[] = $row;
        }
    }

    echo json_encode($appointments);
} catch (PDOException $e) {
    // Send a HTTP 500 response if there's a database error
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

$conn = null;
?>
