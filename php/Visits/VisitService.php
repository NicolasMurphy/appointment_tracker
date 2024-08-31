<?php

declare(strict_types=1);

namespace Visits;

class VisitService
{
    private VisitRepository $visitRepository;

    public function __construct(VisitRepository $visitRepository)
    {
        $this->visitRepository = $visitRepository;
    }

    public function saveVisit(Visit $visit): void
    {
        if (!$this->visitRepository->save($visit)) {
            throw new \Exception('Failed to save visit.');
        }
    }

    public function updateVisit(Visit $visit): void
    {
        if (!$this->visitRepository->update($visit)) {
            throw new \Exception('Failed to update visit.');
        }
    }

    public function updateVerificationStatus(int $id, bool $verified): bool
    {
        return $this->visitRepository->updateVerificationStatus($id, $verified);
    }


    public function deleteVisit(int $id): bool
    {
        return $this->visitRepository->delete($id);
    }

    public function getAllVisits(): array
    {
        return $this->visitRepository->fetchAll();
    }

    public function getVisitById(int $id): array|false
    {
        return $this->visitRepository->fetchById($id);
    }
}
