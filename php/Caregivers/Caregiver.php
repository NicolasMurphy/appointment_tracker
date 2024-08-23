<?php

declare(strict_types=1);

namespace Caregivers;

class Caregiver
{
    private ?int $id = null;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $phoneNumber;
    private string $address;
    private string $payRate;

    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $phoneNumber,
        string $address,
        string $payRate
    ) {

        if (!$this->isValidEmail($email)) {
            throw new \InvalidArgumentException("Invalid email format.");
        }

        if (!$this->isValidPhoneNumber($phoneNumber)) {
            throw new \InvalidArgumentException("Invalid phone number format.");
        }

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->address = $address;
        $this->payRate = $payRate;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

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

    public function getPayRate(): string
    {
        return $this->payRate;
    }

    private function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function isValidPhoneNumber(string $phoneNumber): bool
    {
        return preg_match('/^\+?[0-9\s\-()]{10,20}$/', $phoneNumber) === 1;
    }
}
