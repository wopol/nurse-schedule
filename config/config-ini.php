<?php

$basePath = dirname(dirname(__FILE__));

return array(
    'module' => array(
        'Application',
    ),
    'config' => array(
        'basePath' => $basePath,
        'baseModule' => 'Application',
        'domain' => '',
    ),
    'view' => array(
        'layout' => $basePath . '/module/Application/view/layout/layout.tpl',
        '404' => $basePath . '/module/Application/view/layout/404.tpl',
        'suffix' => '.tpl'
    )
);


