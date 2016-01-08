<?php

namespace Application;

use Application\Day\WeekDay;
use Application\Shift\DayShift;
use Application\Shift\EarlyShift;
use Application\Shift\LateShift;
use Application\Shift\NightShift;
use DateTime;
use DateInterval;


/**
 * Abstract class Day
 * @author Wojciech Polus
 * @package Application
 */
abstract class Day
{
    /**
     * @var int
     */
    protected $dayNumber;

    /**
     * @var DateTime
     */
    private $day;

    /**
     * @var Shift[]
     */
    protected $shifts;

    public function __construct($dayNumber, $dateStart)
    {
        $this->dayNumber = $dayNumber;
        $date = new DateTime($dateStart);
        $interval = DateInterval::createfromdatestring('+'.$dayNumber.' day');

        $date->add($interval);
        $this->day = $date;

        $this->prepareShifts();
    }

    public function getDayNumber()
    {
        return $this->dayNumber;
    }


    /**
     * Returns day
     * @return DateTime
     */
    public function getDay()
    {
        return $this->day;
    }


    /**
     * @return Shift[]
     */
    public function getShifts()
    {
        return $this->shifts;
    }


    /**
     * checks if shift is full
     * @return bool
     */
    public function shiftsCompleted()
    {
        foreach ($this->shifts as $shift) {
            if (!$shift->isFull()) {
                return false;
            }
        }

        return true;
    }


    public function getNightShift()
    {
        foreach ($this->shifts as $shift) {
            if ($shift instanceof NightShift) {
                return $shift;
            }
        }
    }


    public function getLateShift()
    {
        foreach ($this->shifts as $shift) {
            if ($shift instanceof LateShift) {
                return $shift;
            }
        }
    }

    public function getEarlyShift()
    {
        foreach ($this->shifts as $shift) {
            if ($shift instanceof EarlyShift) {
                return $shift;
            }
        }
    }

    public function getDayShift()
    {
        foreach ($this->shifts as $shift) {
            if ($shift instanceof DayShift) {
                return $shift;
            }
        }
    }

    /**
     * Checks if nurse works in this day
     * @param Nurse $nurse
     * @return bool
     */
    public function nurseExists(Nurse $nurse)
    {
        foreach ($this->shifts as $shift) {
            if ($shift->nurseExists($nurse->id())) {
                return true;
            }
        }

        return false;
    }

    public function getNurses()
    {
        $nurses = array();

        foreach ($this->shifts as $shift) {
            $nurses = array_merge($nurses, $shift->getNurses());
        }

        return $nurses;
    }

    public function isWeekend()
    {
        if ($this instanceof WeekDay) {
            return true;
        }
    }

    protected abstract function prepareShifts();

}