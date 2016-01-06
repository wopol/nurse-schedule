<?php

namespace Core\Application;

use Core\Http\Request\Request;
use Core\Http\Response\Response;
use Core\Mvc\Event\MvcEvent;
use Core\Mvc\EventManager;

/**
 * Application init
 * @author Wojciech Polus <polusw@hotmail.com>
 */
class App
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var MvcEvent
     */
    protected $event;

    /**
     * @var EventManager
     */
    protected $events;


    protected $defaultEvents = array(
        MvcEvent::EVENT_ROUTE => 'Core\Mvc\Listener\RouterListener',
        MvcEvent::EVENT_DISPATCH => 'Core\Mvc\Controller\AbstractController',
        MvcEvent::EVENT_RENDER => 'Core\Mvc\Listener\RenderListener'
    );

    /**
     * Init application settings
     */
    private function __construct()
    {
        $this->config = Config::instance();

        $this->request = new Request();
        $this->response = new Response();

        $this->events = new EventManager();

        foreach ($this->defaultEvents as $key => $event) {
            $this->events->attach($key, $event);
        }

        $this->event = new MvcEvent();
        $this->event->setApplication($this)
            ->setRequest($this->request)
            ->setResponse($this->response);

    }


    /**
     * Application start
     */
    static public function run()
    {
        $app = new App();

        $app->events->trigger(MvcEvent::EVENT_ROUTE, $app->event);

        if ($app->event->getError()) {
            return $app->completeRequest();
        }

        $app->events->trigger(MvcEvent::EVENT_DISPATCH, $app->event);

        $app->completeRequest();
    }

    /**
     * Method finished request
     */
    public function completeRequest()
    {
        return $this->events->trigger(MvcEvent::EVENT_RENDER, $this->event);
    }
}
