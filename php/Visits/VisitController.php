<?php

declare(strict_types=1);

namespace Visits;

use Clients\ClientService;
use Caregivers\CaregiverService;
use Services\ServiceService;

class VisitController
{
    private VisitService $visitService;
    private ClientService $clientService;
    private CaregiverService $caregiverService;
    private ServiceService $serviceService;

    public function __construct(
        VisitService $visitService,
        ClientService $clientService,
        CaregiverService $caregiverService,
        ServiceService $serviceService
    ) {
        $this->visitService = $visitService;
        $this->clientService = $clientService;
        $this->caregiverService = $caregiverService;
        $this->serviceService = $serviceService;
    }

    public function handleRequest(): void
    {
        $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'list';

        switch ($action) {
            case 'create':
                $this->createVisit();
                break;
            case 'update':
                $this->updateVisit();
                break;
            case 'delete':
                $this->deleteVisit();
                break;
            case 'verify':
                $this->verifyVisit();
                break;
            case 'list':
            default:
                $this->listVisits();
                break;
        }
    }

    private function createVisit(): void
    {
        $errorMessage = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clientId = filter_input(INPUT_POST, 'client_id', FILTER_VALIDATE_INT);
            $caregiverId = filter_input(INPUT_POST, 'caregiver_id', FILTER_VALIDATE_INT);
            $serviceId = filter_input(INPUT_POST, 'service_id', FILTER_VALIDATE_INT);
            $date = $_POST['date'] ?? '';
            $startTime = $_POST['start_time'] ?? '';
            $endTime = $_POST['end_time'] ?? '';
            $notes = $_POST['notes'] ?? '';

            try {
                $visit = new Visit($clientId, $caregiverId, $serviceId, $date, $startTime, $endTime, $notes);
                $this->visitService->saveVisit($visit);
                header('Location: /php/visits.php?action=list');
                exit();
            } catch (\InvalidArgumentException $e) {
                $errorMessage = $e->getMessage();
            }
        }

        $clients = $this->clientService->getAllClients();
        $caregivers = $this->caregiverService->getAllCaregivers();
        $services = $this->serviceService->getAllServices();

        $this->renderView('views/create-visit-view.php', [
            'errorMessage' => $errorMessage,
            'clients' => $clients,
            'caregivers' => $caregivers,
            'services' => $services
        ]);
    }

    private function updateVisit(): void
    {
        $errorMessage = '';

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            echo "Invalid visit ID.";
            exit();
        }

        $visitData = $this->visitService->getVisitById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clientId = (int)$_POST['client_id'] ?? 0;
            $caregiverId = (int)$_POST['caregiver_id'] ?? 0;
            $serviceId = (int)$_POST['service_id'] ?? 0;
            $date = $_POST['date'] ?? '';
            $startTime = $_POST['start_time'] ?? '';
            $endTime = $_POST['end_time'] ?? '';
            $notes = $_POST['notes'] ?? '';

            try {
                $visit = new Visit($clientId, $caregiverId, $serviceId, $date, $startTime, $endTime, $notes);
                $visit->setId($id);
                $this->visitService->updateVisit($visit);
                header('Location: /php/visits.php?action=list');
                exit();
            } catch (\InvalidArgumentException $e) {
                $errorMessage = $e->getMessage();
            }
        }

        // Fetch clients, caregivers, and services to pass to the view
        $clients = $this->clientService->getAllClients();
        $caregivers = $this->caregiverService->getAllCaregivers();
        $services = $this->serviceService->getAllServices();

        $this->renderView('views/update-visit-view.php', [
            'errorMessage' => $errorMessage,
            'visitData' => $visitData,
            'clients' => $clients,
            'caregivers' => $caregivers,
            'services' => $services,
            'clientId' => $visitData['client_id'],
            'caregiverId' => $visitData['caregiver_id'],
            'serviceId' => $visitData['service_id'],
            'date' => $visitData['date'],
            'startTime' => $visitData['start_time'],
            'endTime' => $visitData['end_time'],
            'notes' => $visitData['notes']
        ]);
    }

    private function deleteVisit(): void
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if ($id !== false && $id !== null) {
            if ($this->visitService->deleteVisit($id)) {
                header('Location: /php/visits.php?action=list');
                exit();
            } else {
                echo "Failed to delete visit.";
            }
        } else {
            echo "Invalid visit ID.";
        }
    }

    private function verifyVisit(): void
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $verified = filter_input(INPUT_POST, 'verified', FILTER_VALIDATE_BOOLEAN);

        if ($id !== false && $id !== null) {
            if ($this->visitService->updateVerificationStatus($id, $verified)) {
                header('Location: /php/visits.php?action=list');
                exit();
            } else {
                echo "Failed to verify visit.";
            }
        } else {
            echo "Invalid visit ID.";
        }
    }


    private function listVisits(): void
    {
        $visits = $this->visitService->getAllVisits();
        include 'views/list-visits-view.php';
    }

    private function renderView(string $viewFile, array $data = []): void
    {
        extract($data);
        include $viewFile;
    }
}
