<?php

declare(strict_types=1);

namespace Clients;

class ClientService
{
    private ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function saveClient(Client $client): void
    {
        if (!$this->clientRepository->save($client)) {
            throw new \Exception('Failed to save client.');
        }
    }

    public function updateClient(Client $client): void
    {
        if (!$this->clientRepository->update($client)) {
            throw new \Exception('Failed to update client.');
        }
    }

    public function getAllClients(): array
    {
        return $this->clientRepository->fetchAll();
    }

    public function getClientById(int $id): array|false
    {
        return $this->clientRepository->fetchById($id);
    }
}
