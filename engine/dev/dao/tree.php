<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 11.11.2015
 * Time: 21:18
 */
class Dev_DAO_Tree extends DAO_MainDAO implements Dev_DAO_Interface_Tree{

	/**
	 * @param Entity_Tree $tree
	 * @return mixed
	 */
	public function addTree($tree){
		$rk = $tree->getRightKey();
		$lev = $tree->getLevel();
		$tit = $tree->getTitle();
		$nam = $tree->getName();
		$link = $tree->getLink();
		$typ = $tree->getType();
		$tid = $tree->getTypeId();
		$pid = $tree->getPid();

		$stmt = $this->DB->prepare('UPDATE `site_tree`
										SET `right_key` = `right_key` + 2,
											`left_key` = IF(`left_key` > :right_key,
															`left_key` + 2, `left_key`)
										WHERE `right_key` >= :right_key');
		$stmt->bindParam(':right_key', $rk);
		$stmt->execute();

		$stmt = $this->DB->prepare('INSERT INTO `site_tree`
										SET `left_key` = :right_key,
											`right_key` = :right_key + 1,
											`level` = :level + 1,
											`title`=:title,
											`name`=:name,
											`link`=:link,
											`type`=:type,
											`type_id`=:type_id,
											`pid`=:pid');
		$stmt->bindParam(':right_key', $rk);
		$stmt->bindParam(':level', $lev);
		$stmt->bindParam(':title', $tit);
		$stmt->bindParam(':name', $nam);
		$stmt->bindParam(':link', $link);
		$stmt->bindParam(':type', $typ);
		$stmt->bindParam(':type_id', $tid);
		$stmt->bindParam(':pid', $pid);
		$stmt->execute();

		return $this->DB->lastInsertId();
	}

	/**
	 * @param Entity_Tree $elem
	 * @return bool
	 */
	public function deleteTree($elem){
		$rk = $elem->getRightKey();
		$lk = $elem->getLeftKey();

		$del = $this->DB->prepare('DELETE FROM `site_tree`
									WHERE `left_key`>=:left
									AND `right_key`<=:right');
		$del->bindParam(':left', $lk);
		$del->bindParam(':right', $rk);
		$q1 = $del->execute();

		$del = $this->DB->prepare('UPDATE `site_tree` SET `left_key`=
									IF(`left_key`>:left, `left_key`–(:right-:left+1), `left_key`),
									`right_key`=`right_key`–(:right-:left+1)
									WHERE `right_key` > :right');
		$del->bindParam(':left', $lk);
		$del->bindParam(':right', $rk);
		$q2 = $del->execute();

		return $q1 && $q2;
	}
}