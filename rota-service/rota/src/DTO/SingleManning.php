<?php

namespace App\DTO;

use UnexpectedValueException;
use JsonSerializable;

class SingleManning implements JsonSerializable
{
    private int $monday;
    private int $tuesday;
    private int $wednesday;
    private int $thursday;
    private int $friday;
    private int $saturday;
    private int $sunday;

    public function __construct()
    {
        $this->monday = 0;
        $this->tuesday = 0;
        $this->wednesday = 0;
        $this->thursday = 0;
        $this->friday = 0;
        $this->saturday = 0;
        $this->sunday = 0;
    }

    public function getTotal(): int
    {
        return $this->getMonday() + $this->getTuesday() + $this->getWednesday() + $this->getThursday() + $this->getFriday() + $this->getSaturday() + $this->getSunday();
    }

    /**
     * @param int $day
     * @param $value
     *
     * @throws UnexpectedValueException
     */
    public function addToDay(int $day, $value): void
    {
        switch ($day) {
            case 1:
                $this->monday += $value;
                break;
            case 2:
                $this->tuesday += $value;
                break;
            case 3:
                $this->wednesday += $value;
                break;
            case 4:
                $this->thursday += $value;
                break;
            case 5:
                $this->friday += ($value);
                break;
            case 6:
                $this->saturday += ($value);
                break;
            case 7:
                $this->sunday += ($value);
                break;
            default:
                throw new UnexpectedValueException('Invalid day provided');
        }
    }

    public function getMonday(): int
    {
        return $this->monday;
    }

    public function getTuesday(): int
    {
        return $this->tuesday;
    }

    public function getWednesday(): int
    {
        return $this->wednesday;
    }

    public function getThursday(): int
    {
        return $this->thursday;
    }

    public function getFriday(): int
    {
        return $this->friday;
    }

    public function getSaturday(): int
    {
        return $this->saturday;
    }

    public function getSunday(): int
    {
        return $this->sunday;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'monday' => $this->getMonday(),
            'tuesday' => $this->getTuesday(),
            'wednesday' => $this->getWednesday(),
            'thursday' => $this->getThursday(),
            'friday' => $this->getFriday(),
            'saturday' => $this->getSaturday(),
            'sunday' => $this->getSunday(),
            'total' => $this->getTotal()
        ];
    }
}