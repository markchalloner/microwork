<?php

class Tag {

    private $values = array();
    private $children = array();
    private $names = array();

    public function __construct($name, $view) {
        $this->name = $name;
        $this->view = $view;
    }

    public function getName() {
        return $this->name;
    }

    public function getView() {
        return $this->view;
    }

    public function setView($view) {
        $this->view = $view;
    }

    public function addValue($value) {
        $this->values[] = $value;
    }

    public function deleteValues() {
        $this->values = array();
    }

    public function addChild($tag) {
        if (empty($this->names[$tag->getName()])) {
            $this->names[$tag->getName()] = TRUE;
            $this->children[] = $tag;
        }
    }

    public function getCurrValue() {
        return $this->values[count($this->values) - 1];
    }

    public function getValues() {
        return $this->values;
    }

    public function getChildren() {
        return $this->children;
    }

    public function isEmpty() {
        $empty = TRUE;
        foreach ($this->getValues() as $value) {
            if (strlen(trim($value)) > 0) {
                $empty = FALSE;
                break;
            }
        }
        return $empty;
    }

}