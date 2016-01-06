<?php

namespace Core\Http\Request;


/**
 * Class Request
 * @author Wojciech Polus <polusw@hotmail.com>
 */
class Request
{
    protected $properties;

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        if ($_SERVER['REQUEST_METHOD']) {
            $this->properties = $_REQUEST;
        }
    }

    public function __get($name)
    {
        if (isset($this->properties[$name])) {
            $var = $this->properties[$name];
            return $this->escape($var);

        }
    }

    public function getInt($name)
    {
        if (isset($this->properties[$name])) {
            return (int) $this->properties[$name];
        }
    }

    public function removeProperties($key)
    {
        unset($this->properties[$key]);
    }


    private function setProperties($key, $val)
    {
        $this->properties[$key] = $val;

    }

    private function escape($var)
    {
        if (is_array($var)) {
            array_walk_recursive($var, function(&$value, $key) {
                $value = strip_tags($value);
            });

            return $var;
        } else {
            return strip_tags($var);
        }

    }


}