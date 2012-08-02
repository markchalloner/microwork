<?php

class Router {

    private $controllers = NULL;
    private $configuration = NULL;

    public function __construct() {
        $this->controllers = dirname('__FILE__') . '/../controllers';
        $this->configuration = new Configuration();
    }

    public function route($path) {
        $path = str_replace('/', '_', substr(strpos($path, '.') === FALSE ? $path : strstr($path, '.', TRUE), 1));
        $path = strlen($path) ? $path : 'index';
        $controller = $this->load($path);
        $controller->run();
    }

    public function load($path) {
        $path = is_file($this->controllers . '/' . $path . '.php') ? $path : '404';
        $controller = $this->controllers . '/' . $path . '.php';
        require_once $controller;
        $class = 'Controller' . ucfirst($path);
        $controller = new $class($path, $this, $this->configuration);
        return $controller;
    }

}