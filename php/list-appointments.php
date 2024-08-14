<?php
require '/var/www/html/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('/var/www/html');
$dotenv->load();

$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT id, title, description, address, date, time FROM appointments ORDER BY date, time");
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<ul id="appointment-list">';
    foreach ($appointments as $appointment) {
        echo '<li data-title="' . htmlspecialchars($appointment['title']) . '" data-date="' . htmlspecialchars($appointment['date']) . '">';
        echo htmlspecialchars($appointment['title']) . ' - ' . htmlspecialchars($appointment['description']) . ' - ' . htmlspecialchars($appointment['address']) . ' - ' . htmlspecialchars($appointment['date']) . ' at ' . htmlspecialchars($appointment['time']);
        echo '</li>';
    }
    echo '</ul>';
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
