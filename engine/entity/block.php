<?php

class Entity_Block{
	private $id;
	private $side = '';
	private $text = '';
	private $is_text = 0;
	

	public function init($res){
		$this->id = $res['block_id'];
        $this->side = $res['block_side'];
		$this->text = $res['block_text'];
		$this->is_text = $res['block_is_text'];
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getSide(){
        return $this->side;
    }

    public function setSide($side){
        $this->side = $side;
    }

    public function getText(){
        return $this->text;
    }

    public function setText($text){
        $this->text = $text;
    }

    public function getIs_text(){
        return $this->is_text;
    }

    public function setIsText($is_text){
        $this->is_text = $is_text;
    }


}