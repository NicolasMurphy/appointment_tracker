<?php

declare(strict_types=1);

namespace Database;

use PDO;
use PDOException;
use Dotenv\Dotenv;

require_once '/var/www/html/vendor/autoload.php'; // docker
// require_once __DIR__ . '/../vendor/autoload.php'; // local

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $dotenv = Dotenv::createImmutable('/var/www/html'); // docker
        // $dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // local
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log('Database connection failed: ' . $e->getMessage());
            die('Database connection failed.');
        }
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
