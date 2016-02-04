<?php
namespace Library;

class Router
{
    private $url;
    private $routes = [];
    private $namedRoutes = [];

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function get($path, $callable, $name = null) {
        return $this->add($path, $callable, $name,'GET');
    }

    public function post($path, $callable, $name = null) {
        return $this->add($path, $callable, $name,'POST');
    }

    private function add($path, $callable, $name, $method) {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if(is_string($callable) && $name === null) {
            $name = $callable;
        }
        if($name) {
            $this->namedRoutes[$name] = $name;
        }
        return $route;
    }

    public function run() {
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new RouterException('REQUEST_METHOD n\'existe pas');
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match($this->url)){
                return $route->call();
            }
        }

        throw new RouterException('Aucune route correspondante');

        /*global $routes;

        if(!empty($routes[$route])) {
            $parts = explode('/index.php?url=', $routes[$route]);
            var_dump($parts);
            require_once('../application/controllers/'.$parts[0].'Controller.php');
            $controllerName = $parts[0].'Controller';
            $test = new $controllerName();
        }
        else {
            throw new Exception('No route for ' . $route);
        }*/
    }

    public function url($name, $params = []) {
        if(!isset($this->namedRoutes[$name])) {
            throw new RouterException('Aucune route ne correspond');
        }
        var_dump($this->namedRoutes);
        return $this->namedRoutes[$name]->getUrl($params);
    }
}