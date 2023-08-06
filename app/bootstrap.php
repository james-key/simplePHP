<?php

use App\App;

define('ROOT', dirname(__DIR__));

require_once ROOT . '/app/classes/App.php';
require_once ROOT . '/app/helpers.php';

$app = new App(ROOT . '/.env', ROOT . '/app/views');

require_once ROOT . '/app/routes.php';

$app->run();
