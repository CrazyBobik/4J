<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 11.11.2015
 * Time: 21:16
 */
interface Dev_DAO_Interface_Tree{
	/**
	 * @param Entity_Tree $tree
	 * @return mixed
	 */
	public function addTree($tree);

	public function deleteTree($id);
}