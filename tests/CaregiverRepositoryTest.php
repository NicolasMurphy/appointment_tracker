<?php

use PHPUnit\Framework\TestCase;
use Caregivers\Caregiver;
use Caregivers\CaregiverRepository;

class CaregiverRepositoryTest extends TestCase
{
    private $pdo;
    private $caregiverRepository;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);

        $this->caregiverRepository = new CaregiverRepository($this->pdo);
    }

    public function testDuplicateNameThrowsException()
    {
        $firstName = "John";
        $lastName = "Doe";

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchColumn')->willReturn(1);

        $this->pdo->method('prepare')->willReturn($stmt);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("A caregiver with this first and last name already exists.");

        $caregiver = new Caregiver($firstName, $lastName, 'john.doe@example.com', '1234567890', '123 Main St', '10');
        $this->caregiverRepository->save($caregiver);
    }
}
