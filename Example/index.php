<?php
/**
 * Created by PhpStorm.
 * User: shyandsy
 * Date: 2/17/2019
 * Time: 12:06 PM
 */
//use Shy;

require __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . "/config.php";

$application = new Shy\Application();

$application->run($config);