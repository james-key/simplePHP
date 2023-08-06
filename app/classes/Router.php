<?php

namespace App;

class Router
{
    private $routes = [];

    public function add($uri, $callback)
    {
        $this->routes[$uri] = $callback;
    }

    public function route($request, $response)
    {
        $uri = $request->getUri();

        if (!isset($this->routes[$uri])) {
            throw new Exception("No route found for URI: $uri");
        }

        $callback = $this->routes[$uri];
        $result = $this->executeCallback($callback);

        $response->send($result);
    }

    private function executeCallback($callback)
    {
        if (is_array($callback)) {
            [$controller, $method] = $callback;
            return call_user_func([$controller, $method]);
        } elseif (is_callable($callback)) {
            return call_user_func($callback);
        } else {
            throw new Exception('Invalid route callback. Must be a controller method or a callable function');
        }
    }
}
