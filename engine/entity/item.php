<?php

class Entity_Item{
	private $id;
	private $f = 0;
	

	public function init($res){
		$this->id = $res['item_id'];
        $this->f = $res['item_f'];
		
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getF(){
        return $this->f;
    }

    public function setF($f){
        $this->f = $f;
    }


}