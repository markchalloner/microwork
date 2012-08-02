<?php

class Value {

    public function __construct($value, $tag) {
        $this->value = $value;
        $this->tag = $tag;
    }

    public function getValue() {
        return $this->value;
    }

    public function getTag() {
        return $this->tag;
    }
}