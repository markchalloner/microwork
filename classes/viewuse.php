<?php

class ViewUse extends View {

    public function run() {
    }

    protected function save($tag, $html, $parent = NULL) {
        $this->html->setUseTag($this, $tag, $html, $parent);
    }

}