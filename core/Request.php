<?php

namespace core;

use models\User;

class Request{

    protected $route;
    protected $routes = [];
    protected $params = [];
    protected $query = [];
    protected $data = [];

    public function __get($name)
    {
        return $this->$name;
    }

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
//        header('Access-Control-Allow-Method: POST');
//        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Method,Authorization,X-Requested-With');

        $routesConf = require "config/routes.php";
        $this->routes = $routesConf;
        $this->data = json_decode(file_get_contents("php://input"),true);
    }

    /**
     * @return bool
     */
    private function match(){
        $method = strtolower($_SERVER["REQUEST_METHOD"]);
        $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
        $this->route = trim($uri_parts[0],'/');
        $route = $method.":".$this->route;
        if(isset($this->routes[$route])){
            $this->params = $this->routes[$route];
            $this->params['method'] = $method;
            return true;
        }
        elseif (isset($this->routes[$this->route])){
            $this->params = $this->routes[$this->route];
            return true;
        }else{
            $this->params = [];
            return false;
        }
    }

    /**
     *
     */
    public function run(){
        if($this->match()){
            $controller = "controllers\\".$this->params['controller'];
            if (class_exists($controller)){
                $action = $this->params['action'];
                if(method_exists($controller,$action)){
                    $instance = new $controller($this);
                    $instance->$action();
                }else{
                    return  response(["message"=>"Method ".$this->params['action']." Not found"],400);
                }
            }
            else{
                return response(["message"=>"Class : ".$this->params['controller']." Not found"],400);
            }
        }else{
            return response(["message"=>"Rout Not found"],400);
        }
    }

}