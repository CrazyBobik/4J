<?php

class Controllers_Blocks_{class_name} extends Controllers_Controller{

	public function index(){
        $tpl = $this->getTPL('blocks/{name}/{name}');
        $html = $tpl;
        $this->render($html);
    }
}