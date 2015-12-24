<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 25.11.2015
 * Time: 20:50
 */
class DAO_Type extends DAO_MainDAO implements DAO_Interface_Type{

	public function getType($id){
		$stmt = $this->DB->prepare('SELECT * FROM `site_types` WHERE `id`=:id');
		$stmt->bindParam(':id', $id);
		$stmt->execute();

		return new Entity_Type($stmt->fetch(PDO::FETCH_ASSOC));
	}

	public function getTypeByName($name){
		$stmt = $this->DB->prepare('SELECT * FROM `site_types` WHERE `name`=:name');
		$stmt->bindParam(':name', $name);
		$stmt->execute();

		return new Entity_Type($stmt->fetch(PDO::FETCH_ASSOC));
	}

	public function createTable($name, $fields, $hasSeo){
		$f = '';
		$seo = '';
		$cnt = count($fields);
		for($i = 0; $i < $cnt; $i++){
			$type = $fields[$i]['int'] ? 'INT(11)' : 'VARCHAR(500)';
			$f .= '`'.$name.'_'.$fields[$i]['name'].'` '.$type.' NOT NULL,';
		}
		if($hasSeo){
			$seo .= '`'.$name.'_seo_title` VARCHAR(250) NOT NULL,';
			$seo .= '`'.$name.'_seo_keywords` VARCHAR(250) NOT NULL,';
			$seo .= '`'.$name.'_seo_description` VARCHAR(250) NOT NULL,';
		}

		$sql = 'CREATE TABLE `site_'.$name.'` (
				`'.$name.'_id` INT(11) AUTO_INCREMENT, '.$f.' '.$seo
				.' PRIMARY KEY(`'.$name.'_id`))';
		$stmt = $this->DB->prepare($sql);

		return $stmt->execute();
	}

	public function writeType($title, $name, $fields, $seo){
		$fields = json_encode($fields);
		$seo = $seo ? 1 : 0;
		$stmt = $this->DB->prepare('INSERT INTO `site_types` (`title`,`name`,`seo`,`json`)
					VALUES (:title, :name, :seo, :json)');
		$stmt->bindParam(':title', $title);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':seo', $seo);
		$stmt->bindParam(':json', $fields);

		return $stmt->execute();
	}
}