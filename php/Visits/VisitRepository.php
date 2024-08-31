<?php

declare(strict_types=1);

namespace Visits;

use PDO;
use PDOException;
use Exception;

class VisitRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(Visit $visit): bool
    {
        try {
            $sql = "INSERT INTO visits (client_id, caregiver_id, service_id, date, start_time, end_time, notes)
                VALUES (:client_id, :caregiver_id, :service_id, :date, :start_time, :end_time, :notes)";
            $stmt = $this->db->prepare($sql);

            $clientId = $visit->getClientId();
            $caregiverId = $visit->getCaregiverId();
            $serviceId = $visit->getServiceId();
            $date = $visit->getDate();
            $startTime = $visit->getStartTime();
            $endTime = $visit->getEndTime();
            $notes = $visit->getNotes();

            $stmt->bindParam(':client_id', $clientId, PDO::PARAM_INT);
            $stmt->bindParam(':caregiver_id', $caregiverId, PDO::PARAM_INT);
            $stmt->bindParam(':service_id', $serviceId, PDO::PARAM_INT);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':start_time', $startTime, PDO::PARAM_STR);
            $stmt->bindParam(':end_time', $endTime, PDO::PARAM_STR);
            $stmt->bindParam(':notes', $notes, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Database error during save: ' . $e->getMessage());
            throw new Exception('Failed to save Visit');
        }
    }

    public function update(Visit $visit): bool
    {
        try {
            $sql = "UPDATE visits
                SET client_id = :client_id, caregiver_id = :caregiver_id,
                service_id = :service_id, date = :date, start_time = :start_time,
                end_time = :end_time, notes = :notes
                WHERE id = :id";
            $stmt = $this->db->prepare($sql);

            $clientId = $visit->getClientId();
            $caregiverId = $visit->getCaregiverId();
            $serviceId = $visit->getServiceId();
            $date = $visit->getDate();
            $startTime = $visit->getStartTime();
            $endTime = $visit->getEndTime();
            $notes = $visit->getNotes();
            $id = $visit->getId();

            $stmt->bindParam(':client_id', $clientId, PDO::PARAM_INT);
            $stmt->bindParam(':caregiver_id', $caregiverId, PDO::PARAM_INT);
            $stmt->bindParam(':service_id', $serviceId, PDO::PARAM_INT);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':start_time', $startTime, PDO::PARAM_STR);
            $stmt->bindParam(':end_time', $endTime, PDO::PARAM_STR);
            $stmt->bindParam(':notes', $notes, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Database error during update: ' . $e->getMessage());
            throw new Exception('Failed to update Visit.');
        }
    }

    public function updateVerificationStatus(int $id, bool $verified): bool
    {
        try {
            $sql = "UPDATE visits SET verified = :verified WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':verified', $verified, PDO::PARAM_BOOL);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Database error during updateVerificationStatus: ' . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $sql = "DELETE FROM visits WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Database error during delete: ' . $e->getMessage());
            throw new Exception('Failed to delete Visit');
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
                visits.id,
                clients.first_name AS client_first_name,
                clients.last_name AS client_last_name,
                caregivers.first_name AS caregiver_first_name,
                caregivers.last_name AS caregiver_last_name,
                services.code AS service_code,
                services.bill_rate AS service_bill_rate,
                visits.date,
                DATE_FORMAT(visits.start_time, '%l:%i %p') AS start_time,
                DATE_FORMAT(visits.end_time, '%l:%i %p') AS end_time,
                visits.notes,
                visits.verified
            FROM
                visits
            JOIN
                clients ON visits.client_id = clients.id
            JOIN
                caregivers ON visits.caregiver_id = caregivers.id
            JOIN
                services ON visits.service_id = services.id
            ORDER BY
                visits.date, visits.start_time"
            );

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error during fetchAll: ' . $e->getMessage());
            return [];
        }
    }

    public function fetchById(int $id): array|false
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT
                    visits.id,
                    visits.client_id,
                    visits.caregiver_id,
                    visits.service_id,
                    visits.date,
                    TIME_FORMAT(visits.start_time, '%H:%i') AS start_time,
                    TIME_FORMAT(visits.end_time, '%H:%i') AS end_time,
                    visits.notes
                FROM
                    visits
                WHERE
                    visits.id = :id"
            );
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: false;
        } catch (PDOException $e) {
            error_log('Database error during fetchById: ' . $e->getMessage());
            return false;
        }
    }
}
