<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 25.11.2015
 * Time: 20:45
 */
interface DAO_Interface_Type{

	public function createTable($name, $fields, $seo);

	public function writeType($title, $name, $fields, $seo);
}