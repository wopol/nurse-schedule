<?php

namespace Application;

use Application\Day\WeekDay;
use Application\Day\WorkDay;
use Iterator;


/**
 * Class Period (Simple iterator)
 * Returns next day, only when current day shifts are full covered
 * @author Wojciech Polus
 * @package Application
 */
class Period implements Iterator
{

    /**
     * @var Day[]
     */
    private $days;

    /**
     * Current element index
     * @var int
     */
    private $current = 0;


    /**
     * Period constructor. Prepares period.
     * @param int $daysCount
     * @param string $dateStart
     */
    public function __construct($daysCount, $dateStart)
    {
        $this->prepareDays($daysCount, $dateStart);
    }


    /**
     * Helper method to creates period days.
     * Creates arrays days, every fifth and sixth is weekend day
     * @param int $count
     * @param string $dateStart
     */
    private function prepareDays($count, $dateStart)
    {
        $counter = 1;
        for ($i = 1; $i <= $count; $i++) {
            if ($counter == 6 || $counter == 7) {
                if ($counter == 7) {
                    $counter = 0;
                }
                $this->days[] = new WeekDay($i, $dateStart);
            } else {
                $this->days[] = new WorkDay($i, $dateStart);
            }
            $counter++;
        }
    }


    /**
     * Returns day on the specified number
     * @param int $dayNumber
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


    /**
     * Returns weekend before receive day number;
     * Weekend lasts 60 h including Saturday 00:00 to Monday 04:00.
     * @param $number
     * @return array
     */
    public function getWeeks($number)
    {
        $weeks = array();

        for ($i = 7; $i < $number; $i = $i + 7) {
            $weeks[] = array(
                $this->days[$i -3],
                $this->days[$i -2],
                $this->days[$i -1],
                $this->days[$i]
            );
        }

        return $weeks;
    }
}