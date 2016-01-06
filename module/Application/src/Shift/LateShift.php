<?php

namespace Application\Shift;

use Application\Shift;

/**
 * Class LateShift
 * @author Wojciech Polus
 * @package Application\Shift
 */
class LateShift extends Shift
{

    function getStartTime()
    {
        return "23:00:00";
    }

    function getStopTime()
    {
        return "07:00:00";
    }
}