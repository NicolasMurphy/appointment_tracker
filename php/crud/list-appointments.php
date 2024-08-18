<?php
require dirname(__DIR__) . '/Database.php';

try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();

    $stmt = $pdo->query("SELECT id, client, caregiver, address, date,
                                DATE_FORMAT(startTime, '%l:%i %p') AS startTime,
                                DATE_FORMAT(endTime, '%l:%i %p') AS endTime,
                                notes
                         FROM appointments
                         ORDER BY date, startTime");
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<ul id="appointment-list">';
    foreach ($appointments as $appointment) {
        echo '<li data-client="' . htmlspecialchars($appointment['client']) . '" data-caregiver="' . htmlspecialchars($appointment['caregiver']) . '" data-date="' . htmlspecialchars($appointment['date']) . '">';
        echo 'Client: ' . htmlspecialchars($appointment['client']) . ' - Caregiver: ' . htmlspecialchars($appointment['caregiver']) . ' - ' . htmlspecialchars($appointment['address']) . ' - ' . htmlspecialchars($appointment['date']) . ' from ' . htmlspecialchars($appointment['startTime']) . ' to ' . htmlspecialchars($appointment['endTime']) . ' - ' . htmlspecialchars($appointment['notes']);

        echo ' <a href="php/crud/update-appointment.php?id=' . htmlspecialchars($appointment['id']) . '">Edit</a>';

        echo ' <form method="POST" action="php/crud/delete-appointment.php" style="display:inline;">';
        echo '<input type="hidden" name="id" value="' . htmlspecialchars($appointment['id']) . '">';
        echo '<button type="submit">Delete</button>';
        echo '</form>';

        echo '</li>';
    }
    echo '</ul>';
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
