<?php

declare(strict_types=1);

namespace Appointments;

use Clients\ClientService;
use Caregivers\CaregiverService;
use Services\ServiceService;

class AppointmentController
{
    private AppointmentService $appointmentService;
    private ClientService $clientService;
    private CaregiverService $caregiverService;
    private ServiceService $serviceService;

    public function __construct(
        AppointmentService $appointmentService,
        ClientService $clientService,
        CaregiverService $caregiverService,
        ServiceService $serviceService
    ) {
        $this->appointmentService = $appointmentService;
        $this->clientService = $clientService;
        $this->caregiverService = $caregiverService;
        $this->serviceService = $serviceService;
    }

    public function handleRequest(): void
    {
        $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS) ?? 'list';

        switch ($action) {
            case 'create':
                $this->createAppointment();
                break;
            case 'update':
                $this->updateAppointment();
                break;
            case 'delete':
                $this->deleteAppointment();
                break;
            case 'verify':
                $this->verifyAppointment();
                break;
            case 'list':
            default:
                $this->listAppointments();
                break;
        }
    }

    private function createAppointment(): void
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
                $appointment = new Appointment($clientId, $caregiverId, $serviceId, $date, $startTime, $endTime, $notes);
                $this->appointmentService->saveAppointment($appointment);
                header('Location: /php/appointments.php?action=list');
                exit();
            } catch (\InvalidArgumentException $e) {
                $errorMessage = $e->getMessage();
            }
        }

        $clients = $this->clientService->getAllClients();
        $caregivers = $this->caregiverService->getAllCaregivers();
        $services = $this->serviceService->getAllServices();

        $this->renderView('views/create-appointment-view.php', [
            'errorMessage' => $errorMessage,
            'clients' => $clients,
            'caregivers' => $caregivers,
            'services' => $services
        ]);
    }

    private function updateAppointment(): void
    {
        $errorMessage = '';

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            echo "Invalid appointment ID.";
            exit();
        }

        $appointmentData = $this->appointmentService->getAppointmentById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $clientId = (int)$_POST['client_id'] ?? 0;
            $caregiverId = (int)$_POST['caregiver_id'] ?? 0;
            $serviceId = (int)$_POST['service_id'] ?? 0;
            $date = $_POST['date'] ?? '';
            $startTime = $_POST['start_time'] ?? '';
            $endTime = $_POST['end_time'] ?? '';
            $notes = $_POST['notes'] ?? '';

            try {
                $appointment = new Appointment($clientId, $caregiverId, $serviceId, $date, $startTime, $endTime, $notes);
                $appointment->setId($id);
                $this->appointmentService->updateAppointment($appointment);
                header('Location: /php/appointments.php?action=list');
                exit();
            } catch (\InvalidArgumentException $e) {
                $errorMessage = $e->getMessage();
            }
        }

        // Fetch clients, caregivers, and services to pass to the view
        $clients = $this->clientService->getAllClients();
        $caregivers = $this->caregiverService->getAllCaregivers();
        $services = $this->serviceService->getAllServices();

        $this->renderView('views/update-appointment-view.php', [
            'errorMessage' => $errorMessage,
            'appointmentData' => $appointmentData,
            'clients' => $clients,
            'caregivers' => $caregivers,
            'services' => $services,
            'clientId' => $appointmentData['client_id'],
            'caregiverId' => $appointmentData['caregiver_id'],
            'serviceId' => $appointmentData['service_id'],
            'date' => $appointmentData['date'],
            'startTime' => $appointmentData['start_time'],
            'endTime' => $appointmentData['end_time'],
            'notes' => $appointmentData['notes']
        ]);
    }

    private function deleteAppointment(): void
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if ($id !== false && $id !== null) {
            if ($this->appointmentService->deleteAppointment($id)) {
                header('Location: /php/appointments.php?action=list');
                exit();
            } else {
                echo "Failed to delete appointment.";
            }
        } else {
            echo "Invalid appointment ID.";
        }
    }

    private function verifyAppointment(): void
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $verified = filter_input(INPUT_POST, 'verified', FILTER_VALIDATE_BOOLEAN);

        if ($id !== false && $id !== null) {
            if ($this->appointmentService->updateVerificationStatus($id, $verified)) {
                header('Location: /php/appointments.php?action=list');
                exit();
            } else {
                echo "Failed to verify appointment.";
            }
        } else {
            echo "Invalid appointment ID.";
        }
    }


    private function listAppointments(): void
    {
        $appointments = $this->appointmentService->getAllAppointments();
        include 'views/list-appointments-view.php';
    }

    private function renderView(string $viewFile, array $data = []): void
    {
        extract($data);
        include $viewFile;
    }
}
