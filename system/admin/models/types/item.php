<?php

class Admin_Models_Types_Item extends Parents_Model{
    /**
	 * @var DAO_Types_Item
	 */
    private $itemDAO;
    /**
     * @var DAO_Tree
     */
    private $treeDAO;

    public function __construct(){
        $this->itemDAO = new DAO_Types_Item();
        $this->treeDAO = new DAO_Tree();
    }

    /**
    * @param int $id
    * @return array()
    */
    public function getItem($id){
        return $this->treeDAO->getOne($id, '*', 'item');
    }


    /**
    * @param String $title
    * @param String $name
    * @param int $pid
    * @param Entity_Item $item
    * @return int id
    */
    public function addItem($title, $name, $pid, $item){
        $parent = $this->treeDAO->getOne($pid);
        $treeLeaf = new Entity_Tree();
        $treeLeaf->setTitle($title);
        $treeLeaf->setLink($parent['link'].'/'.$name);
        $treeLeaf->setName($name);
        $treeLeaf->setType('item');
        $treeLeaf->setRightKey($parent['right_key']);
        $treeLeaf->setLevel($parent['level']);
        $treeLeaf->setPid($pid);

        return $this->itemDAO->add($treeLeaf, $item);
    }

    public function deleteItem($id){
        return $this->itemDAO->delete($id);
    }

    /**
    * @param Entity_Tree $tree
    * @param Entity_Item $item
    * @return bool
    */
    public function updateItem($tree, $item){
        $old = new Entity_Tree();
        $old->init($this->treeDAO->getOne($tree->getId()));
        $link = rtrim($old->getLink(), $old->getName()).$tree->getName();
        $tree->setLink($link);
        $item->setId($old->getTypeId());

        return $this->itemDAO->update($item) && $this->treeDAO->updateTree($tree);
    }
}