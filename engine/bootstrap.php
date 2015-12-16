<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 25.08.2015
 * Time: 22:51
 */
class Bootstrap{
	static private $init = null;

	private function __construct(){
	}

	public static function init(){
		if (self::$init == null){
			self::$init = new self();
		}

		return self::$init;
	}

	public function start(){
		$this->autoLoader();
		//инициализация всего что надо
		$this->initHelpers();

		if (Libs_URL::get()->checkPath('admin')){
			$this->initAdmin();
		} else {
//			$this->initMain();
		}
	}

	private function initMain(){
		new Controllers_Main();
	}

	private function initAdmin(){
		new Admin_Controllers_Main();
	}

	private function initHelpers(){
		require_once 'libs/helpers.php';

		Libs_Session::start();
	}

	public function autoLoader(){
		require_once 'libs/loader.php';
		spl_autoload_register(array('Loader', 'auto_load'));
	}
}