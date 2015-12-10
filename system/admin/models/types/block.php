<?php

class Admin_Models_Types_Block{
    /**
	 * @var DAO_Types_Block
	 */
    private $blockDAO;

    public function __construct(){
        $this->blockDAO = new DAO_Types_Block();
    }

    /**
    * @param int $id
    * @return Entity_Block
    */
    public function getBlock($id){
        return $this->blockDAO->getOne($id);
    }


    /**
    * @param String $title
    * @param String $name
    * @param int $pid
    * @param Entity_Block $block
    * @return int id
    */
    public function addBlock($title, $name, $pid, $block){
        $daoTree = new DAO_Tree();
        $parent = $daoTree->getOne($pid);
        $treeLeaf = new Entity_Tree();
        $treeLeaf->setTitle($title);
        $treeLeaf->setLink($parent->getLink().'/'.$name);
        $treeLeaf->setName($name);
        $treeLeaf->setType('block');
        $treeLeaf->setRightKey($parent->getRightKey());
        $treeLeaf->setLevel($parent->getLevel());
        $treeLeaf->setPid($pid);

        return $this->blockDAO->add($treeLeaf, $block);
    }

    public function deleteBlock($id){
        return $this->blockDAO->delete($id);
    }

    /**
    * @param Entity_Block $block
    * @return bool
    */
    public function updateBlock($block){
        return $this->blockDAO->update($block);
    }
}