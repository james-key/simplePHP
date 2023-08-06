<?php

namespace App;

class DotEnv
{
    private $config = [];

    public function __construct($path)
    {
        if (!is_file($path)) {
            throw new Exception(".env file not found");
        }
        
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false) {
                [$name, $value] = explode('=', $line, 2);
                $this->config[$name] = $value;
            }
        }
    }

    public function get($name)
    {
        return $this->config[$name] ?? null;
    }
}
