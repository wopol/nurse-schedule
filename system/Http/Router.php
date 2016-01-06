<?php

namespace Core\Http;


use Core\Application\Config;
use Core\Http\Request\Request;

/**
 * Class Router
 * @author Wojciech Polus <polusw@hotmail.com>
 */
class Router
{
    private $route;

	/**
	 * @var Config
	 */
	private $config;

	/**
	 * @var String
	 */
    private $view;


	public function __construct()
	{
		$this->config = Config::instance();
	}


	/**
	 * Match module,controller,action based on http address
	 * @param Request $request
	 * @return $this|bool
	 */
    public function routeMatch(Request $request)
    {

        $routeParts = explode('/', $request->page);

        $this->route['module'] = $routeParts[0] ? $this->dashToCamelCase($routeParts[0], true) : $this->config->config['baseModule'];
        $this->route['controller'] = isset($routeParts[1]) ? $this->dashToCamelCase($routeParts[1], true) : "Index";
        $this->route['action'] = isset($routeParts[2]) ? $this->dashToCamelCase($routeParts[2]) : "index";

        $this->prepareNamespace();
		$this->view = $this->matchView();


        if (!class_exists($this->namespace) || !method_exists($this->namespace, $this->action . 'Action')) {
            return false;
        }

        $request->removeProperties('page');

        return $this;

    }


	/**
	 * Interface to vars (module,controller,action,)
	 * @param $name
	 * @return string
	 */
    public function __get($name)
    {
        return $this->route[$name];
    }


	/**
	 *Return path to template
	 * @return string
	 */
	public function getView()
	{
		return $this->view;
	}


	/**
	 * Construct controller namespace
	 */
    private function prepareNamespace()
    {
        $this->route['namespace'] = '\\'. ucwords($this->route['module']) .
			'\\Controller\\' . ucwords($this->route['controller']) . 'Controller';
    }


	/**
	 * Match view template path
	 * @return string
	 */
	private function matchView()
	{
		return $this->config->config['basePath'] .DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR . ucwords($this->module) .
			DIRECTORY_SEPARATOR . 'view' .DIRECTORY_SEPARATOR. $this->camelCaseToDash($this->controller) .DIRECTORY_SEPARATOR .
			($this->camelCaseToDash($this->action)) .  $this->config->view['suffix'];
	}


	/**
	 * Convert dashes string co camelCase
	 * @param string $str
	 * @param boolean $capitalize
	 * @return string
	 */
	private function dashToCamelCase($str, $capitalize = false)
	{
		$str = preg_replace_callback('|-([a-z])|',function($matches) {
			return strtoupper($matches[1]);
		}, $str);

		if ($capitalize) {
			$str = ucwords($str);
		}

		return $str;
	}


	/**
	 * Convert camelCase string to dashed
	 * @param $str
	 * @return string
	 */
	private function camelCaseToDash($str)
	{
		return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $str));
	}

}