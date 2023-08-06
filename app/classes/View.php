<?php

namespace App;

class View
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function render($name, $data = [])
    {
        $path = $this->path . DIRECTORY_SEPARATOR . $name . '.php';
        $path = str_replace(['../', './', '//'], '', $path);

        if (!is_file($path)) {
            throw new Exception("View {$this->path} not found");
        }
        
        ob_start();
        extract($data, EXTR_SKIP);
        require $path;
        return ob_get_clean();
    }
}
