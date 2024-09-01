<?php

use PHPUnit\Framework\TestCase;
use Clients\Client;
use Clients\ClientRepository;
use Clients\ClientService;
use Database\Database;

class ClientIntegrationTest extends TestCase
{
    private ClientService $clientService;
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = Database::getInstance()->getConnection();
        $this->pdo->beginTransaction(); // Start

        $this->pdo->exec("DELETE FROM visits");
        $this->pdo->exec("DELETE FROM clients");

        $clientRepository = new ClientRepository($this->pdo);
        $this->clientService = new ClientService($clientRepository);
    }

    protected function tearDown(): void
    {
        $this->pdo->rollBack(); // Rollback
    }

    public function testCreateAndUpdateClient()
    {
        $client = new Client("John", "Doe", "john.doe@example.com", "1234567890", "123 Main St");
        $this->clientService->saveClient($client);

        $lastInsertId = $this->pdo->lastInsertId();

        $savedClient = $this->clientService->getClientById($lastInsertId);
        $this->assertEquals("John", $savedClient['first_name']);
        $this->assertEquals("Doe", $savedClient['last_name']);
        $this->assertEquals("john.doe@example.com", $savedClient['email']);
        $this->assertEquals("1234567890", $savedClient['phone_number']);
        $this->assertEquals("123 Main St", $savedClient['address']);

        $updatedClient = new Client("John", "Smith", "john.smith@example.com", "0987654321", "456 Elm St");
        $updatedClient->setId($lastInsertId);
        $this->clientService->updateClient($updatedClient);

        $savedClient = $this->clientService->getClientById($lastInsertId);
        $this->assertEquals("John", $savedClient['first_name']);
        $this->assertEquals("Smith", $savedClient['last_name']);
        $this->assertEquals("john.smith@example.com", $savedClient['email']);
        $this->assertEquals("0987654321", $savedClient['phone_number']);
        $this->assertEquals("456 Elm St", $savedClient['address']);
    }
}
