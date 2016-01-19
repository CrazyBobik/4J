<?php

class DAO_Types_Page extends DAO_MainDAO implements DAO_Interface_Page{

	/**
	 * @param int $id
	 * @return Entity_Page
	 */
	public function getOne($id){
		$stmt = $this->DB->prepare('SELECT * FROM `site_page` WHERE `page_id`=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return new Entity_Page($stmt->fetch(PDO::FETCH_ASSOC));
    }

    /**
    * @param Entity_Page $page
    * @param Entity_Tree $treeLeaf
    * @return int
    * @throws ErrorException
    */
    public function add($treeLeaf, $page){
        if (!file_exists(ENGINE.'/dev')){
            throw new ErrorException('I think it will never work =(');
        }

        

        $stmt = $this->DB->prepare('INSERT INTO `site_page`
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
        $elem = new Entity_Tree();
        $elem->init($tree->getOne($id));

        $elem_id = $elem->getTypeId();
        $q1 = $this->deleteFromTable($elem_id);

        $dao = new Dev_DAO_Tree();
        $q2 = $dao->deleteTree($elem);

        return $q1 && $q2;
    }

    public function deleteFromTable($id){
        $stmt = $this->DB->prepare('DELETE FROM `site_page` WHERE `page_id`=:id');
        $stmt->bindParam(':id', $id);
        $q1 = $stmt->execute();

        return $q1;
    }

    /**
    * @param Entity_Page $page
    * @return bool
    */
    public function update($page){
        $id = $page->getId();
        
		$seo_title = $page->getSeoTitle();
		$seo_keywords = $page->getSeoKeywords();
		$seo_description = $page->getSeoDescription();

        $stmt = $this->DB->prepare('UPDATE `site_page` SET
                                    `page_seo_title`=:seo_title,
									`page_seo_keywords`=:seo_keywords,
									`page_seo_description`=:seo_description
                                    WHERE `page_id`=:id');
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':seo_title', $seo_title);
		$stmt->bindParam(':seo_keywords', $seo_keywords);
		$stmt->bindParam(':seo_description', $seo_description);
		
        return $stmt->execute();
    }
}