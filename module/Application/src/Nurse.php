<?php


namespace Application;
use Application\Shift\NightShift;

/**
 * Class Nurse
 * @author Wojciech Polus
 * @package Application
 */
class Nurse
{
    public static $seq = 1;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $hoursInContract;

    /**
     * Used hours in period
     * @var int
     */
    private $usedHours;

    /**
     * Max hours
     * @var int
     */
    private $totalHours;


    public $nightShift = 0;

    /**
     * @var Shift[]
     */
    private $shifts = array();


    public function __construct($hoursInContract)
    {
        $this->id = self::$seq++;
        $this->hoursInContract = $hoursInContract;
        $this->totalHours = $hoursInContract *5;
    }

    /**
     * Checks if nurse used all available hours in period
     * @return bool
     */
    public function usedAllHours()
    {
        if ($this->usedHours + 4 >= $this->totalHours) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns nurse id
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Attach shift to nurse
     * @param Shift $shift
     */
    public function attachShift(Shift $shift)
    {
        if ($shift instanceof NightShift) {
            $this->nightShift++;
        }

        $this->shifts[] = $shift;
        $this->usedHours += 8;
    }


    /**
     * Returns all nurse shifts
     * @return Shift[]
     */
    public function getShifts()
    {
        return $this->shifts;
    }


    /**
     * Returns last attached shift
     * @return Shift
     */
    public function getLastShift()
    {
        if (!empty($this->shifts)) {
            return end($this->shifts);
        }
    }

    public function checkFreeWeeks(Day $day)
    {

        foreach ($this->shifts as $shift) {

        }

    }

    /**
     * Temporary method to create nurse array
     * @return Nurse[]
     */
    public static function getNurses()
    {
        $nurses = array();

        for($i = 0; $i < 12; $i++) {
            $nurses[] = new Nurse(36);
        }

        $nurses[] = new Nurse(32);

        for($i = 0; $i < 3; $i++) {
            $nurses[] = new Nurse(30);
        }

        return $nurses;
    }

}