<?php

namespace Core\Mvc\Controller;

use Core\Application\FlashMessenger;
use Core\Http\Request\Request;
use Core\Http\Response\Response;
use Core\Mvc\Event\MvcEvent;
use Core\Mvc\View\ViewModel;
use Core\Application\App;
use Core\Crm\Ticket;
use Core\Crm\Ticket\File as TicketFile;
use Core\Application\Config;
use Exception;


/**
 * Class BaseController
 * @author Wojciech Polus
 */
class BaseController
{

	/**
	 * @var ViewModel
	 */
	protected $view;

	/**
	 * @var Request
	 */
	protected $request;

	/**
	 * @var Response
	 */
	protected $response;


	/**
	 * @var boolean
	 */
	private $isAjax;


	/**
	 * Function always execute before controller action
	 * @param MvcEvent $e
	 */
	public function onDispatch(MvcEvent $e)
	{
		$route = $e->getRouteMatch();
		$this->isAjax = $e->isAjax();

		$action = $route->action . 'Action';
		$this->$action();

	}


	/**
	 * Set view model
	 * @param ViewModel $view
	 */
	public function  setView(ViewModel $view)
	{
		$this->view = $view;
	}


	/**
	 * Set request object
	 * @param Request $request
	 */
	public function setRequest(Request $request)
	{
		$this->request = $request;
	}


	/**
	 * Set response object
	 * @param Response $response
	 */
	public function setResponse(Response $response)
	{
		$this->response = $response;
	}


	/**
	 * @return Response
	 */
	public function getResponse()
	{
		return $this->response;
	}


	/**
	 * Template will not be rendered
	 */
	public function noRender()
	{
		if ($this->view instanceof ViewModel) {
			$this->view->render = false;
		}
	}

	/**
	 * Redirect to the given url.
	 * @param $url
	 * @param $statusCode
	 */
	public function redirect($url, $statusCode = null)
	{
		$this->response->redirect($url, $statusCode);
	}

}