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

        $tryAgain = true;

        while($tryAgain) {
            Nurse::resetSeq();
            $period = new Period(35);
            $nurses = Nurse::getNurses();

            try {
                $scheduler = new Scheduler($period, $nurses);
                $scheduler->schedule();

                $tryAgain = false;
            } catch (Exception $ex) {

            }
        }

        $this->view->nurses = $scheduler->nurses;
    }

}