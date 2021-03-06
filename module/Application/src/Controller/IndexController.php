<?php

namespace Application\Controller;

use Application\Nurse;
use Application\Period;
use Application\Scheduler;
use Core\Mvc\Controller\BaseController;
use Exception;


/**
 * Class IndexController
 * @author Wojciech Polus <polusw@hotmail.com>
 */
class IndexController extends BaseController
{
    public function indexAction()
    {
        $this->view->error = $this->request->error ? true : false;
    }


    public function startAction()
    {

        $tryAgain = true;
        $counter = 0;

        while($tryAgain) {
            Nurse::resetSeq();
            $date = $this->request->date;
            $period = new Period((int) $date['days'], $date['startDate']);

            $nurses = Nurse::getNurses(
                $this->request->nurse['36'],
                $this->request->nurse['32'],
                $this->request->nurse['20']
            );

            try {
                $scheduler = new Scheduler($period, $nurses);
                $scheduler->schedule();

                $tryAgain = false;
            } catch (Exception $ex) {
                $counter++;
                if ($counter > 500) {
                    return $this->redirect("/?error=error");
                }
            }
        }

        $schedule = $scheduler->prepareForCalendar();

        $this->view->schedule = $schedule;
        $this->view->scheduleJson = json_encode($schedule);
        $this->view->nurses = $scheduler->nurses;

        $date = new \DateTime($this->request->date['startDate']);
        $this->view->year  = $date->format('Y');
        $this->view->month = $date->format('m');
        $this->view->day   = $date->format('d');
    }



}
