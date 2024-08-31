<?php
// run tests with ./vendor/bin/phpunit tests
use PHPUnit\Framework\TestCase;
use Clients\Client;
use Clients\ClientRepository;

class ClientRepositoryTest extends TestCase
{
    private $pdo;
    private $clientRepository;

    protected function setUp(): void
    {
        $this->pdo = $this->createMock(PDO::class);

        $this->clientRepository = new ClientRepository($this->pdo);
    }

    public function testDuplicateNameThrowsException()
    {
        $firstName = "John";
        $lastName = "Doe";

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetchColumn')->willReturn(1);

        $this->pdo->method('prepare')->willReturn($stmt);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("A client with this first and last name already exists.");

        $client = new Client($firstName, $lastName, 'john.doe@example.com', '1234567890', '123 Main St');
        $this->clientRepository->save($client);
    }
}
