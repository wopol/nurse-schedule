<?php

namespace Application\Day;


use Application\Day;
use Application\Shift\DayShift;
use Application\Shift\EarlyShift;
use Application\Shift\LateShift;
use Application\Shift\NightShift;

/**
 * Class WorkDay
 * @author Wojciech Polus
 * @package Application\Day
 */
class WorkDay extends Day
{

    protected function prepareShifts()
    {
        $this->shifts[] = new DayShift(3,$this);
        $this->shifts[] = new EarlyShift(3,$this);
        $this->shifts[] = new LateShift(3,$this);
        $this->shifts[] = new NightShift(1,$this);
    }
}