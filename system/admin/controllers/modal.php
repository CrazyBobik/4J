<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 08.12.2015
 * Time: 0:00
 */
class Admin_Controllers_Modal extends Parents_Ajax{
	public function __construct(){
		parent::__construct(true);
	}

	public function addType(){
		$controller = new Admin_Controllers_Type(false);
		$data['context'] = $controller->getType();
		$data['title'] = 'Добавить новый тип';

		$this->putJSON($data);
	}
}