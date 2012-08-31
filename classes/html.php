<?php

class HTML {

    private $viewcounter = 0;
    private $tags = array();
    private $uses = array();
    private $root = NULL;
    private $contents = array();

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
        $values = $tag->getValues();
        $children = $tag->getChildren();
        if ($tag == $this->root || empty($this->uses[$name])) {
            $values = $tag->getValues();
            $children = $tag->getChildren();
        } else {
            $tag = $this->uses[$name];
            $values = strlen(trim(implode('', $tag->getValues()))) ? $tag->getValues() : $values;
            $children = $this->mergeUses($children, $tag->getChildren());
        }
        for ($i = 0, $l = count($values); $i < $l; $i++) {
            $this->contents[] = $values[$i];
            // Build the child after this content
            if (isset($children[$i])) {
                $this->build($children[$i], $c+1);
            }
        }
        // Build any leftover children
        for ($l = count($children); $i < $l; $i++) {
            $this->build($children[$i], $c+1);
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
            $tag = $this->uses[$name];
        } else {
            $tag = new Tag($name, $view);
            $this->uses[$name] = $tag;
        }
        if (isset($parent) && isset($this->uses[$parent])) {
            $this->uses[$parent]->addChild($tag);
        }
        $tag->addValue($value);
    }

    private function viewToIndex($view) {
        if (!isset($this->viewindexes[$view])) {
            $this->viewindexes[$view] = $this->viewcounter++;
        }
        return $this->viewindexes[$view];
    }

    private function mergeUses($tags, $uses) {
        $return = array();
        foreach ($uses as $use) {
            $return[$use->getName()] = $use;
        }
        foreach ($tags as $tag) {
            $return[$tag->getName()] = $tag;
        }
        return array_values($return);
    }

}