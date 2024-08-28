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
        $errorMessage = '';
        $firstName = $lastName = $email = $phoneNumber = $address = '';

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
                $errorMessage = $e->getMessage();
            }
        }

        // pass error and fields to view
        $this->renderView('views/create-client-view.php', [
            'errorMessage' => $errorMessage,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'address' => $address
        ]);
    }

    private function updateClient(): void
    {
        $errorMessage = '';

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            echo "Invalid client ID.";
            exit();
        }

        // Initially populate with data from the database
        $clientData = $this->clientService->getClientById($id);
        $firstName = $clientData['first_name'] ?? '';
        $lastName = $clientData['last_name'] ?? '';
        $email = $clientData['email'] ?? '';
        $phoneNumber = $clientData['phone_number'] ?? '';
        $address = $clientData['address'] ?? '';

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
                $errorMessage = $e->getMessage();
            }
        }

        // Pass the possibly updated fields and error message to the view
        $this->renderView('views/update-client-view.php', [
            'errorMessage' => $errorMessage,
            'clientData' => $clientData,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'address' => $address,
        ]);
    }

    private function listClients(): void
    {
        $clients = $this->clientService->getAllClients();
        include 'views/list-clients-view.php';
    }

    // display error message and keep fields
    private function renderView(string $viewFile, array $data = []): void
    {
        extract($data);
        include $viewFile;
    }
}
