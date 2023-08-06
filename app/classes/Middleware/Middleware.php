<?php

namespace App\Middleware;

use App\Exception;

class Middleware
{
    private $checks = [];

    public function add($callback)
    {
        $this->checks[] = $callback;
    }

    public function run($args)
    {
        foreach ($this->checks as $check) {
            if (!call_user_func($check, $args)) {
                throw new Exception("Middleware check failed");
            }
        }
    }
}
