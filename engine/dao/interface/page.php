<?php

interface DAO_Interface_Page{
	/**
	 * @param int $id
	 * @return Entity_Page
	 */
	public function getOne($id);

	/**
	 * @param Entity_Page $page
	 * @param Entity_Tree $treeLeaf
	 */
	public function add($treeLeaf, $page);

	public function delete($id);

	/**
	 * @param Entity_Page $page
	 * @return mixed
	 */
	public function update($page);
}