<?php

declare(strict_types=1);
require_once __DIR__ . '/../Database.php';

class Appointment
{
    private ?int $id = null;
    private int $clientId;
    private int $caregiverId;
    private string $address;
    private string $date;
    private string $startTime;
    private string $endTime;
    private string $notes;
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
        int $clientId,
        int $caregiverId,
        string $address,
        string $date,
        string $startTime,
        string $endTime,
        ?string $notes = null
    ): void {
        $this->clientId = $clientId;
        $this->caregiverId = $caregiverId;
        $this->address = $address;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->notes = $notes ?? '';
    }

    private function validateDate(string $date, string $format = 'Y-m-d'): bool
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    private function validateTime(string $time, string $format = 'H:i'): bool
    {
        $t = DateTime::createFromFormat($format, $time);
        return $t && $t->format($format) === $time;
    }

    public function saveAppointment(): bool
    {
        if ($this->validateDate($this->date) && $this->validateTime($this->startTime) && $this->validateTime($this->endTime)) {
            try {
                $sql = "INSERT INTO appointments (client_id, caregiver_id, address, date, startTime, endTime, notes)
                        VALUES (:client_id, :caregiver_id, :address, :date, :startTime, :endTime, :notes)";
                $stmt = $this->db->prepare($sql);

                $stmt->bindParam(':client_id', $this->clientId, PDO::PARAM_INT);
                $stmt->bindParam(':caregiver_id', $this->caregiverId, PDO::PARAM_INT);
                $stmt->bindParam(':address', $this->address, PDO::PARAM_STR);
                $stmt->bindParam(':date', $this->date, PDO::PARAM_STR);
                $stmt->bindParam(':startTime', $this->startTime, PDO::PARAM_STR);
                $stmt->bindParam(':endTime', $this->endTime, PDO::PARAM_STR);
                $stmt->bindParam(':notes', $this->notes, PDO::PARAM_STR);

                return $stmt->execute();
            } catch (PDOException $e) {
                error_log('Database error: ' . $e->getMessage());
                throw new Exception('Failed to execute database operation.', 0, $e);
            }
        } else {
            return false;
        }
    }

    public function updateAppointment(): bool
    {
        if ($this->validateDate($this->date) && $this->validateTime($this->startTime) && $this->validateTime($this->endTime)) {
            try {
                $sql = "UPDATE appointments
                        SET client_id = :client_id, caregiver_id = :caregiver_id, address = :address, date = :date,
                            startTime = :startTime, endTime = :endTime, notes = :notes
                        WHERE id = :id";
                $stmt = $this->db->prepare($sql);

                $stmt->bindParam(':client_id', $this->clientId, PDO::PARAM_INT);
                $stmt->bindParam(':caregiver_id', $this->caregiverId, PDO::PARAM_INT);
                $stmt->bindParam(':address', $this->address, PDO::PARAM_STR);
                $stmt->bindParam(':date', $this->date, PDO::PARAM_STR);
                $stmt->bindParam(':startTime', $this->startTime, PDO::PARAM_STR);
                $stmt->bindParam(':endTime', $this->endTime, PDO::PARAM_STR);
                $stmt->bindParam(':notes', $this->notes, PDO::PARAM_STR);
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

                return $stmt->execute();
            } catch (PDOException $e) {
                error_log('Database error: ' . $e->getMessage());
                throw new Exception('Failed to execute database operation.', 0, $e);
            }
        } else {
            return false;
        }
    }

    public function deleteAppointment(): bool
    {
        try {
            $sql = "DELETE FROM appointments WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

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
                appointments.id,
                clients.name AS client_name,
                caregivers.name AS caregiver_name,
                appointments.address,
                appointments.date,
                DATE_FORMAT(appointments.startTime, '%l:%i %p') AS startTime,
                DATE_FORMAT(appointments.endTime, '%l:%i %p') AS endTime,
                appointments.notes
            FROM
                appointments
            JOIN
                clients ON appointments.client_id = clients.id
            JOIN
                caregivers ON appointments.caregiver_id = caregivers.id
            ORDER BY
                appointments.date, appointments.startTime"
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
                    appointments.id,
                    appointments.client_id,
                    appointments.caregiver_id,
                    appointments.address,
                    appointments.date,
                    TIME_FORMAT(appointments.startTime, '%H:%i') AS startTime,
                    TIME_FORMAT(appointments.endTime, '%H:%i') AS endTime,
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
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }
}