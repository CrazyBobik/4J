<?php

/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 22.09.2015
 * Time: 21:07
 */
class Libs_Session{
    private static $init = null;

    /**
     * Libs_Session constructor.
     */
    private function __construct(){
        session_start();
    }

    private function __clone(){
    }

    public static function start(){
        if(self::$init == null){
            self::$init = new self();
        }

        return self::$init;
    }

    public function setParam($name, $value){
        if(isset($name) && isset($value)){
            $_SESSION[$name] = $value;
            return true;
        } else{
            return false;
        }
    }

    public function getParam($name){
        if(isset($_SESSION[$name]))
            return $_SESSION[$name];
        else
            return false;
    }

    public function deleteParam($name){
        if(isset($_SESSION[$name])){
            unset($_SESSION[$name]);
            return true;
        } else{
            return false;
        }
    }

    public function destroySession(){
        die(session_destroy());
    }

    public function isAdmin(){
        return $this->getParam('admin_id');
    }
}