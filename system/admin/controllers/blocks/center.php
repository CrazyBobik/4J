<?php

class Admin_Controllers_Blocks_Center extends Parents_ControllerAdmin{

    public function __construct(){
        $tpl = $this->getTPL('blocks/center/center');
        $html = $tpl;
        $this->render($html);
    }
}