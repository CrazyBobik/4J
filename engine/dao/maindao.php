<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 09.11.2015
 * Time: 22:35
 */
class DAO_MainDAO{
	protected $DB;

	/**
	 * DAO_MainDAO constructor.
	 */
	public function __construct(){
		$this->DB = DAO_DB::init()->getDB();
	}
}