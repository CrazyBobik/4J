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

        $entity = $this->blockModel->getBlock($id);

        $toReplace = array(
            '{id_value}',
            '{side_value}',
			'{text_value}',
			'{is_text_value}'
        );
        $replace = array(
            $entity->getId(),
            $entity->getSide(),
			$entity->getText(),
			$entity->getIsText()
        );
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
        $entity->setSide($this->isAjax() ? strip_tags($_POST['side']) : $data['side']);
		$entity->setText($this->isAjax() ? strip_tags($_POST['text']) : $data['text']);
		$entity->setIsText($this->isAjax() ? strip_tags($_POST['is_text']) : $data['is_text']);
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
        $entity = new Entity_Block();
        $entity->setId($this->isAjax() ? strip_tags($_POST['id']) : $data['id']);
        $entity->setSide($this->isAjax() ? strip_tags($_POST['side']) : $data['side']);
		$entity->setText($this->isAjax() ? strip_tags($_POST['text']) : $data['text']);
		$entity->setIsText($this->isAjax() ? strip_tags($_POST['is_text']) : $data['is_text']);
        $result = $this->blockModel->updateBlock($entity);

        if ($this->isAjax()){
            $this->putAjax($result);
        }

        return $result;
    }
}