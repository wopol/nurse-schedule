<?php

namespace Core\Mvc\Controller;

use Core\Mvc\Event\MvcEvent;
use Core\Mvc\View\ViewModel;

/**
 * Class AbstractController
 * @author Wojciech Polus <polusw@hotmail.com>
 */
class AbstractController
{

	/**
	 * Dispatch event listener
	 * @param MvcEvent $e
	 * @return $this
	 */
    public function dispatch(MvcEvent $e)
    {
        $route = $e->getRouteMatch();

		$controller = new $route->namespace;
		$controller->setRequest($e->getRequest());
		$controller->setResponse($e->getResponse());

		$view = new ViewModel();
		$controller->setView($view);

		$controller->onDispatch($e);
		$e->setView($view);

		if ($view->render) {
			$view->setTemplate($e->getRouteMatch()->getView());
		}

		return $this;
    }
}