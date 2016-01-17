<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 25.11.2015
 * Time: 20:45
 */
interface DAO_Interface_Type{

	public function getType($id);

	public function getTypeByName($name);

	public function getAllTypes();

	public function createTable($name, $fields, $seo);

	public function dropTable($name);

	public function writeType($title, $name, $fields, $seo);

	public function deleteType($id);
}