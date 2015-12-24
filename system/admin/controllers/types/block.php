<?php

class Admin_Controllers_Types_Block extends Ajax{
	/**
	 * @var Admin_Models_Types_Block
	 */
	private $blockModel;

	/**
	 * Admin_Controllers_Types_Block constructor.
	 * @param bool $isAjax
	 */
	public function __construct($isAjax = true){
	    parent::__construct($isAjax);
		$this->blockModel = new Admin_Models_Types_Block();
    }

    /**
    * @param int $id
    * @return String
    */
    public function getBlock($id = null){
        $id = $this->isAjax() ? intval($_POST['id']) : $id;

        $tree = $this->blockModel->getBlock($id);
        $entity = new Entity_Block($tree);

        $toReplace = array(
            '{action}',
            '{tree_title}',
            '{tree_name}',
            '{tree_pid}',
            '{id_value}',
            '{side_value}',
			'{text_value}',
			'{is_text_value}'
        );
        $replace = array(
            empty($id) ? 'add' : 'update',
            $tree['title'],
            $tree['name'],
            $tree['pid'],
            $tree['id'],
            $entity->getSide(),
			$entity->getText(),
			$entity->getIsText()
        );

        $typeModel = new Admin_Models_Type();
        $type = $typeModel->getTypeByName('block');
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
                if ($cntJ > 0){
                    $str = 'get'.ucfirst($fields[$i]['name']).'()';
                    $tmp = explode(',', $entity->$str);
                    for ($j = 0; $j < count($tmp); $j++){
                        $toReplace[] = '{'.$fields[$i]['name'].'_'.$tmp[$j].'_value}';
                        $replace[] = $fields[$i]['type'] == 'select'
                            ? 'selected="selected"' : 'checked="checked"';
                    }
                }
            }
        }

        $file = file_get_contents(ADMIN.'/views/types/block.tpl');
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
    public function addBlock($data = array()){
        $title = $this->isAjax() ? strip_tags($_POST['title']) : $data['title'];
        $name = $this->isAjax() ? strip_tags($_POST['name']) : $data['name'];
        $pid = $this->isAjax() ? intval($_POST['pid']) : $data['pid'];

        $entity = new Entity_Block();
        $entity->setSide($this->isAjax() ? strip_tags($_POST['block_side']) : $data['block_side']);
		$entity->setText($this->isAjax() ? strip_tags($_POST['block_text']) : $data['block_text']);
		$entity->setIsText($this->isAjax() ? strip_tags($_POST['block_is_text']) : $data['block_is_text']);
        $id = $this->blockModel->addBlock($title, $name, $pid, $entity);

        if ($this->isAjax()){
            $this->putAjax($id);
        }

        return $id;
    }

    /**
    * @param int $id
    * @return bool
    */
    public function deleteBlock($id = null){
        $id = $this->isAjax() ? intval($_POST['id']) : $id;

        $result = $this->blockModel->deleteBlock($id);

        if ($this->isAjax()){
            $this->putAjax($result);
        }

        return $result;
    }

    /**
    * @param array $data
    * @return bool
    */
    public function updateBlock($data = array()){
        $tree = new Entity_Tree();
        $tree->setId($this->isAjax() ? strip_tags($_POST['id']) : $data['id']);
        $tree->setTitle($this->isAjax() ? strip_tags($_POST['title']) : $data['tree_title']);
        $tree->setName($this->isAjax() ? strip_tags($_POST['name']) : $data['tree_name']);

        $entity = new Entity_Block();
        $entity->setSide($this->isAjax() ? strip_tags($_POST['block_side']) : $data['block_side']);
		$entity->setText($this->isAjax() ? strip_tags($_POST['block_text']) : $data['block_text']);
		$entity->setIsText($this->isAjax() ? strip_tags($_POST['block_is_text']) : $data['block_is_text']);
        $result = $this->blockModel->updateBlock($tree, $entity);

        if ($this->isAjax()){
            $this->putAjax($result);
        }

        return $result;
    }
}