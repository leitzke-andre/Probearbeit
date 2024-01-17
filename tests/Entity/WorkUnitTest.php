<?php

namespace App\Tests\Entity;

use App\Entity\WorkUnit;
use PHPUnit\Framework\TestCase;
use DateTime;

class WorkUnitTest extends TestCase
{

    public function testGetTimeElapsedInMinutes_OneMinute()
    {
        $workUnit = new WorkUnit();
        $workUnit->setStart(new DateTime('2024-01-01 00:00:00'));
        $workUnit->setEnd(new DateTime('2024-01-01 00:01:00'));

        self::assertEquals(1, $workUnit->getTimeElapsedInMinutes());
    }

    public function testGetTimeElapsedInMinutes_OverOneHour()
    {
        $workUnit = new WorkUnit();
        $workUnit->setStart(new DateTime('2024-01-01 00:00:00'));
        $workUnit->setEnd(new DateTime('2024-01-01 01:01:01'));

        self::assertEquals(61, $workUnit->getTimeElapsedInMinutes());
    }

    public function testIsValid_EndDateGreater()
    {
        $workUnit = new WorkUnit();
        $workUnit->setStart(new DateTime('2024-01-01 00:00:00'));
        $workUnit->setEnd(new DateTime('2024-01-01 01:01:01'));

        self::assertTrue($workUnit->isValid());
    }

    public function testIsValid_DatesEqual()
    {
        $workUnit = new WorkUnit();
        $workUnit->setStart(new DateTime('2024-01-01 00:00:00'));
        $workUnit->setEnd(new DateTime('2024-01-01 00:00:00'));

        self::assertNotTrue($workUnit->isValid());
    }

    public function testIsValid_StartDateGreater()
    {
        $workUnit = new WorkUnit();
        $workUnit->setStart(new DateTime('2024-01-01 01:01:01'));
        $workUnit->setEnd(new DateTime('2024-01-01 00:00:00'));

        self::assertNotTrue($workUnit->isValid());
    }
}
