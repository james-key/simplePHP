<?php

namespace App;

class DotEnv
{
    public function __construct($path)
    {
        if (!is_file($path)) {
            throw new Exception(".env file not found");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false) {
                [$name, $value] = explode('=', $line, 2);
                putenv("$name=$value");
            }
        }
    }

    public function get($name)
    {
        return getenv($name);
    }
}
