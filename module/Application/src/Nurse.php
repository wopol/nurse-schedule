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
    private $houersInContract;

    private $usedHouers;

    private $totalHouers;

    public $nightShift = 0;

    /**
     * @var Shift[]
     */
    private $shifts = array();


    public function __construct($houersInContract)
    {
        $this->id = self::$seq++;
        $this->houersInContract = $houersInContract;
        $this->totalHouers = $houersInContract *5;
    }

    public function usedAllhouers()
    {
        if ($this->usedHouers + 4 >= $this->totalHouers) {
            return true;
        } else {
            return false;
        }
    }

    public function id()
    {
        return $this->id;
    }

    public function attachShift(Shift $shift)
    {
        if ($shift instanceof NightShift) {
            $this->nightShift++;
        }
        $this->shifts[] = $shift;
        $this->usedHouers += 8;
    }

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

    public function getLastShift()
    {
        $count = count($this->shifts);
        if ($count) {
            return $this->shifts[$count - 1];
        }
    }

}