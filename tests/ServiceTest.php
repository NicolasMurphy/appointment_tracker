<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Services\Service;

class ServiceTest extends TestCase
{
    #[DataProvider('validBillRateProvider')]
    public function testValidBillRate($billRate)
    {
        $service = new Service(
            'Code',
            'Desc',
            $billRate
        );

        $this->assertInstanceOf(Service::class, $service);
        $this->assertEquals((float)$billRate, $service->getBillRate());
    }

    #[DataProvider('invalidBillRateProvider')]
    public function testInvalidBillRate($billRate)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid bill rate format. It should be a valid number.');

        new Service(
            'Code',
            'Desc',
            $billRate
        );
    }

    public static function validBillRateProvider(): array
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

    public static function invalidBillRateProvider(): array
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
