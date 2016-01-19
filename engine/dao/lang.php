<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 19.01.2016
 * Time: 17:12
 */
class DAO_Lang extends DAO_MainDAO implements DAO_Interface_Lang{


	/**
	 * @return Entity_Tree[]
	 */
	public function getLangs(){
		$stmt = $this->DB->prepare('SELECT * FROM `site_tree` t
				WHERE t.`level`=1 ORDER BY t.`left_key`');
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_CLASS, 'Entity_Tree');
	}
}