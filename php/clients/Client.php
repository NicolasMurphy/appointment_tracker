<?php

declare(strict_types=1);
require_once __DIR__ . '/../Database.php';

class Client
{
    private ?int $id = null;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $phoneNumber;
    private string $address;
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setDetails(
        string $firstName,
        string $lastName,
        string $email,
        string $phoneNumber,
        string $address,
    ): void {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
    }

    public function saveClient(): bool
    {
        try {
            $sql = "INSERT INTO clients (first_name, last_name, email, phone_number, address)
                        VALUES (:name, :email, :phone_number, :address)";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':first_name', $this->firstName, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $this->lastName, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindParam(':phone_number', $this->phoneNumber, PDO::PARAM_STR);
            $stmt->bindParam(':address', $this->address, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            throw new Exception('Failed to execute database operation.', 0, $e);
        }
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
                first_name,
                last_name,
                email,
                phone_number,
                address
            FROM
                clients
            ORDER BY
                last_name"
            );

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return [];
        }
    }

    public function fetchById(int $id): array|false
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT
                id,
                first_name,
                last_name,
                email,
                phone_number,
                address
            FROM
                clients"
            );
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: false;
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }
}
