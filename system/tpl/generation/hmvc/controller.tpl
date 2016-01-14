<?php

class Admin_Controllers_Blocks_{class_name} extends Controllers_Controller{

    public function index(){
        $tpl = $this->getTPL('blocks/{name}/{name}');
        $html = $tpl;
        $this->render($html);
    }

    public function getTPL($name){
        return file_get_contents(ADMIN.'/views/'.$name.'.tpl');
    }
}