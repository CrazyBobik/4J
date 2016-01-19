<?php

class DAO_Types_{class_name} extends DAO_MainDAO implements DAO_Interface_{class_name}{

	/**
	 * @param int $id
	 * @return Entity_{class_name}
	 */
	public function getOne($id){
		$stmt = $this->DB->prepare('SELECT * FROM `site_{name}` WHERE `{name}_id`=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetchObject('Entity_{class_name}');
    }

    /**
    * @param Entity_{class_name} ${name}
    * @param Entity_Tree $treeLeaf
    * @return int
    * @throws ErrorException
    */
    public function add($treeLeaf, ${name}){
        if (!file_exists(ENGINE.'/dev')){
            throw new ErrorException('I think it will never work =(');
        }

        {add_param}

        $stmt = $this->DB->prepare('INSERT INTO `site_{name}`
                                        ({add_sql_param})
                                        VALUES
                                        ({add_sql_values})');
        {add_bind_param}
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
        $stmt = $this->DB->prepare('DELETE FROM `site_{name}` WHERE `{name}_id`=:id');
        $stmt->bindParam(':id', $id);
        $q1 = $stmt->execute();

        return $q1;
    }

    /**
    * @param Entity_{class_name} ${name}
    * @return bool
    */
    public function update(${name}){
        $id = ${name}->getId();
        {add_param}{seo_add_param}

        $stmt = $this->DB->prepare('UPDATE `site_{name}` SET
                                    {update_sql_param}
                                    WHERE `{name}_id`=:id');
        $stmt->bindParam(':id', $id);
        {add_bind_param}{seo_bind_param}
        return $stmt->execute();
    }
}