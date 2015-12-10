<?php

class Entity_{class_name}{
	private $id;
	{fields}

	public function __construct($res = null){
		$this->id = $res['{name}_id'];
        {fields_init}
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

{get_and_set}
}