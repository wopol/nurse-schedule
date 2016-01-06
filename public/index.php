<?php

define('ROOT_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

require_once ROOT_PATH . '/system/init.php';

\Core\Application\App::run();
