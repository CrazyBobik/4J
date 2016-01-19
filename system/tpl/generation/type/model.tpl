<?php

class Admin_Models_Types_{class_name}{
    /**
	 * @var DAO_Types_{class_name}
	 */
    private ${name}DAO;
    /**
     * @var DAO_Tree
     */
    private $treeDAO;

    public function __construct(){
        $this->{name}DAO = new DAO_Types_{class_name}();
        $this->treeDAO = new DAO_Tree();
    }

    /**
    * @param int $id
    * @return array()
    */
    public function get{class_name}($id){
        return $this->treeDAO->getOne($id, '*', '{name}');
    }


    /**
    * @param String $title
    * @param String $name
    * @param int $pid
    * @param Entity_{class_name} ${name}
    * @return int id
    */
    public function add{class_name}($title, $name, $pid, ${name}){
        $parent = $this->treeDAO->getOne($pid);
        $treeLeaf = new Entity_Tree();
        $treeLeaf->setTitle($title);
        $treeLeaf->setLink($parent['link'].'/'.$name);
        $treeLeaf->setName($name);
        $treeLeaf->setType('{name}');
        $treeLeaf->setRightKey($parent['right_key']);
        $treeLeaf->setLevel($parent['level']);
        $treeLeaf->setPid($pid);

        return $this->{name}DAO->add($treeLeaf, ${name});
    }

    public function delete{class_name}($id){
        return $this->{name}DAO->delete($id);
    }

    /**
    * @param Entity_Tree $tree
    * @param Entity_{class_name} ${name}
    * @return bool
    */
    public function update{class_name}($tree, ${name}){
        $old = new Entity_Tree();
        $old->init($this->treeDAO->getOne($tree->getId()));
        $link = rtrim($old->getLink(), $old->getName()).$tree->getName();
        $tree->setLink($link);
        ${name}->setId($old->getTypeId());

        return $this->{name}DAO->update(${name}) && $this->treeDAO->updateTree($tree);
    }
}