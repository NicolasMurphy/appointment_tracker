<?php

declare(strict_types=1);

namespace Clients;

use Database\Database;

class ClientController
{
    private ClientService $clientService;

    public function __construct()
    {
        $dbConnection = Database::getInstance()->getConnection();
        $clientRepository = new ClientRepository($dbConnection);
        $this->clientService = new ClientService($clientRepository);
    }

    public function handleRequest(): void
    {
        $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'list';

        switch ($action) {
            case 'create':
                $this->createClient();
                break;
            case 'update':
                $this->updateClient();
                break;
            case 'list':
            default:
                $this->listClients();
                break;
        }
    }

    private function createClient(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = $_POST['first_name'] ?? '';
            $lastName = $_POST['last_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phoneNumber = $_POST['phone_number'] ?? '';
            $address = $_POST['address'] ?? '';

            try {
                $client = new Client($firstName, $lastName, $email, $phoneNumber, $address);
                $this->clientService->saveClient($client);
                header('Location: ?action=list');
                exit();
            } catch (\InvalidArgumentException $e) {
                error_log($e->getMessage());
            }
        }

        include 'views/create-client-view.php';
    }

    private function updateClient(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            echo "Invalid client ID.";
            exit();
        }

        $clientData = $this->clientService->getClientById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = $_POST['first_name'] ?? '';
            $lastName = $_POST['last_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phoneNumber = $_POST['phone_number'] ?? '';
            $address = $_POST['address'] ?? '';

            try {
                $client = new Client($firstName, $lastName, $email, $phoneNumber, $address);
                $client->setId($id);
                $this->clientService->updateClient($client);
                header('Location: ?action=list');
                exit();
            } catch (\InvalidArgumentException $e) {
                error_log($e->getMessage());
            }
        }

        include 'views/update-client-view.php';
    }

    private function listClients(): void
    {
        $clients = $this->clientService->getAllClients();
        include 'views/list-clients-view.php';
    }
}
