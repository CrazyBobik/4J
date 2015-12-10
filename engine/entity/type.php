<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 10.12.2015
 * Time: 21:12
 */
class Entity_Type{
	private $id;
	private $title = '';
	private $name = '';
	private $seo = 0;
	private $json = '';

	/**
	 * Entity_Type constructor.
	 * @param null $res
	 */
	public function __construct($res = null){
		$this->id = $res['id'];
		$this->title = $res['title'];
		$this->name = $res['name'];
		$this->seo = $res['seo'];
		$this->json = $res['json'];
	}

	/**
	 * @return mixed
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id){
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getTitle(){
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title){
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getName(){
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name){
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getJson(){
		return $this->json;
	}

	/**
	 * @param string $json
	 */
	public function setJson($json){
		$this->json = $json;
	}

	/**
	 * @return int
	 */
	public function getSeo(){
		return $this->seo;
	}

	/**
	 * @param int $seo
	 */
	public function setSeo($seo){
		$this->seo = $seo;
	}
}