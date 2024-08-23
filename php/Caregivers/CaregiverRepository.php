<?php

declare(strict_types=1);

namespace Caregivers;

use PDO;
use PDOException;
use Exception;

class CaregiverRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(Caregiver $caregiver): bool
    {

        if ($this->isDuplicateName($caregiver->getFirstName(), $caregiver->getLastName())) {
            throw new \InvalidArgumentException("A caregiver with this first and last name already exists.");
        }

        try {
            $sql = "INSERT INTO caregivers (first_name, last_name, email, phone_number, address, pay_rate)
                    VALUES (:first_name, :last_name, :email, :phone_number, :address, :pay_rate)";
            $stmt = $this->db->prepare($sql);

            $firstName = $caregiver->getFirstName();
            $lastName = $caregiver->getLastName();
            $email = $caregiver->getEmail();
            $phoneNumber = $caregiver->getPhoneNumber();
            $address = $caregiver->getAddress();
            $payRate = $caregiver->getPayRate();

            $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':phone_number', $phoneNumber, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':pay_rate', $payRate, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            throw new Exception('Failed to save caregiver.');
        }
    }

    public function update(Caregiver $caregiver): bool
    {
        try {
            $sql = "UPDATE caregivers
                SET first_name = :first_name,
                    last_name = :last_name,
                    email = :email,
                    phone_number = :phone_number,
                    address = :address,
                    pay_rate = :pay_rate
                WHERE id = :id";
            $stmt = $this->db->prepare($sql);

            $firstName = $caregiver->getFirstName();
            $lastName = $caregiver->getLastName();
            $email = $caregiver->getEmail();
            $phoneNumber = $caregiver->getPhoneNumber();
            $address = $caregiver->getAddress();
            $payRate = $caregiver->getPayRate();
            $id = $caregiver->getId();

            $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':phone_number', $phoneNumber, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':pay_rate', $payRate, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Database error during update: ' . $e->getMessage());
            throw new Exception('Failed to update caregiver.');
        }
    }


    public function isDuplicateName(string $firstName, string $lastName): bool
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT COUNT(*) FROM caregivers WHERE first_name = :first_name AND last_name = :last_name"
            );
            $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            throw new Exception('Failed to check for duplicate caregiver name.');
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
                    address,
                    pay_rate
                FROM
                    caregivers
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
                    address,
                    pay_rate
                FROM
                    caregivers
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
