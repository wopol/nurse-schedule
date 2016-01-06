<?php

namespace Core\Mvc;

use Core\Mvc\Event\EventInterface;

/**
 * Event Manager
 * @author Wojciech Polus <polusw@hotmail.com>
 */
class EventManager
{
    
    private $events = array();
    
    
    /**
     * Attach listener to event
     * @param type $event
     * @param type $callback
     */
    public function attach($event,$callback)
    {
        if (is_callable(array($callback, $event))) {
            $this->events[$event][] = new $callback;
        }
    }
    
    
    /**
     * Detach listener
     * @param type $event
     * @param type $callback
     */
    public function detach($event, $callback)
    {
        
    }
    
    public function trigger($event, EventInterface $e)
    {
        $listeners = $this->getListener($event);
        
        foreach ($listeners as $listener) {
           $listener->$event($e);
        }
    }
    
    public function getListener($event)
    {
        if (array_key_exists($event, $this->events)) {
            return $this->events[$event];
        }
    }
    
    
}