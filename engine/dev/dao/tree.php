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

	public function moveBlock($id, $index){
		$daoTree = new DAO_Tree();
		$moveElem = $daoTree->getOne($id);
		$parent = $daoTree->getOne($moveElem['pid']);

		$childs = $daoTree->getChild($parent['id']);

		$stmt = $this->DB->prepare('UPDATE `site_tree`
									SET `left_key`=:lkey, `right_key`=:rkey
									WHERE `id`=:id');
		$stmt->bindParam(':lkey', $childs[$index]['left_key']);
		$stmt->bindParam(':rkey', $childs[$index]['right_key']);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		if($moveElem['left_key'] > $childs[$index]['left_key']){
			$stmt = $this->DB->prepare('UPDATE `site_tree`
									SET `left_key`=`left_key`+2,`right_key`=`right_key`+2
									WHERE `left_key`>:pleft
									AND `right_key`<:pright
									AND `left_key`>=:left
									AND `left_key`<:mleft
									AND `id`!=:id');
			$stmt->bindParam(':pleft', $parent['left_key']);
			$stmt->bindParam(':pright', $parent['right_key']);
			$stmt->bindParam(':left', $childs[$index]['left_key']);
			$stmt->bindParam(':mleft', $moveElem['left_key']);
			$stmt->bindParam(':id', $id);
			$stmt->execute();
		} else{
			$stmt = $this->DB->prepare('UPDATE `site_tree`
									SET `left_key`=`left_key`-2,`right_key`=`right_key`-2
									WHERE `left_key`>:pleft
									AND `right_key`<:pright
									AND `left_key`<=:left
									AND `left_key`>:mleft
									AND `id`!=:id');
			$stmt->bindParam(':pleft', $parent['left_key']);
			$stmt->bindParam(':pright', $parent['right_key']);
			$stmt->bindParam(':left', $childs[$index]['left_key']);
			$stmt->bindParam(':mleft', $moveElem['left_key']);
			$stmt->bindParam(':id', $id);
			$stmt->execute();
		}

		return true;
	}

	/**
	 * @param Entity_Tree $elem
	 * @return bool
	 */
	public function deleteTree($elem){
		$rk = $elem->getRightKey();
		$lk = $elem->getLeftKey();

		$tree = new DAO_Tree();
		$res = $tree->getChild($elem->getId());
		$this->deleteChildFromTable($res);

		$del = $this->DB->prepare('DELETE FROM `site_tree`
									WHERE `left_key`>=:left
									AND `right_key`<=:right');
		$del->bindParam(':left', $lk);
		$del->bindParam(':right', $rk);
		$q1 = $del->execute();

		$del = $this->DB->prepare('UPDATE `site_tree`
								   SET `right_key`=`right_key`-(:right-:left+1)
								   WHERE `right_key`>:right AND `left_key`<:left');
		$del->bindParam(':left', $lk);
		$del->bindParam(':right', $rk);

		$del->execute();
		$del = $this->DB->prepare('UPDATE `site_tree`
								   SET `left_key`=`left_key`-(:right-:left+1),
								   	   `right_key`=`right_key`-(:right-:left+1)
								   WHERE `left_key`>:right');
		$del->bindParam(':left', $lk);
		$del->bindParam(':right', $rk);
		$del->execute();

		return $q1;
	}

	public function deleteChildFromTable($res){
		$cnt = count($res);
		for($i = 0; $i < $cnt; $i++){
			$strDAO = 'DAO_Types_'.ucfirst($res[$i]['type']);
			$dao = new $strDAO();
			$dao->deleteFromTable($res[$i]['type_id']);
		}
	}
}