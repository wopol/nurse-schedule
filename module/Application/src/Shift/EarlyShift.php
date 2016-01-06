<?php


namespace Application\Shift;

use Application\Shift;


/**
 * Class EarlyShift
 * @author Wojciech Polus
 * @package Application\Shift
 */
class EarlyShift extends Shift
{

    function getStartTime()
    {
        return "07:00:00";
    }

    function getStopTime()
    {
        return "16:00:00";
    }
}