<?php

/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 16.09.2015
 * Time: 21:36
 */
class Libs_URL{
	private $pathArray = array();
	private $parseURL;
	protected static $init = null;

	/**
	 * Lib_URL constructor.
	 * @param string $str URL
	 */
	public function __construct($str){
		$this->parseURL = parse_url($str);

		$this->pathArray = explode('/', trim($this->parseURL['path'], '/'));
	}

	public static function get(){
		if (self::$init == null){
			self::$init = new self($_SERVER['REQUEST_URI']);
		}

		return self::$init;
	}

	public function getPath(){
		return $this->parseURL['path'];
	}

	public function getParseURL(){
		return $this->pathArray;
	}

	public function getPiceURL($id){
		return $this->pathArray[$id];
	}

	public static function getDomen(){
		return $_SERVER['SERVER_NAME'];
	}

	public function checkPath($name, $id = 0){
		if ($this->getPiceURL($id) === $name || $this->getPiceURL(++$id) === $name){
			return true;
		}

		return false;
	}
}