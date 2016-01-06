<?php

namespace Application;
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

    public function nurseExists(Nurse $nurse)
    {
        foreach ($this->shifts as $shift) {
            if ($shift->nurseExists($nurse->id())) {
                return true;
            }
        }

        return false;
    }

    protected abstract function prepareShifts();

}