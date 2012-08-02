<?php

class HTML {

    private $viewcounter = 0;
    private $tags = array();
    private $uses = array();
    private $root = null;

    public function __construct() {

    }

    public function setTag($view, $name, $value, $parent = NULL) {
        if (!isset($this->tags[$name]) || strlen(trim($value))) {
            if (isset($this->tags[$name])) {
                $tag = $this->tags[$name];
            } else {
                $tag = new Tag($name, $view);
                $this->tags[$name] = $tag;
            }
            if (!isset($this->root)) {
                $this->root = $tag;
            }
            if (isset($parent) && isset($this->tags[$parent])) {
                $parent = $this->tags[$parent];
                $parent->addChild($tag);
            }
            if ($view->getIndex() == $tag->getView()->getIndex()) {
                $tag->addValue($value);
            } else if ($view->getIndex() < $tag->getView()->getIndex()) {
                $tag->deleteValues();
                $tag->addValue($value);
                $tag->setView($view);
            }
        }
    }

    public function build($tag = NULL, $k = 0) {
        if (!isset($tag)) {
            $tag = $this->root;
        }
        $name = $tag->getName();
        if (isset($this->uses[$name])) {
            $tag_uses = $this->uses[$name];
            $values_uses = $tag_uses->getValues();
        }
        $values = isset($tag_uses) && strlen(trim(implode('', $values_uses))) ? $values_uses : $tag->getValues();
        $children = $tag->getChildren();
        for ($i = 0, $l = count($values); $i < $l; $i++) {
            echo $values[$i];
            if (isset($children[$i])) {
                $this->build($children[$i], $k+1);
            }
        }
    }

    public function setUseTag($view, $name, $value, $parent = NULL) {
        if (isset($this->uses[$name])) {
            $tag = $this->uses[$name];
        } else {
            $tag = new Tag($name, $view);
            $this->uses[$name] = $tag;
        }
        if (isset($parent) && isset($this->uses[$parent])) {
            $parent = $this->uses[$parent];
            $parent->addChild($tag);
        }
        $tag->addValue($value);
    }

    private function viewToIndex($view) {
        if (!isset($this->viewindexes[$view])) {
            $this->viewindexes[$view] = $this->viewcounter++;
        }
        return $this->viewindexes[$view];
    }

}