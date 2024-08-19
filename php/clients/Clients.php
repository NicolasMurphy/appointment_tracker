<?php

declare(strict_types=1);
require_once __DIR__ . '/../Database.php';

class Client
{
    private ?int $id = null;
    private string $name;
    private string $email;
    private string $phoneNumber;
    private string $address;
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @return array<array<string, string>>
     */
    public function fetchAll(): array
    {
        try {
            $stmt = $this->db->query(
                "SELECT
                id,
                name,
                email,
                phone_number,
                address
            FROM
                clients
            ORDER BY
                name"
            );

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return [];
        }
    }
}
