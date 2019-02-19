<?php
/**
 * Created by PhpStorm.
 * User: shyandsy
 * Date: 2/2/2019
 * Time: 12:00 AM
 */
namespace Shy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Controller
{
    protected $request;
    protected $response;

    public function __construct(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
    public function setOutput($content){
        $this->response->getBody()->write($content);
    }
}