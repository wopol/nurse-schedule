<?php

namespace Application;

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

    /**
     * Checks constraint:
     * "Following a series of at least 2 consecutive night shifts a 42 hours rest is required."
     * @param Shift $shift
     * @return bool
     */
    public function mayByNext(Shift $shift)
    {
        if ($this instanceof NightShift && !$shift instanceof NightShift) {
            return false;
        } else if ($this instanceof NightShift && !$shift instanceof NightShift) {
            return true;
        }

        $start = new \DateTime($shift->getStartTime());
        $stop = new \DateTime("00:00:00");

        $diff = $start->diff($stop);

        $thisStart = $start = new \DateTime($shift->getStopTime());
        $thisStop = new \DateTime("24:00:00");

        $thisDiff = $thisStart->diff($thisStop);
        $h = $diff->h + $thisDiff->h;

        if ($h >= 11) {
            return true;
        } else {
            return false;
        }

    }

    abstract function getStartTime();

    abstract function getStopTime();

    abstract function getType();

}