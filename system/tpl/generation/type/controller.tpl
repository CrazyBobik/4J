<?php

class Admin_Controllers_Types_{class_name} extends Ajax{
	/**
	 * @var Admin_Models_Types_{class_name}
	 */
	private ${name}Model;

	/**
	 * Admin_Controllers_Types_{class_name} constructor.
	 * @param bool $isAjax
	 */
	public function __construct($isAjax = true){
	    parent::__construct($isAjax);
		$this->{name}Model = new Admin_Models_Types_{class_name}();
    }

    /**
    * @param int $id
    * @return String
    */
    public function get{class_name}($id = null){
        $id = $this->isAjax() ? intval($_POST['id']) : $id;

        $tree = $this->{name}Model->get{class_name}($id);
        $entity = new Entity_{class_name}($tree);

        $toReplace = array(
            '{action}',
            '{tree_title}',
            '{tree_name}',
            '{tree_pid}',
            '{id_value}',
            {to_replace}
        );
        $replace = array(
            empty($id) ? 'add' : 'update',
            $tree['title'],
            $tree['name'],
            $tree['pid'],
            $tree['id'],
            {entity_get}{seo_get}
        );
        $file = file_get_contents(ADMIN.'/views/types/{name}.tpl');
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
    public function add{class_name}($data = array()){
        $title = $this->isAjax() ? strip_tags($_POST['title']) : $data['title'];
        $name = $this->isAjax() ? strip_tags($_POST['name']) : $data['name'];
        $pid = $this->isAjax() ? intval($_POST['pid']) : $data['pid'];

        $entity = new Entity_{class_name}();
        {entity_set}{seo_set}
        $id = $this->{name}Model->add{class_name}($title, $name, $pid, $entity);

        if ($this->isAjax()){
            $this->putAjax($id);
        }

        return $id;
    }

    /**
    * @param int $id
    * @return bool
    */
    public function delete{class_name}($id = null){
        $id = $this->isAjax() ? intval($_POST['id']) : $id;

        $result = $this->{name}Model->delete{class_name}($id);

        if ($this->isAjax()){
            $this->putAjax($result);
        }

        return $result;
    }

    /**
    * @param array $data
    * @return bool
    */
    public function update{class_name}($data = array()){
        $tree = new Entity_Tree();
        $tree->setId($this->isAjax() ? strip_tags($_POST['id']) : $data['id']);
        $tree->setTitle($this->isAjax() ? strip_tags($_POST['title']) : $data['tree_title']);
        $tree->setName($this->isAjax() ? strip_tags($_POST['name']) : $data['tree_name']);

        $entity = new Entity_{class_name}();
        {entity_set}{seo_set}
        $result = $this->{name}Model->update{class_name}($tree, $entity);

        if ($this->isAjax()){
            $this->putAjax($result);
        }

        return $result;
    }
}