<?php
/**
 * Created by PhpStorm.
 * User: shyandsy
 * Date: 2/1/2019
 * Time: 3:50 PM
 */
namespace App\Controllers;
use Shy\Controller;

class HomeController extends Controller{//extends Controller{
    public function index(){
        // 获得get参数
        $query   = $this->request->getQueryParams();
        // 获得post参数
        $body    = $this->request->getParsedBody();
        $headers = $this->request->getHeaders();
        // 获得cookie
        $cookies = $this->request->getCookieParams();
        $files   = $this->request->getUploadedFiles();
        $server  = $this->request->getServerParams();

        echo "==============<br>";
        echo "header<br>";
        foreach($headers as $key => $value){
            $value = implode(";", $value);
            echo "$key => $value<br>";
        }
        echo "get<br>";
        foreach($query as $key => $value){
            echo "$key => $value<br>";
        }
        echo "==============<br>";
        echo "post<br>";
        foreach($body as $key => $value){
            echo "$key => $value<br>";
        }
        echo "==============<br>";
        echo "cookies<br>";
        foreach($cookies as $key => $value){
            echo "$key => $value<br>";
        }
        echo "==============<br>";
        echo "files<br>";
        foreach($files as $file){
            echo $file->getClientFilename() . "<br>";
            echo $file->getClientMediaType() . "<br>";
            echo $file->getError() . "<br>";
            echo $file->getSize() . "<br>";
        }
        echo "==============<br>";
        echo "server<br>";
        foreach($server as $key => $value){

            echo "$key => $value<br>";
        }
        $this->setOutput('<h1>Hello, World!</h1>');
    }
}