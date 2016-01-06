<?php

namespace Application\Controller;

use Application\Nurse;
use Application\Period;
use Application\Scheduler;
use Core\Mvc\Controller\BaseController;


/**
 * Class IndexController
 * @author Wojciech Polus <polusw@hotmail.com>
 */
class IndexController extends BaseController
{
    public function indexAction()
    {
        //$start = new \DateTime('2015-10-33 10:00:00');
        //die(var_dump($start));

        //$stop =new \DateTime('24:00:00');

        //die(var_dump($start->diff($stop)));

        //die(var_dump(date("H:i:s",strtotime('10:00:00'))));

        $period = new Period(32);
        $nurses = Nurse::getNurses();

        $scheduler = new Scheduler($period, $nurses);
        $scheduler->schedule();
    }

}