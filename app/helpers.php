<?php

use App\App;

function view($template, $data = [])
{
    $app = App::getInstance();
    return $app->getView()->render($template, $data);
}

function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}
