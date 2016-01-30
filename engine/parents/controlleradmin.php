<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 30.01.2016
 * Time: 15:18
 */
class Parents_ControllerAdmin extends Parents_Controller{
    public function getTPL($name){
        return file_get_contents(ADMIN.'/views/'.$name.'.tpl');
    }
}