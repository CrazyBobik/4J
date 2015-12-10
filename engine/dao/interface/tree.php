<?php

/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 09.11.2015
 * Time: 22:50
 */
interface DAO_Interface_Tree{

	public function getOne($id, $fields='*');

	public function getChild($id, $types);
}