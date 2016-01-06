<?php

namespace Core\Mvc\View\Render;

use Core\Application\Config;
use Core\Application\FlashMessenger;
use Core\Mvc\Event\MvcEvent;
use Core\Mvc\View\ViewModel;
use Smarty;

/**
 * Class SmartyRender
 * @author Wojciech Polus <polusw@hotmail.com>
 * @package Core\Mvc\View\Render
 */
class SmartyRender
{

    /**
     * @var Smarty
     */
    private $smarty;


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
     * @var SmartyRender
     */
    private static $instance;


    /**
     * @return SmartyRender
     */
    public function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Private constructor,
     * to create class instance should invoke instance() method
     */
    private function __construct()
    {
        $config = Config::instance();
        $this->smarty = new Smarty();

        $this->smarty->compile_check = 1;

        $this->smarty->setCompileDir($config->config['basePath'] . '/data/smarty');
        $this->smarty->registerClass('App', 'Core\Application\App');
        $this->smarty->setTemplateDir(array(
            $config->config['basePath'] . '/module'
        ));

    }

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
     * @param ViewModel $view
     * @return string
     */
    public function render(ViewModel $view)
    {
        $config = Config::instance();

        $template = $config->view['layout'];
        $this->setView($view);

        if ($this->view->render) {

            $this->smarty->assign($this->view->getVars());
            $content = $this->smarty->fetch($this->view->getView());
            if(!$this->view->isAjax()) {
                $this->smarty->assign(array('content' => $content));
                $content = $this->smarty->fetch($template);
            }
            $this->content = $content;
        }

        return $this->content;
    }


    //TODO method should be removed
    /**
     * Workaround to handle old application version
     * @return Smarty
     */
    public function getSmarty()
    {
        return $this->smarty;
    }

}