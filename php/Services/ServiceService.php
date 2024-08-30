<?php

declare(strict_types=1);

namespace Services;

class ServiceService
{
    private ServiceRepository $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function saveService(Service $service): void
    {
        if (!$this->serviceRepository->save($service)) {
            throw new \Exception('Failed to save service.');
        }
    }

    public function updateService(Service $service): void
    {
        if (!$this->serviceRepository->update($service)) {
            throw new \Exception('Failed to update service.');
        }
    }

    public function getAllServices(): array
    {
        return $this->serviceRepository->fetchAll();
    }

    public function getServiceById(int $id): array|false
    {
        return $this->serviceRepository->fetchById($id);
    }
}
