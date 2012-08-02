<?php

class View {

    private $stack = array();
    private $uses = array();
    private $vars = array();

    public function __construct($path, $vars = array(), $html = null, $index = 0) {
        $this->vars = $vars;
        if (isset($html)) {
            $this->html = $html;
        } else {
            $this->html = new HTML();
        }
        $this->index = $index;
        $this->child = $index;
        $views = dirname(__FILE__) . '/../views';
        $view = $views . '/' . strtolower($path) . '.php';
        $view_default = $views . '/html.php';
        $this->start('html');
        $this->add(is_file($view) ? $view : $view_default);
        $this->end('html');
    }

    public function add($view) {
        extract($this->vars, EXTR_SKIP);
        include $view;
    }

    public function run() {
        $this->html->build();
    }

    public function start($tag) {
        $len = count($this->stack);
        if ($len > 1) {
            $this->save($this->stack[$len - 1], ob_get_clean(), $this->stack[$len - 2]);
        } else if ($len > 0) {
            $this->save($this->stack[$len - 1], ob_get_clean());
        }
        array_push($this->stack, $tag);
        ob_start();
    }

    public function end($tag) {
        array_pop($this->stack);
        $len = count($this->stack);
        if ($len > 0) {
            $this->save($tag, ob_get_clean(), $this->stack[$len - 1]);
            ob_start();
        } else {
            $this->save($tag, ob_get_clean());
        }
    }


    public function show($tag, $value = '') {
        $this->start($tag);
        echo $value;
        $this->end($tag);
    }

    public function inherits($view) {
        if (!isset($this->parent)) {
            $this->parent = new View($view, $this->vars, $this->html, ++$this->indexcounter);
        }
    }

    public function uses($view) {
        $this->uses[] = new ViewUse($view, $this->vars, $this->html, ++$this->indexcounter);
    }

    public function getIndex() {
        return $this->index;
    }

    protected function save($tag, $html, $parent = NULL) {
        $this->html->setTag($this, $tag, $html, $parent);
    }
}