<?php

namespace App\Service\MannedTime;


use App\DTO\SingleManning;
use App\Entity\Rota;
use App\Entity\Shift;
use Cake\Chronos\Chronos;
use Doctrine\ORM\EntityManagerInterface;

class Calculator
{
    private SingleManning $singleManning;

    public function __construct(Rota $rota, EntityManagerInterface $entityManager)
    {
        $this->singleManning = $this->createSingleManning();
        $this->process($this->retrieveShifts($rota, $entityManager));
    }

    public function getSingleManning(): SingleManning
    {
        return $this->singleManning;
    }

    protected function createSingleManning(): SingleManning
    {
        return new SingleManning();
    }

    protected function retrieveShifts(Rota $rota, EntityManagerInterface $entityManager): array
    {
        return $entityManager->getRepository(Shift::class)->findBy(['rota' => $rota]);
    }

    /**
     * @param Shift[] $shifts
     */
    private function process(array $shifts): void
    {
        $staffAtWork = 0;
        $lastShiftChange = null;

        foreach ($this->retrieveShiftChanges($shifts) as $change) {
            if ($lastShiftChange === null) {
                $lastShiftChange = Chronos::instance($change->getShiftTime());
                $staffAtWork++;
                continue;
            }

            $currentShiftChange = Chronos::instance($change->getShiftTime());

            if ($staffAtWork === 1) {
                $this->singleManning->addToDay(
                    $lastShiftChange->dayOfWeek,
                    $currentShiftChange->diffInMinutes($lastShiftChange, true)
                );
            }

            $change->isStartShift() ? $staffAtWork++ : $staffAtWork--;
            $lastShiftChange = $currentShiftChange;
        }
    }

    /**
     * @param Shift[] $shifts
     *
     * @return ShiftTime[]
     */
    private function retrieveShiftChanges(array $shifts): array
    {
        /** @var ShiftTime[] $shiftChanges */
        $shiftChanges = [];

        foreach ($shifts as $shift) {
            $shiftChanges[] = new ShiftTime($shift->getStartTime(), true);
            $shiftChanges[] = new ShiftTime($shift->getEndTime(), false);
        }

        return $this->sortByDateTime($shiftChanges);
    }

    private function sortByDateTime(array $input): array
    {
        usort($input, function (ShiftTime $a, ShiftTime $b) {
            if ($a->getShiftTime()->getTimestamp() === $b->getShiftTime()->getTimestamp()) {
                return 0;
            }

            return $a->getShiftTime()->getTimestamp() < $b->getShiftTime()->getTimestamp() ? -1 : 1;
        });

        return $input;
    }
}
