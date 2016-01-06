<?php

namespace Application;

use Application\Day\WeekDay;
use Application\Day\WorkDay;
use Iterator;


/**
 * Class Period (Simple iterator)
 * @author Wojciech Polus
 * @package Application
 */
class Period implements Iterator
{

    /**
     * @var Day[]
     */
    private $days;

    private $current = 0;


    public function __construct($daysCount)
    {
        $this->prepareDays($daysCount);
    }

    private function prepareDays($count)
    {
        $counter = 1;
        for ($i = 1; $i <= $count; $i++) {
            if ($counter == 6 || $counter == 7) {
                if ($counter == 7) {
                    $counter = 0;
                }
                $this->days[] = new WeekDay($i);
            } else {
                $this->days[] = new WorkDay($i);
            }
            $counter++;
        }
    }

    /**
     * Returns day on the specified number
     * @param $dayNumber
     * @return Day
     */
    public function get($dayNumber) {
        if (isset($this->days[$dayNumber - 1])) {
            return $this->days[$dayNumber - 1];
        }
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->days[$this->current];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $day = $this->days[$this->current];
        if ($day->shiftsCompleted()) {
            $this->current++;
        }
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->current;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->days[$this->current]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->current = 0;
    }
}