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

    /**
     * @return string
     */
    function getStartTime()
    {
        return "08:00:00";
    }

    /**
     * @return string
     */
    function getStopTime()
    {
        return "17:00:00";
    }

    /**
     * @return string
     */
    function getType()
    {
        return 'Day';
    }
}