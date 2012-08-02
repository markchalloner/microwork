<?php

// 3rd party scripts

// Core classes
spl_autoload_register(function($class) {
    include dirname(__FILE__) . '/../classes/' . strtolower($class) . '.php';
});

// Start session
session_start();

// Create router and route
$router = new Router();
$router->route(isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '');