<?php

namespace Tests\Unit\Entity\DataTransferObject;

use App\Entity\DataTransferObject\SingleManning;
use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;

class SingleManningTest extends Unit
{

    public function testAddToDayMonday(): void
    {
        $fixture = new SingleManning();
        $fixture->addToDay(1, 100);

        $this->assertSame(100, $fixture->getMonday());
    }

    public function testAddToDayTuesday(): void
    {
        $fixture = new SingleManning();
        $fixture->addToDay(2, 100);

        $this->assertSame(100, $fixture->getTuesday());
    }

    public function testAddToDayWednesday(): void
    {
        $fixture = new SingleManning();
        $fixture->addToDay(3, 100);

        $this->assertSame(100, $fixture->getWednesday());
    }

    public function testAddToDayThursday(): void
    {
        $fixture = new SingleManning();
        $fixture->addToDay(4, 100);

        $this->assertSame(100, $fixture->getThursday());
    }

    public function testAddToDayFriday(): void
    {
        $fixture = new SingleManning();
        $fixture->addToDay(5, 100);

        $this->assertSame(100, $fixture->getFriday());
    }

    public function testAddToDaySaturday(): void
    {
        $fixture = new SingleManning();
        $fixture->addToDay(6, 100);

        $this->assertSame(100, $fixture->getSaturday());
    }

    public function testAddToDaySunday(): void
    {
        $fixture = new SingleManning();
        $fixture->addToDay(7, 100);

        $this->assertSame(100, $fixture->getSunday());
    }

    public function testAddToDayThrowsUnexpectedValueException(): void
    {
        $fixture = new SingleManning();

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('Invalid day provided');

        $fixture->addToDay(-1, 100);
    }

    public function testJsonSerialize(): void
    {
        /** @var MockObject|SingleManning $fixture */
        $fixture = $this->getMockBuilder(SingleManning::class)
            ->onlyMethods(
                ['getMonday', 'getTuesday', 'getWednesday', 'getThursday', 'getFriday', 'getSaturday', 'getSunday']
            )->getMock();

        $fixture->method('getMonday')->willReturn(10);
        $fixture->method('getTuesday')->willReturn(20);
        $fixture->method('getWednesday')->willReturn(30);
        $fixture->method('getThursday')->willReturn(40);
        $fixture->method('getFriday')->willReturn(50);
        $fixture->method('getSaturday')->willReturn(60);
        $fixture->method('getSunday')->willReturn(70);

        $expected = [
            'monday' => 10,
            'tuesday' => 20,
            'wednesday' => 30,
            'thursday' => 40,
            'friday' => 50,
            'saturday' => 60,
            'sunday' => 70,
            'total' => 280
        ];

        $this->assertSame($expected, $fixture->jsonSerialize());
    }
}