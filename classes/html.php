<?php

class HTML {

    private $viewcounter = 0;
    private $tags = array();
    private $uses = array();
    private $root = null;
    private $contents = array();

    public function __construct() {
        $this->logger = FirePHP::getInstance(true);
    }

    public function setTag($view, $name, $value, $parent = NULL) {

          // Add the tag if it does not already exist or the value is non-empty
          if (!isset($this->tags[$name]) || strlen(trim($value))) {
            if (isset($this->tags[$name])) {
                $tag = $this->tags[$name];
            } else {
                $tag = new Tag($name, $view);
                $this->tags[$name] = $tag;
            }
            // Assign the root to the first tag (html)
            if (!isset($this->root)) {
                $this->root = $tag;
            }
            if (isset($parent) && isset($this->tags[$parent])) {
                $parent = $this->tags[$parent];
                $parent->addChild($tag);
            }
            // Delete any empty content if we are adding true content
            if (strlen(trim($value)) && $tag->isEmpty()) {
                $tag->deleteValues();
            }
            // If we are at the same level
            if ($view->getIndex() == $tag->getView()->getIndex()) {
                // Just add this content
                $tag->addValue($value);
            // Otherwose
            } else if ($view->getIndex() < $tag->getView()->getIndex()) {
                // Override with this level's content
                $tag->deleteValues();
                $tag->addValue($value);
                $tag->setView($view);
            }
        }
    }

    public function build($tag = NULL, $c = 0) {
        if ($c >= 100) {
            return;
        }
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
            $this->contents[] = $values[$i];
            if (isset($children[$i])) {
                $this->build($children[$i], $c+1);
            }
        }
    }

    public function output() {
        foreach ($this->contents as $content) {
            echo $content;
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