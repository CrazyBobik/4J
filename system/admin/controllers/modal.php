<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 08.12.2015
 * Time: 0:00
 */
class Admin_Controllers_Modal extends Ajax{
	public function __construct(){
		parent::__construct(true);
	}

	public function addType(){
		$controller = new Admin_Controllers_Type();
		$controller->getType();
	}
}