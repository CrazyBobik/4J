<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 02.10.2015
 * Time: 22:31
 */
class Libs_Storage{
	private $arr = array();

	private static $init = null;

	/**
	 * Libs_Storage constructor.
	 */
	public function __construct(){}

	function __clone(){}

	public static function init(){
		if (self::$init == null)
			self::$init = new self();

		return self::$init;
	}

	/**
	 * @return array
	 */
	public function getElement($id){
		if(empty($id))
			return false;

		return $this->arr[$id];
	}

	/**
	 * @param array $arr
	 */
	public function setElemnt($id, $value){
		if (empty($id) || empty($value))
			return false;

		$this->arr[$id] = $value;
		return true;
	}
}