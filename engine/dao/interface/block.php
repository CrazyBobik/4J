<?php

interface DAO_Interface_Block{
	/**
	 * @param int $id
	 * @return Entity_Block
	 */
	public function getOne($id);

	/**
	 * @param Entity_Block $block
	 * @param Entity_Tree $treeLeaf
	 */
	public function add($treeLeaf, $block);

	public function delete($id);

	public function deleteFromTable($id);

	/**
	 * @param Entity_Block $block
	 * @return mixed
	 */
	public function update($block);

	public function getBlocksForPage($page);
}