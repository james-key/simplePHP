<?php

$app->route('/', function () {
    return 'Hello World';
});

$app->route('/user', 'UserController@index');

$app->route('/login', 'LoginController@index');
