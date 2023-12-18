<?php
require 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare a delete statement
    $sql = "DELETE FROM appointments WHERE id = :id";

    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            echo "Appointment deleted successfully.";
        } else {
            echo "Error deleting appointment.";
        }
    }

    // Close statement
    unset($stmt);
} else {
    echo "No ID provided for deletion.";
}

// Close connection
unset($conn);

// Redirect to index.php
header('Location: index.php');
exit;
?>
