<?php

namespace Application;


use Application\Day\WeekDay;
use Application\Shift\LateShift;
use Application\Shift\NightShift;
use Exception;

class Scheduler
{
    /**
     * @var Period;
     */
    private $period;

    /**
     * @var Nurse[]
     */
    public $nurses;

    private $nurse;

    private $dayNumber;


    public function __construct($period, $nurse)
    {
        $this->period = $period;
        $this->nurses = $nurse;
    }

    public function schedule()
    {
        $counter = 0;
        $lastDay = null;

        foreach ($this->period as $day) {

            if ($lastDay && $day->getDayNumber() == $lastDay->getDayNumber()) {
                $counter++;
            } else {
                $counter = 0;
            }

            $lastDay = $day;
            $randID = rand(0, count($this->nurses) - 1);

            if ($this->dayNumber) {
                if ($day->getDayNumber() > $this->dayNumber + 2) {
                    var_dump('unlock');
                    var_dump($day->getDayNumber());
                    $this->dayNumber = null;
                    $this->nurse = null;
                } else if ($this->nurse == $randID) {
                    continue;
                }
            }

            $this->compare($day, $this->nurses[$randID]);

            if ($counter > 5000) {
                $this->schedule();
            }

        }


    }

    public function compare(Day $day, Nurse $nurse)
    {

        //For each day a nurse	may	start only one shift.
        if ($day->nurseExists($nurse)) {
            return false;
        }

        //Within a scheduling period a nurse is allowed to exceed the number of hours for which they are available for their department by at most 4 hours.
        if ($nurse->usedAllHours()) {
            return false;
        }

        foreach ($day->getShifts() as $shift) {

            //Cover needs to be fulfilled (i.e. no shifts must be left unassigned).
            if ($shift->isFull()) {
                continue;
            }

            //The maximum number of night shifts is 3 per period of 5 consecutive weeks.
            if ($shift instanceof NightShift) {
                if ($nurse->nightShift >= 3) {
                    continue;
                }
            }

            //During any period of 24 consecutive hours,  at least 11 hours of rest is required.
            $lastShift = $nurse->getLastShift();

            if ($lastShift instanceof Shift) {
                $shiftDay = $lastShift->getDay();

                if ($day->getDayNumber() - $shiftDay->getDayNumber() == 1) {
                    if (!$lastShift->mayByNext($shift)) {
                        continue;
                    }
                }

            }

            //Following a series of at least 2 consecutive night shifts a 42 hours rest is required.
            //TODO przerwa powinna trwać 42h teraz sprawdzane jest 24h
            $prev = $this->period->get(($day->getDayNumber() -1));
            $prev2 = $this->period->get(($day->getDayNumber() -2));

            if ($prev instanceof Day && $prev2 instanceof Day) {
                $prevNigh = $prev->getNightShift();
                $prev2Nigh = $prev2->getNightShift();

                if ($prev2Nigh->nurseExists($nurse->id()) && $prevNigh->nurseExists($nurse->id())) {
                    continue;
                }
            }

            //The number of consecutive shifts (work days) is at most 6
            if ($day->getDayNumber() > 6) {
                $constantly = 0;
                for ($i = 1; $i <= 6; $i++) {
                    $testDay = $this->period->get($day->getDayNumber() - $i);
                    if ($testDay->nurseExists($nurse)) {
                        $constantly++;
                    } else {
                        break;
                    }
                }

                if ($constantly == 6) {
                    continue;
                }
            }

            if (($day->getDayNumber() - 5) % 7 == 0) {
                $isFiday = true;
            } else {
                $isFiday = false;
            }

            if ($day->getDayNumber() > 7 && ($day instanceof WeekDay || ($isFiday && $shift instanceof NightShift))) {
                $weekends = $this->period->getWeeks($day->getDayNumber());
                $left = 5 - count($weekends);

                $free = 0;
                foreach ($weekends as $week) {
                    $night = $week[0]->getNightShift();

                    if (!$night->nurseExists($nurse->id()) && !$week[1]->nurseExists($nurse) && !$week[2]->nurseExists($nurse)) {
                        $free++;
                    }
                }
                if ($free == 0 && $left < 3) {
                    continue;
                }

                if ($free == 1 && $left < 3) {
                    continue;
                }

                if (($isFiday && $shift instanceof NightShift) && !$this->dayNumber && $free < 2) {
                    var_dump('free');
                    var_dump($day->getDayNumber());
                    $this->nurse = $nurse->id();
                    $this->dayNumber = $day->getDayNumber();
                    continue;
                }

            }

            //Checked free weeks
            if ($nurse)


            $shift->attachNurse($nurse);
            $nurse->attachShift($shift);
            break;
        }
    }


}