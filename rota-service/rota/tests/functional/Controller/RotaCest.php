<?php


use App\Entity\Rota;
use App\Entity\Shift;
use App\Entity\Shop;
use App\Entity\Staff;
use App\Service\MannedTime\Calculator;
use App\Tests\FunctionalTester;
use Cake\Chronos\Chronos;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class RotaCest
{
    private Shop $shop;
    private Rota $rota;

    public function _before(FunctionalTester $I)
    {
        $this->shop = $this->createTestShop($I);
        $this->rota = $this->createTestRota($I, $this->shop);
    }

    public function testSingleShift(FunctionalTester $I)
    {
        $staff = $this->createStaff($I, $this->shop, 'Black', 'Widow');
        $startTime = $this->getStartOfWeek()->hour(9);
        $endTime = $this->getStartOfWeek()->hour(17);
        $this->createShift($I, $staff, $startTime, $endTime);

        $I->sendGET("/rota/{$this->rota->getId()}/singlemannedtime");
        $I->canSeeResponseCodeIs(Response::HTTP_OK);
        $expected = [
            'data' => [
                'monday' => 480,
                'tuesday' => 0,
                'wednesday' => 0,
                'thursday' => 0,
                'friday' => 0,
                'saturday' => 0,
                'sunday' => 0,
                'total' => 480
            ]
        ];

        $I->seeResponseContainsJson($expected);
    }

    public function testTwoShiftsNoOverlap(FunctionalTester $I)
    {
        $staff1 = $this->createStaff($I, $this->shop, 'Black', 'Widow');
        $staff2 = $this->createStaff($I, $this->shop, 'Thor', 'Odinson');

        $startTime = $this->getStartOfWeek()->addDays(1)->hour(9);
        $endTime = $this->getStartOfWeek()->addDays(1)->hour(12);
        $this->createShift($I, $staff1, $startTime, $endTime);

        $startTime = $this->getStartOfWeek()->addDays(1)->hour(12);
        $endTime = $this->getStartOfWeek()->addDays(1)->hour(17);
        $this->createShift($I, $staff2, $startTime, $endTime);

        $I->sendGET("/rota/{$this->rota->getId()}/singlemannedtime");
        $I->canSeeResponseCodeIs(Response::HTTP_OK);
        $expected = [
            'data' => [
                'monday' => 0,
                'tuesday' => 480,
                'wednesday' => 0,
                'thursday' => 0,
                'friday' => 0,
                'saturday' => 0,
                'sunday' => 0,
                'total' => 480
            ]
        ];

        $I->seeResponseContainsJson($expected);
    }

    public function testTwoShiftsOverlap(FunctionalTester $I)
    {
        $staff1 = $this->createStaff($I, $this->shop, 'Wolverine', 'Logan');
        $staff2 = $this->createStaff($I, $this->shop, 'Gamora', 'Zen');

        $startTime = $this->getStartOfWeek()->addDays(2)->hour(9);
        $endTime = $this->getStartOfWeek()->addDays(2)->hour(13);
        $this->createShift($I, $staff1, $startTime, $endTime);

        $startTime = $this->getStartOfWeek()->addDays(2)->hour(10);
        $endTime = $this->getStartOfWeek()->addDays(2)->hour(17);
        $this->createShift($I, $staff2, $startTime, $endTime);

        $I->sendGET("/rota/{$this->rota->getId()}/singlemannedtime");
        $I->canSeeResponseCodeIs(Response::HTTP_OK);
        $expected = [
            'data' => [
                'monday' => 0,
                'tuesday' => 0,
                'wednesday' => 300,
                'thursday' => 0,
                'friday' => 0,
                'saturday' => 0,
                'sunday' => 0,
                'total' => 300
            ]
        ];

        $I->seeResponseContainsJson($expected);
    }

    public function testTwoShiftGapBetween(FunctionalTester $I)
    {
        $staff1 = $this->createStaff($I, $this->shop, 'Wolverine', 'Logan');
        $staff2 = $this->createStaff($I, $this->shop, 'Gamora', 'Zen');

        $startTime = $this->getStartOfWeek()->addDays(3)->hour(9);
        $endTime = $this->getStartOfWeek()->addDays(3)->hour(12);
        $this->createShift($I, $staff1, $startTime, $endTime);

        $startTime = $this->getStartOfWeek()->addDays(3)->hour(13);
        $endTime = $this->getStartOfWeek()->addDays(3)->hour(17);
        $this->createShift($I, $staff2, $startTime, $endTime);

        $I->sendGET("/rota/{$this->rota->getId()}/singlemannedtime");
        $I->canSeeResponseCodeIs(Response::HTTP_OK);
        $expected = [
            'data' => [
                'monday' => 0,
                'tuesday' => 0,
                'wednesday' => 0,
                'thursday' => 420,
                'friday' => 0,
                'saturday' => 0,
                'sunday' => 0,
                'total' => 420
            ]
        ];

        $I->seeResponseContainsJson($expected);
    }

    public function testThreeShiftsOverlapStartAndEnd(FunctionalTester $I)
    {
        $staff1 = $this->createStaff($I, $this->shop, 'Black', 'Widow');
        $staff2 = $this->createStaff($I, $this->shop, 'Thor', 'Odinson');
        $staff3 = $this->createStaff($I, $this->shop, 'Wolverine', 'Logan');

        $startTime = $this->getStartOfWeek()->addDays(4)->hour(9);
        $endTime = $this->getStartOfWeek()->addDays(4)->hour(17);
        $this->createShift($I, $staff1, $startTime, $endTime);

        $startTime = $this->getStartOfWeek()->addDays(4)->hour(9);
        $endTime = $this->getStartOfWeek()->addDays(4)->hour(12);
        $this->createShift($I, $staff2, $startTime, $endTime);

        $startTime = $this->getStartOfWeek()->addDays(4)->hour(14);
        $endTime = $this->getStartOfWeek()->addDays(4)->hour(17);
        $this->createShift($I, $staff3, $startTime, $endTime);

        $I->sendGET("/rota/{$this->rota->getId()}/singlemannedtime");
        $I->canSeeResponseCodeIs(Response::HTTP_OK);
        $expected = [
            'data' => [
                'monday' => 0,
                'tuesday' => 0,
                'wednesday' => 0,
                'thursday' => 0,
                'friday' => 120,
                'saturday' => 0,
                'sunday' => 0,
                'total' => 120
            ]
        ];

        $I->seeResponseContainsJson($expected);
    }

    private function getStartOfWeek(): Chronos
    {
        return Chronos::now()->startOfWeek();
    }

    /**
     * @param FunctionalTester $I
     *
     * @return object|Shop
     */
    private function createTestShop(FunctionalTester $I): object
    {
        $I->haveInRepository(
            Shop::class,
            [
                'name' => 'Test Shop'
            ]
        );

        return $I->grabEntityFromRepository(Shop::class, ['name' => 'Test Shop']);
    }

    /**
     * @param FunctionalTester $I
     * @param Shop $shop
     * @param string $firstname
     * @param string $surname
     *
     * @return object|Staff
     */
    private function createStaff(FunctionalTester $I, Shop $shop, string $firstname, string $surname): object
    {
        $I->haveInRepository(
            Staff::class,
            [
                'firstName' => $firstname,
                'surname' => $surname,
                'shop' => $shop
            ]
        );

        return $I->grabEntityFromRepository(Staff::class,
            ['shop' => $shop, 'firstName' => $firstname, 'surname' => $surname]);
    }

    private function createShift(
        FunctionalTester $I,
        Staff $staff,
        DateTimeInterface $startShift,
        DateTimeInterface $endShift
    ): void {
        $I->haveInRepository(
            Shift::class,
            [
                'staff' => $staff,
                'startTime' => $startShift,
                'endTime' => $endShift,
                'rota' => $this->rota
            ]
        );
    }

    /**
     * @param FunctionalTester $I
     * @param Shop $shop
     *
     * @return object|Rota
     */
    private function createTestRota(FunctionalTester $I, Shop $shop): object
    {
        $I->haveInRepository(
            Rota::class,
            [
                'shop' => $shop,
                'weekCommenceDate' => $this->getStartOfWeek()
            ]
        );

        return $I->grabEntityFromRepository(Rota::class,
            ['shop' => $shop, 'weekCommenceDate' => $this->getStartOfWeek()->toDateString()]);

    }

}