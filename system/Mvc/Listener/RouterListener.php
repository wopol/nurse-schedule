<?php

namespace Core\Mvc\Listener;

use Core\Application\Config;
use Core\Mvc\Event\MvcEvent;
use Core\Http\Router;


/**
 * Class RouterListener
 * @author Wojciech Polus <polusw@hotmail.com>
 * @package Core\Mvc\Listener
 */
class RouterListener
{
    
    /**
     * MvcEvent Listener - match route
     * @param MvcEvent $e
     * @return Router
	 * @author Wojciech Polus <polusw@hotmail.com>
     */
    public function route(MvcEvent $e)
    {
        $request = $e->getRequest();
        $config = Config::instance();
        $router = new Router();
        
        $result = $router->routeMatch($request);

        $config->activModule = $router->module;
        $config->controller = $router->controller;
        $config->action = $router->action;

		if ($result instanceof Router) {
			$e->setRouteMatch($router);
		} else {
			$e->setError('404');
		}

        return $router;
    }
}