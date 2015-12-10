<?php

class Admin_Models_Types_{class_name}{
    /**
	 * @var DAO_Types_{class_name}
	 */
    private ${name}DAO;

    public function __construct(){
        $this->{name}DAO = new DAO_Types_{class_name}();
    }

    /**
    * @param int $id
    * @return Entity_{class_name}
    */
    public function get{class_name}($id){
        return $this->{name}DAO->getOne($id);
    }


    /**
    * @param String $title
    * @param String $name
    * @param int $pid
    * @param Entity_{class_name} ${name}
    * @return int id
    */
    public function add{class_name}($title, $name, $pid, ${name}){
        $daoTree = new DAO_Tree();
        $parent = $daoTree->getOne($pid);
        $treeLeaf = new Entity_Tree();
        $treeLeaf->setTitle($title);
        $treeLeaf->setLink($parent->getLink().'/'.$name);
        $treeLeaf->setName($name);
        $treeLeaf->setType('{name}');
        $treeLeaf->setRightKey($parent->getRightKey());
        $treeLeaf->setLevel($parent->getLevel());
        $treeLeaf->setPid($pid);

        return $this->{name}DAO->add($treeLeaf, ${name});
    }

    public function delete{class_name}($id){
        return $this->{name}DAO->delete($id);
    }

    /**
    * @param Entity_{class_name} ${name}
    * @return bool
    */
    public function update{class_name}(${name}){
        return $this->{name}DAO->update(${name});
    }
}