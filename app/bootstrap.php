<?php

use App\App;

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');

require_once ROOT_PATH . '/app/classes/App.php';
require_once ROOT_PATH . '/app/helpers.php';

$app = new App(ROOT_PATH . '/.env', APP_PATH . '/views');

require_once APP_PATH . '/routes.php';

$app->run();
