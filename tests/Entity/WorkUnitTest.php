<?php

namespace App\Tests\Entity;

use App\Entity\Project;
use App\Entity\WorkUnit;
use PHPUnit\Framework\TestCase;
use DateTime;

class WorkUnitTest extends TestCase
{

    public function test_getTimeElapsedInMinutes_difference_should_be_equal_to_one_minute()
    {
        $workUnit = new WorkUnit();
        $workUnit->setStart(new DateTime('2024-01-01 00:00:00'));
        $workUnit->setEnd(new DateTime('2024-01-01 00:01:00'));

        self::assertEquals(1, $workUnit->getTimeElapsedInMinutes());
    }

    public function testGetTimeElapsedInMinute_should_work_for_periods_over_60_minutes()
    {
        $workUnit = new WorkUnit();
        $workUnit->setStart(new DateTime('2024-01-01 00:00:00'));
        $workUnit->setEnd(new DateTime('2024-01-01 01:01:01'));

        self::assertEquals(61, $workUnit->getTimeElapsedInMinutes());
    }

    public function testIsValid_WorkUnit_is_valid_when_end_time_is_greater_than_start_time_and_project_is_not_null()
    {
        $workUnit = new WorkUnit();
        $workUnit->setProject(new Project());
        $workUnit->setStart(new DateTime('2024-01-01 00:00:00'));
        $workUnit->setEnd(new DateTime('2024-01-01 01:01:01'));

        self::assertTrue($workUnit->isValid());
    }

    public function testIsValid_WorkUnit_is_not_valid_when_end_time_is_equal_to_start_time()
    {
        $workUnit = new WorkUnit();
        $workUnit->setProject(new Project());
        $workUnit->setStart(new DateTime('2024-01-01 00:00:00'));
        $workUnit->setEnd(new DateTime('2024-01-01 00:00:00'));

        self::assertNotTrue($workUnit->isValid());
    }

    public function testIsValid_is_not_valid_when_start_time_is_greater_than_end_time()
    {
        $workUnit = new WorkUnit();
        $workUnit->setProject(new Project());
        $workUnit->setStart(new DateTime('2024-01-01 01:01:01'));
        $workUnit->setEnd(new DateTime('2024-01-01 00:00:00'));

        self::assertNotTrue($workUnit->isValid());
    }

    public function testIsValid_WorkUnit_is_notvalid_when_project_is_null()
    {
        $workUnit = new WorkUnit();
        $workUnit->setStart(new DateTime('2024-01-01 00:00:00'));
        $workUnit->setEnd(new DateTime('2024-01-01 01:01:01'));

        self::assertNotTrue($workUnit->isValid());
    }
}
