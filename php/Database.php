<?php

declare(strict_types=1);

namespace Database;

use PDO;
use PDOException;
use Dotenv\Dotenv;

if (defined('PHPUNIT_COMPOSER_INSTALL') || defined('__PHPUNIT_PHAR__')) {
    require_once __DIR__ . '/../vendor/autoload.php'; // local
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
} else {
    require_once '/var/www/html/vendor/autoload.php'; // docker
    $dotenv = Dotenv::createImmutable('/var/www/html');
}
$dotenv->load();

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $dbType = 'test';

        if ($dbType === 'test') {
            $host = $_ENV['TEST_DB_HOST'];
            $port= $_ENV['TEST_DB_PORT'];
            $dbname = $_ENV['TEST_DB_NAME'];
            $user = $_ENV['TEST_DB_USER'];
            $pass = $_ENV['TEST_DB_PASS'];
        } else {
            $host = $_ENV['DB_HOST'];
            $port= $_ENV['DB_PORT'];
            $dbname = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASS'];
        }

        try {
            $this->pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
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
