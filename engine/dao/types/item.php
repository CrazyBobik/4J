<?php

class DAO_Types_Item extends DAO_MainDAO implements DAO_Interface_Item{

	/**
	 * @param int $id
	 * @return Entity_Item
	 */
	public function getOne($id){
		$stmt = $this->DB->prepare('SELECT * FROM `site_item` WHERE `item_id`=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetchObject('Entity_Item');
    }

    /**
    * @param Entity_Item $item
    * @param Entity_Tree $treeLeaf
    * @return int
    * @throws ErrorException
    */
    public function add($treeLeaf, $item){
        if (!file_exists(ENGINE.'/dev')){
            throw new ErrorException('I think it will never work =(');
        }

        $f = $item->getF();

        $stmt = $this->DB->prepare('INSERT INTO `site_item`
                                        (`item_f`)
                                        VALUES
                                        (:f)');
        $stmt->bindParam(':f', $f);
		
        $stmt->execute();
        $id = $this->DB->lastInsertId();

        $treeLeaf->setTypeId($id);

        $dao = new Dev_DAO_Tree();
        return $dao->addTree($treeLeaf);
    }

    public function delete($id){
        $tree = new DAO_Tree();
        $elem = new Entity_Tree();
        $elem->init($tree->getOne($id));

        $elem_id = $elem->getTypeId();
        $q1 = $this->deleteFromTable($elem_id);

        $dao = new Dev_DAO_Tree();
        $q2 = $dao->deleteTree($elem);

        return $q1 && $q2;
    }

    public function deleteFromTable($id){
        $stmt = $this->DB->prepare('DELETE FROM `site_item` WHERE `item_id`=:id');
        $stmt->bindParam(':id', $id);
        $q1 = $stmt->execute();

        return $q1;
    }

    /**
    * @param Entity_Item $item
    * @return bool
    */
    public function update($item){
        $id = $item->getId();
        $f = $item->getF();

        $stmt = $this->DB->prepare('UPDATE `site_item` SET
                                    `item_f`=:f
                                    WHERE `item_id`=:id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':f', $f);
		
        return $stmt->execute();
    }
}