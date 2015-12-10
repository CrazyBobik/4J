<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 02.10.2015
 * Time: 22:07
 */
class Libs_SEO {
	private $title;
	private $key;
	private $desc;

	private static $init = null;

	/**
	 * Libs_SEO constructor.
	 */
	private function __construct(){}

 	private function __clone(){}

	public static function init(){
		if (self::$init == null)
			self::$init = new self();

		return self::$init;
	}

	/**
	 * @return mixed
	 */
	public function getTitle(){
		return $this->title;
	}

	/**
	 * @param mixed $title
	 */
	public function setTitle($title){
		$this->title = $title;
	}

	/**
	 * @return mixed
	 */
	public function getKey(){
		return $this->key;
	}

	/**
	 * @param mixed $key
	 */
	public function setKey($key){
		$this->key = $key;
	}

	/**
	 * @return mixed
	 */
	public function getDesc(){
		return $this->desc;
	}

	/**
	 * @param mixed $desc
	 */
	public function setDesc($desc){
		$this->desc = $desc;
	}
}