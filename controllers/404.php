<?php

class Controller404 extends Controller {

    public $is404 = TRUE;

    protected function view($vars = array()) {
       $this->notFound();
    }

    private function notFound() {
        header('HTTP/1.0 404 Not Found');
        $view = new View('404');
        $view->run();
        exit;
    }

}