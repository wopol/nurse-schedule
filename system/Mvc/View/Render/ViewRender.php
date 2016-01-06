<?php

namespace Core\Mvc\View\Render;


use Core\Application\Config;
use Core\Application\FlashMessenger;
use Core\Mvc\Event\MvcEvent;
use Core\Mvc\View\ViewModel;
use Exception;

/**
 * Class ViewRender
 * @author Wojciech Polus <polusw@hotmail.com>
 */
class ViewRender {


	/**
	 * @var ViewModel
	 */
	private $view;

	/**
	 * Content html
	 * @var
	 */
	private $content;

	/**
	 * Return path template
	 * @return string
	 */
	public function getView()
	{
		return $this->template;
	}


	public function setView(ViewModel $view)
	{
		$this->view = $view;
	}


	/**
	 * Render html view
	 * @param MvcEvent $e
	 * @throws Exception
	 */
	public function render(MvcEvent $e)
	{

		$config = Config::instance();

		$this->view = $e->getView();
		$response = $e->getResponse();

		if ($this->view->render) {
			try {
				if ($this->view->getView()) {

					if ($this->view->getVars()) {
						extract($this->view->getVars());
					}
					ob_start();
					include $this->view->getView();
					$this->content = ob_get_contents();
					ob_end_clean();

				} else {
					throw new Exception("Template path is not set " . $e->getRouteMatch()->controller . " " . $e->getRouteMatch()->action);
				}

				if(!$e->isAjax()) {
					$messages = FlashMessenger::instance();

					ob_start();
					$content = $this->content;
					$title = $this->view->title;
					$subMenu = $this->view->checkSubMenu();

					if($messages->getMessages()) {
						extract($messages->getMessages());
					}

					include $config->view['layout'];

					$this->content = ob_get_contents();
					ob_end_clean();
				}

				$response->setContent($this->content);
			} catch (Exception $ex) {
				ob_end_clean();
				throw $ex;
			}
		}
		$response->sendResponse();
	}


	/**
	 * Include element method
	 * @param $path
	 * @return string
	 * @throws Exception
	 */
	public function includeElement($path)
	{
		$config = Config::instance();
		$path = $config->config['basePath'] . DIRECTORY_SEPARATOR  .'module'.DIRECTORY_SEPARATOR . $path;

		if (file_exists($path)) {
			if ($this->view->getVars()) {
				extract($this->view->getVars());
			}

			return include $path;
		} else {
			throw new Exception("Nie można wczytać pliku " . $path);
		}

	}

}