<?php

declare(strict_types=1);

namespace Caregivers;

use Database\Database;

class CaregiverController
{
    private CaregiverService $caregiverService;

    public function __construct()
    {
        $dbConnection = Database::getInstance()->getConnection();
        $caregiverRepository = new CaregiverRepository($dbConnection);
        $this->caregiverService = new CaregiverService($caregiverRepository);
    }

    public function handleRequest(): void
    {
        $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'list';

        switch ($action) {
            case 'create':
                $this->createCaregiver();
                break;
            case 'update':
                $this->updateCaregiver();
                break;
            case 'list':
            default:
                $this->listCaregivers();
                break;
        }
    }

    private function createCaregiver(): void
    {
        $errorMessage = '';
        $firstName = $lastName = $email = $phoneNumber = $address = $payRate = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = $_POST['first_name'] ?? '';
            $lastName = $_POST['last_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phoneNumber = $_POST['phone_number'] ?? '';
            $address = $_POST['address'] ?? '';
            $payRate = $_POST['pay_rate'] ?? '';

            try {
                $caregiver = new Caregiver($firstName, $lastName, $email, $phoneNumber, $address, $payRate);
                $this->caregiverService->saveCaregiver($caregiver);
                header('Location: ?action=list');
                exit();
            } catch (\InvalidArgumentException $e) {
                $errorMessage = $e->getMessage();
            }
        }

        // pass error and fields to view
        $this->renderView('views/create-caregiver-view.php', [
            'errorMessage' => $errorMessage,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'address' => $address,
            'payRate' => $payRate
        ]);
    }

    private function updateCaregiver(): void
    {
        $errorMessage = '';

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            echo "Invalid caregiver ID.";
            exit();
        }

        // Initially populate with data from the database
        $caregiverData = $this->caregiverService->getCaregiverById($id);
        $firstName = $caregiverData['first_name'] ?? '';
        $lastName = $caregiverData['last_name'] ?? '';
        $email = $caregiverData['email'] ?? '';
        $phoneNumber = $caregiverData['phone_number'] ?? '';
        $address = $caregiverData['address'] ?? '';
        $payRate = $caregiverData['pay_rate'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = $_POST['first_name'] ?? '';
            $lastName = $_POST['last_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phoneNumber = $_POST['phone_number'] ?? '';
            $address = $_POST['address'] ?? '';
            $payRate = $_POST['pay_rate'] ?? '';

            try {
                $caregiver = new Caregiver($firstName, $lastName, $email, $phoneNumber, $address, $payRate);
                $caregiver->setId($id);
                $this->caregiverService->updateCaregiver($caregiver);
                header('Location: ?action=list');
                exit();
            } catch (\InvalidArgumentException $e) {
                $errorMessage = $e->getMessage();
            }
        }

        // Pass the possibly updated fields and error message to the view
        $this->renderView('views/update-caregiver-view.php', [
            'errorMessage' => $errorMessage,
            'caregiverData' => $caregiverData,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'address' => $address,
            'payRate' => $payRate,
        ]);
    }

    private function listCaregivers(): void
    {
        $caregivers = $this->caregiverService->getAllCaregivers();
        include 'views/list-caregivers-view.php';
    }

    // display error message and keep fields
    private function renderView(string $viewFile, array $data = []): void
    {
        extract($data);
        include $viewFile;
    }
}
