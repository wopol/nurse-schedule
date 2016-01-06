<?php

$basePath = dirname(dirname(__FILE__));

return array(
    'module' => array(
        'Application',
    ),
    'config' => array(
        'basePath' => $basePath,
        'baseModule' => 'Application',
        'domain' => 'crm.local/'
    ),
    'view' => array(
        'renderer' => 'Core\Mvc\View\Render\SmartyRender',
        'layout' => $basePath . '/module/Application/view/layout/layout.tpl',
        '404' => $basePath . '/module/Application/view/layout/404.tpl',
        'suffix' => '.tpl'
    ),
);


