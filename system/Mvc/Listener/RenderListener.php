<?php

namespace Core\Mvc\Listener;

use Core\Application\Config;
use Core\Mvc\Event\MvcEvent;


/**
 * Class RouterListener
 * @author Wojciech Polus <polusw@hotmail.com>
 * @package Core\Mvc\Listener
 */
class RenderListener
{
    
    /**
     * MvcEvent Listener - render layout
     * @param MvcEvent $e
     */
    public function render(MvcEvent $e)
    {
        $config = Config::instance();
        $response = $e->getResponse();


        $renderer = call_user_func($config->view['renderer'] .'::instance');
        $content = $renderer->render($e->getView());

        $response->setContent($content);
        $response->sendResponse();
    }
}