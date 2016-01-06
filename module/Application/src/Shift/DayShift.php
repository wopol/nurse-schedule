<?php

namespace Application\Shift;

use Application\Shift;

/**
 * Class DayShift
 * @author Wojciech Polus
 * @package Application\Shift
 */
class DayShift extends Shift
{

    function getStartTime()
    {
        return "08:00:00";
    }

    function getStopTime()
    {
        return "17:00:00";
    }
}