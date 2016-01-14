<?php

interface DAO_Interface_Item{
	/**
	 * @param int $id
	 * @return Entity_Item
	 */
	public function getOne($id);

	/**
	 * @param Entity_Item $item
	 * @param Entity_Tree $treeLeaf
	 */
	public function add($treeLeaf, $item);

	public function delete($id);

	/**
	 * @param Entity_Item $item
	 * @return mixed
	 */
	public function update($item);
}