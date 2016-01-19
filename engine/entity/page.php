<?php

class Entity_Page{
	private $id;
	private $seoTitle = '';
	private $seoKeywords = '';
	private $seoDescription = '';
	

	public function init($res){
		$this->id = $res['page_id'];
        $this->seoTitle = $res['page_seo_title'];
		$this->seoKeywords = $res['page_seo_keywords'];
		$this->seoDescription = $res['page_seo_description'];
		
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getSeoTitle(){
        return $this->seoTitle;
    }

    public function setSeoTitle($seoTitle){
        $this->seoTitle = $seoTitle;
    }

    public function getSeoKeywords(){
        return $this->seoKeywords;
    }

    public function setSeoKeywords($seoKeywords){
        $this->seoKeywords = $seoKeywords;
    }

    public function getSeoDescription(){
        return $this->seoDescription;
    }

    public function setSeoDescription($seoDescription){
        $this->seoDescription = $seoDescription;
    }


}