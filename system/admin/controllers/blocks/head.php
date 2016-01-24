<?php

class Admin_Controllers_Blocks_Head extends Controllers_Controller{

    public function index(){
        $tpl = $this->getTPL('blocks/head/head');
        $toReplace = array(
            '{lang}',
            '{allLangs}'
        );

        $langM = new Modules_Controllers_Lang();

        $replace = array(
            Config::$lang,
            $langM->genLangHTML()
        );
        $html = str_replace($toReplace, $replace, $tpl);
        $this->render($html);
    }

    public function getTPL($name){
        return file_get_contents(ADMIN.'/views/'.$name.'.tpl');
    }
}