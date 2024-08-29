<?php

declare(strict_types=1);

namespace Caregivers;

class CaregiverService
{
    private CaregiverRepository $caregiverRepository;

    public function __construct(CaregiverRepository $caregiverRepository)
    {
        $this->caregiverRepository = $caregiverRepository;
    }

    public function saveCaregiver(Caregiver $caregiver): void
    {
        if (!$this->caregiverRepository->save($caregiver)) {
            throw new \Exception('Failed to save caregiver.');
        }
    }

    public function updateCaregiver(Caregiver $caregiver): void
    {
        if (!$this->caregiverRepository->update($caregiver)) {
            throw new \Exception('Failed to update caregiver.');
        }
    }

    public function getAllCaregivers(): array
    {
        return $this->caregiverRepository->fetchAll();
    }

    public function getCaregiverById(int $id): array|false
    {
        return $this->caregiverRepository->fetchById($id);
    }
}
