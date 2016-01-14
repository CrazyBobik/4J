<?php

class Entity_Item{
	private $id;
	

	public function __construct($res = null){
		$this->id = $res['item_id'];
        
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }


}