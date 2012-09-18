<?php

class Router {

    private $classes = NULL;
    private $controllers = NULL;
    private $configuration = NULL;

    public function __construct() {
        $this->classes = dirname(__FILE__);
        $this->controllers = dirname(__FILE__) . '/../controllers';
        $this->configuration = new Configuration();
    }

    public function route($path) {
        $path = str_replace('/', '_', substr(strpos($path, '.') === FALSE ? $path : strstr($path, '.', TRUE), 1));
        $path = strlen($path) ? $path : 'index';
        $controller = $this->load($path);
        $controller->run();
    }

    public function load($path) {
        $controller = NULL;
        $file = NULL;
        $routes = $this->configuration->get('routes', array());
        $args = array();
        foreach ($routes as $route => $data) {
            if (preg_match('/^' . $route . '$/', $path, $matches)) {
                foreach ($data['args'] as $route => $value) {
                    if (preg_match('/^' . $route . '$/', $path)) {
                        $args = $value;
                        $args[] = $matches;
                        break;
                    }
                }
                $file = $data['file'];
                $class = $data['class'];
                break;
            }
        }
        if (isset($file) && is_file($this->controllers . '/' . $file . '.php')) {
            $controller = $this->controllers . '/' . $file . '.php';
        } elseif (is_file($this->controllers . '/' . $path . '.php')) {
                $controller = $this->controllers . '/' . $path . '.php';
                $class = 'Controller' . ucfirst($path);
        } else {
                $controller = $this->classes . '/controller.php';
                $class = 'Controller';
        }
        require_once $controller;
        if (class_exists($class)) {
            $reflection = new ReflectionClass($class);
            $controller = $reflection->newInstanceArgs(array_merge(array(
                $path,
                $this,
                $this->configuration,
            ), $args));
            return $controller;
        } else {
            throw new Exception('No Controller with class ' . $controller . 'found.');
        }
    }

}