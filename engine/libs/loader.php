<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 26.08.2015
 * Time: 22:52
 */
class Loader{

	public static function auto_load($class){
		try{
			// Transform the class name into a path
			$file = str_replace('_', '/', strtolower($class));

			if ($path = self::find_file($file)){
				// Load the class file
				require_once $path;
				// Class has been found
				return TRUE;
			}
			// Class is not in the filesystem
			return FALSE;
		} catch (Exception $e){
			throw(new Exception($e->getMessage()));
		}
	}

	public static function find_file($path){
		$resultPath = false;

		if (file_exists(ENGINE.'/'.$path.'.php')){
			$resultPath = ENGINE.'/'.$path.'.php';
		} else if (file_exists(MVC.'/'.$path.'.php')){
			$resultPath = MVC.'/'.$path.'.php';
		} else if (file_exists(AJAX.'/'.$path.'.php')){
			$resultPath = AJAX.'/'.$path.'.php';
		} else if (file_exists(SYSTEM.'/'.$path.'.php')){
			$resultPath = SYSTEM.'/'.$path.'.php';
		}

		return $resultPath;
	}
}