<?php
/**
 * Created by PhpStorm.
 * User: CrazyBobik
 * Date: 09.11.2015
 * Time: 22:43
 */
class Entity_Tree{
	private $id;
	private $title = '';
	private $link = '';
	private $name = '';
	private $type = '';
	private $type_id = 0;
	private $left_key = 0;
	private $right_key = 0;
	private $level = 0;
	private $pid = 0;

	/**
	 * Entity_Tree constructor.
	 * @param $res
	 */
	public function __construct($res = null){
		$this->id = $res['id'];
		$this->title = $res['title'];
		$this->link = $res['link'];
		$this->name = $res['name'];
		$this->type = $res['type'];
		$this->type_id = $res['type_id'];
		$this->left_key = $res['left_key'];
		$this->right_key = $res['right_key'];
		$this->level = $res['level'];
		$this->pid = $res['pid'];
	}

	/**
	 * @return string
	 */
	public function getLink(){
		return $this->link;
	}

	/**
	 * @param string $link
	 */
	public function setLink($link){
		$this->link = $link;
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
	 * @return mixed
	 */
	public function getTitle(){
		return $this->title;
	}

	/**
	 * @param mixed $title
	 */
	public function setTitle($title){
		$this->title = $title;
	}

	/**
	 * @return mixed
	 */
	public function getName(){
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name){
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getType(){
		return $this->type;
	}

	/**
	 * @param mixed $type
	 */
	public function setType($type){
		$this->type = $type;
	}

	/**
	 * @return mixed
	 */
	public function getTypeId(){
		return $this->type_id;
	}

	/**
	 * @param mixed $type_id
	 */
	public function setTypeId($type_id){
		$this->type_id = $type_id;
	}

	/**
	 * @return mixed
	 */
	public function getLeftKey(){
		return $this->left_key;
	}

	/**
	 * @param mixed $left_key
	 */
	public function setLeftKey($left_key){
		$this->left_key = $left_key;
	}

	/**
	 * @return mixed
	 */
	public function getRightKey(){
		return $this->right_key;
	}

	/**
	 * @param mixed $right_key
	 */
	public function setRightKey($right_key){
		$this->right_key = $right_key;
	}

	/**
	 * @return mixed
	 */
	public function getLevel(){
		return $this->level;
	}

	/**
	 * @param mixed $level
	 */
	public function setLevel($level){
		$this->level = $level;
	}

	/**
	 * @return mixed
	 */
	public function getPid(){
		return $this->pid;
	}

	/**
	 * @param mixed $pid
	 */
	public function setPid($pid){
		$this->pid = $pid;
	}


}