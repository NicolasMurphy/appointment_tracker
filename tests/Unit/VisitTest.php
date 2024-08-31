<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Visits\Visit;

class VisitTest extends TestCase
{
    #[DataProvider('invalidDateProvider')]
    public function testInvalidDateThrowsException($invalidDate)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid date format.');

        $clientId = 1;
        $caregiverId = 2;
        $serviceId = 2;
        $startTime = '09:00';
        $endTime = '10:00';
        $notes = 'Follow-up visit';

        new Visit($clientId, $caregiverId, $serviceId, $invalidDate, $startTime, $endTime, $notes);
    }

    #[DataProvider('invalidTimeProvider')]
    public function testInvalidStartTimeThrowsException($invalidStartTime)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid start time format.');

        $clientId = 1;
        $caregiverId = 2;
        $serviceId = 2;
        $date = '2024-08-23';
        $endTime = '10:00';
        $notes = 'Follow-up visit';

        new Visit($clientId, $caregiverId, $serviceId, $date, $invalidStartTime, $endTime, $notes);
    }

    #[DataProvider('invalidTimeProvider')]
    public function testInvalidEndTimeThrowsException($invalidEndTime)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid end time format.');

        $clientId = 1;
        $caregiverId = 2;
        $serviceId = 2;
        $date = '2024-08-23';
        $startTime = '09:00';
        $notes = 'Follow-up visit';

        new Visit($clientId, $caregiverId, $serviceId, $date, $startTime, $invalidEndTime, $notes);
    }

    public static function invalidDateProvider(): array
    {
        return [
            ['invalid-date'],
            ['2024/08/23'],
            ['08-23-2024'],
            ['2024.08.23'],
            [''],
        ];
    }

    public static function invalidTimeProvider(): array
    {
        return [
            ['25:00'],
            ['99:99'],
            ['12:60'],
            ['invalid-time'],
            [''],
        ];
    }
}
