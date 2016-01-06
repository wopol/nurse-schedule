<?php

namespace Core\Http\Response;


/**
 * Class Response
 * @author Wojciech Polus <polusw@hotmail.com>
 * @package Core\Http\Response
 */
class Response
{

	/**
	 * @var Header
	 */
	private $header;

	/**
	 * Content html
	 * @var string
	 */
	private $content;


	private $statusCode = 200;

	/**
	 * Response constructor
	 * @param Header $header | null
	 */
	public function __construct(Header $header = null)
	{
		$this->header = $header;
	}


	/**
	 * Set response status code, default 200
	 * @param $code string
	 * @return $this
	 */
	public function setStatusCode($code)
	{
		$this->statusCode = $code;
		return $this;
	}


	/**
	 * Set body content
	 * @param string $content
	 * @return $this
	 */
	public function setContent($content)
	{
		$this->content  = $content;

		return $this;
	}


	/**
	 * Redirect to the given url.
	 * @param $url
	 * @param $statusCode
	 */
	public function redirect($url, $statusCode = 303)
	{
		header('Location: ' . $url, true, $statusCode);
		die();
	}


	/**
	 * Return header object, if is null, create new
	 * @return Header
	 */
	public function getHeader()
	{
		if (!$this->header instanceof Header) {
			$this->header = new Header();
		}
		return $this->header;
	}


	/**
	 * Send response
	 */
	public function sendResponse()
	{
		if ($this->header instanceof Header) {
			foreach($this->header->getLines() as $line) {
				header($line['name'].": ".$line['value']);
			}
		}

		http_response_code($this->statusCode);

		echo $this->content;
	}
    
}