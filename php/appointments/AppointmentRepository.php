<?php

declare(strict_types=1);

namespace Appointments;

use PDO;
use PDOException;
use Exception;

class AppointmentRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(Appointment $appointment): bool
    {
        try {
            $sql = "INSERT INTO appointments (client_id, caregiver_id, service_id, date, start_time, end_time, notes)
                VALUES (:client_id, :caregiver_id, :service_id, :date, :start_time, :end_time, :notes)";
            $stmt = $this->db->prepare($sql);

            $clientId = $appointment->getClientId();
            $caregiverId = $appointment->getCaregiverId();
            $serviceId = $appointment->getServiceId();
            $date = $appointment->getDate();
            $startTime = $appointment->getStartTime();
            $endTime = $appointment->getEndTime();
            $notes = $appointment->getNotes();

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
            throw new Exception('Failed to save Appointment', 0, $e);
        }
    }

    public function update(Appointment $appointment): bool
    {
        try {
            $sql = "UPDATE appointments
                SET client_id = :client_id, caregiver_id = :caregiver_id,
                service_id = :service_id, date = :date, start_time = :start_time,
                end_time = :end_time, notes = :notes
                WHERE id = :id";
            $stmt = $this->db->prepare($sql);

            $clientId = $appointment->getClientId();
            $caregiverId = $appointment->getCaregiverId();
            $serviceId = $appointment->getServiceId();
            $date = $appointment->getDate();
            $startTime = $appointment->getStartTime();
            $endTime = $appointment->getEndTime();
            $notes = $appointment->getNotes();
            $id = $appointment->getId();

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
            throw new Exception('Failed to update Appointment.', 0, $e);
        }
    }

    public function delete(int $id): bool
    {
        try {
            $sql = "DELETE FROM appointments WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Database error during delete: ' . $e->getMessage());
            throw new Exception('Failed to delete Appointment', 0, $e);
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
                appointments.id,
                clients.first_name AS client_first_name,
                clients.last_name AS client_last_name,
                caregivers.first_name AS caregiver_first_name,
                caregivers.last_name AS caregiver_last_name,
                services.code AS service_code,
                appointments.date,
                DATE_FORMAT(appointments.start_time, '%l:%i %p') AS start_time,
                DATE_FORMAT(appointments.end_time, '%l:%i %p') AS end_time,
                appointments.notes
            FROM
                appointments
            JOIN
                clients ON appointments.client_id = clients.id
            JOIN
                caregivers ON appointments.caregiver_id = caregivers.id
            JOIN
                services ON appointments.service_id = services.id
            ORDER BY
                appointments.date, appointments.start_time"
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
                    appointments.id,
                    appointments.client_id,
                    appointments.caregiver_id,
                    appointments.service_id,
                    appointments.date,
                    TIME_FORMAT(appointments.start_time, '%H:%i') AS start_time,
                    TIME_FORMAT(appointments.end_time, '%H:%i') AS end_time,
                    appointments.notes
                FROM
                    appointments
                WHERE
                    appointments.id = :id"
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
