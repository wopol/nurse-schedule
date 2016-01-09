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

    /**
     * @return string
     */
    function getStartTime()
    {
        return "14:00:00";
    }

    /**
     * @return string
     */
    function getStopTime()
    {
        return "23:00:00";
    }

    /**
     * @return string
     */
    function getType()
    {
        return 'Late';
    }

}
