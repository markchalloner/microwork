<?php

class ControllerIndex extends Controller {

    private $flash = NULL;

    protected function post($vars) {
        if (isset($vars['password']) && $vars['password'] == $this->configuration->get('password')) {
            $controller = $this->router->load('securepage');
            header('Location: securepage' . (empty($controller->is404) ? '?code=' . $controller->getCode() : ''), TRUE, 302);
            exit;
        } else {
            $this->flash = 'Incorrect password';
        }
    }

    protected function get() {
        $this->view(array(
            'flash' => $this->flash
        ));
    }

}