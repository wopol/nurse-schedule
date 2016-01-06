<?php

namespace Core\Http\Response;


/**
 * Class Header
 * @author Wojciech Polus <polusw@hotmail.com>
 * @package Core\Http\Response
 */
class Header
{

	private $line = array();

	/**
	 * Add header line
	 * @param $name
	 * @param $value
	 * @return Header
	 */
	public function addHeaderLine($name, $value)
	{
		$this->line[] = array('name' => $name, 'value' => $value);

		return $this;
	}


	/**
	 * Returns header lines
	 * @return array
	 */
	public function getLines()
	{
		return $this->line;
	}

}