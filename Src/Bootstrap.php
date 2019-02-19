<?php
/**
 * Created by PhpStorm.
 * User: shyandsy
 * Date: 2/17/2019
 * Time: 11:46 AM
 */

use function DI\create;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SuperBlog\Model\ArticleRepository;
use SuperBlog\Persistence\InMemoryArticleRepository;

return [
    // Bind an interface to an implementation
    ArticleRepository::class => create(InMemoryArticleRepository::class),
    // Configure Twig
    Twig_Environment::class => function () {
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/../src/SuperBlog/Views');
        return new Twig_Environment($loader);
    },
    //ServerRequestInterface::class => make('Zend\Diactoros\ServerRequestFactory'),

    ServerRequestInterface::class =>DI\factory(function () {
        $resquest = Zend\Diactoros\ServerRequestFactory::fromGlobals(
            $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
        );
        return $resquest;
    }),
    ResponseInterface::class => DI\factory(function () {
        $response = new Zend\Diactoros\Response();
        return $response;
    }),
];