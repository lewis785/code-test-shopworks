<?php

namespace App\DataFixtures;

use App\Entity\Rota;
use App\Entity\Shift;
use App\Entity\Shop;
use App\Entity\Staff;
use Cake\Chronos\Chronos;
use DateTimeInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $weekStart = Chronos::now()->startOfWeek()->startOfDay();

        $shop = new Shop();
        $shop->setName('FunHouse');
        $manager->persist($shop);

        $rota = new Rota();
        $rota->setShop($shop)
            ->setWeekCommenceDate($weekStart);
        $manager->persist($rota);

        $rota = new Rota();
        $rota->setShop($shop)
            ->setWeekCommenceDate($weekStart->addWeek());
        $manager->persist($rota);

        $staff = $this->createStaff($manager, 'Black', 'Widow', $shop);
        $this->createShift($manager, $staff, $rota, $weekStart->hour(9), $weekStart->hour(17));
        $this->createShift($manager, $staff, $rota, $weekStart->addDays(1)->hour(9), $weekStart->addDays(1)->hour(13));

        $staff = $this->createStaff($manager, 'Thor', 'Odinson', $shop);
        $this->createShift($manager, $staff, $rota, $weekStart->addDays(1)->hour(13), $weekStart->addDays(1)->hour(17));

        $staff = $this->createStaff($manager, 'Wolverine', 'Logan', $shop);
        $this->createShift($manager, $staff, $rota, $weekStart->addDays(2)->hour(9), $weekStart->addDays(2)->hour(13));
        $this->createShift($manager, $staff, $rota, $weekStart->addDays(3)->hour(9), $weekStart->addDays(3)->hour(12));


        $staff = $this->createStaff($manager, 'Gamora', 'Zen', $shop);
        $this->createShift($manager, $staff, $rota, $weekStart->addDays(2)->hour(10), $weekStart->addDays(2)->hour(17));
        $this->createShift($manager, $staff, $rota, $weekStart->addDays(3)->hour(13), $weekStart->addDays(3)->hour(17));

        $manager->flush();
    }

    private function createStaff(ObjectManager $manager, string $firstname, string $lastname, Shop $shop): Staff
    {
        $staff = (new Staff())
            ->setFirstName($firstname)
            ->setSurname($lastname)
            ->setShop($shop);
        $manager->persist($staff);

        return $staff;
    }

    private function createShift(
        ObjectManager $manager,
        Staff $staff,
        Rota $rota,
        DateTimeInterface $start,
        DateTimeInterface $end
    ): Shift {
        $shift = (new Shift())
            ->setStaff($staff)
            ->setRota($rota)
            ->setStartTime($start)
            ->setEndTime($end);
        $manager->persist($shift);

        return $shift;
    }
}
