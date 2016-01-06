<?php

namespace Core\Mvc\Event;


/**
 * Class Event
 * @author Wojciech Polus <polusw@hotmail.com>
 */
class Event implements EventInterface
{

    protected $error;
    
    public function getError() 
    {
		return $this->error? true : false;
    }

	public function setError($type = null)
	{
		$this->error = true;
	}

}