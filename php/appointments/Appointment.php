<?php

declare(strict_types=1);
require_once __DIR__ . '/../Database.php';

class Appointment
{
    private ?int $id = null;
    private string $client;
    private string $caregiver;
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
        string $client,
        string $caregiver,
        string $address,
        string $date,
        string $startTime,
        string $endTime,
        ?string $notes = null
    ): void {
        $this->client = $client;
        $this->caregiver = $caregiver;
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
                $sql = "INSERT INTO appointments (client, caregiver, address, date, startTime, endTime, notes)
                        VALUES (:client, :caregiver, :address, :date, :startTime, :endTime, :notes)";
                $stmt = $this->db->prepare($sql);

                $stmt->bindParam(':client', $this->client, PDO::PARAM_STR);
                $stmt->bindParam(':caregiver', $this->caregiver, PDO::PARAM_STR);
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
                        SET client = :client, caregiver = :caregiver, address = :address, date = :date,
                            startTime = :startTime, endTime = :endTime, notes = :notes
                        WHERE id = :id";
                $stmt = $this->db->prepare($sql);

                $stmt->bindParam(':client', $this->client, PDO::PARAM_STR);
                $stmt->bindParam(':caregiver', $this->caregiver, PDO::PARAM_STR);
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
            $stmt = $this->db->query("SELECT id, client, caregiver, address, date,
                                DATE_FORMAT(startTime, '%l:%i %p') AS startTime,
                                DATE_FORMAT(endTime, '%l:%i %p') AS endTime,
                                notes
                         FROM appointments
                         ORDER BY date, startTime");

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return [];
        }
    }

    public function fetchById(int $id): array|false
    {
        try {
            $stmt = $this->db->prepare("SELECT id, client, caregiver, address, date,
                                   TIME_FORMAT(startTime, '%H:%i') AS startTime,
                                   TIME_FORMAT(endTime, '%H:%i') AS endTime, notes
                                   FROM appointments WHERE id = :id");
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
