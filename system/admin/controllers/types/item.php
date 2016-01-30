<?php

class Admin_Controllers_Types_Item extends Parents_AjaxUpload{
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
            '{f_value}'
        );
        
        $replace = array(
            empty($id) ? 'add' : 'update',
            $tree['title'],
            $tree['name'],
            empty($id) ? intval($_POST['pid']) : $tree['pid'],
            $tree['id'],
            $entity->getF()
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

                $str = 'get'.ucfirst($fields[$i]['name']);
                $arr = explode(',', $entity->$str());
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
        $validator = new Libs_Validator(array(
            'title' => 'Титулка',
            'name' => 'Имя',
            'pid' => 'Ид родителя'
        ));
        $data = array(
            'title' => $title,
            'name' => $name,
            'pid' => $pid
        );
        $valid = array(
            'title' => array('required' => true),
            'name' => array('required' => true),
            'pid' => array('required' => true)
        );
        if(!$validator->isValid($data, $valid)){
            if ($this->isAjax()){
                $json = array(
                    'error' => true,
                    'mess' => $validator->getErrors()
                );
                $this->putJSON($json);
            }
            return $validator->getErrors();
        }

        $entity = new Entity_Item();
        $entity->setF($this->isAjax() ? strip_tags($_POST['item_f']) : $data['item_f']);
        $id = $this->itemModel->addItem($title, $name, $pid, $entity);

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
    public function deleteItem($id = null){
        $id = $this->isAjax() ? intval($_POST['id']) : $id;
        $validator = new Libs_Validator(array('id' => 'Ид'));
        $data = array('id' => $id);
        $valid = array('id' => array('required' => true));
        if(!$validator->isValid($data, $valid)){
            if ($this->isAjax()){
                $json = array(
                    'error' => true,
                    'mess' => $validator->getErrors()
                );
                $this->putJSON($json);
            }
            return $validator->getErrors();
        }
        $tree = $this->itemModel->getItem($id);
        $entity = new Entity_Item();
        $entity->init($tree);

        

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
        $id = $tree->getId();
        $title = $tree->getTitle();
        $name = $tree->getName();
        $validator = new Libs_Validator(array(
            'title' => 'Титулка',
            'name' => 'Имя',
            'pid' => 'Ид родителя'
        ));
        $data = array(
            'title' => $title,
            'name' => $name,
            'id' => $id
        );
        $valid = array(
            'title' => array('required' => true),
            'name' => array('required' => true),
            'id' => array('required' => true)
        );
        if(!$validator->isValid($data, $valid)){
            if ($this->isAjax()){
                $json = array(
                    'error' => true,
                    'mess' => $validator->getErrors()
                );
                $this->putJSON($json);
            }
            return $validator->getErrors();
        }

        $entity = new Entity_Item();
        $entity->setF($this->isAjax() ? strip_tags($_POST['item_f']) : $data['item_f']);
        $result = $this->itemModel->updateItem($tree, $entity);

        if ($this->isAjax()){
            $json = array();
            if($result){
                $json['error'] = false;
                $json['mess'] = 'Обновлено';
                $json['clear'] = false;
                $json['callback'] = 'function callback(){reloadMenu();}';
            } else{
                $json['error'] = true;
                $json['mess'] = 'Ошибка';
            }

            $this->putJSON($json);
        }

        return $result;
    }
}