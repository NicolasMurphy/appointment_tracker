<?php

declare(strict_types=1);

namespace Appointments;

class AppointmentService
{
    private AppointmentRepository $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function saveAppointment(Appointment $appointment): void
    {
        if (!$this->appointmentRepository->save($appointment)) {
            throw new \Exception('Failed to save appointment.');
        }
    }

    public function updateAppointment(Appointment $appointment): void
    {
        if (!$this->appointmentRepository->update($appointment)) {
            throw new \Exception('Failed to update appointment.');
        }
    }

    public function updateVerificationStatus(int $id, bool $verified): bool
    {
        return $this->appointmentRepository->updateVerificationStatus($id, $verified);
    }


    public function deleteAppointment(int $id): bool
    {
        return $this->appointmentRepository->delete($id);
    }

    public function getAllAppointments(): array
    {
        return $this->appointmentRepository->fetchAll();
    }

    public function getAppointmentById(int $id): array|false
    {
        return $this->appointmentRepository->fetchById($id);
    }
}
