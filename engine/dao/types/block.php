<?php

class DAO_Types_Block extends DAO_MainDAO implements DAO_Interface_Block{

	/**
	 * @param int $id
	 * @return Entity_Block
	 */
	public function getOne($id){
		$stmt = $this->DB->prepare('SELECT * FROM `site_block` WHERE `block_id`=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return new Entity_Block($stmt->fetch(PDO::FETCH_ASSOC));
    }

    /**
    * @param Entity_Block $block
    * @param Entity_Tree $treeLeaf
    * @return int
    * @throws ErrorException
    */
    public function add($treeLeaf, $block){
        if (!file_exists(ENGINE.'/dev')){
            throw new ErrorException('I think it will never work =(');
        }

        $side = $block->getSide();
		$text = $block->getText();
		$is_text = $block->getIs_text();

        $stmt = $this->DB->prepare('INSERT INTO `site_block`
                                        (`block_side`,`block_text`,`block_is_text`)
                                        VALUES
                                        (:side,:text,:is_text)');
        $stmt->bindParam(':side', $side);
		$stmt->bindParam(':text', $text);
		$stmt->bindParam(':is_text', $is_text);
		
        $stmt->execute();
        $id = $this->DB->lastInsertId();

        $treeLeaf->setTypeId($id);

        $dao = new Dev_DAO_Tree();
        return $dao->addTree($treeLeaf);
    }

    public function delete($id){
        $tree = new DAO_Tree();
        $elem = new Entity_Tree($tree->getOne($id));

        $elem_id = $elem->getTypeId();
        $q1 = $this->deleteFromTable($elem_id);

        $dao = new Dev_DAO_Tree();
        $q2 = $dao->deleteTree($elem);

        return $q1 && $q2;
    }

    public function deleteFromTable($id){
        $stmt = $this->DB->prepare('DELETE FROM `site_block` WHERE `block_id`=:id');
        $stmt->bindParam(':id', $id);
        $q1 = $stmt->execute();

        return $q1;
    }

    /**
    * @param Entity_Block $block
    * @return bool
    */
    public function update($block){
        $id = $block->getId();
        $side = $block->getSide();
		$text = $block->getText();
		$is_text = $block->getIs_text();

        $stmt = $this->DB->prepare('UPDATE `site_block` SET
                                    `block_side`=:side,
									`block_text`=:text,
									`block_is_text`=:is_text
                                    WHERE `block_id`=:id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':side', $side);
		$stmt->bindParam(':text', $text);
		$stmt->bindParam(':is_text', $is_text);
		
        return $stmt->execute();
    }

    public function getBlocksForPage($page){
        $tree = new DAO_Tree();
        return $tree->getChild(Config::$lang.'/pages/'.$page, array('block'));
    }
}