<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 25.08.2015
 * Time: 23:12
 */

abstract class Controllers_Controller{
	protected $model;

	public function __construct(){
		$this->index();
	}

	public function getTPL($name){
	 	return file_get_contents(MVC.'/views/'.$name.'.tpl');
	}

	public function render($html){
		echo $html;
	}

	abstract public function index();
}