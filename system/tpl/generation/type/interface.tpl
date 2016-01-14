<?php

interface DAO_Interface_{class_name}{
	/**
	 * @param int $id
	 * @return Entity_{class_name}
	 */
	public function getOne($id);

	/**
	 * @param Entity_{class_name} ${name}
	 * @param Entity_Tree $treeLeaf
	 */
	public function add($treeLeaf, ${name});

	public function delete($id);

	public function deleteFromTable($id);

	/**
	 * @param Entity_{class_name} ${name}
	 * @return mixed
	 */
	public function update(${name});
}