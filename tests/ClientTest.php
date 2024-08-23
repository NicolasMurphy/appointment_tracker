<?php

use PHPUnit\Framework\TestCase;
use Clients\Client;

class ClientTest extends TestCase
{
    public function testInvalidEmailThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid email format.");

        $firstName = "John";
        $lastName = "Doe";
        $invalidEmail = "invalid-email";
        $phoneNumber = "+1234567890";
        $address = "123 Main St";

        new Client($firstName, $lastName, $invalidEmail, $phoneNumber, $address);
    }

    public function testInvalidPhoneNumberThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid phone number format.");

        $firstName = "John";
        $lastName = "Doe";
        $email = "john.doe@example.com";
        $invalidPhoneNumber = "123-abc-7890";
        $address = "123 Main St";

        new Client($firstName, $lastName, $email, $invalidPhoneNumber, $address);
    }
}
