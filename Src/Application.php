<?php
/**
 * Created by PhpStorm.
 * User: shyandsy
 * Date: 2/17/2019
 * Time: 10:59 AM
 */
namespace Shy;

use Shy\Exception\ExceptionInvalidConfig;
use DI\ContainerBuilder;
//use FastRoute\simpleDispatcher;
//use FastRoute\RouteCollector
class Application
{
    protected function buildContainer(){
        require __DIR__ . '/../vendor/autoload.php';

        $containerBuilder = new ContainerBuilder;
        $containerBuilder->useAutowiring(true);
        $containerBuilder->useAnnotations(false);

        $containerBuilder->addDefinitions(__DIR__ . '/Bootstrap.php');

        $container = $containerBuilder->build();

        return $container;
    }

    public function run($config){
        $loader = require __DIR__ . '/../vendor/autoload.php';

        $start = microtime(true);

        // 创建container
        $container = $this->buildContainer($config);

        // 添加App namespace
        if(!isset($config['basePath'])){
            throw new ExceptionInvalidConfig("The config file should contain the `basePath`");
            exit;
        }
        $loader->addPsr4("App\\", $config['basePath'], false);

        // 创建路由
        if(!isset($config['route'])){
            throw new ExceptionInvalidConfig("The config file should contain the `route` section");
            exit;
        }
        $dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) use ($config){
            foreach($config['route'] as $route){
                $r->addRoute($route[0], $route[1], $route[2]);
            }
        });

        // Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        $response = null;

        ob_start();

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                if(isset($config['route']['404'])){
                    $routeInfo = $config['route']['404'];

                    $controller = $routeInfo[1];
                    $parameters = $routeInfo[2];

                    $container->call($controller, $parameters);
                }else{
                    $response->getBody()->write("404 not found");
                }
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];

                // ... 405 Method Not Allowed
                if(isset($config['route']['405'])){
                    $routeInfo = $config['route']['405'];

                    $controller = $routeInfo[1];
                    $parameters = $routeInfo[2];

                    $container->call($controller, $parameters);
                }else{
                    $response->getBody()->write(" 405 Method Not Allowed");
                }
                break;
            case \FastRoute\Dispatcher::FOUND:
                $controller = $routeInfo[1];
                $parameters = $routeInfo[2];

                // We could do $container->get($controller) but $container->call()
                // does that automatically
                $container->call($controller, $parameters);
                break;
        }

        $debugContent = ob_get_contents();
        ob_end_clean();

        $response = $container->get("Psr\Http\Message\ResponseInterface");
        $response->getBody()->write($debugContent . $response->getBody()->getContents());

        // send the response to the browser
        $emitter = new \Zend\HttpHandlerRunner\Emitter\SapiEmitter();
        $emitter->emit($response);

        $end = microtime(true);
        echo $end - $start;
    }
}