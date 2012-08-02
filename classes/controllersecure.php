<?php

class ControllerSecure extends Controller {

    protected $code = 0;

    public function run() {
        if (!isset($_GET['code']) || $_GET['code'] != $this->code) {
            $this->forbidden();
        }
        parent::run();
    }

    protected function forbidden() {
        header('HTTP/1.0 403 Forbidden');
        $view = new View('403');
        $view->run();
        exit;
    }

    public function getCode() {
        return $this->code;
    }

}