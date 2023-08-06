<?php

namespace App;

class Router
{
    private $routes = [];

    public function add($uri, $callback)
    {
        $this->routes[$uri] = $callback;
    }

    public function route($uri, $request, $response)
    {
        if (isset($this->routes[$uri])) {
            $callback = $this->routes[$uri];
            if (is_array($callback)) {
                $controller = $callback[0];
                $method = $callback[1];
                $result = call_user_func([$controller, $method]);
                $response->send($result);
            } else if (is_callable($callback)) {
                $result = call_user_func($callback);
                $response->send($result);
            }
        } else {
            throw new Exception("No route found for URI: $uri");
        }
    }
}
