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

		return new Entity_Tree($stmt->fetch(PDO::FETCH_ASSOC));
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
		$SQL = 'SELECT t.*,'.implode(',', $fields)
				.' FROM `site_tree` t '.implode(' ', $joins)
				.' WHERE t.`left_key`>:left_key
					AND t.`right_key`<:right_key AND ('
				.implode(' OR ', $wtypes).') ORDER BY t.`left_key`';
		$stmt = $this->DB->prepare($SQL);

		$lk = $parent->getLeftKey();
		$rk = $parent->getRightKey();
		$stmt->bindParam(':left_key', $lk);
		$stmt->bindParam(':right_key', $rk);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}