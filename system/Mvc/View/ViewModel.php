<?php

namespace Core\Mvc\View;

/**
 * Class ViewModel
 * @author Wojciech Polus <polusw@hotmail.com>
 */
class ViewModel
{

	/**
	 * this variables will be visible in html template
	 * @var mixed
	 */
	protected $vars;


	/**
	 * path to template
	 * @var string
	 */
	protected  $viewPath;


	/**
	 * Path to subMenu if exists
	 * @var string | null
	 */
	protected $subMenu = null;


	/**
	 * flag decides if template will be rendered
	 * @var bool
	 */
	public $render = true;


	/**
	 * title site
	 * @var string
	 */
	public $title = null;


	public function __construct($viewPath = null)
	{
		if ($viewPath && file_exists($viewPath)) {
			$this->viewPath = $viewPath;
		} else {
			$this->viewPath = null;
		}
	}


	/**
	 * Set var
	 * @param string $name
	 * @param mixed $val
	 */
	public function __set($name, $val)
	{
		$this->vars[$name] = $val;
	}


	/**
	 * Return vars
	 * @param $name
	 * @return mixed
	 */
	public function __get($name)
	{
		return $this->vars[$name];
	}



	/**
	 * Return all vars from ViewModel
	 * @return mixed
	 */
	public function getVars()
	{
		return $this->vars;
	}


	/**
	 * Sets array variable, existing variables will be overwritten
	 * @param mixed[]
	 */
	public function setVars($vars)
	{
		if (is_array($vars)) {
			$this->vars = $vars;
		}
	}


	/**
	 * Return view path
	 * @return string
	 */
	public function getView()
	{
		return $this->viewPath;
	}


	/**
	 * Check if template file exist, and sets it
	 * @param $view
	 */
	public function setTemplate($view)
	{
		if ($view && file_exists($view)) {
			$this->viewPath = $view;
		} else {
			$this->viewPath = null;
		}
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
