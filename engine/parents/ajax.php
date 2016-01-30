<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 11.10.2015
 * Time: 12:25
 */
class Parents_Ajax{

	protected $isAjax;

	/**
	 * Ajax constructor.
	 * @param $isAjax
	 */
	public function __construct($isAjax){
		$this->isAjax = $isAjax;
	}

	protected function putJSON($item){
		die(json_encode($item));
	}

	protected function putAjax($item){
		die($item);
	}

	public function isAjax(){
		return $this->isAjax;
	}
}