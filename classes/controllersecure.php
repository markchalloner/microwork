<?php

class ControllerSecure extends Controller {

    protected $code = NULL;
    private $override = 'XXXX';

    public function __construct($path, $router, $configuration, $code) {
        parent::__construct($path, $router, $configuration);
        $this->code = $code;
    }

    public function run() {
        if ($_GET['code'] == $this->override) {
            header('Location: ' . preg_replace('/code=' . $this->override . '/', 'code=' . $this->code, $_SERVER['REQUEST_URI']), TRUE, 302);
            return;
        }
        if (isset($this->code) && (!isset($_GET['code']) || ($_GET['code'] != $this->code))) {
            $this->forbidden();
        }
        parent::run();
    }

    public function getCode() {
        return $this->code;
    }

}