<?php

namespace Core\Application;


use Exception;

/**
 * Application config parser
 * @author Wojciech Polus <polusw@hotmail.com>
 */
class Config
{
    private static $instance;
    private $config = array();
    
    private function __construct()
    {   
        if (file_exists(ROOT_PATH . 'config/config.php')) {
            $this->config = require ROOT_PATH . 'config/config.php';
        } else {
            throw new Exception('Config file error');
        }
        
    }
    
    public static function instance() 
    {
        if (!self::$instance) {
            self::$instance = new Config();
        }
        
        return self::$instance;
    }
    
    public function __get($name)
    {
        return $this->config[$name];
    }


    /**
     * Set dynamic config variable
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->config[$name] = $value;
    }
    
    
}