<?php

class Configuration {

    private $configuration = array();

    public function __construct() {
        require_once dirname(__FILE__) . '/../configuration.php';
        $this->configuration = compact(array_keys(get_defined_vars()));
    }

    public function get($name, $default = FALSE) {
        return isset($this->configuration[$name]) ? $this->configuration[$name] : $default;
    }
}