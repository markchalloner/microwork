<?php

class Controller {

    private $views = NULL;
    protected $path = NULL;
    protected $router = NULL;
    protected $configuration = NULL;

    public function __construct($path, $router, $configuration) {
        $this->views = dirname(__FILE__) . '/../views';
        $this->path = $path;
        $this->router = $router;
        $this->configuration = $configuration;
    }

    public function run() {
        if (isset($_POST) && count($_POST)) {
            $_SESSION['post'] = $_POST;
            header('Location: ' . $_SERVER['REQUEST_URI'], TRUE, 302);
            exit;
        }
        if (isset($_SESSION['post']) && count($_SESSION['post']))  {
            $this->post($_SESSION['post']);
        }
        $this->get();
        unset($_SESSION['post']);
    }

    protected function post($vars) {
    }

    protected function get() {
        $this->view();
    }

    protected function view($vars = array()) {
        if ($this->viewExists()) {
            $view = new View($this->path, $vars);
            $view->run();
        } else {
            $this->notFound();
        }
    }

    public function viewExists() {
        return is_file($this->views . '/' . $this->path . '.php');
    }

    protected function notFound() {
        header('HTTP/1.0 404 Not Found');
        $view = new View('404');
        $view->run();
        exit;
    }

    protected function forbidden() {
        header('HTTP/1.0 403 Forbidden');
        $view = new View('403');
        $view->run();
        exit;
    }

}