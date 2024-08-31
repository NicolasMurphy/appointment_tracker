<?php

use PHPUnit\Framework\TestCase;
use Caregivers\Caregiver;
use Caregivers\CaregiverRepository;
use Caregivers\CaregiverService;
use Database\Database;

class CaregiverIntegrationTest extends TestCase
{
    private CaregiverService $caregiverService;
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = Database::getInstance()->getConnection();

        $this->pdo->exec("DELETE FROM visits");

        $this->pdo->exec("DELETE FROM caregivers");

        $caregiverRepository = new CaregiverRepository($this->pdo);
        $this->caregiverService = new CaregiverService($caregiverRepository);
    }

    public function testCreateAndUpdateCaregiver()
    {
        $caregiver = new Caregiver("John", "Doe", "john.doe@example.com", "1234567890", "123 Main St", "20.00");
        $this->caregiverService->saveCaregiver($caregiver);

        $lastInsertId = $this->pdo->lastInsertId();

        $savedCaregiver = $this->caregiverService->getCaregiverById($lastInsertId);
        $this->assertEquals("John", $savedCaregiver['first_name']);
        $this->assertEquals("Doe", $savedCaregiver['last_name']);
        $this->assertEquals("john.doe@example.com", $savedCaregiver['email']);
        $this->assertEquals("1234567890", $savedCaregiver['phone_number']);
        $this->assertEquals("123 Main St", $savedCaregiver['address']);
        $this->assertEquals("20.00", $savedCaregiver['pay_rate']);

        $updatedCaregiver = new Caregiver("John", "Smith", "john.smith@example.com", "0987654321", "456 Elm St", "25.00");
        $updatedCaregiver->setId($lastInsertId);
        $this->caregiverService->updateCaregiver($updatedCaregiver);

        $savedCaregiver = $this->caregiverService->getCaregiverById($lastInsertId);
        $this->assertEquals("John", $savedCaregiver['first_name']);
        $this->assertEquals("Smith", $savedCaregiver['last_name']);
        $this->assertEquals("john.smith@example.com", $savedCaregiver['email']);
        $this->assertEquals("0987654321", $savedCaregiver['phone_number']);
        $this->assertEquals("456 Elm St", $savedCaregiver['address']);
        $this->assertEquals("25.00", $savedCaregiver['pay_rate']);
    }
}
