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
        $period = new Period(35);
        $nurses = Nurse::getNurses();

        try {
            $scheduler = new Scheduler($period, $nurses);
            $scheduler->schedule();
        } catch (Exception $ex) {
            return $this->redirect("/");
        }


        $this->view->nurses = $scheduler->nurses;
    }

}