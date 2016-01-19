<?php

class Entity_Item{
	private $id;
	

	public function init($res){
		$this->id = $res['item_id'];
        
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }


}