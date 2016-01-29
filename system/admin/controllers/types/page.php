<?php

class Admin_Controllers_Types_Page extends Ajax{
	/**
	 * @var Admin_Models_Types_Page
	 */
	private $pageModel;

	/**
	 * Admin_Controllers_Types_Page constructor.
	 * @param bool $isAjax
	 */
	public function __construct($isAjax = true){
	    parent::__construct($isAjax);
		$this->pageModel = new Admin_Models_Types_Page();
    }

    /**
    * @param int $id
    * @return String
    */
    public function getPage($id = null){
        $id = $this->isAjax() ? intval($_POST['id']) : $id;

        $tree = $this->pageModel->getPage($id);
        $entity = new Entity_Page();
        $entity->init($tree);

        $toReplace = array(
            '{action}',
            '{tree_title}',
            '{tree_name}',
            '{tree_pid}',
            '{id_value}',
            '{seo_title_value}',
			'{seo_keywords_value}',
			'{seo_description_value}'
        );
        $replace = array(
            empty($id) ? 'add' : 'update',
            $tree['title'],
            $tree['name'],
            empty($id) ? intval($_POST['pid']) : $tree['pid'],
            $tree['id'],
            $entity->getSeoTitle(),
			$entity->getSeoKeywords(),
			$entity->getSeoDescription()
        );

        $typeModel = new Admin_Models_Type();
        $type = $typeModel->getTypeByName('page');
        $fields = json_decode($type->getJson(), true);
        $cnt = count($fields);

        if(empty($id)){
            for($i = 0; $i < $cnt; $i++){
                $cntJ = count($fields[$i]['variants']);
                for($j = 0; $j < $cntJ; $j++){
                    $toReplace[] = '{'.$fields[$i]['name'].'_'.$j.'_value}';
                    $replace[] = ($fields[$i]['selects'] == $j) ?
                        ($fields[$i]['type'] == 'select' ? 'selected="selected"' : 'checked="checked"') :
                        '';
                }
            }
        } else{
            for($i = 0; $i < $cnt; $i++){
                $cntJ = count($fields[$i]['variants']);

                $str = 'get'.ucfirst($fields[$i]['name']).'()';
                $arr = explode(',', $entity->$str);
                for ($j = 0; $j < $cntJ; $j++){
                    $toReplace[] = '{'.$fields[$i]['name'].'_'.$j.'_value}';

                    if(in_array($fields[$i]['variants'][$j], $arr)){
                        $replace[] = $fields[$i]['type'] == 'select'
                        ? 'selected="selected"' : 'checked="checked"';
                    } else {
                        $replace[] = '';
                    }
                }
            }
        }

        $file = file_get_contents(ADMIN.'/views/types/page.tpl');
        $result = str_replace($toReplace, $replace, $file);

        if ($this->isAjax()){
            $this->putAjax($result);
        }

        return $result;
    }

    /**
    * @param array $data
    * @return int id
    */
    public function addPage($data = array()){
        $title = $this->isAjax() ? strip_tags($_POST['title']) : $data['title'];
        $name = $this->isAjax() ? strip_tags($_POST['name']) : $data['name'];
        $pid = $this->isAjax() ? intval($_POST['pid']) : $data['pid'];

        $entity = new Entity_Page();
        $entity->setSeoTitle($this->isAjax() ? strip_tags($_POST['seo_title']) : $data['seo_title']);
		$entity->setSeoKeywords($this->isAjax() ? strip_tags($_POST['seo_keywords']) : $data['seo_keywords']);
		$entity->setSeoDescription($this->isAjax() ? strip_tags($_POST['seo_description']) : $data['seo_description']);

        $id = $this->pageModel->addPage($title, $name, $pid, $entity);

        if ($this->isAjax()){
            $json = array();
            if($id){
                $json['error'] = false;
                $json['mess'] = 'Добавлено';
                $json['callback'] = 'function callback(){reloadMenu();}';
            } else{
                $json['error'] = true;
                $json['mess'] = 'Ошибка';
            }

            $this->putJSON($json);
        }

        return $id;
    }

    /**
    * @param int $id
    * @return bool
    */
    public function deletePage($id = null){
        $id = $this->isAjax() ? intval($_POST['id']) : $id;

        $result = $this->pageModel->deletePage($id);

        if ($this->isAjax()){
            $this->putAjax($result);
        }

        return $result;
    }

    /**
    * @param array $data
    * @return bool
    */
    public function updatePage($data = array()){
        $tree = new Entity_Tree();
        $tree->setId($this->isAjax() ? strip_tags($_POST['id']) : $data['id']);
        $tree->setTitle($this->isAjax() ? strip_tags($_POST['title']) : $data['tree_title']);
        $tree->setName($this->isAjax() ? strip_tags($_POST['name']) : $data['tree_name']);

        $entity = new Entity_Page();
        $entity->setSeoTitle($this->isAjax() ? strip_tags($_POST['seo_title']) : $data['seo_title']);
		$entity->setSeoKeywords($this->isAjax() ? strip_tags($_POST['seo_keywords']) : $data['seo_keywords']);
		$entity->setSeoDescription($this->isAjax() ? strip_tags($_POST['seo_description']) : $data['seo_description']);

        $id = $this->pageModel->updatePage($tree, $entity);

        if ($this->isAjax()){
            $json = array();
            if($id){
                $json['error'] = false;
                $json['mess'] = 'Добавлено';
                $json['callback'] = 'function callback(){reloadMenu();}';
            } else{
                $json['error'] = true;
                $json['mess'] = 'Ошибка';
            }

            $this->putJSON($json);
        }

        return $id;
    }
}