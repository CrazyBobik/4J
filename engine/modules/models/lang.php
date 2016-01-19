<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 19.01.2016
 * Time: 17:47
 */
class Modules_Models_Lang{
	private $langDAO;

	/**
	 * Admin_Models_Lang constructor.
	 */
	public function __construct(){
		$this->langDAO = new DAO_Lang();
	}


	/**
	 * @return Entity_Tree[]
	 */
	public function getLangs(){
		return $this->langDAO->getLangs();
	}

	public function genLangHTML(){
		$html = '';

		return $html;
	}
}