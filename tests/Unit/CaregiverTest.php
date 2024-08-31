<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Caregivers\Caregiver;

class CaregiverTest extends TestCase
{
    #[DataProvider('validPayRateProvider')]
    public function testValidPayRate($payRate)
    {
        $caregiver = new Caregiver(
            'John',
            'Doe',
            'john.doe@example.com',
            '+1234567890',
            '123 Main St',
            $payRate
        );

        $this->assertInstanceOf(Caregiver::class, $caregiver);
        $this->assertEquals((float)$payRate, $caregiver->getPayRate());
    }

    #[DataProvider('invalidPayRateProvider')]
    public function testInvalidPayRate($payRate)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid pay rate format. It should be a valid number.');

        new Caregiver(
            'John',
            'Doe',
            'john.doe@example.com',
            '+1234567890',
            '123 Main St',
            $payRate
        );
    }

    public static function validPayRateProvider(): array
    {
        return [
            [25],
            [25.00],
            ['25'],
            ['25.50'],
            [100],
            [0.01],
        ];
    }

    public static function invalidPayRateProvider(): array
    {
        return [
            [-25],
            [-25.00],
            ['-25'],
            [0],
            ['0'],
            ['abc'],
            [''],
            ['25,00'],
            ['25.00.00'],
        ];
    }
}
