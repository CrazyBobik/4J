<?php

class Admin_Controllers_Blocks_Head extends Parents_ControllerAdmin{

    public function __construct(){
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
}