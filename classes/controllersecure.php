<?php

class ControllerSecure extends Controller {

    protected $code = NULL;

    public function run() {
        if (isset($this->code) && (!isset($_GET['code']) || $_GET['code'] != $this->code)) {
            $this->forbidden();
        }
        parent::run();
    }

    public function getCode() {
        return $this->code;
    }

}