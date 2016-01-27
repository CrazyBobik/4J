<?php

class Admin_Models_Types_Page extends Parents_Model{
    /**
	 * @var DAO_Types_Page
	 */
    private $pageDAO;
    /**
     * @var DAO_Tree
     */
    private $treeDAO;

    public function __construct(){
        $this->pageDAO = new DAO_Types_Page();
        $this->treeDAO = new DAO_Tree();
    }

    /**
    * @param int $id
    * @return array()
    */
    public function getPage($id){
        return $this->treeDAO->getOne($id, '*', 'page');
    }


    /**
    * @param String $title
    * @param String $name
    * @param int $pid
    * @param Entity_Page $page
    * @return int id
    */
    public function addPage($title, $name, $pid, $page){
        $parent = $this->treeDAO->getOne($pid);
        $treeLeaf = new Entity_Tree();
        $treeLeaf->setTitle($title);
        $treeLeaf->setLink($parent['link'].'/'.$name);
        $treeLeaf->setName($name);
        $treeLeaf->setType('page');
        $treeLeaf->setRightKey($parent['right_key']);
        $treeLeaf->setLevel($parent['level']);
        $treeLeaf->setPid($pid);

        return $this->pageDAO->add($treeLeaf, $page);
    }

    public function deletePage($id){
        return $this->pageDAO->delete($id);
    }

    /**
    * @param Entity_Tree $tree
    * @param Entity_Page $page
    * @return bool
    */
    public function updatePage($tree, $page){
        $old = new Entity_Tree();
        $old->init($this->treeDAO->getOne($tree->getId()));
        $link = rtrim($old->getLink(), $old->getName()).$tree->getName();
        $tree->setLink($link);
        $page->setId($old->getTypeId());

        return $this->pageDAO->update($page) && $this->treeDAO->updateTree($tree);
    }
}