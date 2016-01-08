<?php

namespace Application\Shift;

use Application\Shift;

/**
 * Class NightShift
 * @author Wojciech Polus
 * @package Application\Shift
 */
class NightShift extends Shift
{

    function getStartTime()
    {
        return '23:00:00';
    }

    function getStopTime()
    {
        return '07:00:00';
    }

    function getType()
    {
        return 'Night';
    }
}