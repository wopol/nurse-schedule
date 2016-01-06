<?php

namespace Core\Mvc\Event;

use Core\Application\Config;
use Core\Http\Router;
use Core\Application\App;
use Core\Http\Request\Request;
use Core\Http\Response\Response;
use Core\Mvc\View\ViewModel;

/**
 * Class MvcEvent
 * @author Wojciech Polus <polusw@hotmail.com>
 */
class MvcEvent extends Event
{
    
    const EVENT_ROUTE = 'route';
    const EVENT_DISPATCH = 'dispatch';
    const EVENT_RENDER = 'render';

	/**
	 * @var App
	 */
    protected $app;

	/**
	 * @var Request
	 */
    protected $request;

	/**
	 * @var Response
	 */
    protected $response;

	/**
	 * @var Router
	 */
    protected $route;

	/**
	 * @var ViewModel
	 */
	protected $view;

	/**
	 * @param App $app
	 * @return $this
	 */
    public function setApplication(App $app)
    {
        $this->app = $app;

        return $this;
    }

	/**
	 * @param Request $request
	 * @return $this
	 */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

	/**
	 * @param Response $response
	 * @return $this
	 */
    public function setResponse(Response $response)
    {
        $this->response = $response;

        return $this;
    }

	/**
	 * @param Router $route
	 * @return $this
	 */
	public function setRouteMatch(Router $route)
	{
		$this->route = $route;

		return $this;
	}

	/**
	 * @param ViewModel $view
	 * @return $this
	 */
	public function setView(ViewModel $view)
	{
		$this->view = $view;

		return $this;
	}

	/**
	 * @return Request
	 */
	public function getRequest()
	{
		return $this->request;
	}

	/**
	 * @return Response
	 */
	public function getResponse()
	{
		return $this->response;
	}


	/**
	 * @return Router
	 */
    public function getRouteMatch()
    {
        return $this->route;
    }

	/**
	 * Set view model
	 * @return ViewModel
	 */
	public function getView()
	{
		if (!$this->view instanceof ViewModel) {
			$this->view = new ViewModel();
		}
		return $this->view;
	}

	/**
	 * Method prepare render to handle error
	 * @param null $type
	 */
	public function setError($type = NULL)
	{
		$config = Config::instance();

		switch ($type) {
			case '404':
				$this->getView()->setTemplate($config->view['404']);
				$this->getResponse()->setStatusCode('404');
				break;
		}

		parent::setError($type);
	}


	/**
	 * Check if is request is xhr
	 */
	public function isAjax()
	{
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
			return true;
		}

	}


}