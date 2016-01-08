<?php

namespace Application;


use Application\Day\WeekDay;
use Application\Shift\DayShift;
use Application\Shift\EarlyShift;
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

            if (($day->getDayNumber() - 7) % 7 == 0) {
                $previousDay = $this->period->get($day->getDayNumber() - 1);
                foreach ($previousDay->getNurses() as $nurse) {
                    if ($this->compare($day, $nurse)) {
                        continue;
                    }
                }

            }

            if (($day->getDayNumber() - 6) % 7 == 0) {
                $previousDay = $this->period->get($day->getDayNumber() - 1);

                foreach ($previousDay->getNightShift()->getNurses() as $nurse) {
                    if ($this->compare($day, $nurse)) {
                        continue;
                    }
                }
            }

            $randID = rand(0, count($this->nurses) - 1);
            $this->compare($day, $this->nurses[$randID]);

            if ($counter > 500) {
                throw new Exception();
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

            if ($day->getDayNumber() > 1 && ($day->getDayNumber() - 1) % 7 == 0) {
                $previousDay = $this->period->get($day->getDayNumber() - 1);
                $previous2Day = $this->period->get($day->getDayNumber() - 2);
                $previous3Day = $this->period->get($day->getDayNumber() - 3);

                if (!$previousDay->nurseExists($nurse)
                        && !$previous2Day->nurseExists($nurse)
                        && !$previous3Day->getNightShift()->nurseExists($nurse->id())) {

                    if ($previous3Day->getLateShift()->nurseExists($nurse->id()) &&
                            $shift instanceof DayShift || $shift instanceof EarlyShift) {
                        continue;
                    }


                }
            }

            // One of the full time nurses request no late shifts (hard constraint)
            if (!$nurse->canLate() && $shift instanceof LateShift) {
                continue;
            }

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
            $prev = $this->period->get(($day->getDayNumber() -1));
            $prev2 = $this->period->get(($day->getDayNumber() -2));
            $prev3 = $this->period->get(($day->getDayNumber() -3));

            if ($prev instanceof Day && $prev2 instanceof Day) {
                $prevNigh = $prev->getNightShift();
                $prev2Nigh = $prev2->getNightShift();
                if ($prev3 instanceof Day) {
                    $prev3Nigh = $prev3->getNightShift();
                }

                if ($prev2Nigh->nurseExists($nurse->id()) && $prevNigh->nurseExists($nurse->id())) {
                    continue;
                }
                if ($prev3 instanceof Day) {
                    if ($prev2Nigh->nurseExists($nurse->id()) && $prev3Nigh->nurseExists($nurse->id())) {
                        continue;
                    }
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


            //A nurse must receive at least 2 weekends off duty per 5 week period. A weekend off duty lasts 60 hours including Saturday 00:00 to Monday 04:00.
            if ($day->getDayNumber() > 7 && ($day instanceof WeekDay || ($isFiday && $shift instanceof NightShift))) {
                $weekends = $this->period->getWeeks($day->getDayNumber());
                $left = 5 - count($weekends);

                $free = 0;
                foreach ($weekends as $week) {
                    $night = $week[0]->getNightShift();
                    $late = $week[0]->getLateShift();

                    $monEarl = $week[3]->getEarlyShift();
                    $monDay = $week[3]->getDayShift();

                    if (!$night->nurseExists($nurse->id()) &&
                            !$week[1]->nurseExists($nurse) &&
                            !$week[2]->nurseExists($nurse) &&
                            ((!$late->nurseExists($nurse->id()) || ($late->nurseExists($nurse->id())
                                && !$monDay->nurseExists($nurse->id())
                                    && !$monEarl->nurseExists($nurse->id())
                                )))
                    ) {
                        $free++;
                    }
                }

                if ($free == 0 && $left < 3) {
                    continue;
                }

                if ($free == 1 && $left < 3) {
                    continue;
                }

            }

            $shift->attachNurse($nurse);
            $nurse->attachShift($shift);
            return true;
        }
    }


    public function prepareForCalendar()
    {
        $schedule = array();
        $zmiany = 1;
        foreach ($this->nurses as $nurse) {
            $schedule[$nurse->id()] = array(
                'nurse' => array(
                    'nurse_id' => $nurse->id()
                )
            );

            $nurseSchedule = array();

            $k = 0;
            foreach ($nurse->getShifts() as $shift) {
                $nurseSchedule[$k] = array(
                    'id' => $k,
                    'startTime' => $shift->getDateString(),
                    'endTime'   => $shift->getDateEndString(),
                    'summary'   => $shift->getType()
                );

                $zmiany++;

                $k++;
            }
            $schedule[$nurse->id()]['shifts'] = $nurseSchedule;
        }

        return $schedule;
    }


}
