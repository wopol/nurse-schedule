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
    /**
     * Sequence class variable
     * Variable make sure that nurse have unique id
     * Variable are incremente when creates new instance this class
     * @var int
     */
    private static $seq = 1;


    /**
     * Nurse unique identifier
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
     * Max number hours to be used in period
     * @var int
     */
    private $totalHours;


    /**
     * Used night shifts in period
     * @var int
     */
    public $nightShift = 0;


    /**
     * This flag, allow nurse to work on late shifts
     * @var bool
     */
    private $canLate = true;


    /**
     * Nurse shifts array
     * @var Shift[]
     */
    private $shifts = array();


    /**
     * Rewind nurse sequence
     */
    public static function resetSeq()
    {
        self::$seq = 1;
    }


    /**
     * Nurse constructor.
     * It must receive how many time nurse works peer week
     * @param $hoursInContract
     */
    public function __construct($hoursInContract)
    {
        $this->id = self::$seq++;
        $this->hoursInContract = $hoursInContract;
        $this->totalHours = $hoursInContract *5;
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


    /**
     * Checks if nurse can works on late shift
     * @return bool
     */
    public function canLate()
    {
        return $this->canLate;
    }


    /**
     * Sets flag, that prevents works on late shift
     */
    public function withoutLate()
    {
        $this->canLate = false;
    }

    /**
     * Temporary method to create nurse array
     * @return Nurse[]
     */
    public static function getNurses($a, $b, $c)
    {
        $nurses = array();

        for($i = 0; $i < $a; $i++) {
            $nurses[] = new Nurse(36);
        }
        end($nurses)->withoutLate();

        for ($i = 0; $i < $b; $i++) {
            $nurses[] = new Nurse(32);
        }

        for($i = 0; $i < $c; $i++) {
            $nurses[] = new Nurse(30);
        }

        return $nurses;
    }

}