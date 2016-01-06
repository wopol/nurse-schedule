<?php

namespace Application;


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
            $this->compare($day, $this->nurses[$randID]);

            if ($counter > 2000) {
                throw new Exception("Too long compares");
            }

        }


    }

    public function compare(Day $day, Nurse $nurse)
    {

        //For each day a nurse	may	start only one shift.
        if ($day->nurseExists($nurse)) {
            return false;
        }

        foreach ($day->getShifts() as $shift) {

            //Cover needs to be fulfilled (i.e. no shifts must be left unassigned).
            if ($shift->isFull()) {
                continue;
            }

            //Within a scheduling period a nurse is allowed to exceed the number of hours for which they are available for their department by at most 4 hours.
            if ($nurse->usedAllHours()) {
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


            $shift->attachNurse($nurse);
            $nurse->attachShift($shift);
            break;
        }
    }


}