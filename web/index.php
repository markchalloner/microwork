<?php

// 3rd party scripts
include dirname(__FILE__) . '/../3rdparty/firephp/lib/FirePHPCore/fb.php';

// Core classes
spl_autoload_register(function($class) {
    include dirname(__FILE__) . '/../classes/' . strtolower($class) . '.php';
});

// Start session
session_start();

// Create router and route
try {
    $router = new Router();
    $router->route(isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '');
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}