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

        return $stmt->fetchObject('Entity_Type');
    }

    public function getTypeByName($name){
        $stmt = $this->DB->prepare('SELECT * FROM `site_types` WHERE `name`=:name');
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        return $stmt->fetchObject('Entity_Type');
    }

    /**
     * @return Entity_Type[]
     */
    public function getAllTypes(){
		$stmt = $this->DB->prepare('SELECT * FROM `site_types` ORDER BY `title` ASC');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Entity_Type');
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

    public function updateTable($name, $add, $del, $addSEO){
        $cnt = count($add);
        $sql = 'ALTER TABLE `site_'.$name.'` ';
        for($i = 0; $i < $cnt; $i++){
            $type = $add[$i]['int'] ? 'INT(11)' : 'VARCHAR(500)';
            $sql .= 'ADD `'.$name.'_'.$add[$i]['name'].'` '.$type.' NOT NULL,';
        }
        if($addSEO == 'add'){
            $sql .= 'ADD `'.$name.'_seo_title` VARCHAR(250) NOT NULL,';
            $sql .= 'ADD `'.$name.'_seo_keywords` VARCHAR(250) NOT NULL,';
            $sql .= 'ADD `'.$name.'_seo_description` VARCHAR(250) NOT NULL,';
        }
        $sql = trim($sql, ',');
        $stmt = $this->DB->prepare($sql);
        $r1 = $stmt->execute();

        $cnt = count($del);
        $sql = 'ALTER TABLE `site_'.$name.'` ';
        for($i = 0; $i < $cnt; $i++){
            $sql .= 'DROP COLUMN `'.$name.'_'.$del[$i]['name'].'`,';
        }
        if($addSEO == 'del'){
            $sql .= 'DROP COLUMN `'.$name.'_seo_title`,';
            $sql .= 'DROP COLUMN `'.$name.'_seo_keywords`,';
            $sql .= 'DROP COLUMN `'.$name.'_seo_description`,';
        }
        $sql = trim($sql, ',');
        $stmt = $this->DB->prepare($sql);
        $r2 = $stmt->execute();

        return $r1 && $r2;
    }

    public function dropTable($name){
        $sql = 'DROP TABLE `site_'.$name.'`';
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

    public function updateType($id, $title, $name, $fields, $seo){
        $fields = json_encode($fields);
        $seo = $seo ? 1 : 0;
        $stmt = $this->DB->prepare('UPDATE `site_types` SET
                            `title`=:title,
                             `name`=:name,
                             `seo`=:seo,
                             `json`=:json WHERE `id`=:id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':seo', $seo);
        $stmt->bindParam(':json', $fields);

        return $stmt->execute();
    }

    public function deleteType($id){
        $stmt = $this->DB->prepare('DELETE FROM `site_types` WHERE `id`=:id');
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}