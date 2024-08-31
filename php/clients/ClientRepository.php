<?php

declare(strict_types=1);

namespace Clients;

use PDO;
use PDOException;
use Exception;

class ClientRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(Client $client): bool
    {

        if ($this->isDuplicateName($client->getFirstName(), $client->getLastName())) {
            throw new \InvalidArgumentException("A client with this first and last name already exists.");
        }

        try {
            $sql = "INSERT INTO clients (first_name, last_name, email, phone_number, address)
                    VALUES (:first_name, :last_name, :email, :phone_number, :address)";
            $stmt = $this->db->prepare($sql);

            $firstName = $client->getFirstName();
            $lastName = $client->getLastName();
            $email = $client->getEmail();
            $phoneNumber = $client->getPhoneNumber();
            $address = $client->getAddress();

            $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':phone_number', $phoneNumber, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            throw new Exception('Failed to save client.');
        }
    }

    public function update(Client $client): bool
    {
        if ($this->isDuplicateNameForUpdate($client->getFirstName(), $client->getLastName(), $client->getId())) {
            throw new \InvalidArgumentException("A client with this first and last name already exists.");
        }

        try {
            $sql = "UPDATE clients
                SET first_name = :first_name,
                    last_name = :last_name,
                    email = :email,
                    phone_number = :phone_number,
                    address = :address
                WHERE id = :id";
            $stmt = $this->db->prepare($sql);

            $firstName = $client->getFirstName();
            $lastName = $client->getLastName();
            $email = $client->getEmail();
            $phoneNumber = $client->getPhoneNumber();
            $address = $client->getAddress();
            $id = $client->getId();

            $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':phone_number', $phoneNumber, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Database error during update: ' . $e->getMessage());
            throw new Exception('Failed to update client.');
        }
    }


    public function isDuplicateName(string $firstName, string $lastName): bool
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT COUNT(*) FROM clients WHERE first_name = :first_name AND last_name = :last_name"
            );
            $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            throw new Exception('Failed to check for duplicate client name.');
        }
    }

    public function isDuplicateNameForUpdate(string $firstName, string $lastName, int $id): bool
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT COUNT(*) FROM clients
             WHERE first_name = :first_name
               AND last_name = :last_name
               AND id != :id"
            );
            $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            throw new Exception('Failed to check for duplicate client name.');
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
                    clients
                WHERE id = :id"
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
