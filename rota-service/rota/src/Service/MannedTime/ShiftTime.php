<?php

namespace App\Service\MannedTime;

use DateTimeInterface;

class ShiftTime
{
    private DateTimeInterface $shiftTime;
    private bool $startShift;

    public function __construct(DateTimeInterface $shiftTime, Bool $startShift)
    {
        $this->shiftTime = $shiftTime;
        $this->startShift = $startShift;
    }

    /**
     * @return DateTimeInterface
     */
    public function getShiftTime(): DateTimeInterface
    {
        return $this->shiftTime;
    }

    /**
     * @return bool
     */
    public function isStartShift(): bool
    {
        return $this->startShift;
    }
}