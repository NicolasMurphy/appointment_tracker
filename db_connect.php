<?php
$servername = "localhost";
$username = "user";
$password = ""; // make env
$dbname = "user";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Removed the echo statement for successful connection
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
