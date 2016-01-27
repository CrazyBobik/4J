<?php

class Admin_Models_Types_Block extends Parents_Model{
    /**
	 * @var DAO_Types_Block
	 */
    private $blockDAO;
    /**
     * @var DAO_Tree
     */
    private $treeDAO;

    public function __construct(){
        $this->blockDAO = new DAO_Types_Block();
        $this->treeDAO = new DAO_Tree();
    }

    /**
    * @param int $id
    * @return array()
    */
    public function getBlock($id){
        return $this->treeDAO->getOne($id, '*', 'block');
    }


    /**
    * @param String $title
    * @param String $name
    * @param int $pid
    * @param Entity_Block $block
    * @return int id
    */
    public function addBlock($title, $name, $pid, $block){
        $parent = $this->treeDAO->getOne($pid);
        $treeLeaf = new Entity_Tree();
        $treeLeaf->setTitle($title);
        $treeLeaf->setLink($parent['link'].'/'.$name);
        $treeLeaf->setName($name);
        $treeLeaf->setType('block');
        $treeLeaf->setRightKey($parent['right_key']);
        $treeLeaf->setLevel($parent['level']);
        $treeLeaf->setPid($pid);

        return $this->blockDAO->add($treeLeaf, $block);
    }

    public function deleteBlock($id){
        return $this->blockDAO->delete($id);
    }

    /**
    * @param Entity_Tree $tree
    * @param Entity_Block $block
    * @return bool
    */
    public function updateBlock($tree, $block){
        $old = new Entity_Tree();
        $old->init($this->treeDAO->getOne($tree->getId()));
        $link = rtrim($old->getLink(), $old->getName()).$tree->getName();
        $tree->setLink($link);
        $block->setId($old->getTypeId());

        return $this->blockDAO->update($block) && $this->treeDAO->updateTree($tree);
    }
}