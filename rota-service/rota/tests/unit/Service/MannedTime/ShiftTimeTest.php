<?php

namespace Tests\Unit\Service\MannedTime;

use App\Service\MannedTime\ShiftTime;
use Cake\Chronos\Chronos;
use Codeception\Test\Unit;
use DateTimeInterface;

class ShiftTimeTest extends Unit
{
    public function testGetShiftTime(): void
    {
        $chronos = Chronos::now();
        $fixture = new ShiftTime($chronos, true);

        $this->assertInstanceOf(DateTimeInterface::class, $fixture->getShiftTime());
        $this->assertSame($chronos->getTimestamp(), $fixture->getShiftTime()->getTimestamp());
    }

    /**
     * @dataProvider startShiftDataProvider
     * @param bool $isStartShift
     */
    public function testGetIsStartShift(bool $isStartShift): void
    {
        $chronos = Chronos::now();
        $fixture = new ShiftTime($chronos, $isStartShift);

        $this->assertSame($isStartShift, $fixture->isStartShift());
    }

    public function startShiftDataProvider()
    {
        return [
            'is start shift' => [true],
            'is not start shift' => [false]
        ];
    }
}