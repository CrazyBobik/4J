<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 19.01.2016
 * Time: 17:53
 */
class Modules_Controllers_Lang{
	private $langModel;

	/**
	 * Modules_Controllers_Lang constructor.
	 */
	public function __construct(){
		$this->langModel = new Modules_Models_Lang();
	}

	/**
	 * @return Entity_Tree[]
	 */
	public function getLangs(){
		return $this->langModel->getLangs();
	}

	public function genLangHTML(){
		return $this->langModel->genLangHTML();
	}
}