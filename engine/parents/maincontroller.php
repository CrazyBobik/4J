<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 27.01.2016
 * Time: 14:28
 */
class Parents_MainController{
	public function removeFile($name){
		$fileWorker = new Libs_FileWorker();
		$fileWorker->removeFile($name);
	}
}