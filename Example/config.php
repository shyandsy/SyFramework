<?php
/**
 * Created by PhpStorm.
 * User: shyandsy
 * Date: 2/17/2019
 * Time: 12:06 PM
 */

return [
    'basePath' => __DIR__,
    //'controllerNameSpace' => '',
    'route' => [
        ['GET', '/', ['App\Controllers\HomeController', 'index']],
        ['POST', '/', ['App\Controllers\HomeController', 'index']],
        ['GET', '/user/{id:\d+}', ['App\Controllers\HomeController', 'index']],
        ['GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler']
    ]
];