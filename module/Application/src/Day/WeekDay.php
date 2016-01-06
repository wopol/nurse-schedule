<?php

namespace Application\Day;

use Application\Day;
use Application\Shift\DayShift;
use Application\Shift\EarlyShift;
use Application\Shift\LateShift;
use Application\Shift\NightShift;

/**
 * Class WeekDay
 * @author Wojciech Polus
 * @package Application\Day
 */
class WeekDay extends Day
{

    protected function prepareShifts()
    {
        $this->shifts[] = new DayShift(2, $this);
        $this->shifts[] = new EarlyShift(2, $this);
        $this->shifts[] = new LateShift(2,$this);
        $this->shifts[] = new NightShift(1,$this);
    }
}