<?php

class View {

    private $stack = array();
    private $uses = array();
    private $vars = array();
    private $parents = array();

    public function __construct($path, $vars = array(), $html = null, $parents = array(), $index = 0) {
        $this->logger = FirePHP::getInstance(true);
        $this->vars = $vars;
        if (isset($html)) {
            $this->html = $html;
        } else {
            $this->html = new HTML();
        }
        $this->parents = $parents;
        $this->index = $index;
        $this->child = $index;
        $views = dirname(__FILE__) . '/../views';
        $view = $views . '/' . strtolower($path) . '.php';
        $view_default = $views . '/html.php';
        ob_start();
        $this->start('html');
        $this->add(is_file($view) ? $view : $view_default);
        $this->end('html');
    }

    public function add($view) {
        extract($this->vars, EXTR_SKIP);
        include $view;

    }

    public function run() {
        header('Content-type: text/html');
        $this->html->build();
        $this->html->output();
    }

    public function start($tag) {
        // Close off previous tag
        $len = count($this->stack);
        $content = ob_get_clean();
        if ($len > 0) {
            $prev = $this->stack[$len - 1];
            if (isset($this->parents[$prev])) {
                $parent = $this->parents[$prev];
            } else {
                if ($len > 1) {
                    $parent = $this->stack[$len - 2];
                } else {
                    $parent = NULL;
                }
                $this->parents[$prev] = $parent;
            }
            $this->save($this->stack[$len - 1], $content, $parent);
        }
        array_push($this->stack, $tag);
        ob_start();
    }

    public function end($tag) {
        $len = count($this->stack);
        if ($this->stack[$len - 1] != $tag) {
            throw new Exception('Mismatched end tag: ' . $tag);
        }
        array_pop($this->stack);
        $len = count($this->stack);
        $content = ob_get_clean();

        if (isset($this->parents[$tag])) {
            $parent = $this->parents[$tag];
        } else {
            if ($len > 0) {
                $parent = $this->stack[$len - 1];
            } else {
                $parent = NULL;
            }
            $this->parents[$tag] = $parent;
        }
        $this->save($tag, $content, $parent);
        if ($len > 0) {
            ob_start();
        }
    }

    public function show($tag, $value = '') {
        $this->start($tag);
        echo $value;
        $this->end($tag);
    }

    public function inherits($view) {
        if (!isset($this->parent)) {
            $parent = new View($view, $this->vars, $this->html, $this->parents, ++$this->indexcounter);
            $this->parents = array_merge($parent->getParents(), $this->parents);
            $this->parent = $parent;
        }
    }

    public function uses($view) {
        $this->uses[] = new ViewUse($view, $this->vars, $this->html, $this->parents, ++$this->indexcounter);
    }

    public function getParents() {
        return $this->parents;
    }

    public function getIndex() {
        return $this->index;
    }

    protected function save($tag, $html, $parent = NULL) {
        $this->html->setTag($this, $tag, $html, $parent);
    }

}