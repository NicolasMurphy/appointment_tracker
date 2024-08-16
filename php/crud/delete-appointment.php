<?php
require dirname(__DIR__) . '/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id === false || $id === null) {
        echo "Invalid appointment ID.";
        exit();
    }

    try {
        $sql = "DELETE FROM appointments WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header('Location: ../../');
            exit();
        } else {
            echo "Failed to delete appointment.";
        }
    } catch (PDOException $e) {
        error_log('Database error: ' . $e->getMessage());
        echo "Error: Unable to delete appointment.";
    }
}
