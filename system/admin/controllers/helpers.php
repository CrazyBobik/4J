<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 19.01.2016
 * Time: 22:05
 */
class Admin_Controllers_Helpers extends Ajax{
    /**
     * Ajax constructor.
     * @param $isAjax
     */
    public function __construct($isAjax = true){
        parent::__construct($isAjax);
    }

    public function changeLang(){
        $langM = new Modules_Controllers_Lang();

        $this->putAjax($langM->setAdminLang(strip_tags($_POST['lang'])));
    }
}