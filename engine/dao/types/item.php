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

        return new Entity_Item($stmt->fetch(PDO::FETCH_ASSOC));
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

        

        $stmt = $this->DB->prepare('INSERT INTO `site_item`
                                        ()
                                        VALUES
                                        ()');
        
        $stmt->execute();
        $id = $this->DB->lastInsertId();

        $treeLeaf->setTypeId($id);

        $dao = new Dev_DAO_Tree();
        return $dao->addTree($treeLeaf);
    }

    public function delete($id){
        $tree = new DAO_Tree();
        $elem = $tree->getOne($id);

        $elem_id = $elem->getTypeId();
        $stmt = $this->DB->prepare('DELETE FROM `site_item` WHERE `item_id`=:id');
        $stmt->bindParam(':id', $elem_id);
        $q1 = $stmt->execute();

        $dao = new Dev_DAO_Tree();
        $q2 = $dao->deleteTree($elem);

        return $q1 && $q2;
    }

    /**
    * @param Entity_Item $item
    * @return bool
    */
    public function update($item){
        $id = $item->getId();
        

        $stmt = $this->DB->prepare('UPDATE `site_item` SET
                                    
                                    WHERE `item_id`=:id');
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}