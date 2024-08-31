<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Clients\Client;

class ClientTest extends TestCase
{
    #[DataProvider('invalidEmailProvider')]
    public function testInvalidEmailThrowsException($invalidEmail)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid email format.");

        $firstName = "John";
        $lastName = "Doe";
        $phoneNumber = "+1234567890";
        $address = "123 Main St";

        new Client($firstName, $lastName, $invalidEmail, $phoneNumber, $address);
    }

    #[DataProvider('invalidPhoneNumberProvider')]
    public function testInvalidPhoneNumberThrowsException($invalidPhoneNumber)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid phone number format.");

        $firstName = "John";
        $lastName = "Doe";
        $email = "john.doe@example.com";
        $address = "123 Main St";

        new Client($firstName, $lastName, $email, $invalidPhoneNumber, $address);
    }

    public static function invalidEmailProvider(): array
    {
        return [
            ['invalid-email'],
            ['john.doe@'],
            ['@example.com'],
            ['john.doe@example'],
            ['john.doe@.com'],
            [''],
        ];
    }

    public static function invalidPhoneNumberProvider(): array
    {
        return [
            ['123-abc-7890'],
            ['123456789'],
            ['phone123'],
            [''],
        ];
    }
}
