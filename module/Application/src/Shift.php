<?php

namespace Application;

use Application\Shift\DayShift;
use Application\Shift\EarlyShift;
use Application\Shift\LateShift;
use Application\Shift\NightShift;

/**
 * Abstract class Shift
 * @author Wojciech Polus
 * @package Application
 */
abstract class Shift
{

    /**
     * @var int
     */
    protected $nurseCount;

    /**
     * @var Nurse[]
     */
    public $nurses = array();

    /**
     * @var Day
     */
    private $day;


    public function __construct($count, Day $day)
    {
        $this->nurseCount = (int) $count;
        $this->day = $day;

    }

    /**
     * Returns shift day
     * @return Day
     */
    public function getDay()
    {
        return $this->day;
    }


    /**
     * Attaches nurse to shift
     * @param Nurse $nurse
     */
    public function attachNurse(Nurse $nurse)
    {
        if ($this->nurseCount > count($this->nurses)) {
            $this->nurses[$nurse->id()] = $nurse;
        }
    }

    /**
     * Checks if the nurse is assigned to the shift
     * @param int $id
     * @return bool
     */
    public function nurseExists($id)
    {
        return array_key_exists($id, $this->nurses);
    }


    /**
     * Checks if shift is full
     * @return bool
     */
    public function isFull()
    {
        if ($this->nurseCount == count($this->nurses)) {
            return true;
        } else {
            return false;
        }
    }

    public function getNurses()
    {
        return $this->nurses;
    }

    /**
     * Checks constraint:
     * "Following a series of at least 2 consecutive night shifts a 42 hours rest is required."
     * @param Shift $shift
     * @return bool
     */
    public function mayByNext(Shift $shift)
    {

        if ($this instanceof NightShift && $shift instanceof NightShift) {
            return true;
        }


        if ($this instanceof EarlyShift) {
            return true;
        }

        if ($this instanceof DayShift) {
            return true;
        }

        if ($this instanceof LateShift && ($shift instanceof LateShift || $shift instanceof NightShift)) {
            return true;
        }

        return false;
    }

    abstract function getStartTime();

    abstract function getStopTime();

    abstract function getType();

}