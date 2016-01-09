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

    /**
     * @return string
     */
    function getStartTime()
    {
        return '23:00:00';
    }

    /**
     * @return string
     */
    function getStopTime()
    {
        return '07:00:00';
    }

    /**
     * @return string
     */
    function getType()
    {
        return 'Night';
    }

    /**
     * @return string
     */
    public function getDateEndString()
    {
        $interval = \DateInterval::createfromdatestring('+1 day');

        $day = clone $this->getDay()->getDay();
        $day->add($interval);
        return $day->format("Y-m-d") . ' ' . $this->getStopTime();
    }
}
