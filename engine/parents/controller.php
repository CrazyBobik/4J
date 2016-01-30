<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 25.08.2015
 * Time: 23:12
 */

abstract class Parents_Controller{
	protected $model;

	public function getTPL($name){
	 	return file_get_contents(MVC.'/views/'.$name.'.tpl');
	}

	public function render($html){
		echo $html;
	}
}