<?php

namespace Application;


use Application\Shift\LateShift;
use Application\Shift\NightShift;

class Scheduler
{
    /**
     * @var Period;
     */
    private $period;

    /**
     * @var Nurse[]
     */
    private $nurses;


    public function __construct($period, $nurse)
    {
        $this->period = $period;
        $this->nurses = $nurse;
    }

    public function schedule()
    {
        foreach ($this->period as $day) {
            var_dump($day->getDayNumber());
            //foreach ($this->nurses as $nurse) {
            $randID = rand(0, count($this->nurses) - 1);
                $this->compare($day, $this->nurses[$randID]);
            //}
        }
        foreach ($day->getShifts() as $shift) {
            var_dump($shift->nurses);
        }

    }

    public function compare(Day $day, Nurse $nurse)
    {
        if ($day->nurseExists($nurse)) {
            return false;
        }

        foreach ($day->getShifts() as $shift) {
            if ($shift->isFull()) {
                continue;
            }

            if ($nurse->usedAllhouers()) {
                continue;
            }

            if ($shift instanceof NightShift) {
                if ($nurse->nightShift >= 3) {
                    continue;
                }
            }


            $lastShift = $nurse->getLastShift();

            if ($lastShift instanceof Shift) {
                $shiftDay = $lastShift->getDay();

                if ($day->getDayNumber() - $shiftDay->getDayNumber() == 1) {
                    if (!$lastShift->mayByNext($shift)) {
                        continue;
                    }
                }

            }


            $prev = $this->period->get(($day->getDayNumber() -1));
            $prev2 = $this->period->get(($day->getDayNumber() -2));

            if ($prev instanceof Day && $prev2 instanceof Day) {
                $prevNigh = $prev->getNightShift();
                $prev2Nigh = $prev2->getNightShift();

                if ($prev2Nigh->nurseExists($nurse->id()) && $prevNigh->nurseExists($nurse->id()) && $day->getDayNumber() < $prev->getDayNumber() + 2) {
                    continue;
                }
            }


            $shift->attachNurse($nurse);
            $nurse->attachShift($shift);
            break;
        }
    }


}