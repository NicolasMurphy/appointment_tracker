<?php

declare(strict_types=1);

namespace Services;

use PDO;
use PDOException;
use Exception;

class ServiceRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(Service $service): bool
    {

        try {
            $sql = "INSERT INTO services (code, description, bill_rate)
                    VALUES (:code, :description, :bill_rate)";
            $stmt = $this->db->prepare($sql);

            $code = $service->getCode();
            $description = $service->getDescription();
            $billRate = $service->getBillRate();

            $stmt->bindParam(':code', $code, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':bill_rate', $billRate, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            throw new Exception('Failed to save service.');
        }
    }

    public function update(Service $service): bool
    {
        try {
            $sql = "UPDATE services
                SET code = :code,
                    description = :description,
                    bill_rate = :bill_rate
                WHERE id = :id";
            $stmt = $this->db->prepare($sql);

            $code = $service->getCode();
            $description = $service->getDescription();
            $billRate = $service->getBillRate();
            $id = $service->getId();

            $stmt->bindParam(':code', $code, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':bill_rate', $billRate, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Database error during update: ' . $e->getMessage());
            throw new Exception('Failed to update service.');
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
                    code,
                    description,
                    bill_rate
                FROM
                    services"
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
                    code,
                    description,
                    bill_rate
                FROM
                    services
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
