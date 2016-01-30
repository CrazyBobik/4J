<?php

class Controllers_Blocks_{class_name} extends Parents_Controller{

	public function __construct(){
        $tpl = $this->getTPL('blocks/{name}/{name}');
        $html = $tpl;
        $this->render($html);
    }
}