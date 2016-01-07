<?php

namespace Application;
use Application\Day\WeekDay;
use Application\Shift\DayShift;
use Application\Shift\EarlyShift;
use Application\Shift\LateShift;
use Application\Shift\NightShift;

/**
 * Abstract class Day
 * @author Wojciech Polus
 * @package Application
 */
abstract class Day
{
    protected $dayNumber;

    /**
     * @var Shift[]
     */
    protected $shifts;

    public function __construct($dayNumber)
    {
        $this->dayNumber = $dayNumber;
        $this->prepareShifts();
    }

    public function getShifts()
    {
        return $this->shifts;
    }

    public function shiftsCompleted()
    {
        foreach ($this->shifts as $shift) {
            if (!$shift->isFull()) {
                return false;
            }
        }

        return true;
    }

    public function getDayNumber()
    {
        return $this->dayNumber;
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