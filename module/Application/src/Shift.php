<?php

namespace Application;

use Application\Shift\NightShift;
use Exception;

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

    public function getDay()
    {
        return $this->day;
    }

    public function attachNurse(Nurse $nurse)
    {
        if ($this->nurseCount > count($this->nurses)) {
            $this->nurses[$nurse->id()] = $nurse;
        } else {
            //throw new Exception('Zmiana jest już zapełniona');
        }
    }

    public function nurseExists($id)
    {
        return array_key_exists($id, $this->nurses);
    }


    public function isFull()
    {
        if ($this->nurseCount == count($this->nurses)) {
            return true;
        } else {
            return false;
        }
    }

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
        $thisstop = new \DateTime("24:00:00");

        $thisdiff = $thisStart->diff($thisstop);
        $h = $diff->h + $thisdiff->h;

        if ($h >= 11) {
            return true;
        } else {
            return false;
        }

    }

    abstract function getStartTime();

    abstract function getStopTime();

}