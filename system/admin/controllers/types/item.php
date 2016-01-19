<?php

class Admin_Controllers_Types_Item extends Ajax{
	/**
	 * @var Admin_Models_Types_Item
	 */
	private $itemModel;

	/**
	 * Admin_Controllers_Types_Item constructor.
	 * @param bool $isAjax
	 */
	public function __construct($isAjax = true){
	    parent::__construct($isAjax);
		$this->itemModel = new Admin_Models_Types_Item();
    }

    /**
    * @param int $id
    * @return String
    */
    public function getItem($id = null){
        $id = $this->isAjax() ? intval($_POST['id']) : $id;

        $tree = $this->itemModel->getItem($id);
        $entity = new Entity_Item();
        $entity->init($tree);

        $toReplace = array(
            '{action}',
            '{tree_title}',
            '{tree_name}',
            '{tree_pid}',
            '{id_value}',
            
        );
        $replace = array(
            empty($id) ? 'add' : 'update',
            $tree['title'],
            $tree['name'],
            empty($id) ? intval($_POST['pid']) : $tree['pid'],
            $tree['id'],
            
        );

        $typeModel = new Admin_Models_Type();
        $type = $typeModel->getTypeByName('item');
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

        $file = file_get_contents(ADMIN.'/views/types/item.tpl');
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
    public function addItem($data = array()){
        $title = $this->isAjax() ? strip_tags($_POST['title']) : $data['title'];
        $name = $this->isAjax() ? strip_tags($_POST['name']) : $data['name'];
        $pid = $this->isAjax() ? intval($_POST['pid']) : $data['pid'];

        $entity = new Entity_Item();
        
        $id = $this->itemModel->addItem($title, $name, $pid, $entity);

        if ($this->isAjax()){
            $this->putAjax($id);
        }

        return $id;
    }

    /**
    * @param int $id
    * @return bool
    */
    public function deleteItem($id = null){
        $id = $this->isAjax() ? intval($_POST['id']) : $id;

        $result = $this->itemModel->deleteItem($id);

        if ($this->isAjax()){
            $this->putAjax($result);
        }

        return $result;
    }

    /**
    * @param array $data
    * @return bool
    */
    public function updateItem($data = array()){
        $tree = new Entity_Tree();
        $tree->setId($this->isAjax() ? strip_tags($_POST['id']) : $data['id']);
        $tree->setTitle($this->isAjax() ? strip_tags($_POST['title']) : $data['tree_title']);
        $tree->setName($this->isAjax() ? strip_tags($_POST['name']) : $data['tree_name']);

        $entity = new Entity_Item();
        
        $result = $this->itemModel->updateItem($tree, $entity);

        if ($this->isAjax()){
            $this->putAjax($result);
        }

        return $result;
    }
}