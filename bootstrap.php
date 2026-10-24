<?php

use Core\App;
use Core\Container;
use Core\Database;
use Core\PayPal\PayPal;

$container = new Container();

$container->singleton(Database::class, function () {
    $config = require base_path('config.php');

    return new Database($config['database'], $config['username'], $config['password']);
});

$container->singleton(PayPal::class, function () {
    $config = require base_path('config.php');

    return new PayPal($config['paypal']);
});

App::setContainer($container);