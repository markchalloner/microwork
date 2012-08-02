<?php

class ControllerSecurepage extends ControllerSecure {

    protected $code = '123';
    private $flash = NULL;

    protected function get() {
        $this->view(array(
            'flash' => $this->flash
        ));
    }

}