<?php

class File {

    private $name = NULL;

    public function __construct($name) {
        $this->name = $name;
    }

    public function read($default = FALSE) {
        return is_file($this->name) && is_readable($this->name) ? file_get_contents($this->name) : $default;
    }

    public function write($data) {
        return @file_put_contents($this->name, $data) !== FALSE;
    }

}