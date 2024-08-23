<?php

use PHPUnit\Framework\TestCase;
use Appointments\Appointment;

class AppointmentTest extends TestCase
{
    public function testInvalidDateThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid date format.');

        $clientId = 1;
        $caregiverId = 2;
        $invalidDate = 'invalid-date';
        $startTime = '09:00';
        $endTime = '10:00';
        $notes = 'Follow-up appointment';

        new Appointment($clientId, $caregiverId, $invalidDate, $startTime, $endTime, $notes);
    }

    public function testInvalidStartTimeThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid start time format.');

        $clientId = 1;
        $caregiverId = 2;
        $date = '2024-08-23';
        $invalidStartTime = '25:00';
        $endTime = '10:00';
        $notes = 'Follow-up appointment';

        new Appointment($clientId, $caregiverId, $date, $invalidStartTime, $endTime, $notes);
    }

    public function testInvalidEndTimeThrowsException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid end time format.');

        $clientId = 1;
        $caregiverId = 2;
        $date = '2024-08-23';
        $startTime = '09:00';
        $invalidEndTime = 'invalid-time';
        $notes = 'Follow-up appointment';

        new Appointment($clientId, $caregiverId, $date, $startTime, $invalidEndTime, $notes);
    }
}
