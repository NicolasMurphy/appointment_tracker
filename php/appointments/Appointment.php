<?php
require __DIR__ . '/../Database.php';

$db = Database::getInstance();

class Appointment
{
    private $id;
    private $client;
    private $caregiver;
    private $address;
    private $date;
    private $startTime;
    private $endTime;
    private $notes;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setDetails($client, $caregiver, $address, $date, $startTime, $endTime, $notes = '')
    {
        $this->client = $client;
        $this->caregiver = $caregiver;
        $this->address = $address;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->notes = $notes;
    }

    public function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    public function validateTime($time, $format = 'H:i')
    {
        $t = DateTime::createFromFormat($format, $time);
        return $t && $t->format($format) === $time;
    }

    public function save()
    {
        if ($this->validateDate($this->date) && $this->validateTime($this->startTime) && $this->validateTime($this->endTime)) {
            try {
                $pdo = $this->db->getConnection();

                $sql = "INSERT INTO appointments (client, caregiver, address, date, startTime, endTime, notes)
                        VALUES (:client, :caregiver, :address, :date, :startTime, :endTime, :notes)";
                $stmt = $pdo->prepare($sql);

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
                return false;
            }
        } else {
            return false;
        }
    }

    public function update()
    {
        if ($this->validateDate($this->date) && $this->validateTime($this->startTime) && $this->validateTime($this->endTime)) {
            try {
                $pdo = $this->db->getConnection();

                $sql = "UPDATE appointments
                        SET client = :client, caregiver = :caregiver, address = :address, date = :date,
                            startTime = :startTime, endTime = :endTime, notes = :notes
                        WHERE id = :id";
                $stmt = $pdo->prepare($sql);

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
                return false;
            }
        } else {
            return false;
        }
    }

    public function delete()
    {
        try {
            $pdo = $this->db->getConnection();

            $sql = "DELETE FROM appointments WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }

    public function fetchAll()
    {
        try {
            $pdo = $this->db->getConnection();

            $stmt = $pdo->query("SELECT id, client, caregiver, address, date,
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

    public function fetchById($id)
    {
        try {
            $pdo = $this->db->getConnection();

            $stmt = $pdo->prepare("SELECT id, client, caregiver, address, date,
                                   TIME_FORMAT(startTime, '%H:%i') AS startTime,
                                   TIME_FORMAT(endTime, '%H:%i') AS endTime, notes
                                   FROM appointments WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }
}
