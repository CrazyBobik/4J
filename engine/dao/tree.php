<?php

/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 15.09.2015
 * Time: 21:37
 */
class DAO_Tree extends DAO_MainDAO implements DAO_Interface_Tree{

	public function getOne($id, $fields = '*', $type = ''){
		$id = trim($id, '/');
		$key = is_numeric($id) ? 'id' : 'link';
		$fields = is_array($fields) ? implode(',', $fields) : $fields;
		$join = '';
		if (!empty($type)){
			$fields .= ',t2.*';
			$join = 'LEFT JOIN `site_'.$type.'` t2
						ON t.`type_id`=t2.`'.$type.'_id`
						AND t.`type`=\''.$type.'\'';
		}

		$stmt = $this->DB->prepare('SELECT '.$fields.' FROM `site_tree` t '.$join.'
				WHERE t.`'.$key.'`=:value');
		$stmt->bindParam(':value', $id);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function getChild($id, $types = array()){
		$parent = $this->getOne($id, array('left_key', 'right_key'));

		$cntTypes = count($types);
		$fields = array();
		$joins = array();
		$wtypes = array();
		for ($i = 0; $i < $cntTypes; $i++){
			$fields[] = 'ty'.$i;
			$joins[] = 'LEFT JOIN `site_'.$types[$i].'` '.$fields[$i].'
						ON t.`type_id`='.$fields[$i].'.`'.$types[$i].'_id`
						AND t.`type`=\''.$types[$i].'\'';
			$wtypes[] = 't.`type`=\''.$types[$i].'\'';
			$fields[$i] = 'ty'.$i.'.*';
		}
		$SQL = 'SELECT t.*'.(empty($fields) ? '' : ',').implode(',', $fields)
				.' FROM `site_tree` t '.implode(' ', $joins)
				.' WHERE t.`left_key`>:left_key
					AND t.`right_key`<:right_key '.(empty($fields) ? '' : 'AND (')
				.implode(' OR ', $wtypes).(empty($fields) ? '' : ')').' ORDER BY t.`left_key`';
		$stmt = $this->DB->prepare($SQL);

		$lk = $parent['left_key'];
		$rk = $parent['right_key'];
		$stmt->bindParam(':left_key', $lk);
		$stmt->bindParam(':right_key', $rk);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getParent($id){
		$pid = $this->getOne($id, 't.pid');

		return $this->getOne($pid['pid']);
	}


	/**
	 * @param Entity_Tree $tree
	 * @return bool
	 */
	public function updateTree($tree){
		$id = $tree->getId();
		$title = $tree->getTitle();
		$name = $tree->getName();
		$link = $tree->getLink();

		$stmt = $this->DB->prepare('UPDATE `site_tree` SET
									`title`=:title,
									`name`=:name,
									`link`=:link
                                    WHERE `id`=:id');
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':title', $title);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':link', $link);

		return $stmt->execute();
	}
}