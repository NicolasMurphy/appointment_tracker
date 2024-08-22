<?php

declare(strict_types=1);

namespace Clients;

class Client
{
    // private ?int $id = null;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $phoneNumber;
    private string $address;

    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $phoneNumber,
        string $address
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
    }

    // public function getId(): ?int
    // {
    //     return $this->id;
    // }

    // public function setId(int $id): void
    // {
    //     $this->id = $id;
    // }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
}
