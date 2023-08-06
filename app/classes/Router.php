<?php

namespace App;

class Router
{
    private $routes = [];

    public function add($uri, $callback)
    {
        $this->routes[$uri] = $callback;
    }

    public function match($uri)
    {
        if (!isset($this->routes[$uri])) {
            throw new Exception("No route found for URI: $uri");
        }
        
        return $this->routes[$uri];
    }
}
