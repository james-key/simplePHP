<?php

namespace App;

use App\Http\Request;
use App\Http\Response;
use App\Middleware\Middleware;

class App
{
    private static $instance;
    private $env;
    private $router;
    private $middleware;
    private $view;


    public function __construct($env_path, $view_path)
    {
        spl_autoload_register([$this, 'register']);

        $this->env = new DotEnv($env_path);
        $this->router = new Router();
        $this->middleware = new Middleware();
        $this->view = new View($view_path);

        self::$instance = $this;
    }

    public static function getInstance() {
        return self::$instance;
    }

    public function register($class_name)
    {
        $prefix = 'App\\';
        $class_name = str_replace($prefix, '', $class_name);
        $file_path = str_replace('\\', DIRECTORY_SEPARATOR, $class_name);
        $file = __DIR__ . '/' . $file_path . '.php';

        if (file_exists($file)) {
            include $file;
        }
    }

    public function run()
    {
        try {
            $request = new Request();
            $response = new Response();
            $uri = $request->getUri();

            $this->middleware->run($uri);
            $this->router->route($request, $response);
        } catch (Exception $e) {
            $response->setStatusCode(500);
            $response->send("Error: " . $e->getMessage());
        }
    }

    public function route($uri, $callback)
    {
        if (is_string($callback)) {
            [$controller_name, $method] = explode('@', $callback);
            $controller = $this->getController($controller_name);
            $callback = [$controller, $method];
        } else if (!is_callable($callback)) {
            throw new Exception('Invalid route callback. Must be a controller method or a callable function');
        }
        
        $this->router->add($uri, $callback);
    }

    public function getController($name)
    {
        $class = "\\App\\Controller\\$name";
        return new $class($this);
    }

    public function getEnv()
    {
        return $this->env;
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function getMiddleware()
    {
        return $this->middleware;
    }

    public function getView()
    {
        return $this->view;
    }
}
