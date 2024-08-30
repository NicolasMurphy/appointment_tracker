<?php

declare(strict_types=1);

namespace Services;

use Database\Database;

class ServiceController
{
    private ServiceService $serviceService;

    public function __construct()
    {
        $dbConnection = Database::getInstance()->getConnection();
        $serviceRepository = new ServiceRepository($dbConnection);
        $this->serviceService = new ServiceService($serviceRepository);
    }

    public function handleRequest(): void
    {
        $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'list';

        switch ($action) {
            case 'create':
                $this->createService();
                break;
            case 'update':
                $this->updateService();
                break;
            case 'list':
            default:
                $this->listServices();
                break;
        }
    }

    private function createService(): void
    {
        $errorMessage = '';
        $code = $description = $billRate = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'] ?? '';
            $description = $_POST['description'] ?? '';
            $billRate = $_POST['bill_rate'] ?? '';

            try {
                $service = new Service($code, $description, $billRate);
                $this->serviceService->saveService($service);
                header('Location: ?action=list');
                exit();
            } catch (\InvalidArgumentException $e) {
                $errorMessage = $e->getMessage();
            }
        }

        // pass error and fields to view
        $this->renderView('views/create-service-view.php', [
            'errorMessage' => $errorMessage,
            'code' => $code,
            'description' => $description,
            'billRate' => $billRate
        ]);
    }

    private function updateService(): void
    {
        $errorMessage = '';

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            echo "Invalid service ID.";
            exit();
        }

        // Initially populate with data from the database
        $serviceData = $this->serviceService->getServiceById($id);
        $code = $serviceData['code'] ?? '';
        $description = $serviceData['description'] ?? '';
        $billRate = $serviceData['bill_rate'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'] ?? '';
            $description = $_POST['description'] ?? '';
            $billRate = $_POST['bill_rate'] ?? '';

            try {
                $service = new Service($code, $description, $billRate);
                $service->setId($id);
                $this->serviceService->updateService($service);
                header('Location: ?action=list');
                exit();
            } catch (\InvalidArgumentException $e) {
                $errorMessage = $e->getMessage();
            }
        }

        // Pass the possibly updated fields and error message to the view
        $this->renderView('views/update-service-view.php', [
            'errorMessage' => $errorMessage,
            'serviceData' => $serviceData,
            'code' => $code,
            'description' => $description,
            'billRate' => $billRate,
        ]);
    }

    private function listServices(): void
    {
        $services = $this->serviceService->getAllServices();
        include 'views/list-services-view.php';
    }

    // display error message and keep fields
    private function renderView(string $viewFile, array $data = []): void
    {
        extract($data);
        include $viewFile;
    }
}
