<?php

class Admin_Controllers_Blocks_Menu extends Controllers_Controller{
    private $menuModel;

    /**
     * Admin_Controllers_Blocks_Menu constructor.
     */
    public function __construct(){
        $this->menuModel = new Admin_Models_Blocks_Menu();
        parent::__construct();
    }

    public function index(){
        $tpl = $this->getTPL('blocks/menu/menu');
		$toReplace = array(
            '{add}',
            '{menu}'
        );
        $replace = array(
            $this->menuModel->genAddField(),
            $this->genMenuHTML()
        );
        $html = str_replace($toReplace, $replace, $tpl);
        $this->render($html);
    }

    public function getTPL($name){
        return file_get_contents(ADMIN.'/views/'.$name.'.tpl');
    }

    public function genMenuHTML(){
        return $this->menuModel->genMenuHTML();
    }
}