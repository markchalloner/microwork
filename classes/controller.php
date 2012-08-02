<?php

class Controller {

    protected $path = NULL;
    protected $router = NULL;
    protected $configuration = NULL;

    public function __construct($path, $router, $configuration) {
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
        $view = new View($this->path, $vars);
        $view->run();
    }

}