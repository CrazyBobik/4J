<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 22.09.2015
 * Time: 21:40
 */
class Libs_Cookie{
	public static function setCookie($name, $value = '', $exp = null, $path = null,
									 $domain = null, $secure = null, $http = null){
		return setcookie($name, $value, $exp, $path, $domain, $secure, $http);
	}

	public static function getCookie($name){
		if (isset($_COOKIE[$name])){
			return $_COOKIE[$name];
		} else {
			return false;
		}
	}

	public static function deleteCookie($name){
		setcookie($name, '');
	}

	public static function setArrayCookie($name, $array = array(), $exp = null, $path = null,
										  $domain = null, $secure = null, $http = null){
		foreach ($array as $k => $v){
			self::setCookie($name.'['.$k.']', $v, $exp, $path, $domain, $secure, $http);
		}
	}

	public static function getArrayCookie($name){
		if (isset($_COOKIE[$name])){
			$result = array();
			foreach ($_COOKIE[$name] as $k => $v){
				$result[$k] = $v;
			}

			return $result;
		} else {
			return false;
		}
	}

	public static function deleteArrayCookie($name){
		if (isset($_COOKIE[$name])){
			foreach ($_COOKIE[$name] as $k => $v){
				self::deleteCookie($name.'['.$k.']');
			}
		}
	}
}