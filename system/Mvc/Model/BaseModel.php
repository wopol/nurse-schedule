<?php

namespace Core\Mvc\Model;


use Core\Db\AbstractSqlDriver;
use Core\Db\Driver;
use \ArrayObject;
use Core\Application\App;

/**
 * Class BaseModel, provide acces to db
 * @package Core\Mvc\Model
 * @author Wojciech Polusw <polusw@hotmail.com>
 */
class BaseModel extends ArrayObject
{
    /**
     * Db connect id initialized during event dispatch
     * @var Driver
     */
    protected  static $db;

    /**
     * connects to the database
     */
    public static function connect()
    {
        if (!self::$db instanceof AbstractSqlDriver) {
            self::$db = App::getDriver();
        }
    }

}